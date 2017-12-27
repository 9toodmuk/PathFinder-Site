<?php
use Controller\View\Language;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);
$pagename = $variables[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once 'app/view/layouts/admin/main/head.php'; ?>
    <title><?=$lang[$pagename]?></title>
</head>

<body>

  <div id="wrapper">
    <?php include_once 'app/view/layouts/admin/main/navbar.php' ?>
    <?php include_once 'app/view/layouts/admin/main/left-sidebar.php' ?>
    </nav>

    <div id="page-wrapper">
      <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header"><?=$lang[$pagename]?></h1>
          </div>
      </div>
      <?php include_once $variables[1]; ?>
    </div>
  </div>


  <script src="/themes/js/raphael.min.js"></script>
  <script src="/themes/js/sb-admin-2.js"></script>
</body>
