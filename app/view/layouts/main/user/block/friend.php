<div class="col-md-12" id="<?=$ruser['id']?>">
  <div class="col-md-12 margin-bottom-10" style="float:left; width: 100%; padding: 15px; border: 1px solid #ccc;">
    <div class="pull-left" style="margin-right: 20px;">
      <a href="/user/<?=$ruser['id']?>"><img src="/uploads/profile_image/<?=$ruser['profile_image']?>" width="80px" alt=""></a>
    </div>
    <div class="pull-left"  style="margin-top: 20px;">
      <h4 style="padding: 0; margin: 0"><a href="/user/<?=$ruser['id']?>"><?=$ruser['first_name']?> <?=$ruser['last_name']?></a></h4>
      <span><?=$ruser['email']?></span>
    </div>

    <div class="pull-right"  style="margin-top: 20px;">
      <?php
        if($friendship == 0){
          echo '<Button onclick="addfriend(this)" class="btn btn-primary btn-lg" id="'.$ruser['id'].'">'.$lang['addfriend'].'</Button>';
        }else if($friendship == 1){
          echo '<Button class="btn btn-primary btn-lg">'.$lang['requestsent'].'</Button>';
        }else if($friendship == 2){
          echo '<Button onclick="addfriend(this)" class="btn btn-primary btn-lg" id="'.$ruser['id'].'">'.$lang['acceptrequest'].'</Button>';
        }else if($friendship == 3){
          echo '<Button class="btn btn-primary btn-lg">'.$lang['friend'].'</Button>';
        }else if($friendship == 4){
          echo '';
        }
      ?>
    </div>
  </div>
</div>
