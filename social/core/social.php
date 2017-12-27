<?php
namespace Core;

class Core{
  public static function run() {
       self::init();
       self::autoload();
       self::dispatch();
   }

  private static function init() {
    define("DS", DIRECTORY_SEPARATOR);
    define("ROOT", getcwd() . DS);
    define("APP_PATH", ROOT . 'app' . DS);
    define("FRAMEWORK_PATH", ROOT . 'social' . DS);
    define("CONFIG_PATH", APP_PATH . "config" . DS);
    define("CONTROLLER_PATH", APP_PATH . "controller" . DS);
    define("MODEL_PATH", APP_PATH . "model" . DS);
    define("VIEW_PATH", APP_PATH . "view" . DS);
    define("CORE_PATH", FRAMEWORK_PATH . "core" . DS);
    define('DB_PATH', FRAMEWORK_PATH . "database" . DS);
    define("LIB_PATH", FRAMEWORK_PATH . "libraries" . DS);
    define("UPLOAD_PATH", ROOT . "uploads" . DS);
    define("PLATFORM", isset($_REQUEST['p']) ? $_REQUEST['p'] : 'home');
    define("CONTROLLER", isset($_REQUEST['c']) ? $_REQUEST['c'] : 'Index');
    define("ACTION", isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index');
    define("CURR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM . DS);
    define("CURR_VIEW_PATH", VIEW_PATH . PLATFORM . DS);
    require CORE_PATH . "Controller.php";
    require CORE_PATH . "Loader.php";
    require DB_PATH . "Mysql.php";
    require CORE_PATH . "Model.php";
    $GLOBALS['config'] = include CONFIG_PATH . "config.php";
    session_start();
  }

  private static function autoload() {
    spl_autoload_register(array(__CLASS__,'load'));
  }

  private static function load($classname){
    if (substr($classname, -10) == "Controller"){
      require_once CURR_CONTROLLER_PATH . "$classname.php";
    } elseif (substr($classname, -5) == "Model"){
      require_once  MODEL_PATH . "$classname.php";
    }
  }

  private static function dispatch() {
    $controller_name = CONTROLLER . "Controller";
    $action_name = ACTION . "Action";
    $controller = new $controller_name;
    $controller->$action_name();
  }
}
