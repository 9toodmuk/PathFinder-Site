<?php
namespace Controller\Auth;

use Controller\Utils\Utils;
use Config\Database;

class Login{

  public static function login($email, $pass){
    if(Login::validate($pass)){

      $newpass = Utils::passhash($pass);
      $conn = Database::connection();
      $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$newpass' AND (user_group = '1' OR user_group = '3');";
      if($query = $conn->query($sql)){
        if(mysqli_num_rows($query) <= 0){
          $array = array(
            'status' => false,
            'error' => 2
          );
          echo json_encode($array);
        }else{
          $arr = mysqli_fetch_array($query);
          Login::loginSuccess($arr['id']);
        }
      }else{
        $array = array(
          'status' => false,
          'error' => 1
        );
        echo json_encode($array);
      }
    }
  }

  public static function validate($pass){
    if($pass == ''){
      return false;
      exit();
    }
    return true;
  }

  public static function checkProfile($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM personal_details WHERE user_id = '$id';";
    $query = $conn->query($sql);
    return mysqli_num_rows($query);
  }

  public static function isUser($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM users WHERE id = '$id';";
    $query = $conn->query($sql);
    if(mysqli_num_rows($query) >= 1){
      return true;
    }else{
      return false;
    }
  }

  public static function checkStatus($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM users WHERE id = '$id';";
    $query = $conn->query($sql);
    $user = mysqli_fetch_array($query);
    return $user['status'];
  }

  public static function setUserLang($id, $lang){
    $conn = Database::connection();
    $sql = "UPDATE users SET language = '$lang' WHERE id = '$id';";
    $conn->query($sql);
  }

  public static function getUserGroup($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM users WHERE id = '$id';";
    $query = $conn->query($sql);
    $user = mysqli_fetch_array($query);
    return $user['user_group'];
  }

  public static function getUserLang($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM users WHERE id = '$id';";
    $query = $conn->query($sql);
    $user = mysqli_fetch_array($query);
    return $user['language'];
  }

  public static function loginSuccess($id){
    $_SESSION['social_id'] = $id;
    $_SESSION['language'] = Login::getUserLang($id);
    $array = array(
      'status' => true,
      'userid' => $id
    );
    echo json_encode($array);
  }

  public static function logout(){
    session_destroy();
    header("Location: /");
    exit();
  }
}
