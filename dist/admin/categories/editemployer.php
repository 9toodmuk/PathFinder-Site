<?php
  include_once $_SERVER['DOCUMENT_ROOT'].'/dist/config.php';

  $id = $_POST['id'];
  $name = $_POST['name'];

  $sql = "UPDATE company_categories SET name = '$name' WHERE id = '$id';";
  $query = $conn->query($sql);
  
?>
