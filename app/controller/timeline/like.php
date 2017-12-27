<?php
namespace Controller\Timeline;

use Config\Database;
use Controller\Timeline\Notification;
use Controller\Timeline\Post;
use Controller\Timeline\Comment;

class Like {
  public static function addNewLike($id, $pid, $type){
    if(!Like::getLikesStatus($id, $pid, $type)){
      $created_at = date("Y-m-d H:i:s");
      $conn = Database::connection();
      $sql = "INSERT INTO likes (author, type, post_id, created_at) VALUES ('$id', '$type', '$pid', '$created_at')";
      if($conn->query($sql)){
        echo "SuccessAdd";
        if($type == 0){
          $pid = Post::getPostAuthor($pid);
          $type = 'post.like';
        }else{
          $pid = Comment::getCommentAuthor($pid);
          $type = 'post.comment.like';
        }
        Notification::set($pid, $id, $type, $pid);
      }else{
        echo "Error";
      }
    }else{
      Like::deleteLike($id, $pid, $type);
    }
  }

  public static function deleteLike($id, $pid, $type){
    $conn = Database::connection();
    $sql = "DELETE FROM likes WHERE type = '$type' AND author = '$id' AND post_id = '$pid'";
    if($conn->query($sql)){
      echo "SuccessDelete";
    }else{
      echo "Error";
    }
  }

  public static function getLikesCount($id, $type){
    $conn = Database::connection();
    $sql = "SELECT * FROM likes WHERE type = '$type' AND post_id = '$id'";
    $result = $conn->query($sql);
    return mysqli_num_rows($result);
  }

  public static function getLikesStatus($id, $pid, $type){
    $conn = Database::connection();
    $sql = "SELECT * FROM likes WHERE type = '$type' AND author = '$id' AND post_id = '$pid'";
    $result = $conn->query($sql);
    if(mysqli_num_rows($result) >= 1){
      return true;
    }else{
      return false;
    }
  }
}
