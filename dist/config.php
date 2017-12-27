<?php
  $host = "www.pathfinder.in.th";
  $user = "cp525119_aemza";
  $pass = "AemzaLanla159";
  $database = "cp525119_pathfinder";

  $conn = mysqli_connect($host,$user,$pass,$database);
  mysqli_set_charset($conn,"UTF8");

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
?>
