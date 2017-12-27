<?php
use Controller\View\Language;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once 'app/view/layouts/emp/head.php'; ?>
    <link href="/themes/stylesheets/creative.css" rel="stylesheet">
    <title><?=$lang['appname']?> :: Employer</title>
  </head>


  <body id="page-top">

    <div class="top-content">
      <div class="inner-bg">
        <div class="container">
          <?php include_once $variables; ?>
        </div>
      </div>
      <?php include_once 'app/view/layouts/emp/footer.php'; ?>
    </div>

    <script src="/themes/js/jquery.backstretch.min.js"></script>
    <script src="/themes/js/empscripts.js"></script>

  </body>
</html>
