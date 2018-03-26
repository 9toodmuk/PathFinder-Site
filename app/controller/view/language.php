<?php
namespace App\Controller\View;

class Language{
  public static function loadLanguage($language = "th"){
    if(file_exists("app/view/languages/".$language.".php")){
      include "app/view/languages/".$language.".php";
      return $lang;
    }else{
      include "app/view/languages/en.php";
      return $lang;
    }
  }
}
?>
