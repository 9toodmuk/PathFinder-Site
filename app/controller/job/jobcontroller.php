<?php
namespace Controller\Job;

use Config\Database;
use Controller\User\Profile;
use Controller\View\View;

class JobController {
  public static function loadAllPosting($limit = NULL, $offset = NULL, $id = NULL){
    $conn = Database::connection();
    $sql = "SELECT * FROM job_lists";
    if(!is_null($id)){
      $sql = $sql . " WHERE company_id = '$id'";
    }

    if(!is_null($offset)){
      $sql = $sql . " LIMIT $offset, $limit";
    }else{
      if(!is_null($limit)){
        $sql = $sql . " LIMIT $limit";
      }
    }

    return $conn->query($sql);
  }

  public static function removePost($id){
    $conn = Database::connection();
    $sql = "DELETE FROM job_lists WHERE id = '$id';";
    if($conn->query($sql)){
      $array = array(
        'success' => true
      );
      echo json_encode($array);
    }else{
      $array = array(
        'success' => false
      );
      echo json_encode($array);
    }
  }

  public static function loadTopJob($limit = 0){
    $conn = Database::connection();
    $sql = "SELECT * FROM featured_jobs_list INNER JOIN job_lists ON job_lists.id = featured_jobs_list.job_id";
    if($limit != 0){
      $sql = $sql . " LIMIT $limit";
    }
    return $conn->query($sql);
  }

  public static function loadByCategory($category, $limit = NULL, $offset = NULL){
    $conn = Database::connection();
    $sql = "SELECT * FROM job_lists";
    if($category != 0){
      $sql .= " WHERE category_id = '$category'";
    }
    if(!is_null($offset)){
      $sql = $sql . " LIMIT $offset, $limit";
    }else{
      if(!is_null($limit)){
        $sql = $sql . " LIMIT $limit";
      }
    }
    return $conn->query($sql);
  }

  public static function applyJob($uid, $jid, $message){
    $created_date = date("Y-m-d H:i:s");

    $conn = Database::connection();
    $sql = "INSERT INTO application_lists (user_id, job_id, message, status, created_at) VALUES ('$uid', '$jid', '$message', '0', '$created_date');";
    if($conn->query($sql)){
      $array = array(
        'success' => true
      );
      echo json_encode($array);
    }else{
      $array = array(
        'success' => false
      );
      echo json_encode($array);
    }
  }

  public static function saveJob($uid, $jid){
    if(!JobController::getSaveStatus($uid, $jid)){
      JobController::addFavJob($uid, $jid);
    }else{
      JobController::deleteFavJob($uid, $jid);
    }

  }

  public static function addFavJob($uid, $jid){
    $created_date = date("Y-m-d H:i:s");

    $conn = Database::connection();
    $sql = "INSERT INTO job_fav_lists (user_id, job_id, created_at) VALUES ('$uid', '$jid', '$created_date');";
    if($conn->query($sql)){
      $array = array(
        'success' => true,
        'add' => true
      );
      echo json_encode($array);
    }else{
      $array = array(
        'success' => false
      );
      echo json_encode($array);
    }
  }

  public static function deleteFavJob($uid, $jid){
    $conn = Database::connection();
    $sql = "DELETE FROM job_fav_lists WHERE user_id = '$uid' AND job_id = '$jid';";
    if($conn->query($sql)){
      $array = array(
        'success' => true,
        'add' => false
      );
      echo json_encode($array);
    }else{
      $array = array(
        'success' => false
      );
      echo json_encode($array);
    }
  }

  public static function getApplyStatus($uid, $jid){
    $conn = Database::connection();
    $sql = "SELECT * FROM application_lists WHERE user_id = '$uid' AND job_id = '$jid';";
    $query = $conn->query($sql);

    if(mysqli_num_rows($query) >= 1){
      return true;
    }else{
      return false;
    }
  }

