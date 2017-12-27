<?php
function __autoload($className){
  $filename =  "app/".str_replace('\\', '/', $className) . '.php';
  $filename = strtolower($filename);
  require_once $filename;
}
