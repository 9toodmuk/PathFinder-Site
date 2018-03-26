<?php
use App\Controller\User\Profile;
use App\Controller\Timeline\Like;
use App\Controller\Utils\Utils;
use App\Controller\View\Language;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);

$author = Profile::profileload($row['author']);
$author = mysqli_fetch_array($author);
$date = Utils::time_elapsed_string($row['created_at']);
?>
<div class="portlet margin-bottom-10" id="<?=$row['id']?>">
  <div class="portlet-title">
    <div class="stats pull-right" id="1">
      <?php
        if(Like::getLikesStatus($_SESSION['social_id'], $row['id'], 1)) {
          $class = 'btn-liked';
        }else{
          $class = 'btn-like';
        }
      ?>
      <a onclick="like(this)" id="<?=$row['id']?>" class="btn btn-stats <?=$class?>"><i class="fa fa-heart"></i> <span><?=Like::getLikesCount($row['id'], 1)?></span></a>
    </div>
    <div class="comment-avatar"><a href="/user/<?=$author['id']?>"><img src="/uploads/profile_image/<?=$author['profile_image']?>" alt=""></a></div>
    <h5 class="comment-name"><a href="/user/<?=$author['id']?>"><?=$author['first_name']?> <?=$author['last_name']?></a> <span> · <?php
      if($date == "justnow"){
        echo $lang[$date];
      }else{
        $date = explode(" ", $date);
        echo $date[0]." ".$lang[$date[1]].$lang[$date[2]];
      }
    ?></span></h5>
  </div>
  <div class="portlet-body">
    <?=$row['message']?>
  </div>
</div>
