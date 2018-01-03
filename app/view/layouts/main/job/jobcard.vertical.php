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

<div class="col-md-4 margin-bottom-10" id="<?=$row['id']?>">
  <div class="card vertical">
    <div class="card-image">
      <img src="/uploads/logo_images/<?=JobController::getEmployerLogo($row['company_id'])?>" style="object-fit: contain;">
    </div>
    <div class="card-stacked">
      <div class="card-content job-card">
        <p><a href="/job/detail/<?=$row['id']?>"><strong style="text-overflow: ellipsis;"><?=$row['name']?></strong></a></p>
        <p><i class="fa fa-building" aria-hidden="true"></i> <a href="/job/employer/<?=$row['company_id']?>"><?=JobController::getEmployerName($row['company_id']);?></a></p>
        <p><i class="fa fa-map-marker" aria-hidden="true"></i> <a href="/search/advance/?location=<?=$location?>"><?=Address::getProvinceName($location)?></a></p>
      </div>
    </div>
  </div>
</div>
