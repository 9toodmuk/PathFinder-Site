<?php
  include_once $_SERVER['DOCUMENT_ROOT'].'/dist/config.php';

  $email = $_POST['email'];

  $sql = "SELECT * FROM users WHERE email = '$email';";
  $query = $conn->query($sql);
  if(mysqli_num_rows($query) >= 1){
    echo '1';
  }else{
    echo '0';
  }
?>
