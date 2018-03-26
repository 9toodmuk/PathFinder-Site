<?php
use App\Controller\Job\JobController;
$recommendjob = JobController::getRecommendedJob($_SESSION['social_id'], 3);
?>
<div class="portlet margin-bottom-30">
  <div class="portlet-title">
    <div class="caption caption-green">
      <i class="fa fa-tag" aria-hidden="true"></i>
      <span class="caption-subject text-uppercase"> <?=$lang['RecommendedJob']?></span>
    </div>
    <div class="actions">
      <a href="/job/categories/" class="btn">
        <?=$lang['More']?>
      </a>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
        <?php 
        while($row = mysqli_fetch_assoc($recommendjob)){
          include 'app/view/layouts/main/job/jobcard.php'; 
        }
        ?>
    </div>
  </div>
</div>
