<?php
namespace Controller\Employer;

use Config\Database;

class Detail {
  public static function edit($field, $data, $id){
    $conn = Database::connection();
    $sql = "UPDATE company SET $field = '$data' WHERE id = '$id';";
    if($conn->query($sql)){
      $result = array(
        'status' => true
      );
      echo json_encode($result);
    }else{
      $result = array(
        'status' => false
      );
      echo json_encode($result);
    }
  }

  public static function changeLogo($id, $url){
    $conn = Database::connection();
    $sql = "UPDATE company SET logo = '$url' WHERE user_id = '$id';";
    $conn->query($sql);
  }

  public static function getEmpId($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM company WHERE user_id = '$id';";
    $result = $conn->query($sql);
    $result = mysqli_fetch_array($result);

    return $result['id'];
  }

  public static function getDetails($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM company JOIN users WHERE company.user_id = '$id' AND users.id = '$id';";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result);
  }

  public static function getLogo($id){
    $result = Detail::getDetails($id);
    return $result['logo'];
  }

  public static function getSettings($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM company_settings WHERE user_id = '$id';";
    $result = $conn->query($sql);
    return mysqli_fetch_array($result);
  }

  public static function editLocation($id, $name, $address1, $address2, $city, $province, $postcode, $telephone){
    $conn = Database::connection();
    $sql = "UPDATE company_location SET name = '$name', address = '$address1', address2 = '$address2', city = '$city',
    province = '$province', postcode = '$postcode', telephone = '$telephone' WHERE id = '$id';";
    if($conn->query($sql)){
      $result = array(
        'status' => true
      );
      echo json_encode($result);
    }else{
      $result = array(
        'status' => false,
        'error' => $conn->error
      );
      echo json_encode($result);
    }
  }

  public static function addLocation($name, $address1, $address2, $city, $province, $postcode, $telephone, $id){
    $conn = Database::connection();
    $main = Detail::getLocation($id, true);

    if(mysqli_num_rows($main) >= 1){
      $ismain = 0;
    }else{
      $ismain = 1;
    }

    $sql = "INSERT INTO company_location (name, address, address2, city, province, postcode, telephone, main_location, company_id)
    VALUES ('$name', '$address1', '$address2', '$city', '$province', '$postcode', '$telephone', '$ismain', '$id');";
    if($conn->query($sql)){
      $result = array(
        'status' => true
      );
      echo json_encode($result);
    }else{
      $result = array(
        'status' => false
      );
      echo json_encode($result);
    }
  }

  public static function removeLocation($id, $cid){
    $main = Detail::getLocation($id, true, false);

    if(mysqli_num_rows($main) >= 1){
      $ismain = true;
    }else{
      $ismain = false;
    }

    $conn = Database::connection();
    $sql = "DELETE FROM company_location WHERE id = '$id';";

    if($conn->query($sql)){
      if($ismain){

        $newmain = Detail::getLocation($cid);
        while ($row = mysqli_fetch_array($newmain)) {
          Detail::setMainLocation($row['id'], $cid);
          break;
        }

      }else{
        $result = array(
          'status' => true
        );
        echo json_encode($result);
      }
    }else{
      $result = array(
        'status' => false
      );
      echo json_encode($result);
    }
  }

  public static function setMainLocation($id, $cid){
    $nomain = false;
    $conn = Database::connection();
    $main = Detail::getLocation($cid, true, true);
    if(mysqli_num_rows($main) >= 1){
      $ismain = true;
    }else{
      $ismain = false;
      $nomain = true;
    }

    if($ismain){
      $main = mysqli_fetch_array($main);
      $oldid = $main['id'];

      $sql = "UPDATE company_location SET main_location = '0' WHERE id = '$oldid';";
      if($conn->query($sql)){
        $nomain = true;
      }
    }

    if($nomain){
      $sql = "UPDATE company_location SET main_location = '1' WHERE id = '$id';";
      if($conn->query($sql)){
        $result = array(
          'status' => true
        );
        echo json_encode($result);
      }else{
        $result = array(
          'status' => false
        );
        echo json_encode($result);
      }
    }
  }

  public static function getLastPostings($id, $lastest = false, $offset = NULL, $limit = NULL){
    $conn = Database::connection();
    $sql = "SELECT * FROM job_lists WHERE company_id = '$id'";

    if($lastest){
      $sql .= " ORDER BY 'created_at' DESC";
    }
    if(!is_null($offset)){
      if(!is_null($limit)){
        $sql .= " LIMIT $offset, $limit";
      }else{
        $sql .= " LIMIT $offset";
      }
    }

    return $conn->query($sql);
  }

  public static function getLastApplications($id, $lastest = false, $offset = NULL, $limit = NULL){
    $conn = Database::connection();
    $sql = "SELECT * FROM application_lists JOIN job_lists ON application_lists.job_id = job_lists.id WHERE job_lists.company_id = '$id'";

    if($lastest){
      $sql .= " ORDER BY 'created_at' DESC";
    }
    if(!is_null($offset)){
      if(!is_null($limit)){
        $sql .= " LIMIT $offset, $limit";
      }else{
        $sql .= " LIMIT $offset";
      }
    }

    return $conn->query($sql);
  }

  public static function getLocation($id, $primary = false, $bycomp = true){
    $conn = Database::connection();
    $sql = "SELECT * FROM company_location";

    if($bycomp){
      $sql .= " WHERE company_id = '$id'";
    }else{
      $sql .= " WHERE id = '$id'";
    }

    if($primary){
      $sql .= " AND main_location = 1";
    }

    $sql .= " ORDER BY id";

    return $conn->query($sql);
  }

  public static function updateSettings($id, $sendemail, $senddetail){
    $conn = Database::connection();
    $sql = "UPDATE company_settings SET sendemail = '$sendemail', senddetail = '$senddetail' WHERE id = '$id'";
    if($conn->query($sql)){
      $result = array(
        'updated' => true
      );
      return $result;
    }else{
      $result = array(
        'updated' => false,
        'errorUpdate' => $conn->error
      );
      return $result;
    }
  }
}
