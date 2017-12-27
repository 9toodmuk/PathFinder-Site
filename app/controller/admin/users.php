<?php
namespace Controller\Admin;

use Config\Database;
use Controller\Utils\Utils;

class Users {
  public static function addAccount($email, $pass, $fname, $lname, $ugp){
    $created_date = date("Y-m-d H:i:s");
    $newpass = Utils::passhash($pass);
    $conn = Database::connection();

    $guid = Utils::getGUID();
    $sql = "INSERT INTO users (guid, email, password, user_group, created_at) VALUES ('$guid', '$email', '$newpass', '$ugp', '$created_date');";
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

  public static function usersCount(){
    $conn = Database::connection();
    $sql = "SELECT * FROM users;";
    $query = $conn->query($sql);
    return mysqli_num_rows($query);
  }

  public static function getUserEmail($id){
    $user = Users::getUser($id);
    return $user['email'];
  }

  public static function getUserName($id){
    $user = Users::getUser($id);
    return $user['first_name'].' '.$user['last_name'];
  }

  public static function getAllUsers(){
    $conn = Database::connection();
    $sql = "SELECT * FROM personal_details JOIN users ON users.id = personal_details.user_id";
    return $conn->query($sql);
  }

  public static function getUser($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM personal_details JOIN users ON users.id = personal_details.user_id WHERE users.id = '$id'";
    $query = $conn->query($sql);
    return mysqli_fetch_assoc($query);
  }

  public static function getGroupName($gid){
    $group = Users::userGroup($gid);
    return $group['name'];
  }

  public static function userGroup($gid){
    $conn = Database::connection();
    $sql = "SELECT * FROM user_groups WHERE id = '$gid';";
    $query = $conn->query($sql);
    return mysqli_fetch_array($query);
  }

  public static function getAllGroup(){
    $conn = Database::connection();
    $sql = "SELECT * FROM user_groups;";
    $query = $conn->query($sql);
    return $query;
  }

  public static function deleteAccount($id){
    $conn = Database::connection();
    $sql = "DELETE FROM users WHERE id = '$id';";
    if($conn->query($sql)){
      $sql = "DELETE FROM personal_details WHERE user_id = '$id';";
      if($conn->query($sql)){
        header("Location: /admin/users/");
        exit();
      }
    }
  }
}
