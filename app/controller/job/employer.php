<?php
namespace App\Controller\Job;

use App\Config\Database;

class Employer{
  public static function loadEMP($id = NULL){
    $conn = Database::connection();
    $sql = "SELECT * FROM company";
    if(!is_null($id)){
      $sql .= " WHERE id = '$id'";
    }
    return $conn->query($sql);
  }

  public static function loadAllEMP($offset = NULL, $limit = NULL){
    $conn = Database::connection();
    $sql = "SELECT * FROM company";
    if(!is_null($offset)){
      if(!is_null($limit)){
        $sql = $sql . " LIMIT $offset, $limit";
      }else{
        $sql = $sql . " LIMIT $offset";
      }
    }
    return $conn->query($sql);
  }

  public static function getAllCategory($id = NULL){
    $conn = Database::connection();
    $sql = "SELECT * FROM company_categories";
    if(!is_null($id)){
      $sql .= " WHERE id = '$id'";
    }
    return $conn->query($sql);
  }
}
