<?php

use App\Controller\View\View;
use App\Controller\Auth\Login;
use App\Controller\Auth\Register;
use App\Controller\User\Profile;
use App\Controller\Utils\Email;

class Home extends Controller{
  protected $indexlayout = 'app/view/layouts/index.php';
  protected $homelayout = 'app/view/layouts/home.php';
  protected $nosidebar = 'app/view/layouts/nosidebar.php';
  protected $fullwidth = 'app/view/layouts/fullwidth.php';
  protected $timeline = 'app/view/layouts/main/timeline/index.php';
  protected $formlogin = 'app/view/layouts/index/forms/formlogin.php';
  protected $registerlogin = 'app/view/layouts/index/forms/formregister.php';
  protected $recoverform = 'app/view/layouts/index/forms/formforgotpassword.php';
  protected $createprofile = 'app/view/layouts/index/forms/formcreateprofile.php';
  protected $favorite = 'app/view/layouts/main/user/favorite.php';
  protected $inbox = 'app/view/layouts/main/user/message/inbox.php';
  protected $reader = 'app/view/layouts/main/user/message/reader.php';

  public function __construct(){

  }

  function index(){
    if(isset($_SESSION['social_id'])){
      $user = Profile::profileLoad($_SESSION['social_id']);
      $user = mysqli_fetch_assoc($user);
      if($user['status'] == 0 && $user['skip'] == 0){
        header("Location: /home/createprofile/");
        exit();
      }else{
        echo View::render($this->homelayout, "home");
      }
    }else{
      echo View::render($this->indexlayout, $this->formlogin);
    }
  }

  function registration(){
    if(isset($_SESSION['social_id'])){
      header("Location: /");
      exit();
    }else{
      echo View::render($this->indexlayout, $this->registerlogin);
    }
  }

  function recover(){
    if(isset($_SESSION['social_id'])){
      echo View::render($this->indexlayout, $this->recoverform);
    }else{
      header("Location: /");
      exit();
    }
  }

  function sendRecover(){
    if(isset($_SESSION['social_id'])){
      Email::sendEmail($_SESSION['social_id'], 1);
    }else{
      header("Location: /");
      exit();
    }
  }

  function createprofile(){
    if(!isset($_SESSION['social_id'])){
      header("Location: /");
      exit();
    }else{
      $user = Profile::profileLoad($_SESSION['social_id']);
      $user = mysqli_fetch_assoc($user);
      if($user['status'] == 0){
        echo View::render($this->indexlayout, $this->createprofile);
      }else if($user['skip'] == 1){
        header("Location: /");
        exit();
      }else{
        header("Location: /");
        exit();
      }
    }
  }

  function favorites(){
    if(isset($_SESSION['social_id'])){
      echo View::render($this->homelayout, array("favorite", $this->favorite));
    }else{
      header("Location: /");
      exit();
    }
  }

  function messages($page = NULL, $id = NULL){
    if(isset($_SESSION['social_id'])){
      if ($page == NULL) {
        header("Location: /home/messages/inbox");
        exit();
      } else if ($page == 'inbox') {
        echo View::render($this->fullwidth, array("inbox", $this->inbox));
      } else if ($page == 'reader') {
        if ($id != NULL) {
          echo View::render($this->fullwidth, array("reader", $this->reader, $id));
        } else {
          header("Location: /");
          exit();
        }
      } else {
        header("Location: /");
        exit();
      }
    }else{
      header("Location: /");
      exit();
    }
  }

  function login(){
    $email = $_POST['email'];
    $pass = $_POST['password'];

    Login::login($email, $pass);
  }

  function logout(){
    Login::logout();
  }

  function changelanguage(){
    $_SESSION['language'] = $_GET['language'];
    if(isset($_SESSION['social_id'])){
      Login::setUserLang($_SESSION['social_id'], $_GET['language']);
    }
  }
}
