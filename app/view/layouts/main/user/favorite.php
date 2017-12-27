<?php
use Controller\User\Profile;
use Controller\Job\JobController;

$result = Profile::getFavJobs($_SESSION['social_id']);
?>

<div class="portlet margin-bottom-30">
  <div class="portlet-title">
    <div class="caption caption-green">
      <i class="fa fa-tasks" aria-hidden="true"></i>
      <span class="caption-subject text-uppercase"> <?=$lang['AllJobTitle']?></span>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row" id="empcentre<?=$variables['2']?>">
      <?php
        while($row1 = $result->fetch_assoc()){
          $row = JobController::loadJobPosting($row1['job_id']);
          include 'app/view/layouts/main/job/jobcard.php';
        }
      ?>
    </div>
  </div>
</div>

<script src="/themes/js/empcentre.js"></script>
