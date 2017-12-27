<?php
use Controller\Job\JobController;
use Controller\View\Language;
use Controller\Employer\Detail;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);
$location = Detail::getLocation($row['id'], true, true);
$location = mysqli_fetch_array($location);

$category = JobController::getEmpCatName($row['category_id']);
?>

<div class="col-md-12 margin-bottom-10" id="<?=$row['id']?>">
  <div class="card horizontal">
    <div class="card-image">
      <img src="/uploads/logo_images/<?=JobController::getEmployerLogo($row['id'])?>" style="object-fit: contain;">
    </div>
    <div class="card-stacked">
      <div class="card-content job-card" style="margin-top:20px">

        <p><a href="/job/employer/<?=$row['id']?>"><strong><?=$row['name'];?></strong></a></p>
        <p><i class="fa fa-tag" aria-hidden="true"></i> <?=$category?></p>
        <p><i class="fa fa-phone" aria-hidden="true"></i> <?=$row['telephone']?></p>

      </div>
    </div>
  </div>
</div>
