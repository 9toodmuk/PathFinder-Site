<?php
namespace App\Controller\Timeline;

use App\Config\Database;
use App\Controller\Timeline\Notification;

class Post {
  public static function addPost($message, $id, $fid = NULL){
    $conn = Database::connection();
    $created_at = date("Y-m-d H:i:s");
    $sql = "INSERT INTO post (message, author, created_at) VALUES ('$message', '$id', '$created_at')";

    if($fid != NULL){
      if($id != $fid){
        $sql = "INSERT INTO post (message, author, created_at, posted_to) VALUES ('$message', '$id', '$created_at', '$fid')";
      }
    }

    if($conn->query($sql)){
      $pid = $conn->insert_id;
      if($fid != NULL){
        $type = "post.feed";
        Notification::set($fid, $id, $type, $pid);
      }
      return Post::loadById($pid);
    }else{
      echo "Error";
    }
  }

  public static function getPostAuthor($pid){
    $post = Post::loadById($pid);
    $result = $post->fetch_array();

    return $result['author'];
  }

  public static function loadById($pid){
    $conn = Database::connection();
    $sql = "SELECT * FROM post WHERE id = '$pid'";
    return $conn->query($sql);
  }

  public static function postload($id, $perpage = NULL){
    $conn = Database::connection();
    $sql = "SELECT * FROM (SELECT * FROM post";

    if($id != 0){
      $sql = $sql . " WHERE id < '$id'";
    }

    $sql = $sql . ") t ORDER BY t.created_at DESC LIMIT 10";

    return $conn->query($sql);
  }
}
