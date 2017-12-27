<?php

use Controller\View\View;
use Controller\Job\JobController;
use Controller\Job\Employer;
use Controller\User\Profile;
use Controller\Employer\Detail;
use Controller\Utils\Address;

class Job extends Controller{
  protected $homelayout = 'app/view/layouts/home.php';
  protected $jobmain = 'app/view/layouts/main/job/index.php';
  protected $empmain = 'app/view/layouts/main/job/emp.php';
  protected $emppage = 'app/view/layouts/main/job/emplist.php';
  protected $catpage = 'app/view/layouts/main/job/categories.php';
  protected $detailpage = 'app/view/layouts/main/job/detail.php';
  protected $applypage = 'app/view/layouts/main/job/apply.php';
  protected $jobcard = 'app/view/layouts/main/job/jobcard.php';
  protected $empcard = 'app/view/layouts/main/search/block/companyblock.php';

  public function __construct(){
  }

  public static function index(){
    if(!isset($_SESSION['social_id'])){
      header("Location: /");
      exit();
    }
    echo View::render($this->homelayout, array("home", $this->jobmain));
  }

  public static function categories($id = NULL){
    if($id != null){
      echo View::render($this->catpage, $id);
    }else{
      header("Location: /job/");
      exit();
    }
  }

  public static function detail($id = NULL, $error = 0){
    if($id != null){
      echo View::render($this->homelayout, array("detailpage", $this->detailpage, $id));
    }else{
      header("Location: /job/");
      exit();
    }
  }

  public static function apply($id = NULL){
    if($id != null){
      echo View::render($this->homelayout, array("applypage", $this->applypage, $id));
    }else{
      header("Location: /job/");
      exit();
    }
  }

  public static function employer($id = NULL, $error = 0){
    if($id != null){
      echo View::render($this->homelayout, array("empdetailpage", $this->empmain, $id, $error));
    }else{
      echo View::render($this->homelayout, array("emplistpage", $this->emppage));
    }
  }

  public static function loadmore(){
    if(isset($_POST['limit'])){
      if(isset($_POST['perpage'])){
        $result = JobController::loadAllPosting($_POST['perpage'], $_POST['limit']);
        while ($row = $result->fetch_array()){
          include $this->jobcard;
        }
      }
    }
  }

  public static function loademp(){
    if(isset($_POST['id'])){
      if(isset($_POST['limit'])){
        if(isset($_POST['perpage'])){
          $result = JobController::loadAllPosting($_POST['perpage'], $_POST['limit'], $_POST['id']);
          while ($row = $result->fetch_array()){
            include $this->jobcard;
          }
        }
      }
    }
  }

  public static function getallemp(){
    if(isset($_POST['offset'])){
      if(isset($_POST['limit'])){
        $result = Employer::loadAllEMP($_POST['offset'], $_POST['limit']);
        while ($row = $result->fetch_array()){
          include $this->empcard;
        }
      }
    }
  }

  public static function sendapply(){
    if(isset($_POST['id'])){
      $jid = $_POST['id'];
      $message = $_POST['message'];
      $uid = $_POST['uid'];
      JobController::applyJob($uid, $jid, $message);
    }
  }

  public static function loadallemp(){
    $result = Employer::loadEMP();
    $jsonData = array();
    while ($arr = mysqli_fetch_assoc($result)) {
      array_push($jsonData,$arr);
    }
    echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
  }

  public static function save(){
    if(isset($_POST['id'])){
      $id = $_POST['id'];
      $uid = $_SESSION['social_id'];
      JobController::saveJob($uid, $id);
    }
  }

  public static function getByCategory($category, $limit = 10, $offset = 0){
    $result = JobController::loadByCategory($category, $limit, $offset);
    $jsonData = array();
    while($row = mysqli_fetch_assoc($result)){
      array_push($jsonData, $row);
    }
    echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
  }

  public static function getFavJobs($id){
    $result = Profile::getFavJobs($id);

    $jsonData = array();

    while($job = mysqli_fetch_assoc($result)){
      $row = JobController::loadJobPosting($job['job_id']);
      $category = JobController::getJobCategory($row['category_id']);
      $category = $category['name'];
      
      if(is_numeric($row['location'])){
        $location = Detail::getLocation($row['location'], false, false);
        $location = mysqli_fetch_array($location);
        $location = $location['province'];
      }else{
        $location = $row['location'];
      }

      $arr = array('id' => $row['id'],
          'name' => $row['name'],
          'responsibilities' => $row['responsibilities'],
          'qualification' => $row['qualification'],
          'benefit' => $row['benefit'],
          'capacity' => $row['capacity'],
          'cap_type' => $row['cap_type'],
          'salary' => $row['salary'],
          'salary_type' => $row['salary_type'],
          'negotiable' => JobController::isNegetiable($row['negetiable']),
          'location' => Address::getProvinceName($location),
          'type' => $row['type'],
          'level' => $row['level'],
          'exp_req' => $row['exp_req'],
          'edu_req' => $row['edu_req'],
          'category' => $category,
          'company_id' => $row['company_id'],
          'created_at' => $row['created_at'],
          'favorite' => JobController::getSaveStatus($id, $row['id']),
          'apply' => JobController::getApplyStatus($id, $row['id']),
        );

        array_push($jsonData, $arr);
    }
    echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
  }
}
