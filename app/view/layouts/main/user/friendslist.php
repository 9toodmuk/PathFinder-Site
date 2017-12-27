<?php
  use Controller\View\Language;
  use Controller\User\Profile;

  if(!isset($_SESSION['language'])){
    $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
    $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  }else{
    $language = $_SESSION['language'];
  }
  $lang = Language::loadLanguage($language);

  $friend = Profile::getFriends($variables[2], false);
?>

<div class="row" id="friendslist">
  <div class="portlet margin-bottom-30">
    <div class="portlet-title">
      <div class="caption caption-green">
        <i class="fa fa-user" aria-hidden="true"></i>
        <span class="caption-subject text-uppercase"> <?=$lang['FriendList']?></span>
      </div>
    </div>
    <div class="portlet-body" id="friend">
      <div class="row" id="relativeblock">
        <?php
          while ($result = $friend->fetch_array()) {
            $ruser = Profile::profileLoad($result['ID']);
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
