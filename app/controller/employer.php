<?php

use App\Controller\View\View;
use App\Controller\Employer\Auth;
use App\Controller\Employer\Detail;
use App\Controller\Admin\Postings;
use App\Controller\Job\JobController;
use App\Controller\Utils\Utils;

class Employer extends Controller{
  protected $indexlayout = 'app/view/layouts/emp.php';
  protected $homelayout = 'app/view/layouts/emp/main/main.php';
  protected $dashboardlayout = 'app/view/layouts/emp/main/dashboard.php';
  protected $postinglayout = 'app/view/layouts/emp/main/postings.php';
  protected $applicationslayout = 'app/view/layouts/emp/main/applications.php';
  protected $detailslayout = 'app/view/layouts/emp/main/details.php';
  protected $settingslayout = 'app/view/layouts/emp/main/settings.php';
  protected $formlogin = 'app/view/layouts/emp/forms/formlogin.php';
  protected $formregister = 'app/view/layouts/emp/forms/formregister.php';
  protected $applydetail = 'app/view/layouts/emp/main/block/application_detail.php';

  public function __construct(){

  }

  function index(){
    if(isset($_SESSION['emp_id'])){
      echo View::render($this->homelayout, array("Dashboard", $this->dashboardlayout));
    }else{
      echo View::render($this->indexlayout, $this->formlogin);
    }
  }

  function postings(){
    if(isset($_SESSION['emp_id'])){
      echo View::render($this->homelayout, array("Postings", $this->postinglayout));
    }else{
      header("Location: /employer/");
      exit();
    }
  }

  function applications($page = NULL, $id = NULL){
    if(isset($_SESSION['emp_id'])){
      if($page != NULL){
        if($page == "detail")
        if($id != NULL){
          echo View::render($this->homelayout, array("APPLY_DETAILS", $this->applydetail, $id));
        }else{
          header("Location: /employer/");
          exit();
        }
      }else{
        echo View::render($this->homelayout, array("Applications", $this->applicationslayout));
      }
    }else{
      header("Location: /employer/");
      exit();
    }
  }

  function replyapply(){
    $apply_id = $_POST['id'];
    $message = $_POST['message'];
    $sender = $_POST['sender'];
    $reciever = $_POST['reciever'];
    echo Detail::replyApplication($apply_id, $message, $sender, $reciever);
  }

  function details(){
    if(isset($_SESSION['emp_id'])){
      echo View::render($this->homelayout, array("Details", $this->detailslayout));
    }else{
      header("Location: /employer/");
      exit();
    }
  }

  function settings(){
    if(isset($_SESSION['emp_id'])){
      echo View::render($this->homelayout, array("Settings", $this->settingslayout));
    }else{
      header("Location: /employer/");
      exit();
    }
  }

  function register(){
    if(isset($_SESSION['emp_id'])){
      header("Location: /employer/");
      exit();
    }else{
      echo View::render($this->indexlayout, $this->formregister);
    }
  }

  function login(){
    $email = $_POST['email'];
    $pass = $_POST['password'];

    Auth::login($email, $pass);
  }

  function signup(){
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $category = $_POST['category'];
    $contactemail = $_POST['contactemail'];
    if(isset($_POST['section'])){
      $section = $_POST['section'];
    }else{
      $section = "";
    }
    $telephone = $_POST['telephone'];

    Auth::register($email, $pass, $name, $contact, $category, $contactemail, $section, $telephone);
  }
  function newpostings(){
    $name = $_POST['name'];
    $company = $_POST['id'];
    $cat = $_POST['parent'];
    $responsibility = $_POST['responsibility'];
    $qualification = $_POST['qualification'];
    $benefit = $_POST['benefit'];
    $cap_type = 1;
    $capacity = 0;
    if(!isset($_POST['many'])){
      $cap_type = 0;
      $capacity = $_POST['capacity'];
    }
    $disability_req = $_POST['disability_req'];
    $location = $_POST['location'];
    $level = $_POST['joblevel'];
    $edulevel = $_POST['eduLevel'];
    $exp = $_POST['exp'];
    $type = $_POST['type'];
    $salary = $_POST['salary'];
    $salarytype = $_POST['salary_type'];
    $negetiable = 0;
    if(isset($_POST['negetiable'])){
      $negetiable = 1;
    }
    Postings::addpostings($name, $responsibility, $qualification, $benefit, $capacity, $cap_type, $disability_req, $salary, $salarytype, $negetiable, $location, $type, $level, $exp, $edulevel, $cat, $company);
  }

