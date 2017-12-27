<?php
use Controller\User\Profile;
use Controller\Timeline\Like;
use Controller\Timeline\Comment;
use Controller\Utils\Utils;
use Controller\View\Language;
$author = Profile::profileload($row['author']);
$author = mysqli_fetch_array($author);
$reader = NULL;
if($row['posted_to'] != 0){
  $reader = Profile::profileload($row['posted_to']);
  $reader = mysqli_fetch_array($reader);
}

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);

$date = Utils::time_elapsed_string($row['created_at']);
?>

<div class="panel panel-default" id="<?=$row['id']?>">
<div class="post">
  <div class="panel-heading">
    <span class="pull-left"><a href="/user/<?=$author['id']?>"><img id="user-account-image" class="img-rounded" src="/uploads/profile_image/<?=$author['profile_image']?>" height="50" width="50" style="width: 50px; height: 50px;"></a></span>
    <div class="post-header">
      <div class="post-title">
        <a href="/user/<?=$author['id']?>"><?=$author['first_name']?> <?=$author['last_name']?></a>
        <?php if($reader != NULL) { ?>
        <span>▶</span>  <a href="/user/<?=$reader['id']?>"><?=$reader['first_name']?> <?=$reader['last_name']?></a>
        <?php } ?>
      </div>
      <div class="post-subtitle">
        <?php
          if($date == "justnow"){
            echo $lang[$date];
          }else{
            $date = explode(" ", $date);
            echo $date[0]." ".$lang[$date[1]].$lang[$date[2]];
          }
        ?>
      </div>
    </div>
  </div>
  <hr>
  <div class="panel-body">
    <p><?=$row['message']?></p>
    <div class="stats" id="0">
      <?php
        if(Like::getLikesStatus($_SESSION['social_id'], $row['id'], 0)) {
          $class = 'btn-liked';
        }else{
          $class = 'btn-like';
        }
      ?>
      <a class="btn btn-stats <?=$class?> btn-lg" onclick="like(this)" id="<?=$row['id']?>"><i class="fa fa-heart"></i> <span><?=Like::getLikesCount($row['id'], 0)?></span></a>
      <a class="btn btn-stats btn-reply btn-lg" onclick="reply(this)" id="<?=$row['id']?>"><i class="fa fa-reply"></i> <span><?=Comment::getCommentsCount($row['id'], 0)?></span></a>
    </div>
  </div>
  <div class="panel-footer" id="panel<?=$row['id']?>" style="display: none;">
    <div class="comments-form form-group">
      <form id="comment-form-<?=$row['id']?>" method="POST" style="display: block;">
        <div class="input-group">
          <input class="form-control input-lg" name="comment" id="comment" placeholder="<?=$lang['CommentYourThought']?>">
          <span class="input-group-btn">
            <button class="btn btn-default btn-lg" type="submit">
              <i class="fa fa-reply"></i>
            </button>
          </span>
        </div>
      </form>
    </div>
    <div class="post-footer" id="comment<?=$row['id']?>">

    </div>
  </div>
</div>
</div>
<script type="text/javascript">
  $("#comment-form-<?=$row['id']?>").submit(function(e){
    e.preventDefault();
    comment($(this));
  })
</script>
<?php unset($reader); ?>
