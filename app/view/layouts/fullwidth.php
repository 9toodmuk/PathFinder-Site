<?php
use App\Controller\Config\Database;
use App\Controller\Auth\Login;
use App\Controller\Job\JobController;
use App\Controller\View\Language;

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
  <div class="wrapper no-alert-top">
    <?php include_once 'app/view/layouts/main/navbar.php'; ?>

    <?php
      include_once $variables[1];
    ?>

    <?php include_once 'app/view/layouts/main/footer.php'; ?>
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
