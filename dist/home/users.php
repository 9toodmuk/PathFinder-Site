<?php
  include_once $_SERVER['DOCUMENT_ROOT'].'/dist/config.php';

  if(isset($_GET["status"])){
    $status = $_GET["status"];
    if($status == "userloader"){
      $id = $_GET['id'];

      userloader($id);
    }
  }

  function userloader($id){
    $sql = "SELECT users.id, users.guid, users.email, users.user_group, users.status, users.validate, users.profile_image, personal_details.first_name, personal_details.last_name, personal_details.sex, personal_details.birthdate, personal_details.address, personal_details.subdistrict, personal_details.district, personal_details.postcode, personal_details.province, personal_details.telephone FROM users JOIN personal_details ON users.id = personal_details.user_id WHERE users.id = '$id';";
    $query = $GLOBALS['conn']->query($sql);
    $jsonData = array();
    while ($arr = mysqli_fetch_assoc($query)) {
      array_push($jsonData,$arr);
    }
    echo str_replace(array('[', ']'), '', htmlspecialchars(json_encode($jsonData, JSON_UNESCAPED_UNICODE), ENT_NOQUOTES));
  }

?>
