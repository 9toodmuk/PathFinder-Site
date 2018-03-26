<?php
namespace App\Controller\Admin;

use App\Config\Database;
use App\Controller\View\Language;

class Postings {
  public static function addpostings($name, $responsibility, $qualification, $benefit, $capacity, $cap_type, $disability_req, $salary, $salarytype, $negetiable, $location, $type, $level, $exp_req, $edu_req, $category, $company){
    $conn = Database::connection();
    $type = Postings::joinType($type);

    $created_date = date("Y-m-d H:i:s");

    $sql = "INSERT INTO job_lists (name, responsibilities, qualification, benefit, capacity, cap_type, disability_req, salary, salary_type, negetiable, location, type, level, exp_req, edu_req, category_id, company_id, created_at) VALUES ('$name', '$responsibility', '$qualification', '$benefit', '$capacity', '$cap_type', '$disability_req', '$salary', '$salarytype', '$negetiable', '$location', '$type', '$level', '$exp_req', '$edu_req', '$category', '$company', '$created_date');";
    if($conn->query($sql)){
      echo "Success";
    }else{
      echo "Error";
    }
  }

  public static function editpostings($id, $name, $responsibility, $qualification, $benefit, $capacity, $cap_type, $disability_req, $salary, $salarytype, $negetiable, $location, $type, $level, $exp_req, $edu_req, $category, $company){
    $conn = Database::connection();
    $type = Postings::joinType($type);

    $sql = "UPDATE job_lists SET name = '$name', responsibilities = '$responsibility', qualification = '$qualification', benefit = '$benefit', capacity = '$capacity', cap_type = '$cap_type', disability_req = '$disability_req', salary = '$salary', salary_type = '$salarytype',";
    $sql .= "negetiable = '$negetiable', location = '$location', type = '$type', level = '$level', exp_req = '$exp_req', edu_req = '$edu_req', category_id = '$category', company_id = '$company' WHERE id = '$id'";

    if($conn->query($sql)){
      echo "Success";
    }else{
      echo "Error";
    }
  }

  public static function checkFeaturedJob($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM featured_jobs_list WHERE job_id = '$id';";
    $query = $conn->query($sql);
    return mysqli_num_rows($query);
  }

  public static function editfeatured($id){
    if(Postings::checkFeaturedJob($id) <= 0){
      Postings::addFeauturedJob($id);
    }else{
      Postings::deleteFeauturedJob($id);
    }
  }

  public static function addFeauturedJob($id){
    $created_date = date("Y-m-d H:i:s");

    $conn = Database::connection();
    $sql = "INSERT INTO featured_jobs_list (job_id, created_at) VALUES ('$id', '$created_date')";
    if($conn->query($sql)){
      echo "Success";
    }else{
      echo "Error";
    }
  }

  public static function deleteFeauturedJob($id){
    $conn = Database::connection();
    $sql = "DELETE FROM featured_jobs_list WHERE job_id = '$id';";
    if($conn->query($sql)){
      echo "Success";
    }else{
      echo "Error";
    }
  }

  public static function getPostingName($id){
    $posting = Postings::getPosting($id);
    return $posting['name'];
  }

  public static function getAllPostings(){
    $conn = Database::connection();
    $sql = "SELECT * FROM job_lists";
    return $conn->query($sql);
  }

  public static function getLastPostings($limit = 10){
    $conn = Database::connection();
    $sql = "SELECT * FROM job_lists ORDER BY id DESC LIMIT $limit;";
    return $conn->query($sql);
  }

  public static function getLastestPostingsDate(){
    $post = Postings::getLastPostings(1);
    $result = mysqli_fetch_assoc($post);
    return $result['created_at'];
  }

  public static function getPosting($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM job_lists WHERE id = '$id';";
    $query = $conn->query($sql);
    return mysqli_fetch_assoc($query);
  }

  public static function getPostingEmploymentType($id){
    $arr = Postings::getPosting($id);
    $type = Postings::joinEmpType($arr['type']);
    return $type;
  }

  public static function joinEmpType($type){
    $arr = explode(",", $type);
    $arr2 = array();
    foreach ($arr as $key) {
      array_push($arr2, Postings::employmentConverter($key));
    }
    return $arr2;
  }

  public static function deletepostings($id){
    $conn = Database::connection();
    $sql = "DELETE FROM job_lists WHERE id = '$id'";
    if($conn->query($sql)){
      header("Location: /admin/postings/");
      exit();
    }
  }

  public static function postingsCount(){
    $conn = Database::connection();
    $sql = "SELECT * FROM job_lists;";
    $query = $conn->query($sql);
    $num = mysqli_num_rows($query);
    return $num;
  }

  function joinType($type){
    return implode(",", $type);
  }

  public static function allPostingsType(){
    $arr = array("full", "part", "permanent", "temporary", "contract", "internship", "freelance");
    return $arr;
  }

  public static function jobLevel($level = 0){
    switch ($level) {
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
        echo 'ไม่ระบุ';
        break;
    }
  }

  public static function employmentConverter($type){
    switch ($type) {
      case 'full':
        return 'fulltime';
        break;
      case 'part':
        return 'parttime';
        break;
      case 'permanent':
        return 'permanent';
        break;
      case 'temporary':
        return 'temp';
        break;
      case 'contract':
        return 'contractjob';
        break;
      case 'internship':
        return 'internshipjob';
        break;
      case 'freelance':
        return 'freelance';
        break;
    }
  }

  public static function salaryType($level = 0){
    switch ($level) {
      case 1:
        return 'Monthly';
        break;
      case 2:
        return 'Hourly';
        break;
    }
  }

  public static function eduLevel($level = 0){
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
      case 5:
        echo 'ปริญญาเอก';
        break;
      default:
        echo 'ไม่จำกัด';
        break;
    }
  }

  public static function expLevel($level = '0'){
    $years = (string) $level;
    if($level == 0){
      echo "ไม่จำกัด";
    }else{
      echo $years." ปีขึ้นไป";
    }
  }
}
