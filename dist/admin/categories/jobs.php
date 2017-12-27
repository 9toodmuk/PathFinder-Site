<?php
  include_once $_SERVER['DOCUMENT_ROOT'].'/dist/config.php';

  $sql = "SELECT * FROM job_categories;";
  $query = $conn->query($sql);
  $rows = array();
  while($r = $query->fetch_assoc()) {
    $rows[] = $r;
  }
  print json_encode($rows);
?>
