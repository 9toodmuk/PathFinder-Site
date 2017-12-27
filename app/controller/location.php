<?php
use Controller\View\View;

class Location extends Controller{
  protected $homelayout = 'app/view/layouts/home.php';
  protected $locationlayout = 'app/view/layouts/main/location/index.php';

  public function __construct(){
  }

  public static function index(){
    if(isset($_SESSION['social_id'])){
      echo View::render($this->homelayout, array("location", $this->locationlayout));
    }else{
      header("Location: /");
      exit();
    }
  }

  public static function user($id = NULL){
    if(isset($_SESSION['social_id'])){
      if(!is_null($id)){
        echo View::render($this->homelayout, array("relativelocation", $this->locationlayout, $id));
      }else{
        header("Location: /");
        exit();
      }
    }else{
      header("Location: /");
      exit();
    }
  }
}
