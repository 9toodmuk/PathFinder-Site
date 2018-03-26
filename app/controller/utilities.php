<?php
use App\Controller\User\Location;
use App\Controller\Timeline\Notification;
use App\Controller\User\Profile;
use App\Controller\User\Experiences;
use App\Controller\User\Educations;
use App\Controller\Timeline\Post;
use App\Controller\Timeline\Like;
use App\Controller\Timeline\Comment;
use App\Controller\Job\JobController;
use App\Controller\Job\Employer;
use App\Controller\Employer\Detail;
use App\Controller\Utils\Address;

class Utilities extends Controller{
  public function __construct(){
  }

  function index(){
    header("HTTP/1.0 404 Not Found");
    exit();
  }

  function nameeditor(){
    include 'app/view/layouts/main/user/block/nameeditor.php';
  }

  function gendereditor(){
    include 'app/view/layouts/main/user/block/gendereditor.php';
  }

  function disabilityeditor(){
    include 'app/view/layouts/main/user/block/disabilityeditor.php';
  }

  function fieldeditor(){
    include 'app/view/layouts/main/user/block/fieldeditor.php';
  }

  function dateeditor(){
    include 'app/view/layouts/main/user/block/dateeditor.php';
  }

  function expeditor(){
    include 'app/view/layouts/main/user/block/expeditor.php';
  }

  function expeditor2(){
    include 'app/view/layouts/main/user/block/expeditor2.php';
  }

  function edueditor(){
    include 'app/view/layouts/main/user/block/edueditor.php';
  }

  function edueditor2(){
    include 'app/view/layouts/main/user/block/edueditor2.php';
  }

  function skilleditor(){
    include 'app/view/layouts/main/user/block/skilleditor.php';
  }

  function relateeditor(){
    if(isset($_POST['id'])){
      $id = $_POST['id'];
    }
    include 'app/view/layouts/main/user/block/relateeditor.php';
  }

  function postingeditor(){
    $id = $_POST['id'];
    include 'app/view/layouts/emp/main/form/editposting.php';
  }

  function malerelateoption(){
    include 'app/view/layouts/main/user/block/genderselect/male.php';
  }

  function femalerelateoption(){
    include 'app/view/layouts/main/user/block/genderselect/female.php';
  }

  function empcateditor(){
    include 'app/view/layouts/emp/main/form/cateditor.php';
  }

  function compabouteditor(){
    include 'app/view/layouts/emp/main/form/abouteditor.php';
  }

  function emplogoeditor(){
    include 'app/view/layouts/emp/main/form/emplogoeditor.php';
  }

  function empdetaileditor(){
    $type = $_POST['type'];
    include 'app/view/layouts/emp/main/form/detaileditor.php';
  }

  function locationeditor(){
    $formname = $_POST['formname'];
    include 'app/view/layouts/emp/main/form/locationeditor.php';
  }

  function notifications(){
    if(isset($_POST['id'])){
      $id = $_POST['id'];
      $result = Notification::getByRecipient($id);
      while($row = $result->fetch_array()){
        include 'app/view/layouts/main/timeline/block/notification.php';
      }
    }
  }

  function saveJob($id = NULL){
    if($id != null){
      $uid = $_POST['uid'];
      JobController::saveJob($uid, $id);
    }
  }

