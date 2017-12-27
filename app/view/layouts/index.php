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
  <?php include_once 'app/view/layouts/index/head.php'; ?>

  <body>
    <div class="top-content">
      <div class="inner-bg">
        <div class="container">
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
              <img src="/themes/images/logos/BannerWhite.png" width="350px" />
            </div>
          </div>
          <?php include_once $variables; ?>
        </div>
      </div>
      <?php include_once 'app/view/layouts/index/footer.php'; ?>
    </div>

    <script src="/themes/js/jquery.backstretch.min.js"></script>
    <script src="/themes/js/scripts.js"></script>
  </body>
</html>
