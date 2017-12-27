<?php

use Controller\View\View;
use Controller\Auth\Login;
use Controller\Auth\Register;
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
  protected $timeline = 'app/view/layouts/main/user/index.php';
  protected $post = 'app/view/layouts/main/timeline/block/post.php';
  protected $comment = 'app/view/layouts/main/timeline/block/comment.php';
  protected $about = 'app/view/layouts/main/user/about.php';
  protected $friendslist = 'app/view/layouts/main/user/friendslist.php';
  protected $edit = 'app/view/layouts/main/user/edit.php';

  public function __construct(){

  }

  public static function index($id = NULL, $page = NULL){
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

  public static function edit(){
    if(isset($_SESSION['social_id'])){
      echo View::render($this->homelayout, array("edit", $this->edit, $_SESSION['social_id']));
    }else{
      header("Location: /user/$id");
      exit();
    }
  }

  public static function add(){
    $uid = $_POST['uid'];
    $fid = $_POST['fid'];

    Profile::sendRequest($uid, $fid);
  }

  public static function update(){
    $id = $_POST['id'];
    $data = $_POST['data'];
    $fieldname = $_POST['field'];

    if(isset($_POST['data2'])){
      $data = array($_POST['data'], $_POST['data2']);
      $fieldname = array($_POST['field'],$_POST['field2']);
    }

    Profile::update($id, $data, $fieldname);
  }

  public static function load(){
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

  public static function newexp(){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $emp = $_POST['emp'];
    $start = $_POST['start']."-01";
    $end = "1900-00-00";
    $now = $_POST['now'];
    if($now == 0){
      $end = $_POST['end']."-01";
    }

    Experiences::newExp($id, $title, $emp, $start, $end, $now);
  }

  public static function newedu(){
    $id = $_POST['id'];
    $institue = $_POST['institue'];
    $level = $_POST['level'];
    $major = $_POST['major'];
    $gpa = $_POST['gpa'];

    Educations::newEdu($id, $institue, $level, $major, $gpa);
  }

  public static function editexp(){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $emp = $_POST['emp'];
    $start = $_POST['start']."-01";
    $end = "1900-00-00";
    $now = $_POST['now'];
    if($now == 0){
      $end = $_POST['end']."-01";
    }

    Experiences::editExp($id, $title, $emp, $start, $end, $now);
  }

  public static function editedu(){
    $id = $_POST['id'];
    $institue = $_POST['institue'];
    $level = $_POST['level'];
    $major = $_POST['major'];
    $gpa = $_POST['gpa'];

    Educations::editEdu($id, $institue, $level, $major, $gpa);
  }

  public static function removeexp(){
    $id = $_POST['id'];

    Experiences::removeExp($id);
  }

  public static function removeedu(){
    $id = $_POST['id'];

    Educations::removeEdu($id);
  }

  public static function uploadpic(){
    $uploader = $_POST['uploader'];
    $file = $_FILES['file'];
    Utils::uploadPic($file, $uploader);
  }

  public static function removepropic(){
    $id = $_POST['id'];
    Utils::removeProPic($id);
  }

  public static function editprofilepic(){
    $id = $_POST['id'];
  }

  public static function addRelative(){
    $user1 = $_POST['user1'];
    $user2 = $_POST['user2'];
    $relation = $_POST['relationship'];

    Profile::addRelative($user1, $user2, $relation);
  }

  public static function editRelative(){
    $user1 = $_POST['user1'];
    $user2 = $_POST['user2'];
    $relation = $_POST['relationship'];

    Profile::editRelative($user1, $user2, $relation);
  }

  public static function removeRelative(){
    $user1 = $_POST['user1'];
    $user2 = $_POST['user2'];

    Profile::removeRelative($user1, $user2);
  }

  public static function newSkill(){
    $skill = $_POST['skill'];
    $id = $_SESSION['social_id'];

    Skills::newSkill($skill, $id);
  }

  public static function editSkill(){
    $skill = $_POST['skill'];
    $id = $_POST['id'];

    Skills::editSkill($skill, $id);
  }

  public static function removeSkill(){
    $id = $_POST['id'];

    Skills::removeSkill($id);
  }
}
