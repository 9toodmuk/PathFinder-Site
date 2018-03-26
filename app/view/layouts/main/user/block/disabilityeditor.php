<?php
use Controller\User\Profile;
use Controller\Job\JobController;
use Controller\View\Language;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);


$user = Profile::profileLoad($_POST['id']);
$user = mysqli_fetch_array($user);
?>
<div class="form-group col-md-12">
  <form id="disabilityform" method="post" role="form" style="display: block;">
  <div class="row margin-bottom-10">
    <div class="col-md-12">
      <select name="disability" class='form-control'>
        <?php 
          $disability = JobController::getAllDisabilityType();
          while($row = mysqli_fetch_assoc($disability)){
            echo "<option value='".$row['id']."'";
            if($user['disability'] == $row['id']){
              echo " selected";
            }
            if($language == 'th'){
              echo ">".$row['name']."</option>";
            }else{
              echo ">".$row['name_eng']."</option>";
            }
          }
        ?>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <button type='submit' class='btn btn-primary btn-block' id="btnEditDisability" data-loading-text="<?=$lang['processing']?>"><?=$lang['EditBtn']?></button>
      <input type='hidden' name='id' value='<?=$_POST['id']?>' />
    </div>
  </div>
  </form>
</div>

<script type="text/javascript">
  $('#disabilityform').submit(function(e){
    e.preventDefault();
    var btn = $('#btnEditDisability');
    var disability = $('select[name="disability"]').val();
    var id = $('input[name="id"]').val();
    var finaltext = $('select[name="disability"] option:selected').text();

    var text = '<span>'+finaltext+'</span> <a onclick="edit(this)" class="btn pull-right"><i class="fa fa-pencil-square-o"></i> Edit</a>';

    btn.button('loading');

    $.ajax({
      url: '/user/update/',
      type: 'POST',
      data: {id: id, data: disability, field: "disability"},
      success: function(result){
        if(result == 'Success'){
          swal({
            type: 'success',
            title: '<?=$lang['Success']?>',
            timer: 1500
          });
          $("td#disability").html(text);
        }
      }
    });
  });
</script>
