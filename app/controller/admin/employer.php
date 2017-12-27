<?php
namespace Controller\Admin;

use Config\Database;

class Employer{
  public static function addEmployer($name, $parent, $location, $country, $telephone, $logo){
    $conn = Database::connection();
    $sql = "INSERT INTO company (name, province, country, telephone, logo, category_id) VALUES ('$name', '$location', '$country', '$telephone', '$logo', '$parent');";
    if($conn->query($sql)){
      header("Location: /admin/employer/");
      exit();
    }
  }

  public static function editEmployer($id, $name, $parent, $location, $country, $telephone, $logo){
    $sql = "UPDATE company SET name = '$name', province = '$location', country = '$country', telephone = '$telephone', category_id = '$parent', logo = '$logo' WHERE id = '$id';";

    if(is_null($logo)){
      $sql = "UPDATE company SET name = '$name', province = '$location', country = '$country', telephone = '$telephone', category_id = '$parent' WHERE id = '$id';";
    }

    $conn = Database::connection();

    if($conn->query($sql)){
      header("Location: /admin/employer/");
      exit();
    }
  }

  public static function loadEmployer($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM company WHERE id = '$id';";
    $query = $conn->query($sql);
    $result = mysqli_fetch_assoc($query);
    return $result;
  }

  public static function getEmployerName($id){
    $emp = Employer::loadEmployer($id);
    return $emp['name'];
  }

  public static function deleteEmployer($id){
    $conn = Database::connection();
    $filename = Employer::loadEmployer($id);
    $sql = "DELETE FROM company WHERE id = '$id';";
    if($conn->query($sql)){
      unlink("uploads/logo_images/".$filename['logo']);
      header("Location: /admin/employer/");
      exit();
    }
  }

  public static function deleteOldLogo($id){
    $filename = Employer::loadEmployer($id);
    unlink("uploads/logo_images/".$filename['logo']);
  }

  public static function employerCount(){
    $conn = Database::connection();
    $sql = "SELECT * FROM company;";
    $query = $conn->query($sql);
    return $count = mysqli_num_rows($query);
  }

  public static function uploadLogo($file){
    $newname = Employer::newFileName(basename($file["name"]));
    $target_dir = "uploads/logo_images/";
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $check = getimagesize($file["tmp_name"]);

    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {
      $uploadOk = 0;
    }

    if ($uploadOk == 0) {

    } else {
      move_uploaded_file($file["tmp_name"], $target_dir.$newname);
    }

    return $newname;
  }

  function newFileName($name){
    $temp = explode(".", $name);
    $salt = sha1(md5($name));
    $newname = md5($pass.$salt);
    return $newname.".".end($temp);
  }
}
