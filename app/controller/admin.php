<?php

use Controller\View\View;
use Controller\Admin\Categories\JobController;
use Controller\Admin\Categories\EmployerController;
use Controller\Admin\Employer;
use Controller\Admin\Users;
use Controller\Admin\Auth\Auth;
use Controller\Admin\Postings;
use Controller\Admin\Applications;

class Admin extends Controller{
  protected $mainlayout = 'app/view/layouts/admin/main.php';
  protected $loginpage = 'app/view/layouts/admin/login.php';
  protected $dashboard = 'app/view/layouts/admin/pages/dashboard.php';
  protected $emppage = 'app/view/layouts/admin/pages/employer.php';
  protected $jobscat = 'app/view/layouts/admin/pages/category/jobs.php';
  protected $empcat = 'app/view/layouts/admin/pages/category/employers.php';
  protected $jobscatedit = 'app/view/layouts/admin/pages/category/jobsedit.php';
  protected $userspage = 'app/view/layouts/admin/pages/users.php';
  protected $postingspage = 'app/view/layouts/admin/pages/postings/index.php';
  protected $addpostings = 'app/view/layouts/admin/pages/postings//add.php';
  protected $editpostings = 'app/view/layouts/admin/pages/postings//edit.php';
  protected $applications = 'app/view/layouts/admin/pages/application.php';

  public function __construct(){

  }

  public static function index(){
    if(!isset($_SESSION['admin_id'])){
      header("Location: /admin/login/");
      exit();
    }
    echo View::render($this->mainlayout, array("Dashboard", $this->dashboard));
  }

  public static function login($fid = 0){
    if(isset($_SESSION['admin_id'])){
      header("Location: /admin/");
      exit();
    }else{
      echo View::render($this->loginpage, $fid);
    }
  }

  public static function signin(){
    $user = $_POST['email'];
    $pass = $_POST['password'];

    Auth::signAdminIn($user, $pass);
  }

  public static function signout(){
    Auth::logout();
  }

  public static function categories($page = NULL, $modify = NULL, $id = NULL){
    if(!isset($_SESSION['admin_id'])){
      header("Location: /admin/login/");
      exit();
    }
    if($page == "job"){
      if($modify == NULL){
        echo View::render($this->mainlayout, array("Dashboard", $this->jobscat));
      }else if($modify == "edit"){
        if($id != NULL){
          echo View::render($this->mainlayout, array("Dashboard", $this->jobscatedit, $id));
        }else{
          header("Location: /admin/categories/job/");
          exit();
        }
      }else if($modify == "delete"){
        if($id != NULL){
          JobController::deleteCategories($id);
        }else{
          header("Location: /admin/categories/job/");
          exit();
        }
      }else{
        header("Location: /admin/categories/job/");
        exit();
      }
    }else if($page == "employer"){
      if($modify == NULL){
        echo View::render($this->mainlayout, array("Dashboard", $this->empcat));
      }else if($modify == "delete"){
        if($id != NULL){
          EmployerController::deleteCategories($id);
        }else{
          header("Location: /admin/categories/employer/");
          exit();
        }
      }
    }else if($page == "add"){
      if($modify == "job"){
        $name = $_POST['name'];
        $parent = $_POST['parent'];
        $icon = $_POST['icon'];
        JobController::addCategories($name,$parent,$icon);
      }else if($modify == "employer"){
        $name = $_POST['name'];
        EmployerController::addCategories($name);
      }
    }else if($page == "edit"){
      if($modify == "job"){
        $id = $_POST['cid'];
        $name = $_POST['name'];
        $parent = $_POST['parent'];
        $icon = $_POST['icon'];

        JobController::editCategories($id,$name,$parent,$icon);
      }
    }else{
      header("Location: /admin/");
      exit();
    }
  }

