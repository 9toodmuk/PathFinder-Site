<?php

use Controller\View\View;
use Controller\Auth\Login;
use Controller\Auth\Register;
use Controller\Job\JobController;
use Controller\Timeline\Post;
use Controller\Timeline\Like;
use Controller\Timeline\Comment;
use Controller\User\Profile;
use Controller\User\Experiences;
use Controller\User\Educations;
use Controller\User\Skills;
use Controller\Utils\Utils;

class User extends Controller{
  protected $homelayout = 'app/view/layouts/userpage.php';
  protected $mainlayout = 'app/view/layouts/home.php';
  protected $timeline = 'app/view/layouts/main/user/index.php';
  protected $post = 'app/view/layouts/main/timeline/block/post.php';
  protected $comment = 'app/view/layouts/main/timeline/block/comment.php';
  protected $about = 'app/view/layouts/main/user/about.php';
  protected $friendslist = 'app/view/layouts/main/user/friendslist.php';
  protected $settings = 'app/view/layouts/main/user/settings.php';
  protected $edit = 'app/view/layouts/main/user/edit.php';

  public function __construct(){

  }

  function index($id = NULL, $page = NULL){
    if(isset($_SESSION['social_id'])){
      if($id != NULL){
        if(Login::getUserGroup($id) != '2'){
          if(Login::isUser($id)){
            if($page == "about"){
              echo View::render($this->homelayout, array("about", $this->about, $id));
            }else if($page == "friend"){
              echo View::render($this->homelayout, array("friendslist", $this->friendslist, $id));
            }else{
              echo View::render($this->homelayout, array("timeline", $this->timeline, $id));
            }
          }else{
            header("Location: /");
            exit();
          }
        }else{
          header("Location: /");
          exit();
        }
      }else{
        header("Location: /");
        exit();
      }
    }else{
      header("Location: /");
      exit();
    }
  }

  function edit(){
    if(isset($_SESSION['social_id'])){
      echo View::render($this->homelayout, array("edit", $this->edit, $_SESSION['social_id']));
    }else{
      header("Location: /");
      exit();
    }
  }

  function settings(){
    if(isset($_SESSION['social_id'])){
      echo View::render($this->mainlayout, array("settings", $this->settings, $_SESSION['social_id']));
    }else{
      header("Location: /");
      exit();
    }
  }

  function add(){
    $uid = $_POST['uid'];
    $fid = $_POST['fid'];

    Profile::sendRequest($uid, $fid);
  }

  function update(){
    $id = $_POST['id'];
    $data = $_POST['data'];
    $fieldname = $_POST['field'];

    if(isset($_POST['data2'])){
      $data = array($_POST['data'], $_POST['data2']);
      $fieldname = array($_POST['field'],$_POST['field2']);
    }

    Profile::update($id, $data, $fieldname);
  }

  function load(){
    if(isset($_POST['limit'])){
      if(isset($_POST['perpage'])){
        $id = $_POST['pid'];
        $result = Post::postload($_POST['limit'], $_POST['perpage']);
        while ($row = $result->fetch_array()){
          if($row['author'] == $id || $row['posted_to'] == $id){
            include $this->post;
          }
        }
      }
    }
  }

  function newexp(){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $emp = $_POST['emp'];
    $start = $_POST['start']."-01";
    $end = "1900-00-00";
    $now = $_POST['now'];
    if($now == 0){
      $end = $_POST['end']."-01";
    }

    echo Experiences::newExp($id, $title, $emp, $start, $end, $now);
  }

  function newedu(){
    $id = $_POST['id'];
    $institue = $_POST['institue'];
    $level = $_POST['level'];
    $major = $_POST['major'];
    $gpa = $_POST['gpa'];

    echo Educations::newEdu($id, $institue, $level, $major, $gpa);
  }

  function editexp(){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $emp = $_POST['emp'];
    $start = $_POST['start']."-01";
    $end = "1900-00-00";
    $now = $_POST['now'];
    if($now == 0){
      $end = $_POST['end']."-01";
    }

    echo Experiences::editExp($id, $title, $emp, $start, $end, $now);
  }

  function editedu(){
    $id = $_POST['id'];
    $institue = $_POST['institue'];
    $level = $_POST['level'];
    $major = $_POST['major'];
    $gpa = $_POST['gpa'];

    echo Educations::editEdu($id, $institue, $level, $major, $gpa);
  }

  function removeexp(){
    $id = $_POST['id'];

    echo Experiences::removeExp($id);
  }