  public static function getSaveStatus($uid, $jid){
    $conn = Database::connection();
    $sql = "SELECT * FROM job_fav_lists WHERE user_id = '$uid' AND job_id = '$jid';";
    $query = $conn->query($sql);

    if(mysqli_num_rows($query) >= 1){
      return true;
    }else{
      return false;
    }
  }

  public static function loadJobPosting($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM job_lists WHERE id = '$id';";
    $query = $conn->query($sql);

    return mysqli_fetch_array($query);
  }

  public static function isNegetiable($id){
    $job = JobController::loadJobPosting($id);
    if($job['negetiable'] == 1){
      return true;
    }else{
      return false;
    }
  }

  public static function getEmployer($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM company WHERE id = '$id';";
    $query = $conn->query($sql);

    return mysqli_fetch_array($query);
  }

  public static function getEmpCategory($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM company_categories WHERE id = '$id';";
    $query = $conn->query($sql);

    return mysqli_fetch_array($query);
  }

  public static function getJobCapacity($id){
    $job = JobController::loadJobPosting($id);
    if($job['cap_type'] == 1){
      return true;
    }else{
      return false;
    }
  }

  public static function getJobCategory($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM job_categories WHERE id = '$id';";
    $query = $conn->query($sql);

    return mysqli_fetch_array($query);
  }

  public static function getEmployerName($id){
    $emp = JobController::getEmployer($id);
    return $emp['name'];
  }

  public static function getEmployerLogo($id){
    $emp = JobController::getEmployer($id);
    return $emp['logo'];
  }

  public static function getEmployerCat($id){
    $emp = JobController::getEmployer($id);
    return JobController::getEmpCatName($emp['category_id']);
  }

  public static function getEmpCatName($id){
    $empcat = JobController::getEmpCategory($id);
    return $empcat['name'];
  }

  public static function getJobCatName($id){
    $jobcat = JobController::getJobCategory($id);
    return $jobcat['name'];
  }

  public static function getSaveCount($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM job_fav_lists WHERE job_id = '$id';";
    $query = $conn->query($sql);

    return mysqli_num_rows($query);
  }

  public static function addCount($id){
    $conn = Database::connection();
    $sql = "UPDATE job_lists SET viewer = viewer + 1 WHERE id = '$id';";
    $conn->query($sql);
  }

  public static function getJobLevel($type = 0){
    switch ($type) {
      case 0:
        echo 'ไม่ระบุ';
        break;
      case 1:
        echo 'ระดับเจ้าหน้าที่';
        break;
      case 2:
        echo 'หัวหน้างาน';
        break;
      case 3:
        echo 'ผู้จัดการ / อาวุโส';
        break;
      case 4:
        echo 'ผู้บริหารระดับสูง';
        break;
      default:
        'ไม่ระบุ';
        break;
    }
  }

  public static function getEducationRequired($level = 0){
    switch ($level) {
      case 0:
        echo 'ไม่จำกัด';
        break;
      case 1:
        echo 'มัธยมศึกษาตอนปลาย';
        break;
      case 2:
        echo 'อนุปริญญา';
        break;
      case 3:
        echo 'ปริญญาตรี';
        break;
      case 4:
        echo 'ปริญญาโท';
        break;
      case 4:
        echo 'ปริญญาเอก';
        break;
      default:
        'ไม่จำกัด';
        break;
    }
  }

  public static function getExpRequired($level = '0'){
    $years = (string) $level;
    if($level == 0){
      echo "ไม่จำกัด";
    }else{
      echo $years." ปีขึ้นไป";
    }
  }

  public static function getGetSalaryType($type = 0){
    if($type == 1){
      echo "ต่อเดือน";
    }else if($type == 2){
      echo "ต่อชั่วโมง";
    }else{
      echo '';
    }
  }

  public static function getPostedTime($time){
    echo $mysqldate = date( 'd/m/Y', strtotime($time) );
  }
}
