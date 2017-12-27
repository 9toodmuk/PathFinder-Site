<?php
use Controller\User\Profile;
$user = Profile::profileLoad($_POST['id']);
$user = mysqli_fetch_array($user);

use Controller\View\Language;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);
?>
<div class="form-group col-md-12">
  <form id="editform" method="post" role="form" style="display: block;">
  <div class="row margin-bottom-10">
    <div class="col-md-6">
      <input type='text' class='form-control' name='first_name' placeholder="ชื่อ" value='<?=$user["first_name"]?>' />
    </div>
    <div class="col-md-6">
      <input type='text' class='form-control' name='last_name' placeholder="นามสกุล" value='<?=$user["last_name"]?>' />
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <button type='submit' class='btn btn-primary btn-block' id="btnEditName" data-loading-text="<?=$lang['processing']?>">Edit</button>
      <input type='hidden' name='id' value='<?=$_POST['id']?>' />
    </div>
  </div>
  </form>
</div>

<script type="text/javascript">
  $('#editform').submit(function(e){
    e.preventDefault();
    var btn = $('#btnEditName');
    var fname = $('input[name="first_name"]').val();
    var lname = $('input[name="last_name"]').val();
    var id = $('input[name="id"]').val();

    var text = '<span>'+fname+' '+lname+'</span> <a onclick="edit(this)" class="btn pull-right"><i class="fa fa-pencil-square-o"></i> Edit</a>';

    btn.button('loading');

    $.ajax({
      url: '/user/update/',
      type: 'POST',
      data: {id: id, data: fname, data2: lname, field: "first_name", field2: "last_name"},
      success: function(result){
        if(result == 'Success'){
          alert("Success");
          $("td#name").html(text);
        }
      }
    });
  });
</script>
