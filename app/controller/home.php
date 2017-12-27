<?php

use Controller\View\View;
use Controller\Auth\Login;
use Controller\Auth\Register;

class Home extends Controller{
  protected $indexlayout = 'app/view/layouts/index.php';
  protected $homelayout = 'app/view/layouts/home.php';
  protected $timeline = 'app/view/layouts/main/timeline/index.php';
  protected $formlogin = 'app/view/layouts/index/forms/formlogin.php';
  protected $registerlogin = 'app/view/layouts/index/forms/formregister.php';
  protected $favorite = 'app/view/layouts/main/user/favorite.php';

  public function __construct(){

  }

  public static function index(){
    if(isset($_SESSION['social_id'])){
      echo View::render($this->homelayout, "home");
    }else{
      echo View::render($this->indexlayout, $this->formlogin);
    }
  }

  public static function registration(){
    if(isset($_SESSION['social_id'])){
      header("Location: /");
      exit();
    }else{
      echo View::render($this->indexlayout, $this->registerlogin);
    }
  }

  public static function favorites(){
    if(isset($_SESSION['social_id'])){
      echo View::render($this->homelayout, array("favorite", $this->favorite));
    }else{
      header("Location: /");
      exit();
    }
  }

  public static function login(){
    $email = $_POST['email'];
    $pass = $_POST['password'];

    Login::login($email, $pass);
  }

  public static function logout(){
    Login::logout();
  }

  public static function changelanguage(){
    $_SESSION['language'] = $_GET['language'];
    if(isset($_SESSION['social_id'])){
      Login::setUserLang($_SESSION['social_id'], $_GET['language']);
    }
  }
}
