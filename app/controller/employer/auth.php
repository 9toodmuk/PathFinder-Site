<?php
namespace App\Controller\Employer;

use App\Config\Database;
use App\Controller\Utils\Utils;
use App\Controller\Auth\Login;

class Auth {
  public static function login($email, $pass){
    if(Auth::validate($pass)){

      $newpass = Utils::passhash($pass);
      $conn = Database::connection();
      $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$newpass' AND user_group = '2';";
      if($query = $conn->query($sql)){
        if(mysqli_num_rows($query) <= 0){
          $result = array(
            'status' => false,
            'error' => 'nouser'
          );
          echo json_encode($result);
        }else{
          $arr = mysqli_fetch_array($query);
          $result = array(
            'status' => true,
          );
          echo json_encode($result);
          $_SESSION['emp_id'] = $arr['id'];
          $_SESSION['language'] = Login::getUserLang($arr['id']);
        }
      }else{
        $result = array(
          'status' => false,
          'error' => $conn->error
        );
        echo json_encode($result);
      }
    }
  }

  public static function checkPass($id, $pass){
    $newpass = Utils::passhash($pass);
    $conn = Database::connection();
    $sql = "SELECT * FROM users WHERE id = '$id' AND password = '$newpass' AND user_group = '2';";
    if($query = $conn->query($sql)){
      if(mysqli_num_rows($query) <= 0){
        $result = array(
          'status' => false,
          'error' => 'wrongpassword'
        );
        echo json_encode($result);
        return false;
      }else{
        return true;
      }
    }
  }

  public static function changePassword($id, $pass){
    $newpass = Utils::passhash($pass);
    $conn = Database::connection();
    $sql = "UPDATE users SET password = '$newpass' WHERE id = '$id';";
    if($conn->query($sql)){
      $result = array(
        'passchanged' => true
      );
      return $result;
    }else{
      $result = array(
        'passchanged' => false
      );
      return $result;
    }
  }

  public static function register($email, $pass, $name, $contact, $category, $contactemail, $section, $telephone){
    Auth::checkemail($email);

    $created_date = date("Y-m-d H:i:s");
    $newpass = Utils::passhash($pass);
    $conn = Database::connection();

    $group = '2';

    $sql = "INSERT INTO users (email, password, user_group, created_at) VALUES ('$email', '$newpass', '$group', '$created_date');";
    if ($conn->query($sql)) {
      $userid = $conn->insert_id;
      $sql = "INSERT INTO company (name, telephone, contact_name, contact_email, section, category_id, user_id) VALUES ('$name', '$telephone', '$contact', '$contactemail', '$section', '$category', '$userid');";
      if ($conn->query($sql)) {
        $sql = "INSERT INTO company_settings (user_id) VALUES ('$userid');";
        if ($conn->query($sql)) {
          $result = array(
            'status' => true,
            'userid' => $userid
          );
          echo json_encode($result);
        }
      }
    }else{
      $result = array(
        'status' => false,
        'reason' => 2
      );
      echo json_encode($result);
    }
  }

  public static function checkemail($email){
    $conn = Database::connection();
    $sql = "SELECT * FROM users WHERE email = '$email';";
    $query = $conn->query($sql);
    if(mysqli_num_rows($query) >= 1){
      $result = array(
        'status' => false,
        'reason' => 1
      );
      echo json_encode($result);
      exit();
    }
  }

  public static function validate($pass){
    if($pass == ''){
      return false;
      exit();
    }
    return true;
  }
}
