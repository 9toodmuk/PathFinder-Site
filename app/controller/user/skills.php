<?php
namespace App\Controller\User;

use App\Config\Database;

class Skills{
  public static function skillLoad($uid){
    $conn = Database::connection();
    $sql = "SELECT * FROM skill_lists WHERE user_id = '$uid';";
    return $conn->query($sql);
  }

  public static function skillLoadbyId($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM skill_lists WHERE id = '$id';";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result);
  }

  public static function editSkill($skill, $id){
    $conn = Database::connection();
    $sql = "UPDATE skill_lists SET name = '$skill' WHERE id = '$id';";
    if($conn->query($sql)){
      $arr = array('status' => true);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }else{
      $arr = array('status' => false, 'error' => $conn->error);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
  }

  public static function newSkill($skill, $id){
    $conn = Database::connection();
    $sql = "INSERT INTO skill_lists (name, user_id) VALUES ('$skill', '$id');";
    if($conn->query($sql)){
      $arr = array('status' => true);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }else{
      $arr = array('status' => false, 'error' => $conn->error);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
  }

  public static function removeSkill($id){
    $conn = Database::connection();
    $sql = "DELETE FROM skill_lists WHERE id='$id';";
    if($conn->query($sql)){
      $arr = array('status' => true);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }else{
      $arr = array('status' => false, 'error' => $conn->error);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
  }
}
