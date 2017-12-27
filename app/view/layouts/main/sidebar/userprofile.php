    <?php
      $currentuser = Controller\User\Profile::profileLoad($_SESSION['social_id']);
      $currentuser = mysqli_fetch_array($currentuser); ?>
    <div class="profile-sidebar margin-bottom-30">
    <div class="profile-userpic">
      <img src="/uploads/profile_image/<?=$currentuser['profile_image']?>" class="img-responsive" alt="">
    </div>
    <div class="profile-usertitle">
      <div class="profile-usertitle-name">
        <?=$currentuser['first_name']?> <?=$currentuser['last_name']?>
      </div>
    </div>
    <div class="profile-usermenu">
      <ul class="nav">
        <li>
          <a href="/"><i class="fa fa-home"></i> <?=$lang['Home']?> </a>
        </li>
        <li>
          <a href="/timeline/"><i class="fa fa-rss"></i> <?=$lang['Timeline']?> </a>
        </li>
        <li>
          <a href="/user/<?=$currentuser['id']?>">
          <i class="fa fa-user"></i>
          <?=$lang['Profile']?> </a>
        </li>
        <!-- <li>
          <a>
          <i class="fa fa-envelope"></i>
          Messages </a>
        </li> -->
        <li>
          <a href="/home/favorites/">
          <i class="fa fa-star"></i>
          <?=$lang['FavJob']?> </a>
        </li>
      </ul>
    </div>
  </div>
