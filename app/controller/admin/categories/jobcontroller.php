<?php
namespace Controller\Admin\Categories;

use Config\Database;

class JobController{
  public static function addCategories($name, $parent, $icon){
    $conn = Database::connection();
    if($parent == ""){
      if($icon == ""){
        $sql = "INSERT INTO job_categories (name) VALUES ('$name');";
      }else{
        $sql = "INSERT INTO job_categories (name, icon) VALUES ('$name', '$icon');";
      }
    }else{
      $sql = "INSERT INTO job_categories (name, parent_id, icon) VALUES ('$name', '$parent', '$icon');";
    }
    if($conn->query($sql)){
      header("Location: /admin/categories/job/");
      exit();
    }
  }

  public static function deleteCategories($id){
    $conn = Database::connection();
    $sql = "DELETE FROM job_categories WHERE id = '$id';";
    if($conn->query($sql)){
      header("Location: /admin/categories/job/");
      exit();
    }
  }

  public static function loadCategories($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM job_categories WHERE id = '$id';";
    $query = $conn->query($sql);
    $row = mysqli_fetch_array($query);
    return $row;
  }

  public static function editCategories($id, $name, $parent, $icon){
    $conn = Database::connection();
    if($parent == ""){
      if($icon == ""){
        $sql = "UPDATE job_categories SET name = '$name', parent_id = NULL, icon = NULL WHERE id = '$id';";
      }else{
        $sql = "UPDATE job_categories SET name = '$name', parent_id = NULL, icon = '$icon' WHERE id = '$id';";
      }
    }else{
      $sql = "UPDATE job_categories SET name = '$name', parent_id = '$parent', icon = '$icon' WHERE id = '$id';";
    }
    if($conn->query($sql)){
      header("Location: /admin/categories/job/");
      exit();
    }
  }
}
