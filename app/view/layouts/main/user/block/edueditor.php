<?php
use Controller\View\Language;
use Controller\Admin\Postings;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);
?>
<div id="edueditor" class="form-group col-md-12" style="border: 1px solid #eee; padding: 10px;">
  <form id="eduform" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="" class="col-sm-2 control-label"><?=$lang['Institute']?></label>
        <div class="col-sm-10">
          <input type="text" name="institute_name" id="institute_name" class="form-control" value="" placeholder="<?=$lang['Institute']?>" required>
        </div>
    </div>

    <div class="form-group">
        <label for="" class="col-sm-2 control-label"><?=$lang['Background']?></label>
        <div class="col-sm-10">
          <select class="form-control" name="edulevel">
            <?php
            for ($i=1; $i <= 5 ; $i++) {
              echo "<option value=".$i.">";
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
          <input type="text" name="major" id="major" class="form-control" value="" placeholder="<?=$lang['Major']?>" required>
        </div>
    </div>

    <div class="form-group">
        <label for="" class="col-sm-2 control-label"><?=$lang['GPA']?></label>
        <div class="col-sm-10">
          <input type="number"  step="0.01" min="0.00" name="gpa" id="gpa" class="form-control" value="" placeholder="<?=$lang['GPA']?>" required>
        </div>
    </div>

    <div class="form-group">
      <div class="col-md-12 text-center">
        <button id="btnEduEdit" type="submit" class="btn btn-primary" data-loading-text="<?=$lang['processing']?>"><?=$lang['EditBtn']?></button>
        <button id="btnEduCancel" type="button" class="btn btn-default"><?=$lang['RemoveBtn']?></button>
      </div>
      <input type='hidden' name='id' value='<?=$_SESSION['social_id']?>' />
    </div>
  </form>
</div>

<script type="text/javascript">
  $("#btnEduCancel").click(function(){
    var defaultbtn = '<button type="button" onclick="newedu()" class="btn btn-primary btn-lg btn-block">Add New</button>';
    $("#edublock").fadeOut('slow', function(){
      $("#edublock").html(defaultbtn);
      $("#edublock").fadeIn("fast");
    });
  });

  $('#eduform').submit(function(e){
    e.preventDefault();
    var btn = $('#btnEduEdit');
    btn.button('loading');

    var id = $('input[name="id"]').val();
    var institue = $('#institute_name').val();
    var level = $('select[name="edulevel"]').val();
    var major = $('#major').val();
    var gpa = $('#gpa').val();

    $.ajax({
      url: '/user/newedu/',
      type: 'POST',
      data: {id: id, institue: institue, level: level, major: major, gpa: gpa},
      success: function(result){
        if(result == "Success"){
          alert("Success");
          setTimeout(function(){ window.location.reload(); }, 100);
        }
      }
    });
  });
</script>
