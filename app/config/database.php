<?php
namespace Config;

class Database{
  public static function connection(){
    $host = "www.pathfinder.in.th";
    $user = "cp525119_aemza";
    $pass = "AemzaLanla159";
    $database = "cp525119_pathfinder";

    $conn = mysqli_connect($host,$user,$pass,$database);
    date_default_timezone_set("Asia/Bangkok");
    mysqli_set_charset($conn,"UTF8");
    return $conn;
  }
}
