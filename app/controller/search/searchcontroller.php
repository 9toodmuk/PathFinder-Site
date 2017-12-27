<?php
namespace Controller\Search;

use Config\Database;

class SearchController {
  public static function search($query){
    $conn = Database::connection();
    $sql = "(SELECT id, 'company' as type FROM company WHERE company.name LIKE '%$query%') UNION
    (SELECT id, 'job' as type FROM job_lists WHERE job_lists.name LIKE '%$query%') UNION
    (SELECT user_id, 'user' as type FROM personal_details WHERE personal_details.first_name LIKE '%$query%' OR personal_details.last_name LIKE '%$query%')";
    $result = $conn->query($sql);
    return $result;
  }

  public static function advancesearch($query, $category, $location, $type){
    $category = ($category != "") ? explode(",", $category) : "";
    $location = ($location != "") ? explode(",", $location) : "";
    $type = ($type != "") ? explode(",", $type) : "";

    $categoryCondition = array();
    $locationCondition = array();
    $typeCondition = array();

    if($category != ""){
      foreach ($category as $value) {
        array_push($categoryCondition, "job_lists.category_id = '$value'");
      }
    }

    if($location != ""){
      foreach ($location as $value) {
        array_push($locationCondition, "company_location.province = '$value'");
      }
    }

    if($type != ""){
      foreach ($type as $value) {
        array_push($typeCondition, "job_lists.type LIKE '%$value%'");
      }
    }

    $conn = Database::connection();
    $sql = "SELECT job_lists.id AS id, company_location.province as province FROM job_lists JOIN company_location ON job_lists.location = company_location.id";

    $firstword = true;

    if($query != ""){
      $sql .= " WHERE job_lists.name LIKE '%$query%'";
      $firstword = false;
    }

    if(sizeof($categoryCondition) >= 1){
      if($firstword){
        $sql .= " WHERE ";
      }else{
        $sql .= " AND ";
      }
      $i = 1;
      foreach ($categoryCondition as $value) {
        $sql .= ($i == 1) ? "$value" : " OR $value";
        $i++;
      }
    }

    if(sizeof($locationCondition) >= 1){
      if($firstword){
        $sql .= " WHERE ";
      }else{
        $sql .= " AND ";
      }
      $i = 1;
      foreach ($locationCondition as $value) {
        $sql .= ($i == 1) ? "$value" : " OR $value";
        $i++;
      }
    }

    if(sizeof($typeCondition) >= 1){
      if($firstword){
        $sql .= " WHERE ";
      }else{
        $sql .= " AND ";
      }
      $i = 1;
      foreach ($typeCondition as $value) {
        $sql .= ($i == 1) ? "$value" : " OR $value";
        $i++;
      }
    }

    return $conn->query($sql);
  }
}
