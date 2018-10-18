<?php
namespace App\Config;

class Database{
  public static function connection(){
    $host = "";
    $user = "";
    $pass = "";
    $database = "";

    // $host = "localhost";
    // $user = "root";
    // $pass = "";
    // $database = "pathfinder";

    $conn = mysqli_connect($host,$user,$pass,$database);
    date_default_timezone_set("Asia/Bangkok");
    mysqli_set_charset($conn,"UTF8");
    return $conn;
  }
}
