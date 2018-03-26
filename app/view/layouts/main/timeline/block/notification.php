<?php
use App\Controller\Utils\Utils;
use App\Controller\User\Profile;
use App\Controller\Timeline\Notification;
use App\Controller\View\Language;

$date = Utils::time_elapsed_string($row['created_at']);
$date = explode(" ", $date);
$notiUser = Profile::profileLoad($row['sender_id']);
$notiUser = mysqli_fetch_array($notiUser);

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);
?>
<li id='<?=$row['id']?>' onmouseout="markread(this)">
  <a href="<?=$row['reference_link']?>">
    <div class="notification">
      <div class="notification-img"><img src="/uploads/profile_image/<?=$notiUser['profile_image']?>" width="48px" alt=""></div>
      <div class="notification-text">
        <div class="notification-title"><strong><?=$notiUser['first_name']?> <?=$notiUser['last_name']?></strong> <?=$lang[Notification::getType($row['type'])]?></div>
        <div class="notification-subtitle"><?=$date[0]?> <?=$lang[$date[1]]?><?=$lang[$date[2]]?></div>
      </div>
    </div>
  </a>
</li>
