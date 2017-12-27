<?php
use Controller\Config\Database;
use Controller\Auth\Login;
use Controller\User\Profile;
use Controller\Search\SearchController;
use Controller\Job\JobController;
use Controller\Job\Employer;
use Controller\View\Language;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);

$result = SearchController::advancesearch($variables[1]['keyword'], $variables[1]['category'], $variables[1]['location'], $variables[1]['type']);
$count = mysqli_num_rows($result);

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
    <?php if($count > 0){ ?>

        <div class="row" id="jobs">
          <div class="portlet margin-bottom-30">
            <div class="portlet-title">
              <div class="caption caption-green">
                <i class="fa fa-tasks" aria-hidden="true"></i>
                <span class="caption-subject text-uppercase"> Jobs</span>
              </div>
            </div>
            <div class="portlet-body">
              <div class="row">
                <?php
                  while($jobs = mysqli_fetch_array($result)){
                    $row = JobController::loadJobPosting($jobs['id']);
                    include 'app/view/layouts/main/job/jobcard.php';
                  }
                ?>
              </div>
            </div>
          </div>
        </div>

    <?php }else{ ?>

      <div class="alert alert-info">
        ไม่พบข้อมูล
      </div>

    <?php } ?>

      </div>

      <div class="col-md-4" id="sidebar">
        <?php include_once 'app/view/layouts/main/sidebar/searchbox.php'; ?>
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
