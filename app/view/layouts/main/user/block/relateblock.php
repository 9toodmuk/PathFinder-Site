<?php
use App\Controller\View\Language;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);
?>

<div class="col-md-12" id="<?=$ruser['id']?>">
  <div class="col-md-12 margin-bottom-10" style="float:left; width: 100%; padding: 15px; border: 1px solid #ccc;">
    <div class="pull-left" style="margin-right: 20px;">
      <a href="/user/<?=$ruser['id']?>"><img src="/uploads/profile_image/<?=$ruser['profile_image']?>" width="80px" alt=""></a>
    </div>
    <div class="pull-left" style="margin-top: 20px;">
      <h4 style="padding: 0; margin: 0"><a href="/user/<?=$ruser['id']?>"><?=$ruser['first_name']?> <?=$ruser['last_name']?></a></h4>
      <span><?=$lang['relate_'.$type]?> <?php if(isset($onpending) && $onpending == 1) echo "(Pending)" ?> <?php if(isset($onrequest) && $onrequest == 1) echo "(Requesting)" ?></span>
    </div>
    <div class="pull-right" style="margin-top: 25px;">
      <?php if(isset($onrequest) && $onrequest == 1){ ?>
        <a onclick="acceptrelative(this)" <?php if(isset($onrequest) && $onrequest == 1) echo "id=".$type ?> class="btn btn-edit"><i class="fa fa-check"></i> Accept</a> <a onclick="edit(this)" class="btn btn-remove"><i class="fa fa-times"></i> Decline</a>
      <?php }else if(isset($onpending) && $onpending == 1){?>
        <a onclick="removerelative(this)" class="btn btn-remove"><i class="fa fa-trash"></i> Remove</a>
      <?php }else{?>
        <a onclick="editrelate(this)" class="btn btn-edit"><i class="fa fa-pencil-square-o"></i> Edit</a> <a onclick="removerelative(this)" class="btn btn-remove"><i class="fa fa-trash"></i> Remove</a>
      <?php } ?>
    </div>
  </div>
</div>
