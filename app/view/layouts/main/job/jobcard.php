<?php
use Controller\Job\JobController;
use Controller\Utils\Address;
use Controller\View\Language;
use Controller\Employer\Detail;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);
$location = Detail::getLocation($row['location'], false, false);
$location = mysqli_fetch_array($location);
$location = $location['province'];
?>

<div class="col-md-12 margin-bottom-10" id="<?=$row['id']?>">
  <div class="card horizontal">
    <div class="card-image">
      <img src="/uploads/logo_images/<?=JobController::getEmployerLogo($row['company_id'])?>" style="object-fit: contain;">
    </div>
    <div class="card-stacked">
      <div class="card-content job-card">

        <div class="pull-right favorite fa"><a style="cursor:pointer;" onclick="addfavjob(this)" id="<?=$row['id']?>" <?php if(JobController::getSaveStatus($_SESSION['social_id'], $row['id'])) echo "class='active'"; ?>><span class="fa-lg"></span></a></div>
        <div class="pull-right">
          <a href="/job/detail/<?=$row['id']?>/" class="btn btn-primary"><?=$lang['ApplyJob']?></a>
        </div>
        <p><a href="/job/detail/<?=$row['id']?>"><strong><?=$row['name']?></strong></a></p>
        <p><i class="fa fa-building" aria-hidden="true"></i> <a href="/job/employer/<?=$row['company_id']?>"><?=JobController::getEmployerName($row['company_id']);?></a></p>
        <p><i class="fa fa-map-marker" aria-hidden="true"></i> <a href="/search/advance/?location=<?=$location?>"><?=Address::getProvinceName($location)?></a></p>
        <p><i class="fa fa-money" aria-hidden="true"></i> <?=$row['salary']?> <i class="fa fa-money" aria-hidden="true"></i> <?=$row['type']?></p>

      </div>
    </div>
  </div>
</div>
