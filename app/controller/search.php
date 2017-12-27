<?php
use Controller\View\View;
use Controller\Job\JobController;
use Controller\Job\Employer;
use Controller\User\Profile;
use Controller\Search\SearchController;
use Controller\Employer\Detail;
use Controller\Utils\Address;

class Search extends Controller{
  protected $homelayout = 'app/view/layouts/search.php';
  protected $advancelayout = 'app/view/layouts/advancesearch.php';

  public function __construct(){

  }

  public static function index($query = NULL){
    header("Location: /");
    exit();
  }

  public static function term($query = NULL){
    if(isset($_SESSION['social_id'])){
      if($query != NULL){
        echo View::render($this->homelayout, array("Search", $query));
      }else{
        header("Location: /");
        exit();
      }
    }else{
      header("Location: /");
      exit();
    }
  }

  public static function advance(){
    if(isset($_SESSION['social_id'])){

      if(isset($_GET['keyword'])){
        $keyword = $_GET['keyword'];
      }else{
        $keyword = '';
      }

      if(isset($_GET['category'])){
        $category = $_GET['category'];
      }else{
        $category = '';
      }

      if(isset($_GET['location'])){
        $location = $_GET['location'];
      }else{
        $location = '';
      }

      if(isset($_GET['type'])){
        $type = $_GET['type'];
      }else{
        $type = '';
      }

      $array = array('keyword' => $keyword, 'category' => $category, 'location' => $location, 'type' => $type);

      echo View::render($this->advancelayout, array("Advance Search", $array));
    }else{
      header("Location: /");
      exit();
    }
  }

  public static function search($query = NULL){
    $result = SearchController::search($query);
    $count = mysqli_num_rows($result);
    $uid = $_POST['id'];

    if($count > 0){
      $company = array();
      $jobs = array();
      $users = array();

      while($row = mysqli_fetch_assoc($result)){
        $type = $row['type'];
        if($type == 'company'){
          array_push($company, $row['id']);
        }else if($type == 'job'){
          array_push($jobs, $row['id']);
        }else if($type == 'user'){
          array_push($users, $row['id']);
        }
      }
    }

    $search = array();

    foreach($jobs as $value){
      $row = JobController::loadJobPosting($value);
      $category = JobController::getJobCategory($row['category_id']);
      $category = $category['name'];
      $location = Detail::getLocation($row['location'], false, false);
      $location = mysqli_fetch_array($location);
      $location = $location['province'];

      $arr = array('result' => 1,
          'id' => $row['id'],
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
        );

      array_push($search, $arr);
    }

    foreach($users as $value){
      $row = Profile::profileLoad($value);
      $row = mysqli_fetch_array($row);
      $friendship = Profile::getFriendship($uid, $row['id']);
      if($uid === $row['id']){
        $friendship = 4;
      }

      $arr = array('result' => 2,
          "id" => $row['id'],
          "guid" => $row['guid'],
          "email" => $row['email'],
          "user_group" => $row['user_group'],
          "status" => $row['status'],
          "validate" => $row['validate'],
          "profile_image" => $row['profile_image'],
          "header_image" => $row['header_image'],
          "first_name" => $row['first_name'],
          "last_name" => $row['last_name'],
          "sex" => $row['sex'],
          "birthdate" => $row['birthdate'],
          "telephone" => $row['telephone'],
          "facebook" => $row['facebook'],
          "twitter" => $row['twitter'],
          "line" => $row['line'],
          "other_link" => $row['other_link'],
          "friend_status" => $friendship,
          "friend_count" => Profile::getFriendsCount($row['id']),
        );

      array_push($search, $arr);
    }

    foreach($company as $value){
      $row = Employer::loadEMP($value);
      $row = mysqli_fetch_array($row);
      $category = JobController::getEmpCategory($row['category_id']);

      $arr = array('result' => 3,
          "id" => $row['id'],
          "name" => $row['name'],
          "about" => $row['about'],
          "logo" => $row['logo'],
          "telephone" => $row['telephone'],
          "contact_name" => $row['contact_name'],
          "contact_email" => $row['contact_email'],
          "section" => $row['section'],
          "category" => $category['name']
      );

      array_push($search, $arr);
    }

    echo json_encode($search, JSON_UNESCAPED_UNICODE);

  }
}
