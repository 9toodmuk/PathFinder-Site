<?php
namespace Controller\Auth;

use Controller\Utils\Utils;
use Controller\Auth\Login;
use Config\Database;

class Register{
  public static function register($email, $pass, $fname, $lname, $group = 1){
    Register::checkemail($email);

    $created_date = date("Y-m-d H:i:s");
    $newpass = Utils::passhash($pass);
    $conn = Database::connection();

    $guid = Utils::getGUID();

    $sql = "INSERT INTO users (guid, email, password, user_group, created_at) VALUES ('$guid', '$email', '$newpass', '$group', '$created_date');";
    if ($conn->query($sql)) {
      $userid = $conn->insert_id;
      $sql = "INSERT INTO personal_details (first_name, last_name, user_id) VALUES ('$fname', '$lname', '$userid');";
      if ($conn->query($sql)) {
        echo "Success";
      }
    }else{
      echo "Error";
    }
  }

  public static function checkemail($email){
    $conn = Database::connection();
    $sql = "SELECT * FROM users WHERE email = '$email';";
    $query = $conn->query($sql);
    if(mysqli_num_rows($query) >= 1){
      echo "EMailUsed";
      exit();
    }
  }

  public static function updateProfile($uid, $fname = NULL, $lname = NULL, $sex, $birthday, $address, $subdistrict, $district, $province, $postcode, $telephone, $min, $max, $exp){
    $conn = Database::connection();
    $sql = "SELECT * FROM personal_details WHERE user_id = '$uid';";
    $query = $conn->query($sql);
    if(mysqli_num_rows($query) >= 1){
      if($fname == NULL){
        if($lname == NULL){
          $sql = "UPDATE personal_details SET sex = '$sex', birthdate = '$birthday', address = '$address', subdistrict = '$subdistrict', district = '$district', postcode = '$postcode', province = '$province', telephone = '$telephone', experiences = '$exp' WHERE user_id = '$uid';";
        }else{
          $sql = "UPDATE personal_details SET last_name = '$lname', sex = '$sex', birthdate = '$birthday', address = '$address', subdistrict = '$subdistrict', district = '$district', postcode = '$postcode', province = '$province', telephone = '$telephone', experiences = '$exp' WHERE user_id = '$uid';";
        }
      }else{
        if($lname == NULL){
          $sql = "UPDATE personal_details SET first_name = '$fname', sex = '$sex', birthdate = '$birthday', address = '$address', subdistrict = '$subdistrict', district = '$district', postcode = '$postcode', province = '$province', telephone = '$telephone', experiences = '$exp' WHERE user_id = '$uid';";
        }else{
          $sql = "UPDATE personal_details SET first_name = '$fname', last_name = '$lname', sex = '$sex', birthdate = '$birthday', address = '$address', subdistrict = '$subdistrict', district = '$district', postcode = '$postcode', province = '$province', telephone = '$telephone', experiences = '$exp' WHERE user_id = '$uid';";
        }
      }
    }else{
      $sql = "INSERT INTO personal_details (first_name, last_name, sex, birthdate, address, subdistrict, district, province, postcode, telephone, experiences, user_id) VALUES ('$fname', '$lname', '$sex', '$birthday', '$address', '$subdistrict', '$district', '$province', '$postcode', '$telephone', '$exp', '$uid');";
    }
    if($conn->query($sql)){
      Register::updateSalary($min, $max, $uid);
      Register::updateStatus($uid);
    }
  }

  public static function createExp($uid, $edu, $exp, $company, $status, $start, $end, $name, $min, $max){
    $conn = Database::connection();
    Register::addEducation('', $edu, '', '', $uid);
    if($exp != 'new'){
      $sql = "UPDATE personal_details SET experiences = '$exp' WHERE user_id = '$uid';";
      $query = $conn->query($sql);
      Register::addExp($name, $company, $status, $start, $end, $uid);
    }
    Register::updateSalary($min, $max, $uid);
  }

  public static function updateStatus($id){
    $conn = Database::connection();
    $sql = "UPDATE users SET status = 1 WHERE id = '$id';";
    if($conn->query($sql)){
      header("Location: /stream/");
      exit();
    }
  }

  public static function updateSalary($min, $max, $uid){
    $conn = Database::connection();
    $salary = $min.'-'.$max;
    $sql = "UPDATE personal_details SET expected_salary = '$salary' WHERE user_id = '$uid';";
    $query = $conn->query($sql);
  }

  public static function addEducation($insititue_name, $background, $major, $gpa, $uid){
    $conn = Database::connection();
    $sql = "INSERT INTO education_lists (institute_name, background, major, gpa, user_id) VALUES ('$insititue_name', '$background', '$major', '$gpa', '$uid');";
    $query = $conn->query($sql);
  }

  public static function updateEducation($id, $insititue_name, $background, $major, $gpa){
    $conn = Database::connection();
    $sql = "UPDATE education_lists SET institute_name = '$insititue_name', background = '$background', major = '$major', gpa = '$gpa' WHERE id = '$id';";
    $query = $conn->query($sql);
  }

  public static function addExp($name, $company, $status, $start, $end, $uid){
    $conn = Database::connection();
    $sql = "INSERT INTO experience_lists (name, company, status, start_at, end_at, user_id) VALUES ('$name', '$company', '$status', '$start', '$end', '$uid');";
    $query = $conn->query($sql);
  }

  public static function updateExp($id, $company, $status, $start, $end){
    $conn = Database::connection();
    $sql = "UPDATE experience_lists SET name = '$company', status = '$status', start_at = '$start', end_at = '$end', detail = '$detail' WHERE id = '$id';";
    $query = $conn->query($sql);
  }
}
