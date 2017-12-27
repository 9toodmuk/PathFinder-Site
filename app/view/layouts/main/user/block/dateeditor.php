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
  <form id="editformbd" method="post" role="form" style="display: block;">
  <div class="row margin-bottom-10">
    <div class="col-md-12">
      <input type='text' class="form-control" value='<?=$user['birthdate']?>' id='datetimepicker' data-date-format="yyyy-mm-dd" data-link-field="birthday" data-link-format="yyyy-mm-dd"/>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <button type='submit' class='btn btn-primary btn-block' id="btnEditBD" data-loading-text="<?=$lang['processing']?>"><?=$lang['editlocationbtn']?></button>
      <input type='hidden' name='id' value='<?=$_POST['id']?>' />
      <input type="hidden" name="birthday" id="birthday" value="<?=$user['birthdate']?>"/>
    </div>
  </div>
  </form>
</div>

<script type="text/javascript">
  $(function () {
    $('#datetimepicker').datetimepicker({
      viewMode: 'years',
      format: 'yyyy-mm-dd',
      weekStart: 0,
      autoclose: 1,
      startView: 4,
      minView: 2,
      forceParse: 1,
      locale: 'th'
    });
    moment().format();
  });

  $('#editformbd').submit(function(e){
    e.preventDefault();
    var btn = $('#btnEditBD');
    var bd = $('input#birthday').val();
    var id = $('input[name="id"]').val();

    var text = '<span>'+bd+'</span> <a onclick="edit(this)" class="btn pull-right"><i class="fa fa-pencil-square-o"></i> Edit</a>';

    btn.button('loading');

    $.ajax({
      url: '/user/update/',
      type: 'POST',
      data: {id: id, data: bd, field: "birthdate"},
      success: function(result){
        if(result == 'Success'){
          alert("Success");
          $("td#birthdate").html(text);
        }
      }
    });
  });
</script>
