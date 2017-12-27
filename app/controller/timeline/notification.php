<?php
namespace Controller\Timeline;

use Config\Database;
use Controller\Utils\FCM;
use Controller\User\Profile;
use Controller\View\Language;

class Notification {
  public static function get($id, $limit = 20, $offset = 0){
    $conn = Database::connection();
    $sql = "SELECT * FROM notifications WHERE id = '$id' LIMIT $offset, $limit;;";
    $result = $conn->query($sql);

    return mysqli_fetch_array($result);
  }

  public static function getByRecipient($id, $limit = 20, $offset = 0){
    $conn = Database::connection();
    $sql = "SELECT * FROM notifications WHERE recipient_id = '$id' AND sender_id != '$id' ORDER BY created_at DESC LIMIT $offset, $limit;";
    return $conn->query($sql);
  }

  public static function getUnreadsNum($id, $limit = 20, $offset = 0){
    $conn = Database::connection();
    $sql = "SELECT * FROM notifications WHERE recipient_id = '$id' AND sender_id != '$id' AND unread = 1 LIMIT $offset, $limit;";
    $result = $conn->query($sql);

    return mysqli_num_rows($result);
  }

  public static function set($recipient, $sender, $type, $ref){
      $created_at = date("Y-m-d H:i:s");
      $conn = Database::connection();
      $ref = Notification::setRef($type, $ref);
      if(is_array($recipient)){
        foreach ($recipient as $value) {
          if($value != $sender){
            $sql = "INSERT INTO notifications (recipient_id, sender_id, type, reference_link, created_at) VALUES ('$value', '$sender', '$type', '$ref', '$created_at');";
            if($conn->query($sql)){
              Notification::send($value, $sender, 'PathFinder', $type);
            }
          }
        }
      }else{
        if($recipient != $sender){
          $sql = "INSERT INTO notifications (recipient_id, sender_id, type, reference_link, created_at) VALUES ('$recipient', '$sender', '$type', '$ref', '$created_at');";
          if($conn->query($sql)){
            Notification::send($recipient, $sender, 'PathFinder', $type);
          }
        }
      }
  }

  public static function send($id, $sender, $title, $body, $action = 'OPEN_ACTIVITY', $sound = 'default', $badge = 1){
    $token = array();

    if (is_array($id)) {
      foreach ($id as $value) {
        $temp = Profile::getToken($value);
        if($temp !== false){
          array_push($token, $temp);
        }
      }
    }else{
      array_push($token, Profile::getToken($id));
    }

    $senderprofile = Profile::profileload($sender);
    $senderprofile = mysqli_fetch_array($senderprofile);

    $action = Notification::getActivity($body);

    $body = Notification::setText($sender, $body);

    if(sizeof($token) >= 1){
      $notification = array(
      	'title' => $title,
      	'body' => $body,
      	'sound' => $sound,
      	'badge' => $badge,
      	'click_action' => $action
      );

      $data = array(
        'profile_image' => 'https://www.pathfinder.in.th/uploads/profile_image/'.$senderprofile['profile_image'],
        'sender_id' => $sender
      );

      FCM::send_notification($token, $notification, $data);
    }
  }

  public static function setText($sender, $type){
    $sender = Profile::profileload($sender);
    $sender = mysqli_fetch_array($sender);

    $array = Language::loadlanguage('th');

    $type = $array[Notification::getType($type)];

    $text = $sender['first_name'].' '.$sender['last_name'].' '.$type;

    return $text;
  }

  public static function setType($type){
    return $type;
  }

  public static function setRef($type, $ref){
    switch($type){
      case "post.like":
        $ref = '/timeline/post/'.$ref;
        break;
      case "post.comment":
        $ref = '/timeline/post/comment/'.$ref;
        break;
      case "post.comment.like":
        $ref = '/timeline/post/comment/'.$ref;
        break;
      case "tag.post":
        return "noti_tag_post";
        break;
      case "tag.comment":
        return "noti_tag_comment";
        break;
      case "post.feed":
        $ref = '/timeline/post/'.$ref;
        break;
      case "dis.callhelp":
        $ref = "/location/user/".$ref;
        break;
      case "friend.add":
        $ref = "/user/".$ref;
        break;
      case "friend.accept":
        $ref = "/user/".$ref;
        break;
      case "relative.add":
        $ref = "/location/user/edit/#relative";
        break;
      case "relative.accept":
        $ref = "/location/user/edit/#relative";
        break;
    }
    return $ref;
  }

  public static function mark($id, $unread){
    $conn = Database::connection();
    $sql = "UPDATE notifications SET unread = '$unread' WHERE id = '$id';";
    if($conn->query($sql)){
      echo "Success";
    }
  }

  public static function getActivity($type){
    switch($type){
      case "dis.callhelp":
        return "OPEN_MAP_ACTIVITY";
        break;
      default:
        return "OPEN_POST_ACTIVITY";
        break;
    }
  }

  public static function getType($type){
    switch($type){
      case "post.like":
        return "noti_post_like";
        break;
      case "post.comment":
        return "noti_post_comment";
        break;
      case "post.comment.like":
        return "noti_post_comment_like";
        break;
      case "tag.post":
        return "noti_tag_post";
        break;
      case "tag.comment":
        return "noti_tag_comment";
        break;
      case "post.feed":
        return "noti_post_feed";
        break;
      case "dis.callhelp":
        return "noti_callhelp";
        break;
      case "friend.add":
        return "noti_friend_add";
        break;
      case "friend.accept":
        return "noti_friend_accept";
        break;
      case "relative.add":
        return "noti_relative_add";
        break;
      case "relative.accept":
        return "noti_relative_accept";
        break;
    }
  }
}
?>
