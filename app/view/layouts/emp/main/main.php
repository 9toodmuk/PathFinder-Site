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
    <?php include_once 'app/view/layouts/main/head.php'; ?>
    <link href="/themes/stylesheets/empdash.css" rel="stylesheet" type="text/css" />
    <link href="/themes/stylesheets/metisMenu.css" rel="stylesheet" type="text/css" />
    <link href="/themes/stylesheets/morris.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/themes/js/metisMenu.min.js"></script>
    <link rel="stylesheet" href="/themes/stylesheets/bootstrap-multiselect.css" type="text/css" />
    <script type="text/javascript" src="/themes/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/fc-3.2.3/r-2.2.0/sc-1.4.3/sl-1.2.3/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.16/fc-3.2.3/r-2.2.0/sc-1.4.3/sl-1.2.3/datatables.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote-bs4.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote-bs4.min.js"></script>

    <title><?=$lang['appname']?> :: <?=$lang[$pagename]?></title>
  </head>

  <body>
    <div id="wrapper">
      <?php include_once 'app/view/layouts/emp/main/block/navbar.php'; ?>
      <?php include_once 'app/view/layouts/emp/main/block/leftsidebar.php'; ?>

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
      <script src="/themes/js/empadmin.js"></script>
  </body>
</html>