  public static function employer($page = NULL, $id = NULL){
    if(!isset($_SESSION['admin_id'])){
      header("Location: /admin/login/");
      exit();
    }
    if(is_null($page)){
      echo View::render($this->mainlayout, array("Dashboard", $this->emppage));
    }else{
      if($page == "add"){
        $name = $_POST['name'];
        $parent = $_POST['parent'];
        $location = $_POST['location'];
        $country = $_POST['country'];
        $telephone = $_POST['telephone'];
        $logo = NULL;

        if(file_exists($_FILES['logo']['tmp_name'])){
          $logo = Employer::uploadLogo($_FILES['logo']);
        }

        Employer::addEmployer($name, $parent, $location, $country, $telephone, $logo);
      }else if($page == "delete"){
        if(!is_null($id)){
          Employer::deleteEmployer($id);
        }else{
          header("Location: /admin/employer/");
          exit();
        }
      }else if($page == "edit"){
        if(!is_null($id)){
          $id = $_POST['eid'];
          $name = $_POST['name'];
          $parent = $_POST['parent'];
          $location = $_POST['location'];
          $country = $_POST['country'];
          $telephone = $_POST['telephone'];
          $logo = NULL;

          if(file_exists($_FILES['logo']['tmp_name'])){
            Employer::deleteOldLogo($id);
            $logo = Employer::uploadLogo($_FILES['logo']);
          }

          Employer::editEmployer($id, $name, $parent, $location, $country, $telephone, $logo);

        }else{
          header("Location: /admin/employer/");
          exit();
        }
      }
    }
  }

  public static function users($page = NULL, $id = NULL){
    if(!isset($_SESSION['admin_id'])){
      header("Location: /admin/login/");
      exit();
    }
    if(is_null($page)){
      echo View::render($this->mainlayout, array("Dashboard", $this->userspage));
    }else if($page == "delete"){
      if(!is_null($id)){
        Users::deleteAccount($id);
      }else{
        header("Location: /admin/users/");
        exit();
      }
    }else if($page == "add"){
      $email = $_POST['email'];
      $pass = $_POST['password'];
      $fname = $_POST['name'];
      $lname = $_POST['lname'];
      $ugp = $_POST['group'];

      Users::addAccount($email, $pass, $fname, $lname, $ugp);
    }else{
      echo View::render($this->userspage, $page);
    }
  }

  public static function applications($page = NULL, $id = NULL){
    if(!isset($_SESSION['admin_id'])){
      header("Location: /admin/login/");
      exit();
    }
    if(is_null($page)){
      echo View::render($this->mainlayout, array("Dashboard", $this->applications));
    }else if($page == "delete"){
      if(!is_null($id)){
        Applications::deleteApplication($id);
      }else{
        header("Location: /admin/applications/");
        exit();
      }
    }else if($page == "add"){
      $uid = $_POST['user'];
      $jid = $_POST['job'];
      $status = $_POST['status'];

      Applications::addApplication($uid, $jid, $status);
    }
  }

  public static function postings($page = NULL, $id = NULL){
    if(!isset($_SESSION['admin_id'])){
      header("Location: /admin/login/");
      exit();
    }
    if(is_null($page)){
      echo View::render($this->mainlayout, array("Dashboard", $this->postingspage));
    }else if($page == "add"){
      echo View::render($this->mainlayout, array("Dashboard", $this->addpostings));
    }else if($page == "new"){
      $name = $_POST['name'];
      $company = $_POST['company'];
      $cat = $_POST['parent'];
      $responsibility = $_POST['responsibility'];
      $qualification = $_POST['qualification'];
      $benefit = $_POST['benefit'];
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

      Postings::addpostings($name, $responsibility, $qualification, $benefit, $salary, $salarytype, $negetiable, $location, $type, $level, $exp, $edulevel, $cat, $company);
    }else if($page == "delete"){
      if(!is_null($id)){
        Postings::deletepostings($id);
      }else{
        header("Location: /admin/postings/");
        exit();
      }
    }else if($page == "edit"){
      if(!is_null($id)){
        echo View::render($this->mainlayout, array("Dashboard", $this->editpostings, $id));
      }else{
        header("Location: /admin/postings/");
        exit();
      }
    }else if($page == "update"){
        $id = $_POST['pid'];
        $name = $_POST['name'];
        $company = $_POST['company'];
        $cat = $_POST['parent'];
        $responsibility = $_POST['responsibility'];
        $qualification = $_POST['qualification'];
        $benefit = $_POST['benefit'];
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

        Postings::editpostings($id, $name, $responsibility, $qualification, $benefit, $salary, $salarytype, $negetiable, $location, $type, $level, $exp, $edulevel, $cat, $company);
    }else if($page == "featured"){
        $id = $_POST['id'];
        Postings::editfeatured($id);
    }
  }
}
