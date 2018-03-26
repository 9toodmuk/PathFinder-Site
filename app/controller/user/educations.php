<?php
namespace App\Controller\User;

use App\Config\Database;

class Educations{
  public static function newEdu($id, $institue, $level, $major, $gpa){
    $conn = Database::connection();
    $sql = "INSERT INTO education_lists (institute_name, background, major, gpa, user_id) VALUES ('$institue', '$level', '$major', '$gpa', '$id')";
    if($conn->query($sql)){
      return "Success";
    }else{
      return "Error";
    }
  }

  public static function editEdu($id, $institue, $level, $major, $gpa){
    $conn = Database::connection();
    $sql = "UPDATE education_lists SET institute_name = '$institue', background = '$level', major = '$major', gpa = '$gpa' WHERE id = '$id'";
    if($conn->query($sql)){
      return "Success";
    }else{
      return "Error";
    }
  }

  public static function removeEdu($id){
    $conn = Database::connection();
    $sql = "DELETE FROM education_lists WHERE id = '$id'";
    if($conn->query($sql)){
      return "Success";
    }else{
      return "Error";
    }
  }

  public static function eduLoad($uid){
    $conn = Database::connection();
    $sql = "SELECT * FROM education_lists WHERE user_id = '$uid';";
    return $conn->query($sql);
  }

  public static function eduLoadbyId($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM education_lists WHERE id = '$id';";
    $result = $conn->query($sql);

    return mysqli_fetch_array($result);
  }
}
