<?php
namespace Controller\User;

use Config\Database;

class Experiences{
  public static function newExp($id, $title, $emp, $start, $end, $now){
    $conn = Database::connection();
    $sql = "INSERT INTO experience_lists (name, company, status, start_at, end_at, user_id) VALUES ('$title', '$emp', '$now', '$start', '$end', '$id')";
    if($conn->query($sql)){
      echo "Success";
    }else{
      echo "Error";
    }
  }

  public static function editExp($id, $title, $emp, $start, $end, $now){
    $conn = Database::connection();
    $sql = "UPDATE experience_lists SET name = '$title', company = '$emp', start_at = '$start', end_at = '$end', status = '$now' WHERE id = '$id'";
    if($conn->query($sql)){
      echo "Success";
    }else{
      echo "Error";
    }
  }

  public static function removeExp($id){
    $conn = Database::connection();
    $sql = "DELETE FROM experience_lists WHERE id = '$id'";
    if($conn->query($sql)){
      echo "Success";
    }else{
      echo "Error";
    }
  }

  public static function expLoad($uid){
    $conn = Database::connection();
    $sql = "SELECT * FROM experience_lists WHERE user_id = '$uid';";
    return $conn->query($sql);
  }

  public static function expLoadbyId($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM experience_lists WHERE id = '$id';";
    $result = $conn->query($sql);

    return mysqli_fetch_array($result);
  }
}
