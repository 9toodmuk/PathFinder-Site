<?php
use Controller\User\Profile;
$user = Profile::profileLoad($_POST['id']);
$user = mysqli_fetch_array($user);

$field = $_POST['field'];

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
  <form id="editform<?=$field?>" method="post" role="form" style="display: block;">
  <div class="row margin-bottom-10">
    <div class="col-md-12">
      <input
      <?php
        if($field == "telephone" || $field == "postcode" || $field == "expected_salary"){
          echo 'type = "number"';
        }else{
          echo 'type = "text"';
        }
      ?>
      id="field<?=$field?>" class='form-control' name='<?=$field?>' placeholder=""
      <?php
        if($field == "telephone"){
          echo 'maxlength = "10"';
        }else if($field == "postcode"){
          echo 'maxlength = "5"';
        }
      ?>
      value='<?=$user[$field]?>'
      />
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <button type='submit' class='btn btn-primary btn-block' id="btnEdit<?=$field?>" data-loading-text="<?=$lang['processing']?>"><?=$lang['EditBtn']?></button>
      <input type='hidden' name='id' value='<?=$_POST['id']?>' />
    </div>
  </div>
  </form>
</div>

<script type="text/javascript">
  $('#editform<?=$field?>').submit(function(e){
    e.preventDefault();
    var btn = $('#btnEdit<?=$field?>');
    var data = $('input#field<?=$field?>').val();
    var field = $('input#field<?=$field?>').attr('name');
    var id = $('input[name="id"]').val();

    var text = '<span>'+data+'</span> <a onclick="edit(this)" class="btn pull-right"><i class="fa fa-pencil-square-o"></i> Edit</a>';

    btn.button('loading');

    $.ajax({
      url: '/user/update/',
      type: 'POST',
      data: {id: id, data: data, field: field},
      success: function(result){
        if(result == 'Success'){
          alert("Success");
          $("td#"+field).html(text);
        }
      }
    });
  });
</script>
