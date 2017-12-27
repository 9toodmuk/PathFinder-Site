<?php
namespace Controller\Admin;

use Config\Database;

class Applications {
  public static function addApplication($uid, $jid, $status){
    $conn = Database::connection();

    $created_date = date("Y-m-d H:i:s");

    $sql = "INSERT INTO application_lists (user_id, job_id, status, created_at) VALUES ('$uid', '$jid', '$status', '$created_date');";

    if($conn->query($sql)){
      echo "Success";
    }else{
      echo "Error";
    }
  }

  public static function loadAllApplication(){
    $conn = Database::connection();
    $sql = "SELECT * FROM application_lists";
    return $conn->query($sql);
  }

  public static function loadLastApplication(){
    $conn = Database::connection();
    $sql = "SELECT * FROM application_lists ORDER BY id DESC LIMIT 10;";
    return $conn->query($sql);
  }

  public static function getApplication($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM application_lists WHERE id = '$id'";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result);
  }

  public static function deleteApplication($id){
    $conn = Database::connection();
    $sql = "DELETE FROM application_lists WHERE id = '$id'";
    if($conn->query($sql)){
      header("Location: /admin/applications/");
      exit();
    }
  }

  public static function applicationCount(){
    $app = Applications::loadAllApplication();
    return mysqli_num_rows($app);
  }
}
