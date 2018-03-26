<?php

use App\Controller\View\View;
use App\Controller\Auth\Register;

class Registration extends Controller{
  protected $indexpage = 'app/view/layouts/register.php';
  protected $createprofilepage = 'app/view/layouts/createprofile.php';

  public function __construct(){
  }

  function updateexp(){
    $uid = $_SESSION['social_id'];
    $edu = $_POST['education'];
    $exp = $_POST['workexperience'];
    $company = $_POST['lastestempoyer'];
    $name = $_POST['lastestjob'];
    $status = "0";
    $start_m = $_POST['start_m'];
    $end_m = $_POST['end_m'];
    $start_y = $_POST['start_y'];
    $end_y = $_POST['end_y'];
    $min = $_POST['expectmin'];
    $max = $_POST['expectmax'];

    if(isset($_POST['present'])){
      $status = "1";
    }

    $start = $start_y.'-'.$start_m.'-01';
    $end = $end_y.'-'.$end_m.'-01';

    Register::createExp($uid, $edu, $exp, $company, $status, $start, $end, $name, $min, $max);
  }

  function signup(){
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    Register::register($email, $pass, $fname, $lname);
  }

  function updateprofile(){
    $uid = $_SESSION['social_id'];
    $sex = $_POST['sex'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $subdistrict = $_POST['subdistrict'];
    $district = $_POST['district'];
    $province = $_POST['province'];
    $postcode = $_POST['postcode'];
    $telephone = $_POST['telephone'];
    $min = $_POST['expectmin'];
    $max = $_POST['expectmax'];
    $exp = $_POST['workexperience'];

    Register::updateprofile($uid,'','',$sex,$birthday,$address,$subdistrict,$district,$province,$postcode,$telephone,$min,$max,$exp);
  }

  function session() {
    $_SESSION['social_id'] = $_POST['id'];
    $_SESSION['language'] = $_POST['lang'];
  }
}
