<?php
  include_once $_SERVER['DOCUMENT_ROOT'].'/dist/config.php';

  if(isset($_POST["status"])){
    $status = $_POST["status"];

    $email = $_POST['email'];
    $pass = $_POST['password'];

    if($status == "login"){
      login($email, $pass);
    }else if($status == "register"){
      $name = $_POST['name'];
      $lastname = $_POST['lastname'];
      $group = 1;
      register($email, $pass, $name, $lastname);
    }
  }

  function login($email, $pass){
    $newpass = passHash($pass);
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$newpass';";
    $query = $GLOBALS['conn']->query($sql);

    if(mysqli_num_rows($query) <= 0){
      echo "Failed";
    }else{
      $arr = mysqli_fetch_array($query);
      echo $arr['id'];
    }
  }

  function passHash($pass){
    $salt = sha1(md5($pass));
    $newpass = md5($pass.$salt);
    return $newpass;
  }

  function checkemail($email){
    $sql = "SELECT * FROM users WHERE email = '$email';";
    $query = $GLOBALS['conn']->query($sql);
    if(mysqli_num_rows($query) >= 1){
      return false;
    }else{
      return true;
    }
  }

  function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
        return $uuid;
    }
  }
?>
