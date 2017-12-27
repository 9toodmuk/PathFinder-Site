<?php
namespace Controller\User;

use Config\Database;
use Controller\Auth\Login;
use Controller\Timeline\Notification;

class Profile{
  public static function profileLoad($uid){
    $conn = Database::connection();
    $sql = "SELECT users.id, users.guid, users.email, users.user_group, users.status, users.on_order, users.validate,
    users.profile_image, users.header_image, personal_details.first_name, personal_details.last_name, personal_details.sex, personal_details.birthdate,
    personal_details.telephone, personal_details.facebook, personal_details.twitter, personal_details.line, personal_details.other_link, personal_details.disability
    FROM users JOIN personal_details ON users.id = personal_details.user_id WHERE users.id = '$uid';";

    return $conn->query($sql);
  }

  public static function allProfilesLoad(){
    $conn = Database::connection();
    $sql = "SELECT users.id, users.guid, users.email, users.user_group, users.status, users.on_order, users.validate,
    users.profile_image, users.header_image, personal_details.first_name, personal_details.last_name, personal_details.sex, personal_details.birthdate,
    personal_details.telephone, personal_details.facebook, personal_details.twitter, personal_details.line, personal_details.other_link, personal_details.disability
    FROM users JOIN personal_details ON users.id = personal_details.user_id;";

    return $conn->query($sql);
  }

  public static function getFavJobs($uid){
    $conn = Database::connection();
    $sql = "SELECT job_id, created_at FROM job_fav_lists WHERE user_id = '$uid';";

    return $conn->query($sql);
  }

  public static function getProPic($uid){
    $user = Profile::profileload($uid);
    $user = mysqli_fetch_array($user);
    return $user['profile_image'];
  }

  public static function getUserGroup($uid){
    $conn = Database::connection();
    $sql = "SELECT * FROM users WHERE id ='$uid'";
    $user = $conn->query($sql);
    $user = mysqli_fetch_array($user);
    return $user['user_group'];
  }

  public static function changeProfilePic($id, $url){
    $conn = Database::connection();
    $sql = "UPDATE users SET profile_image = '$url' WHERE id = '$id';";
    $conn->query($sql);
  }

  public static function getFriendship($id1, $id2){
    $conn = Database::connection();
    $sql = "SELECT * FROM user_friendship WHERE user_id = '$id1' AND friend_user_id = '$id2' OR user_id = '$id2' AND friend_user_id = '$id1'";
    $query = $conn->query($sql);

    $num = mysqli_num_rows($query);

    if($num == 2){
      return 3;
    }elseif($num == 0){
      return 0;
    }else{
      $result = mysqli_fetch_array($query);
      return Profile::checkrequest($result, $id1);
    }
  }

