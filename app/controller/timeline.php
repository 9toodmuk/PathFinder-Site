<?php
use App\Controller\View\View;
use App\Controller\Auth\Login;
use App\Controller\Auth\Register;
use App\Controller\Timeline\Post;
use App\Controller\Timeline\Like;
use App\Controller\Timeline\Comment;
use App\Controller\User\Profile;

class Timeline extends Controller{
  protected $homelayout = 'app/view/layouts/home.php';
  protected $timeline = 'app/view/layouts/main/timeline/index.php';
  protected $post = 'app/view/layouts/main/timeline/block/post.php';
  protected $comment = 'app/view/layouts/main/timeline/block/comment.php';

  public function __construct(){

  }

  function index(){
    if(isset($_SESSION['social_id'])){
      echo View::render($this->homelayout, array("timeline", $this->timeline));
    }else{
      header("Location: /");
      exit();
    }
  }

  function load(){
    if(isset($_POST['id'])){
      if(isset($_POST['limit'])){
        $result = Post::postload($_POST['id'], $_POST['limit']);
        while ($row = $result->fetch_assoc()){
          $friendship = Profile::getFriendship($_SESSION['social_id'], $row['author']);
          if($row['author'] == $_SESSION['social_id'] || $friendship == 3 || $friendship == 1){
            include $this->post;
          }
        }
      }
    }
  }

  function post(){
    $id = $_POST['id'];
    $message = $_POST['message'];

    if(isset($_POST['fid'])){
      $fid = $_POST['fid'];
      $result = Post::addPost($message, $id, $fid);
    }else{
      $result = Post::addPost($message, $id);
    }

    while ($row = $result->fetch_array()){
      include $this->post;
    }
  }

  function comment(){
    $id = $_POST['id'];
    $pid = $_POST['pid'];
    $message = $_POST['message'];

    $result = Comment::addComment($id, $pid, $message);

    while ($row = $result->fetch_array()){
      include $this->comment;
    }
  }

  function commentload(){
    if(isset($_POST['limit'])){
      if(isset($_POST['perpage'])){
        $id = $_POST['id'];

        $result = Comment::load($id, $_POST['limit'], $_POST['perpage']);

        while ($row = $result->fetch_array()){
          include $this->comment;
        }
      }
    }
  }

  function like(){
    $id = $_POST['id'];
    $uid = $_POST['uid'];
    $type = $_POST['type'];

    Like::addNewLike($uid, $id, $type);
  }
}
