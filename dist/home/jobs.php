<?php
  include_once $_SERVER['DOCUMENT_ROOT'].'/dist/config.php';

  if(isset($_GET["status"])){
    $status = $_GET["status"];
    if($status == "loadfeaturedjob"){
      $sql = "SELECT job_lists.id, name, responsibilities, qualification, benefit, salary, salary_type, location, type, level, exp_req, edu_req, category_id, company_id, job_lists.created_at FROM job_lists INNER JOIN featured_jobs_list ON job_lists.id = featured_jobs_list.job_id";
      $query = $conn->query($sql);
      $jsonData = array();
      while ($arr = mysqli_fetch_assoc($query)) {
        array_push($jsonData,$arr);
      }
      echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
    }else if($status == "loadallemp"){
        $sql = "SELECT * FROM company;";
      $query = $conn->query($sql);
      $jsonData = array();
      while ($arr = mysqli_fetch_assoc($query)) {
        array_push($jsonData,$arr);
      }
      echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
    }
  }
?>