  public static function getFriendsCount($id){
    $conn = Database::connection();
    $sql = "SELECT ID FROM (SELECT user_id AS ID FROM user_friendship WHERE friend_user_id = '$id'
      UNION ALL SELECT friend_user_id FROM user_friendship WHERE user_id = '$id') t
      GROUP BY ID HAVING COUNT(ID) > 1;";
    $result = $conn->query($sql);
    return mysqli_num_rows($result);
  }

  public static function getFriends($id, $asarray = true){
    $conn = Database::connection();
    $sql = "SELECT ID FROM (SELECT user_id AS ID FROM user_friendship WHERE friend_user_id = '$id'
      UNION ALL SELECT friend_user_id FROM user_friendship WHERE user_id = '$id') t
      GROUP BY ID HAVING COUNT(ID) > 1;";

    $result = $conn->query($sql);

    if($asarray){
      $friends = array();
      while($row = $result->fetch_array()){
        array_push($friends, $row['ID']);
      }
      return $friends;
    }else{
      return $result;
    }
  }

  public static function getRelatives($id){
    $conn = Database::connection();
    $sql = "SELECT ID FROM (SELECT user1 AS ID FROM user_relations WHERE user2 = '$id'
      UNION ALL SELECT user2 FROM user_relations WHERE user1 = '$id') t
      GROUP BY ID HAVING COUNT(ID) > 1;";
    $result = $conn->query($sql);

    $relative = array();
    while($row = $result->fetch_array()){
      array_push($relative, $row['ID']);
    }

    return $relative;
  }

  public static function getRelateType($user1, $user2){
    $conn = Database::connection();
    $sql = "SELECT * FROM user_relations WHERE user1 = '$user1' AND user2 = '$user2';";
    $result = $conn->query($sql);
    $result = mysqli_fetch_array($result);

    return $result['type'];
  }

  public static function getPendingRelatives($id){
    $conn = Database::connection();

    $sql = "SELECT user2 AS ID FROM user_relations WHERE user1 = '$id' AND user2 NOT IN (SELECT user1 FROM user_relations WHERE user2 = '$id')";
    $result = $conn->query($sql);

    $relative = array();
    while($row = $result->fetch_array()){
      array_push($relative, $row['ID']);
    }

    return $relative;
  }

  public static function getRequestRelatives($id){
    $conn = Database::connection();

    $sql = "SELECT user1 AS ID FROM user_relations WHERE user2 = '$id' AND user1 NOT IN (SELECT user2 FROM user_relations WHERE user1 = '$id')";
    $result = $conn->query($sql);

    $relative = array();
    while($row = $result->fetch_array()){
      array_push($relative, $row['ID']);
    }

    return $relative;
  }

  public static function removeRelative($id1, $id2){
    $conn = Database::connection();

    $sql = "DELETE FROM user_relations WHERE user1 in ('$id1', '$id2') AND user2 in ('$id1', '$id2');";
    $result = $conn->query($sql);

    if($conn->query($sql)){
      $arr = array('status' => true);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }else{
      $arr = array('status' => false, 'error' => $conn->error);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
  }

  public static function setToken($id, $token){
    if(Profile::checkToken($id, $token) < 1){
      $conn = Database::connection();
      $sql = "INSERT INTO user_tokens (token, user_id) VALUES ('$token', '$id');";
      $conn->query($sql);
    }
  }

  public static function deleteToken($id, $token){
    $conn = Database::connection();
    $sql = "DELETE FROM user_tokens WHERE token = '$token' AND user_id = '$id';";
    $conn->query($sql);
  }

  public static function getToken($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM user_tokens WHERE user_id = '$id';";
    $result = $conn->query($sql);
    if(mysqli_num_rows($result) >= 1){
      $result = mysqli_fetch_array($result);
      return $result['token'];
    }else{
      return false;
    }
  }

  public static function checkToken($id, $token){
    $conn = Database::connection();
    $sql = "SELECT * FROM user_tokens WHERE token = '$token' AND user_id = '$id';";
    $result = $conn->query($sql);

    return mysqli_num_rows($result);
  }

  public static function checkrequest($result, $uid){
    if($result['user_id'] == $uid){
      return 1;
    }else{
      return 2;
    }
  }

  public function addRelative($user1, $user2, $relationship){
    $conn = Database::connection();
    $sql = "SELECT * FROM user_relations WHERE user1 = '$user1' AND user2 = '$user2';";
    $result = $conn->query($sql);
    if(mysqli_num_rows($result) == 0){
      $created_at = date("Y-m-d H:i:s");
      $sql = "INSERT INTO user_relations (user1, user2, type, created_at) VALUES ('$user1', '$user2', '$relationship', '$created_at')";
      if($conn->query($sql)){
        $type = "relative.add";
        Notification::set($user2, $user1, $type, $user2);
        $arr = array('status' => true);
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
      }else{
        $arr = array('status' => false, 'error' => $conn->error);
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
      }
    }else{
      $arr = array('status' => false, 'error' => 'multiple');
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
  }

  public function editRelative($user1, $user2, $relationship){
    $conn = Database::connection();
    $sql = "UPDATE user_relations SET type = '$relationship' WHERE user1 = '$user1' AND user2 = '$user2';";
    $result = $conn->query($sql);
    if($conn->query($sql)){
      $arr = array('status' => true);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }else{
      $arr = array('status' => false, 'error' => $conn->error);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
  }

  public function update($id, $data, $field){
    $conn = Database::connection();
    if(is_array($data)){
      $sql = "UPDATE personal_details SET $field[0] = '$data[0]', $field[1] = '$data[1]' WHERE user_id = '$id';";
    }else{
      $sql = "UPDATE personal_details SET $field = '$data' WHERE user_id = '$id';";
    }
    if($conn->query($sql)){
      $status = Login::checkStatus($id);
      if($status == 0){
        $sql = "UPDATE users SET status = '1' WHERE id = '$id';";
        if($conn->query($sql)){
          echo "Success";
        }else{
          echo "Error";
        }
      }else{
        echo "Success";
      }
    }else{
      echo "Error";
    }
  }

  public function sendRequest($uid, $friend){
    $created_at = date("Y-m-d H:i:s");
    $conn = Database::connection();
    $sql = "INSERT INTO user_friendship (user_id, friend_user_id, created_at) VALUES ('$uid', '$friend', '$created_at');";
    if($conn->query($sql)){
      $friendship = Profile::getFriendship($uid, $friend);
      if($friendship == 3){
        $type = "friend.accept";
        Notification::set($friend, $uid, $type, $uid);
      }else{
        $type = "friend.add";
        Notification::set($friend, $uid, $type, $uid);
      }
      $arr = array('status' => true, 'friendship' => $friendship);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }else{
      $arr = array('status' => false);
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
  }

  public function gender($gender){
    switch($gender){
      case 0:
        return 'male';
      case 1:
        return 'female';
    }
  }
}
