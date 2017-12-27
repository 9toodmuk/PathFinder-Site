<?php
use Controller\View\Language;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <?php include_once 'app/view/layouts/admin/main/head.php'; ?>
  <title><?=$lang['appname']?> :: <?=$lang['login']?></title>

</head>

<body>

  <div class="container">
    <div class="row">

      <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><?=$lang['login']?></h3>
          </div>
          <div class="panel-body">
            <?php
              if($variables == 1){
            ?>
            <div class="alert alert-danger">
              <?=$lang['ErrorWrongEmailorPassword']?>
            </div>
          <?php }else if($variables == 2){ ?>
          <div class="alert alert-danger">
            <?=$lang['ErrorNoPermission']?>
          </div>
          <?php } ?>
            <form role="form" action="/admin/signin/" method=POST>
              <fieldset>
                <div class="form-group">
                  <input class="form-control" placeholder="<?=$lang['email']?>" name="email" type="email" value="" autofocus>
                </div>
                <div class="form-group">
                  <input class="form-control" placeholder="<?=$lang['password']?>" name="password" type="password" value="">
                </div>
                <button class="btn btn-lg btn-success btn-block"><?=$lang['login']?></button>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


    <script src="/themes/js/raphael.min.js"></script>
    <script src="/themes/js/sb-admin-2.js"></script>

</body>

</html>