  function editpostings(){
    $id = $_POST['jid'];
    $name = $_POST['editname'];
    $company = $_POST['id'];
    $cat = $_POST['editparent'];
    $responsibility = $_POST['editresponsibility'];
    $qualification = $_POST['editqualification'];
    $benefit = $_POST['editbenefit'];
    $cap_type = 1;
    $capacity = 0;
    if(!isset($_POST['editmany'])){
      $cap_type = 0;
      $capacity = $_POST['editcapacity'];
    }
    $disability_req = $_POST['editdisability_req'];
    $location = $_POST['location'];
    $level = $_POST['editjoblevel'];
    $edulevel = $_POST['editeduLevel'];
    $exp = $_POST['editexp'];
    $type = $_POST['edittype'];
    $salary = $_POST['editsalary'];
    $salarytype = $_POST['editsalary_type'];
    $negetiable = 0;
    if(isset($_POST['editnegetiable'])){
      $negetiable = 1;
    }
    Postings::editpostings($id, $name, $responsibility, $qualification, $benefit, $capacity, $cap_type, $disability_req, $salary, $salarytype, $negetiable, $location, $type, $level, $exp, $edulevel, $cat, $company);
  }

  function rempost(){
    $id = $_POST['id'];
    JobController::removePost($id);
  }

  function edit(){
    $field = $_POST['field'];
    $data = $_POST['data'];
    $id = Detail::getEmpId($_SESSION['emp_id']);
    Detail::edit($field, $data, $id);
  }

  function uploadlogo(){
    $uploader = $_POST['uploader'];
    $file = $_FILES['file'];
    echo Utils::uploadPic($file, $uploader);
  }

  function addlocation(){
    $name = $_POST['name'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $postcode = $_POST['postcode'];
    $telephone = $_POST['telephone'];
    $id = Detail::getEmpId($_SESSION['emp_id']);

    Detail::addLocation($name, $address1, $address2, $city, $province, $postcode, $telephone, $id);
  }

  function editlocation(){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $postcode = $_POST['postcode'];
    $telephone = $_POST['telephone'];

    Detail::editLocation($id, $name, $address1, $address2, $city, $province, $postcode, $telephone);
  }

  function setMainLocation(){
    $id = $_POST['id'];
    $cid = Detail::getEmpId($_SESSION['emp_id']);
    Detail::setMainLocation($id, $cid);
  }

  function removelocation(){
    $id = $_POST['id'];
    $cid = Detail::getEmpId($_SESSION['emp_id']);
    Detail::removeLocation($id, $cid);
  }

  function editsettings(){
    if(Auth::checkPass($_SESSION['emp_id'], $_POST['oldpassword'])){

      $id = Detail::getEmpId($_SESSION['emp_id']);

      $language = $_POST['language'];

      if(isset($_POST['sendemail'])){
        $sendemail = $_POST['sendemail'];
      }else{
        $sendemail = 0;
      }

      if(isset($_POST['senddetail'])){
        $senddetail = $_POST['senddetail'];
      }else{
        $senddetail = 0;
      }

      $jsonData = array();

      if($_POST['password'] != ""){
        $newpass = $_POST['password'];
        $arr = Auth::changePassword($_SESSION['emp_id'], $newpass);
        $jsonData = array_merge($jsonData, $arr);
      }

      $arr = Detail::updateSettings($id, $sendemail, $senddetail);
      $jsonData = array_merge($jsonData, $arr);

      echo json_encode($jsonData);
    }
  }
}
