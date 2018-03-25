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
$result = SearchController::search($variables[1]);

$count = mysqli_num_rows($result);

if($count > 0){
  $company = array();
  $jobs = array();
  $users = array();

  while($row = mysqli_fetch_assoc($result)){
    $type = $row['type'];
    if($type == 'company'){
      array_push($company, $row['id']);
    }else if($type == 'job'){
      array_push($jobs, $row['id']);
    }else if($type == 'user'){
      array_push($users, $row['id']);
    }
  }
}
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
        <?php if(sizeof($jobs) > 0){ ?>
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
                    foreach($jobs as $value){
                      $row = JobController::loadJobPosting($value);
                      include 'app/view/layouts/main/job/jobcard.php';
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>

        <?php if(sizeof($users) > 0){ ?>
          <div class="row" id="users">
            <div class="portlet margin-bottom-30">
              <div class="portlet-title">
                <div class="caption caption-green">
                  <i class="fa fa-user" aria-hidden="true"></i>
                  <span class="caption-subject text-uppercase"> Users</span>
                </div>
              </div>
              <div class="portlet-body">
                <div class="row">
                  <?php
                    foreach($users as $value){
                      $ruser = Profile::profileLoad($value);
                      $ruser = mysqli_fetch_array($ruser);
                      $friendship = Profile::getFriendship($_SESSION['social_id'], $ruser['id']);
                      if($_SESSION['social_id'] === $ruser['id']){
                        $friendship = 4;
                      }
                      include 'app/view/layouts/main/user/block/friend.php';
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>

        <?php if(sizeof($company) > 0){ ?>
          <div class="row" id="employer">
            <div class="portlet margin-bottom-30">
              <div class="portlet-title">
                <div class="caption caption-green">
                  <i class="fa fa-building" aria-hidden="true"></i>
                  <span class="caption-subject text-uppercase"> Employers</span>
                </div>
              </div>
              <div class="portlet-body">
                <div class="row">
                  <?php
                    foreach($company as $value){
                      $row = Employer::loadEMP($value);
                      $row = mysqli_fetch_assoc($row);
                      include 'app/view/layouts/main/search/block/companyblock.php';
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      <?php }else{ ?>

        <div class="alert alert-info">
          ไม่พบข้อมูล
        </div>

      <?php } ?>

        </div>

        <div class="col-md-4" id="sidebar">
          <?php include_once 'app/view/layouts/main/sidebar/searchbox.php'; ?>
        </div>
      </div>
    </div>

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
