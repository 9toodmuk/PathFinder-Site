<?php
namespace Controller\Utils;

class FCM {
  public function send_notification($token, $payload_notification, $payload_data) {
    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array(
        'registration_ids' => $token,
        'priority' => 'normal',
        'notification' => $payload_notification,
        'data' => $payload_data
    );

    $headers = array(
        'Authorization: key=AAAAJw5Av1o:APA91bFfYbzxSwCGwL4JV9_gcK7-5V7n5ZdEPPLGkTWKieYpUcLvrc_MoCHS-1Qzmufkkyeot5b0QKRGZGdt9TA-Olq_HSdvwScUlR4Xjgb_Yvoo9k1exRM1K6Fkp3MATgHNNhkejUcT',
        'Content-Type: application/json'
    );
    // Open connection
    $ch = curl_init();
    // Set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Disabling SSL Certificate support temporary
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    // Execute post
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    // Close connection
    curl_close($ch);
  }
}
