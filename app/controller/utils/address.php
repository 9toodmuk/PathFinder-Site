<?php
namespace Controller\Utils;

use Config\Database;

class Address {
  public static function getAllProvince($thai = true){
    $conn = Database::connection();
    $sql = "SELECT PROVINCE_ID as id, ";

    if($thai){
      $sql .= "PROVINCE_NAME as name ";
    }else{
      $sql .= "PROVINCE_NAME_ENG as name ";
    }

    $sql .= "FROM address_province ORDER BY CONVERT (name USING tis620)  ASC";

    return $conn->query($sql);
  }

  public static function getProvince($id, $thai = true){
    $conn = Database::connection();
    $sql = "SELECT PROVINCE_ID as id, ";

    if($thai){
      $sql .= "PROVINCE_NAME as name ";
    }else{
      $sql .= "PROVINCE_NAME_ENG as name ";
    }

    $sql .= "FROM address_province WHERE PROVINCE_ID = '$id'";

    return $conn->query($sql);
  }

  public static function getProvinceName($id, $thai = true){
    $result = Address::getProvince($id, $thai);
    $result = mysqli_fetch_assoc($result);
    return $result['name'];
  }

  public static function getAmphurName($id, $thai = true){
    $result = Address::getAmphur($id, $thai);
    $result = mysqli_fetch_assoc($result);
    return $result['name'];
  }

  public static function getAmphurByProvince($id, $thai = true){
    $conn = Database::connection();
    $sql = "SELECT AMPHUR_ID as id, ";

    if($thai){
      $sql .= "AMPHUR_NAME as name ";
    }else{
      $sql .= "AMPHUR_NAME_ENG as name ";
    }

    $sql .= "FROM address_amphur WHERE PROVINCE_ID = '$id' ORDER BY CONVERT (name USING tis620)  ASC";

    return $conn->query($sql);
  }

  public static function getAmphur($id, $thai = true){
    $conn = Database::connection();
    $sql = "SELECT AMPHUR_ID as id, ";

    if($thai){
      $sql .= "AMPHUR_NAME as name ";
    }else{
      $sql .= "AMPHUR_NAME_ENG as name ";
    }

    $sql .= "FROM address_amphur WHERE AMPHUR_ID = '$id' ORDER BY CONVERT (name USING tis620)  ASC";

    return $conn->query($sql);
  }
}
