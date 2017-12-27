<?php
class Loader{
  public static function library($lib){
    include LIB_PATH . "$lib.class.php";
  }
}
