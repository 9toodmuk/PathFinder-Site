<?php
namespace App\Controller\Admin\Categories;

use App\Config\Database;

class EmployerController{
  public static function addCategories($name){
    $conn = Database::connection();
    $sql = "INSERT INTO company_categories (name) VALUES ('$name');";
    if($conn->query($sql)){
      header("Location: /admin/categories/employer/");
      exit();
    }
  }

  public static function deleteCategories($id){
    $conn = Database::connection();
    $sql = "DELETE FROM company_categories WHERE id = '$id';";
    if($conn->query($sql)){
      header("Location: /admin/categories/employer/");
      exit();
    }
  }

  public static function loadCategories($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM company_categories WHERE id = '$id';";
    $query = $conn->query($sql);
    $row = mysqli_fetch_array($query);
    return $row;
  }

  public static function editCategories($id, $name){
    $conn = Database::connection();
    $sql = "UPDATE company_categories SET name = '$name' WHERE id = '$id';";
    if($conn->query($sql)){
      echo "Success";
    }
  }
}
