<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

define('GITHUB_SECRET', '82JMdZ6MagqnugfBCnsv');
define('GITHUB_BRANCH', 'master');
define('EMAIL_RECIPIENT', 'misterzemz@outlook.com');
define('SITE_DOMAIN', 'pathfinder.in.th');
define('SSH_PORT', 22);
define('SSH_USERNAME', 'cp525119');
define('KEYPAIR_NAME', 'deploy');
define('KEYPAIR_PASSPHRASE', 'Um(P9ZiHH_]J');

class Deploy extends Controller {
    public function __construct(){ }

    public function index() {
        try {
            $signature = $_SERVER['HTTP_X_GITHUB_EVENT'];
            if (is_null($signature) || $signature != 'push') {
                header('HTTP/1.0 400 Bad Request');
                die("Go Away!");
            }
            $payload = file_get_contents('php://input');
            // get the signature out of the headers and split it into parts
            $signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
            $sigParts  = explode('=', $signature);
            if (sizeof($sigParts) != 2) {
                throw new Exception('Bad signature: wrong number of \'=\' chars');
            }
            $sigAlgo = $sigParts[0];
            $sigHash = $sigParts[1];
            // verify that the signature is correct
            $hash = hash_hmac($sigAlgo, $payload, GITHUB_SECRET);
            if ($hash === false) {
                throw new Exception("Unknown signature algo: $sigAlgo");
            }
            if ($hash != $sigHash) {
                throw new Exception("Signatures didn't match. Ours: '$hash', theirs: '$sigHash'.");
            }
            // read the payload
            $data = json_decode($payload);
            if (is_null($data)) {
                throw new Exception('Failed to decode JSON payload');
            }
            // make sure it's the right branch
            $branchRef = $data->ref;
            if ($branchRef != 'refs/heads/'.GITHUB_BRANCH) {
                die("Ignoring push to '$branchRef'");
            }
            // ssh into the local server
            $sshSession = ssh2_connect('localhost', SSH_PORT);
            $authSuccess = ssh2_auth_pubkey_file(
                $sshSession,
                SSH_USERNAME,
                '/home/'.SSH_USERNAME.'/.ssh/'.KEYPAIR_NAME.'.pub',
                '/home/'.SSH_USERNAME.'/.ssh/'.KEYPAIR_NAME,
                KEYPAIR_PASSPHRASE
            );
            if (!$authSuccess) {
                throw new Exception('SSH authentication failure');
            }
            // start a shell session
            $shell = ssh2_shell($sshSession, 'xterm');
            if ($shell === false) {
                throw new Exception('Failed to open shell');
            }
            stream_set_blocking($shell, true);
            stream_set_timeout($shell, 15);
            // run the commands
            $output = '';
            $endSentinel = "!~@#_DONE_#@~!";
            fwrite($shell, 'cd ~/public_html' . "\n");
            fwrite($shell, 'git pull' . "\n");
            fwrite($shell, 'echo ' . escapeshellarg($endSentinel) . "\n");
            while (true) {
                $o = stream_get_contents($shell, 15);
                if ($o === false) {
                    throw new Exception('Failed while reading output from shell');
                }
                $output .= $o;
                if (strpos($output, $endSentinel) !== false) {
                    break;
                }
            }
            fwrite($shell, 'composer install' . "\n");
            fclose($shell);
            $mailBody = "GitHub payload:\r\n"
                . print_r($data, true)
                . "\r\n\r\n"
                . "Output of `git pull`:\r\n"
                . $output
                . "\r\n"
                . 'That\'s all, toodles!';
            $mailSuccess = $this->sendEmail(true, $mailBody);
        } catch (Exception $e) {
            $mailSuccess = $this->sendEmail(false, strval($e));
        }
        if(!$mailSuccess) {
            header('HTTP/1.0 500 Internal Server Error');
            die('Failed to send email to admin!');
        }
        die("All good here!");
    }

    function sendEmail($success, $message)
    {
        $headers = 'Content-type: text/plain' . "\r\n" .
            'From: PathFinder <contact@'.SITE_DOMAIN.'>';
        $subject = '['.SITE_DOMAIN.'] ';
        if ($success) {
            $subject .= 'Deploy success';
        } else {
            $subject .= 'Deploy failure';
            $headers .= "\r\n" .
                'X-Priority: 1 (Highest)' . "\r\n" .
                'X-MSMail-Priority: High' . "\r\n" .
                'Importance: High';
        }
        return mail(
            EMAIL_RECIPIENT,
            $subject,
            $message,
            $headers
        );
    }
}