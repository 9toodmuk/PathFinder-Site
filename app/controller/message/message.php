<?php
namespace Controller\Message;
use Config\Database;
use Controller\Employer\Detail;
use Controller\User\Profile;
use Controller\Utils\Utils;

class Message {
    public static function getMessage($id){
        $conn = Database::connection();
        $sql = "SELECT * FROM message";
        if(!is_null($id)){
            $sql .= " WHERE id = '$id'";
        }
        return Message::queryMessage($conn->query($sql));
    }

    public static function getSentMessages($id){
        $conn = Database::connection();
        $sql = "SELECT * FROM message";
        if(!is_null($id)){
            $sql .= " WHERE sender = '$id'";
        }
        return Message::queryMessage($conn->query($sql));
    }

    public static function getInbox($id){
        $conn = Database::connection();
        $sql = "SELECT * FROM message";
        if(!is_null($id)){
            $sql .= " WHERE reciever = '$id'";
        }
        return Message::queryMessage($conn->query($sql));
    }

    function queryMessage($result) {
        $messages = array();
        while($message = mysqli_fetch_assoc($result)) {
            $array = array(
                'id' => $message['id'],
                'title' => $message['title'],
                'message' => $message['text'],
                'sender' => Message::getSender($message['sender'], $message['type']),
                'sentAt' => Utils::time_elapsed_string($message['sent_at']),
                'isReaded' => Message::isRead($message['readed']),
                'type' => $message['type']
            );
            array_push($messages, $array);
        }

        return $messages;
    }

    function isRead($readed) {
        $isRead = false;

        if ($readed == '1') {
            $isRead = true;
        }

        return $isRead;
    }

    function getSender($id, $type) {
        $sender = 'SYSTEM';
        switch ($type) {
            case '1':
                $user = mysqli_fetch_assoc(Profile::profileLoad($id));
                $sender = $user['first_name']." ".$user['last_name'];
            case '2':
                $employer = Detail::getDetails($id, true);
                $sender = $employer['name'];
        };
        return $sender;
    }

    function count($id) {
        $conn = Database::connection();
        $sql = "SELECT * FROM message WHERE reciever = '$id' AND readed = '0'";
        $inbox = $conn->query($sql);
        return array(
            'inbox' => mysqli_num_rows($inbox)
        );
    }
}