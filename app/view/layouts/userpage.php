<?php
use Controller\Config\Database;
use Controller\Auth\Login;
use Controller\Job\JobController;
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
<html>

<head>
  <?php include_once 'app/view/layouts/main/head.php'; ?>
  <title><?=$lang['appname']?></title>
</head>


<body>
  <?php include_once 'app/view/layouts/main/navbar.php'; ?>

  <div class="container" style="margin-top: 90px">
    <?php if(Login::checkStatus($_SESSION['social_id']) == 0) { ?>
    <div class="alert-message alert-message-notice" id="errorbox">
      <a href="/user/edit/" class="btn btn-xs btn-warning pull-right"><?=$lang['CreateProfile']?></a>
      <?=$lang['NoProfileAlert']?>
    </div>
    <?php } ?>
    <div class="row">
      <?php include 'app/view/layouts/main/user/block/header.php'; ?>
      <div class="col-md-8">
        <?php
            include_once $variables[1];
        ?>
      </div>

      <div class="col-md-4" id="sidebar">
        <?php include_once 'app/view/layouts/main/sidebar.php'; ?>
        <?php include_once 'app/view/layouts/main/footer.php'; ?>
      </div>
    </div>
  </div>

  <input type="hidden" value="<?=$_SESSION['social_id']?>" id="uid"/>
  <input type="hidden" value="<?=$variables[2]?>" id="pid"/>

  <?php include 'app/view/layouts/utils/editprofilepic-modal.php'; ?>

  <script type="text/javascript">
    $(function(){
      var id = <?=$_SESSION['social_id']?>;
      updateNotification(id);
      setInterval(function(){
        updateNotification(id);
      }, 5000);
    });
  </script>

  <script type="text/javascript">
    function addfriend(element){
      var uid = "<?=$_SESSION['social_id']?>";
      var fid = $(element).attr('id');

      $.ajax({
        url: '/user/add/',
        type: 'POST',
        data: {uid: uid, fid: fid},
        dataType: "json",
        success: function(result){
          if(result.status){
            if(result.friendship == 1){
              $(element).text("Request Sent");
              $(element).prop("onclick", null).off('click');
            }else if(result.friendship == 3){
              $(element).text("Friend");
              $(element).prop("onclick", null).off('click');
            }
          }
        }
      });
    }
  </script>

<script type="text/javascript">

var formData = new FormData();
  var image = document.getElementById('demo');

var cropper = new Cropper(image, {
  minContainerWidth: 350,
  minContainerHeight: 350,
  aspectRatio: 1/1,
  viewMode: 1
});

function readURL(input){
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      setPicture(e.target.result);
    }
  }

  reader.readAsDataURL(input.files[0]);
}

function setPicture(picture){
    cropper.replace(picture);
  }

function removeProfilePic(){
  var id = <?=$_SESSION['social_id']?>;
  $.ajax({
    url: '/user/removepropic/',
    type: 'POST',
    data: {id: id},
    dataType: "json",
    success: function(result){
      if(result.status){
        $("#headerprofilepic").attr('src', result.url);
        alert("Success");
      }
    }
  });
}

function uploadProfilePic(){
  var picture = $("input#profilepic");

  $(picture).click();

  picture.change(function(){
    readURL(this);
    console.log(profilepic.files.length);
    $('#editprofilepic').modal('show');
  });
}

function upload(){
  var formData = new FormData();
  var uploader = <?=$_SESSION['social_id']?>;

  $('#btnSubmit').button('loading');

  var newimage = cropper.getCroppedCanvas().toDataURL('image/jpeg');

  cropper.getCroppedCanvas().toBlob(function (blob) {
    var fileext = blob.type;
    var filetype = fileext.replace("image/","");
    var filename = "profilePic."+filetype;
    console.log(blob);
    formData.append("file", blob, filename);
    formData.append("uploader", uploader);

    $.ajax({
      url: '/user/uploadpic/',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function(result){
        if(result.status){
          alert("Success")
          location.reload();
        }
      }
    });
  });  
}
</script>

</body>

</html>
