<?php
namespace Controller\Volunteer;

use Controller\Utils\Utils;
use Config\Database;

class VolunteerController{
  public static function login($email, $pass){
    if(VolunteerController::validate($pass)){

      $newpass = Utils::passhash($pass);
      $conn = Database::connection();
      $sql = "SELECT * FROM volunteer WHERE email = '$email' AND password = '$newpass';";
      if($query = $conn->query($sql)){
        if(mysqli_num_rows($query) <= 0){
          $arr = array('status' => false, 'error' => 1);
          echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        }else{
          $query = mysqli_fetch_array($query);
          $arr = array('status' => true, 'uid' => $query['id']);
          echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        }
      }else{
        $arr = array('status' => false, 'error' => 0);
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
      }
    }
  }

  public static function register($email, $pass, $fname, $lname){
    VolunteerController::checkemail($email);

    $created_date = date("Y-m-d H:i:s");
    $newpass = Utils::passhash($pass);
    $conn = Database::connection();

    $sql = "INSERT INTO volunteer (email, password, created_at) VALUES ('$email', '$newpass', '$created_date');";
    if ($conn->query($sql)) {
      $userid = $conn->insert_id;
      $sql = "INSERT INTO volunteer_profile (first_name, last_name, volunteer_id) VALUES ('$fname', '$lname', '$userid');";
      if ($conn->query($sql)) {
        $arr = array('status' => true);
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
      }
    }else{
      $arr = array('status' => false, 'error' => 0);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
  }

  public static function checkemail($email){
    $conn = Database::connection();
    $sql = "SELECT * FROM volunteer WHERE email = '$email';";
    $query = $conn->query($sql);
    if(mysqli_num_rows($query) >= 1){
      $arr = array('status' => false, 'error' => 1);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
      exit();
    }
  }

  public static function requestVolunteer($id, $cat, $lat, $lng){
    $created_date = date("Y-m-d H:i:s");
    $conn = Database::connection();
    $sql = "INSERT INTO volunteer_order (user_id, category, lat, lng, created_at) VALUES ('$id', '$cat', '$lat', '$lng', '$created_date')";
    if($conn->query($sql)){
      $oid = $conn->insert_id;
      $sql = "UPDATE users SET on_order = '$oid' WHERE id = '$id'";
      if($conn->query($sql)){
        $arr = array('status' => true, 'order_id' => $oid);
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
      }else{
        $arr = array('status' => false);
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
      }
    }else{
      $arr = array('status' => false);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
  }

  public static function getAllOrder(){
    $conn = Database::connection();
    $sql = "SELECT * FROM volunteer_order";
    $result = $conn->query($sql);
    return $result;
  }

  public static function checkOrderStatus($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM volunteer_order WHERE id = '$id';";
    $result = $conn->query($sql);
    return mysqli_fetch_assoc($result);
  }

  public static function setOrderStatus($id, $status, $vid = NULL){
    $conn = Database::connection();
    $result = VolunteerController::checkOrderStatus($id);

    if($result['status'] != 4){
      $sql = "UPDATE volunteer_order SET status = '$status'";

      if($vid != NULL){
        $sql .= ", volunteer_id = '$vid'";
      }

      $sql .= " WHERE id = '$id'";

      if($conn->query($sql)){
        if($vid != NULL){
          if(VolunteerController::setVolunteerStatus($vid, 1, $id)){
              $arr = array('status' => true);
              echo json_encode($arr, JSON_UNESCAPED_UNICODE);
          }
        }else{
          $arr = array('status' => true);
          echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        }

        if($status == 4 || $status == 3){
          VolunteerController::setVolunteerStatus($vid, 0, 0);
          $sql = "UPDATE users SET on_order = '0' WHERE on_order = '$id'";
          $conn->query($sql);
        }
      }else{
        $arr = array('status' => false, 'error' => 1);
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
      }
    }else{
        $arr = array('status' => false, 'error' => 2);
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
  }

  public static function setVolunteerStatus($id, $status, $order){
    $conn = Database::connection();
    $sql = "UPDATE volunteer SET status = '$status', on_order = '$order' WHERE id = '$id';";
    return $conn->query($sql);
  }

  public static function getCategory($id = NULL){
    $conn = Database::connection();
    $sql = "SELECT * FROM volunteer_categories";
    if($id != NULL){
      $sql .= " WHERE id = '$id'";
    }
    return $conn->query($sql);
  }

  public static function getVolunteer($id){
    $conn = Database::connection();
    $sql = "SELECT volunteer.id, volunteer.email, volunteer_profile.first_name, volunteer_profile.last_name, volunteer_profile.profile_picture, volunteer_profile.telephone, volunteer.on_order, volunteer.category,
    volunteer.status, volunteer.validate, volunteer.online FROM volunteer JOIN volunteer_profile ON volunteer.id = volunteer_profile.volunteer_id WHERE volunteer.id = '$id';";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result);
  }

  public static function isOnline($id){
    $volunteer = VolunteerController::getVolunteer($id);
    if($volunteer['online'] == 1){
      return true;
    }else{
      return false;
    }
  }

  public static function setOnline($id, $online, $category = 0){
    $conn = Database::connection();
    $sql = "UPDATE volunteer SET online = '$online', category = '$category' WHERE id = '$id';";
    if($conn->query($sql)){
      $arr = array('status' => true);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }else{
      $arr = array('status' => false, 'error' => 0);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
  }

  public static function setLocation($id, $lat, $lng){
    $conn = Database::connection();
    $updated_at = date("Y-m-d H:i:s");
    $location = VolunteerController::getLocation($id);
    if(mysqli_num_rows($location) > 0){
      $sql = "UPDATE volunteer_location SET lat = '$lat', lng = '$lng', updated_at = '$updated_at' WHERE volunteer_id = '$id';";
    }else{
      $sql = "INSERT INTO volunteer_location (lat, lng, updated_at, volunteer_id) VALUES ('$lat', '$lng', '$updated_at', '$id');";
    }
    if($conn->query($sql)){
      $arr = array('status' => true);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }else{
      $arr = array('status' => false, 'error' => 0);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
  }

  public static function setToken($id, $token){
    $conn = Database::connection();
    $sql = "INSERT INTO volunteer_tokens (token, volunteer_id) VALUES ('$token', '$id');";
    if($conn->query($sql)){
      $arr = array('status' => true);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }else{
      $arr = array('status' => false, 'error' => 0);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
  }

  public static function getLocation($id = NULL){
    $conn = Database::connection();
    $sql = "SELECT * FROM volunteer_location";
    if($id != NULL){
       $sql .= " WHERE volunteer_id = '$id'";
    }
    return $conn->query($sql);
  }

  public static function validate($pass){
    if($pass == ''){
      return false;
      exit();
    }
    return true;
  }

  public static function getInRangeVolunteer($lat, $lng){
    $conn = Database::connection();
    $sql = "SELECT * FROM volunteer_location WHERE ACOS( SIN( RADIANS( `lat` ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( `lat` )) * COS( RADIANS( $lat )) * COS( RADIANS( `lng` ) - RADIANS( $lng )) ) * 6380 < 1;";
    return $conn->query($sql);
  }

  public static function changeProfilePic($id, $picture){
    $conn = Database::connection();
    $sql = "UPDATE volunteer_profile SET profile_picture = '$picture' WHERE volunteer_id = '$id'";
    return $conn->query($sql);
  }

  public static function editProfile($firstname, $lastname, $id){
    $conn = Database::connection();
    $sql = "UPDATE volunteer_profile SET first_name = '$firstname', last_name = '$lastname' WHERE volunteer_id = '$id'";
    if($conn->query($sql)){
      $arr = array('status' => true);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }else{
      $arr = array('status' => false);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
  }
}
