<?php
namespace Controller\User;

use Config\Database;

class Location{
  public static function setCurrentLocation($id, $lat, $lng){
    $conn = Database::connection();
    $created_at = date("Y-m-d H:i:s");
    $sql = "INSERT INTO user_location (user_id, lat, lng, created_at) VALUES ('$id', '$lat', '$lng', '$created_at');";
    if($conn->query($sql)){
      echo "Success";
    }else{
      echo "Error";
    }
  }

  public static function getCurrentLocation($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM user_location WHERE user_id = '$id' ORDER BY created_at DESC LIMIT 1";
    $result = $conn->query($sql);
    $jsonData = array();

    while ($arr = mysqli_fetch_assoc($result)) {
      array_push($jsonData,$arr);
    }

    echo str_replace(array('[', ']'), '', htmlspecialchars(json_encode($jsonData, JSON_UNESCAPED_UNICODE), ENT_NOQUOTES));
  }
}
