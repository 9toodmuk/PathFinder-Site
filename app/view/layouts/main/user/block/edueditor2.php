<?php
use Controller\View\Language;
use Controller\User\Educations;
use Controller\Admin\Postings;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);

$edu = Educations::eduLoadbyId($_POST['id']);
?>
<div id="editedueditor" class="form-group col-md-12" style="border: 1px solid #eee; padding: 10px;">
  <form id="editeduform" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="" class="col-sm-2 control-label"><?=$lang['Institute']?></label>
        <div class="col-sm-10">
          <input type="text" name="institute_name" id="institute_name" class="form-control" value="<?=$edu['institute_name']?>" placeholder="<?=$lang['Institute']?>" required>
        </div>
    </div>

    <div class="form-group">
        <label for="" class="col-sm-2 control-label"><?=$lang['Backgroud']?></label>
        <div class="col-sm-10">
          <select class="form-control" name="edulevel">
            <?php
            for ($i=1; $i <= 5 ; $i++) {
              if($edu['background'] == $i){
                echo "<option value=".$i." selected>";
              }else{
                echo "<option value=".$i.">";
              }

              Postings::eduLevel($i);
              echo "</option>";
            }
            ?>
          </select>
        </div>
    </div>

    <div class="form-group">
        <label for="" class="col-sm-2 control-label"><?=$lang['Major']?></label>
        <div class="col-sm-10">
          <input type="text" name="major" id="major" class="form-control" value="<?=$edu['major']?>" placeholder="<?=$lang['Major']?>" required>
        </div>
    </div>

    <div class="form-group">
        <label for="" class="col-sm-2 control-label"><?=$lang['GPA']?></label>
        <div class="col-sm-10">
          <input type="number" step="0.01" min="0.00" name="gpa" id="gpa" class="form-control" value="<?=$edu['gpa']?>" placeholder="<?=$lang['GPA']?>" required>
        </div>
    </div>

    <div class="form-group">
      <div class="col-md-12 text-center">
        <button id="btnEditEdu" type="submit" class="btn btn-primary" data-loading-text="<?=$lang['processing']?>"><?=$lang['EditBtn']?></button>
        <button id="btnCancelEdu" type="button" class="btn btn-default"><?=$lang['RemoveBtn']?></button>
      </div>
      <input type='hidden' name='id' value='<?=$_POST['id']?>' />
    </div>
  </form>
</div>

<script type="text/javascript">
  $("#btnCancelEdu").click(function(){
    setTimeout(function(){ window.location.reload(); }, 100);
  });

  $('#editeduform').submit(function(e){
    e.preventDefault();
    var btn = $('#btnEditEdu');
    btn.button('loading');

    var id = $('input[name="id"]').val();
    var institue = $('#institute_name').val();
    var level = $('select[name="edulevel"]').val();
    var major = $('#major').val();
    var gpa = $('#gpa').val();

    $.ajax({
      url: '/user/editedu/',
      type: 'POST',
      data: {id: id, institue: institue, level: level, major: major, gpa: gpa},
      success: function(result){
        if(result == "Success"){
          swal({
            type: 'success',
            title: '<?=$lang['Success']?>',
            showConfirmButton: false,
            timer: 1500
          });
          setTimeout(function(){ window.location.reload(); }, 1000);
        }
      }
    });
  });
</script>
