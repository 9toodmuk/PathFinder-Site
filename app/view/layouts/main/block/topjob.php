<?php
use App\Controller\Job\JobController;
?>
<div class="portlet margin-bottom-30">
  <div class="portlet-title">
    <div class="caption caption-green">
      <i class="fa fa-tasks" aria-hidden="true"></i>
      <span class="caption-subject text-uppercase"> <?=$lang['FeaturedJobs']?></span>
    </div>
    <div class="actions">
      <a href="/job/" class="btn">
        <?=$lang['More']?>
      </a>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">

      <?php
        $currentjob = JobController::loadTopJob();
        while ($row = $currentjob->fetch_array()){
          include 'app/view/layouts/main/job/jobcard.php';
        }
      ?>

    </div>
  </div>
</div>
