<?php
namespace Controller\Admin\Auth;

use Controller\Utils\Utils;
use Config\Database;

class Auth{
  public static function signAdminIn($name, $pass){
    if(Auth::validate($pass)){

      $newpass = Utils::passhash($pass);
      $conn = Database::connection();
      $sql = "SELECT * FROM users WHERE email = '$name' AND password = '$newpass';";
      $query = $conn->query($sql);
      if(mysqli_num_rows($query) <= 0){
        Auth::login_failed(1);
      }else{
        $arr = mysqli_fetch_array($query);
        if($arr['user_group'] == "3"){
          Auth::login_success($arr['id']);
        }else{
          Auth::login_failed(2);
        }
      }
    }
  }

  public static function validate($pass){
    if($pass == ''){
      return false;
      exit();
    }
    return true;
  }

  public static function login_success($id){
    $_SESSION['admin_id'] = $id;
    header("Location: /admin/");
    exit();
  }

  public static function login_failed($fid){
    header("Location: /admin/login/$fid/");
    exit();
  }

  public static function logout(){
    unset($_SESSION['admin_id']);
    header("Location: /admin/login/");
    exit();
  }
}
