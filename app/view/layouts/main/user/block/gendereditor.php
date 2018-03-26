<?php
use App\Controller\User\Profile;
$user = Profile::profileLoad($_POST['id']);
$user = mysqli_fetch_array($user);

use App\Controller\View\Language;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);
?>
<div class="form-group col-md-12">
  <form id="nameform" method="post" role="form" style="display: block;">
  <div class="row margin-bottom-10">
    <div class="col-md-12">
      <select name="gender" class='form-control'>
        <option value="0" <?php if($user['sex'] == 0) echo "selected" ?>><?=$lang['male']?></option>
        <option value="1" <?php if($user['sex'] == 1) echo "selected" ?>><?=$lang['female']?></option>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <button type='submit' class='btn btn-primary btn-block' id="btnEditGender" data-loading-text="<?=$lang['processing']?>"><?=$lang['EditBtn']?></button>
      <input type='hidden' name='id' value='<?=$_POST['id']?>' />
    </div>
  </div>
  </form>
</div>

<script type="text/javascript">
  $('#nameform').submit(function(e){
    e.preventDefault();
    var btn = $('#btnEditGender');
    var sex = $('select[name="gender"]').val();
    var id = $('input[name="id"]').val();
    if(sex == 0){
      var sextext = '<?=$lang['male']?>';
    }else if(sex == 1){
      var sextext = '<?=$lang['female']?>';
    }

    var text = '<span>'+sextext+'</span> <a onclick="edit(this)" class="btn pull-right"><i class="fa fa-pencil-square-o"></i> Edit</a>';

    btn.button('loading');

    $.ajax({
      url: '/user/update/',
      type: 'POST',
      data: {id: id, data: sex, field: "sex"},
      success: function(result){
        if(result == 'Success'){
          swal({
            type: 'success',
            title: '<?=$lang['Success']?>',
            timer: 1500
          });
          $("td#gender").html(text);
        }
      }
    });
  });
</script>