  function getJobByEmp($id = NULL){
    if($id != null){
      $uid = $_POST['uid'];
      $result = JobController::loadAllPosting($_POST['limit'], $_POST['offset'], $id);
      $jsonData = array();
      while ($row = mysqli_fetch_array($result)) {
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
            'favorite' => JobController::getSaveStatus($uid, $id),
            'apply' => JobController::getApplyStatus($uid, $id),
          );
          array_push($jsonData, $arr);
      }
      echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
    }
  }

  function getJobDetail($id = NULL){
    if($id != null){
      $uid = $_POST['uid'];
      $row = JobController::loadJobPosting($id);
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
          'favorite' => JobController::getSaveStatus($uid, $id),
          'apply' => JobController::getApplyStatus($uid, $id),
        );
      echo str_replace(array('[', ']'), '', json_encode($arr, JSON_UNESCAPED_UNICODE));
    }else{
      $uid = $_POST['uid'];
      $result = JobController::loadTopJob();
      $jsonData = array();
      while ($row = mysqli_fetch_array($result)) {
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
            'favorite' => JobController::getSaveStatus($uid, $id),
            'apply' => JobController::getApplyStatus($uid, $id),
          );
          array_push($jsonData, $arr);
      }
      echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
    }
  }

  function getRecommendJob($uid, $limit){
    $result = JobController::getRecommendedJob($uid, $limit);
    $jsonData = array();
    while ($row = mysqli_fetch_array($result)) {
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
          'favorite' => JobController::getSaveStatus($uid, $row['id']),
          'apply' => JobController::getApplyStatus($uid, $row['id']),
        );
        array_push($jsonData, $arr);
    }
    echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
  }

  function getSimilarJob($jid){
    $uid = $_POST['uid'];
    $result = JobController::getSimilarJob($jid);
    $jsonData = array();
    while ($row = mysqli_fetch_array($result)) {
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
          'favorite' => JobController::getSaveStatus($uid, $row['id']),
          'apply' => JobController::getApplyStatus($uid, $row['id']),
        );
        array_push($jsonData, $arr);
    }
    echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
  }

  function getEmpDetail($id){
    if(isset($id)){
      $result = Employer::loadEMP($id);
      $jsonData = array();
      while ($row = mysqli_fetch_array($result)) {
        $category = JobController::getEmpCategory($row['category_id']);
        $arr = array(
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
        array_push($jsonData, $arr);
      }
      echo str_replace(array('[', ']'), '', json_encode($jsonData, JSON_UNESCAPED_UNICODE));
    }
  }

  function getnotis(){
    if(isset($_POST['id'])){
      $id = $_POST['id'];
      $result = Notification::getByRecipient($id);
      $notiCount = Notification::getUnreadsNum($id);

      $jsonData = array();

      while ($arr = mysqli_fetch_assoc($result)) {
        array_push($jsonData, $arr);
      }

      echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
    }
  }

  function noticount(){
    if(isset($_POST['id'])){
      $id = $_POST['id'];
      echo Notification::getUnreadsNum($id);
    }
  }

  function saveLocation($help = false){
    if(isset($_POST['id'])){
      $id = $_POST['id'];
      $lat = $_POST['lat'];
      $lng = $_POST['lng'];
      Location::setCurrentLocation($id, $lat, $lng);
      if($help){
        $id = $_POST['id'];
        $relatives = Profile::getRelatives($id);
        Notification::set($relatives, $id, 'dis.callhelp', $id);
      }
    }
  }

  function getLocation(){
    if(isset($_POST['id'])){
      $id = $_POST['id'];
      Location::getCurrentLocation($id);
    }
  }

  function newtoken(){
    if(isset($_POST['id'])){
      $id = $_POST['id'];
      $token = $_POST['token'];
      Profile::setToken($id, $token);
    }
  }

  function deleteToken(){
    if(isset($_POST['id'])){
      $id = $_POST['id'];
      $token = $_POST['token'];
      Profile::deleteToken($id, $token);
    }
  }

  function markread(){
    if(isset($_POST['id'])){
      $id = $_POST['id'];
      Notification::mark($id, 0);
    }
  }

  function getFriends($id = NULL){
    if($id != NULL){
      $jsonData = array();
      $friend = Profile::getFriends($id, false);
      while ($fnd = mysqli_fetch_assoc($friend)) {
        $result = Profile::profileload($fnd['ID']);
        while ($arr = mysqli_fetch_assoc($result)) {
          if($_POST['id'] == $arr['id']){
            $friendship = 4;
          }else{
            $friendship = Profile::getFriendship($_POST['id'], $arr['id']);
          }
          $profile = array(
            "id" => $arr['id'],
            "guid" => $arr['guid'],
            "email" => $arr['email'],
            "user_group" => $arr['user_group'],
            "status" => $arr['status'],
            "validate" => $arr['validate'],
            "profile_image" => $arr['profile_image'],
            "header_image" => $arr['header_image'],
            "first_name" => $arr['first_name'],
            "last_name" => $arr['last_name'],
            "sex" => $arr['sex'],
            "birthdate" => $arr['birthdate'],
            "telephone" => $arr['telephone'],
            "facebook" => $arr['facebook'],
            "twitter" => $arr['twitter'],
            "line" => $arr['line'],
            "other_link" => $arr['other_link'],
            "friend_status" => $friendship,
            "friend_count" => Profile::getFriendsCount($arr['id']),
          );
          array_push($jsonData,$profile);
        }
      }
      echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
    }
  }

  function getProfile($id = NULL){
    if($id != NULL){
      $result = Profile::profileLoad($id);
      $jsonData = array();

      while ($arr = mysqli_fetch_assoc($result)) {
        if($_POST['id'] == $arr['id']){
          $freindship = 4;
        }else{
          $freindship = Profile::getFriendship($_POST['id'], $arr['id']);
        }
        $profile = array(
          "id" => $arr['id'],
          "guid" => $arr['guid'],
          "email" => $arr['email'],
          "user_group" => $arr['user_group'],
          "status" => $arr['status'],
          "on_order" => $arr['on_order'],
          "validate" => $arr['validate'],
          "profile_image" => $arr['profile_image'],
          "header_image" => $arr['header_image'],
          "first_name" => $arr['first_name'],
          "last_name" => $arr['last_name'],
          "sex" => $arr['sex'],
          "birthdate" => $arr['birthdate'],
          "telephone" => $arr['telephone'],
          "facebook" => $arr['facebook'],
          "twitter" => $arr['twitter'],
          "line" => $arr['line'],
          "other_link" => $arr['other_link'],
          "friend_status" => $freindship,
          "friend_count" => Profile::getFriendsCount($arr['id']),
        );
        array_push($jsonData,$profile);
      }

      echo str_replace(array('[', ']'), '', htmlspecialchars(json_encode($jsonData, JSON_UNESCAPED_UNICODE), ENT_NOQUOTES));
    }
  }

    function getAllProfiles(){
    $result = Profile::allProfilesLoad();

    $jsonData = array();

    while ($arr = mysqli_fetch_assoc($result)) {
      if($_POST['id'] == $arr['id']){
        $freindship = 4;
      }else{
        $freindship = Profile::getFriendship($_POST['id'], $arr['id']);
      }
      $profile = array(
        "id" => $arr['id'],
        "guid" => $arr['guid'],
        "email" => $arr['email'],
        "user_group" => $arr['user_group'],
        "status" => $arr['status'],
        "on_order" => $arr['on_order'],
        "validate" => $arr['validate'],
        "profile_image" => $arr['profile_image'],
        "header_image" => $arr['header_image'],
        "first_name" => $arr['first_name'],
        "last_name" => $arr['last_name'],
        "sex" => $arr['sex'],
        "birthdate" => $arr['birthdate'],
        "telephone" => $arr['telephone'],
        "facebook" => $arr['facebook'],
        "twitter" => $arr['twitter'],
        "line" => $arr['line'],
        "other_link" => $arr['other_link'],
        "friend_status" => $freindship,
        "friend_count" => Profile::getFriendsCount($arr['id']),
      );
      array_push($jsonData,$profile);
    }

    echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
  }

  function commentload($id = NULL){
    if(isset($_POST['offset'])){
      if(isset($_POST['limit'])){
        $result = Comment::load($id, $_POST['offset'], $_POST['limit']);
        $jsonData = array();
        while ($row = $result->fetch_array()){
          $arr = array('id' => $row['id'],
              'message' => $row['message'],
              'created_at' => $row['created_at'],
              'author' => $row['author'],
              'post_id' => $row['post_id'],
              'like_count' => Like::getLikesCount($row['id'], 1),
              'like_status' => Like::getLikesStatus($_POST['id'], $row['id'], 1)
            );
          array_push($jsonData, $arr);
        }
        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
      }else{
        echo "NO LIMIT";
      }
    }else{
      echo "NO OFFSET";
    }
  }

  function getpost(){
    if(isset($_POST['offset'])){
      if(isset($_POST['limit'])){
        $result = Post::postload($_POST['offset'], $_POST['limit']);
        $id = $_POST['id'];

        $jsonData = array();

        while ($row = $result->fetch_array()){
          $friendship = Profile::getFriendship($_POST['id'], $row['author']);
          if($row['author'] == $_POST['id'] || $friendship == 3 || $friendship == 1){
            $arr = array('id' => $row['id'],
                'message' => $row['message'],
                'created_at' => $row['created_at'],
                'author' => $row['author'],
                'posted_to' => $row['posted_to'],
                'like_count' => Like::getLikesCount($row['id'], 0),
                'comment_count' => Comment::getCommentsCount($row['id']),
                'like_status' => Like::getLikesStatus($_POST['id'], $row['id'], 0)
              );
            array_push($jsonData, $arr);
          }
        }

        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
      }else{
        echo "No Limit";
      }
    }else{
      echo "No Offset";
    }
  }

  function getPostById($id = null){
      $result = Post::loadById($id);
      $row = mysqli_fetch_assoc($result);
      $uid = $_POST['id'];
      $arr = array('id' => $row['id'],
          'message' => $row['message'],
          'created_at' => $row['created_at'],
          'author' => $row['author'],
          'posted_to' => $row['posted_to'],
          'like_count' => Like::getLikesCount($row['id'], 0),
          'comment_count' => Comment::getCommentsCount($row['id']),
          'like_status' => Like::getLikesStatus($_POST['id'], $row['id'], 0)
        );
      echo str_replace(array('[', ']'), '', htmlspecialchars(json_encode($arr, JSON_UNESCAPED_UNICODE), ENT_NOQUOTES));
  }

  function getProfileTimeline(){
    if(isset($_POST['offset'])){
      if(isset($_POST['limit'])){
        $id = $_POST['pid'];
        $result = Post::postload($_POST['offset'], $_POST['limit']);

        $jsonData = array();

        while ($row = $result->fetch_array()){
          if($row['author'] == $id || $row['posted_to'] == $id){
            $arr = array('id' => $row['id'],
                'message' => $row['message'],
                'created_at' => $row['created_at'],
                'author' => $row['author'],
                'posted_to' => $row['posted_to'],
                'like_count' => Like::getLikesCount($row['id'], 0),
                'comment_count' => Comment::getCommentsCount($row['id']),
                'like_status' => Like::getLikesStatus($_POST['id'], $row['id'], 0)
              );
            array_push($jsonData, $arr);
          }
        }

        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
      }
    }
  }

  function getFriendsName($id, $norelate = false){
    $result = Profile::getFriends($id);

    if($norelate){
      $relative = Profile::getRelatives($id);
      $pending = Profile::getPendingRelatives($id);
      $result = array_diff($result, $relative);
      $result = array_diff($result, $pending);
    }

    $jsonData = array();

    foreach ($result as $value) {
      $user = Profile::profileLoad($value);
      $user = mysqli_fetch_array($user);
      $name = $user['first_name']." ".$user['last_name'];
      $arr = array('id' => $value,
        'name' => $name,
        'gender' => $user['sex'],
        'profile_image' => $user['profile_image']);
      array_push($jsonData, $arr);
    }

    echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
  }

  function getExp($id = NULL){
    if($id != NULL){
      $result = Experiences::expLoad($id);
      $jsonData = array();
      while ($row = $result->fetch_assoc()){
        $arr = array('id' => $row['id'],
            'name' => $row['name'],
            'company' => $row['company'],
            'status' => $row['status'],
            'start_at' => $row['start_at'],
            'end_at' => $row['end_at']
          );
        array_push($jsonData, $arr);
      }

      echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
    }else{
      header("HTTP/1.0 404 Not Found");
      exit();
    }
  }

  function getEdu($id = NULL){
    if($id != NULL){
      $result = Educations::eduLoad($id);
      $jsonData = array();
      while ($row = $result->fetch_assoc()){
        $arr = array('id' => $row['id'],
            'institute_name' => $row['institute_name'],
            'background' => $row['background'],
            'major' => $row['major'],
            'gpa' => $row['gpa']
          );
        array_push($jsonData, $arr);
      }

      echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
    }else{
      header("HTTP/1.0 404 Not Found");
      exit();
    }
  }

  function getAmphurList($id = NULL, $lang = "en"){
    if($id != NULL){
      if($lang == "en"){
        $thai = false;
      }else{
        $thai = true;
      }
      $result = Address::getAmphurByProvince($id, $thai);
      $jsonData = array();
      while ($row = $result->fetch_assoc()){
        array_push($jsonData, $row);
      }
      echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
    }else{
      header("HTTP/1.0 404 Not Found");
      exit();
    }
  }

  function getProvinceList($lang = "en"){
    if($lang == "en"){
      $thai = false;
    }else{
      $thai = true;
    }
    $result = Address::getAllProvince($thai);
    $jsonData = array();
    while ($row = $result->fetch_assoc()){
      array_push($jsonData, $row);
    }
    echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
  }
}
