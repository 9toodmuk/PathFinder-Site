<?php
use Controller\Config\Database;
use Controller\Auth\Login;
use Controller\Job\JobController;
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
<html>

<head>
  <?php include_once 'app/view/layouts/main/head.php'; ?>
  <title><?=$lang['appname']?></title>
</head>

<body>
  <?php include_once 'app/view/layouts/main/navbar.php'; ?>

  <div class="container" style="margin-top: 90px">
    <?php if(Login::checkStatus($_SESSION['social_id']) == 0) { ?>
    <div class="alert-message alert-message-notice" id="errorbox">
      <a href="/user/edit/" class="btn btn-xs btn-warning pull-right"><?=$lang['CreateProfile']?></a>
      <?=$lang['NoProfileAlert']?>
    </div>
    <?php } ?>
    <div class="row">
      <div class="col-md-8">
        <?php
          if($variables == "home"){
            include_once 'app/view/layouts/main/block/topjob.php';
            include_once 'app/view/layouts/main/block/topemp.php';
          }else{
            include_once $variables[1];
          }
        ?>
      </div>

      <div class="col-md-4" id="sidebar">
        <?php include_once 'app/view/layouts/main/sidebar.php'; ?>
        <?php include_once 'app/view/layouts/main/footer.php'; ?>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(function(){
      var id = <?=$_SESSION['social_id']?>;
      updateNotification(id);
      setInterval(function(){
        updateNotification(id);
      }, 5000);
    });
  </script>

</body>

</html>
