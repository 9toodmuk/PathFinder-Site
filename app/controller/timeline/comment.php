<?php
namespace Controller\Timeline;

use Config\Database;
use Controller\Timeline\Notification;
use Controller\Timeline\Post;

class Comment {

  public static function addComment($id, $pid, $comment){
    $conn = Database::connection();
    $created_at = date("Y-m-d H:i:s");
    $sql = "INSERT INTO comments (message, author, created_at, post_id) VALUES ('$comment', '$id', '$created_at', '$pid')";
    if($conn->query($sql)){
      $cid = $conn->insert_id;
      $type = "post.comment";
      Notification::set(Post::getPostAuthor($pid), $id, $type, $cid);
      return Comment::loadById($cid);
    }else{
      echo "Error";
    }
  }

  public static function getCommentAuthor($pid){
    $post = Comment::loadById($pid);
    $result = $post->fetch_array();

    return $result['author'];
  }

  public static function load($id, $perpage = NULL, $limit = NULL){
    $conn = Database::connection();
    $sql = "SELECT * FROM comments WHERE post_id = '$id'";
    if(!is_null($limit)){
      if(!is_null($perpage)){
        $sql = $sql . " LIMIT $perpage, $limit";
      }else{
        $sql = $sql . " LIMIT $limit";
      }
    }
    return $conn->query($sql);
  }

  public static function loadById($id){
    $conn = Database::connection();
    $sql = "SELECT * FROM comments WHERE id = '$id'";
    return $conn->query($sql);
  }

  public static function getCommentsCount($id){
    $result = Comment::load($id);
    return mysqli_num_rows($result);
  }
}