  function removeedu(){
    $id = $_POST['id'];

    echo Educations::removeEdu($id);
  }

  function uploadpic(){
    $uploader = $_POST['uploader'];
    $file = $_FILES['file'];
    echo Utils::uploadPic($file, $uploader);
  }

  function removepropic(){
    $id = $_POST['id'];
    Utils::removeProPic($id);
  }

  function editprofilepic($uid, $filename){
    $file = $_FILES['file'];
    echo Utils::uploadPic($file, $uid, true, $filename);
  }

  function addRelative(){
    $user1 = $_POST['user1'];
    $user2 = $_POST['user2'];
    $relation = $_POST['relationship'];

    Profile::addRelative($user1, $user2, $relation);
  }

  function editRelative(){
    $user1 = $_POST['user1'];
    $user2 = $_POST['user2'];
    $relation = $_POST['relationship'];

    Profile::editRelative($user1, $user2, $relation);
  }

  function removeRelative(){
    $user1 = $_POST['user1'];
    $user2 = $_POST['user2'];

    Profile::removeRelative($user1, $user2);
  }

  function newSkill(){
    $skill = $_POST['skill'];
    $id = $_SESSION['social_id'];

    Skills::newSkill($skill, $id);
  }

  function editSkill(){
    $skill = $_POST['skill'];
    $id = $_POST['id'];

    Skills::editSkill($skill, $id);
  }

  function removeSkill(){
    $id = $_POST['id'];

    Skills::removeSkill($id);
  }

  function skipCreateProfile(){
    if($_SERVER['REQUEST_METHOD'] == "POST"){
      echo Profile::skipCreateProfile($_SESSION['social_id']);
    }else{
      header("HTTP/1.0 404 Not Found");
      exit();
    }
  }

  function createProfile(){
    if($_SERVER['REQUEST_METHOD'] == "POST"){
      if(isset($_POST['id'])){
        $uid = $_POST['id'];
      }else{
        $uid = $_SESSION['social_id'];
      }
      $valid = true;
      $error = 0;

      if(isset($_FILES['file'])){
        $photo = Utils::uploadPic($_FILES['file'], $uid);
        $photo = json_decode($photo, true);
        if($photo["status"] !== TRUE){
          $valid = false;
          $error = 1;
          echo json_encode(array('status' => $valid, 'error' => $error));
          return false;
        }
      }

      $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];
      $gender = $_POST['gender'];
      $birthday = $_POST['birthday'];
      $telephone = $_POST['telephone'];
      $facebook = $_POST['Facebook'];
      $twitter = $_POST['Twitter'];
      $line = $_POST['Line'];
      $disability = $_POST['disability'];

      $profile = Profile::createProfile($uid, $firstname, $lastname, $gender, $birthday, $telephone, $facebook, $twitter, $line, $disability);
      $profile = json_decode($profile, true);
      if($profile["status"] !== TRUE){
        $valid = false;
        $error = 2;
        echo json_encode(array('status' => $valid, 'error' => $error));
        return false;
      }

      $exp = $_POST['exp'];
      if($exp >= 0){
        $recent_work = $_POST['recent_work'];
        $recent_emp = $_POST['recent_emp'];
        $start = $_POST['start']."-01";
        $end = "1900-00-00";
        $now = 1;
        if(!isset($_POST['now'])){
          $now = 0;
          $end = $_POST['end']."-01";
        }

        $exp = Experiences::newExp($uid, $recent_work, $recent_emp, $start, $end, $now);
        if($exp != "Success"){
          $valid = false;
          $error = 3;
          echo json_encode(array('status' => $valid, 'error' => $error));
          return false;
        }
      }

      $edu = $_POST['edu'];
      if($edu > 0){
        $institue = $_POST['highest_insitute'];
        $major = $_POST['highest_edu_level'];
        $gpa = $_POST['gpa'];

        $edu = Educations::newEdu($uid, $institue, $edu, $major, $gpa);
        if($edu != "Success"){
          $valid = false;
          $error = 4;
          echo json_encode(array('status' => $valid, 'error' => $error));
          return false;
        }
      }

      echo json_encode(array('status' => $valid));
    }else{
      header("HTTP/1.0 404 Not Found");
      exit();
    }
  }

  function getAllDisabilityType(){
    $disability = JobController::getAllDisabilityType();
    $jsonData = array();
    while($row = $disability->fetch_assoc()){
      array_push($jsonData, $row['name']);
    }
    echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
  }
}
