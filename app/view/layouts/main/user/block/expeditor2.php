<?php
use Controller\View\Language;
use Controller\User\Experiences;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);

$exp = Experiences::expLoadbyId($_POST['id']);
?>
<div id="editexpeditor" class="form-group col-md-12" style="border: 1px solid #eee; padding: 10px;">
  <form id="editexpform" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="" class="col-sm-2 control-label"><?=$lang['Title']?></label>
        <div class="col-sm-10">
          <input type="text" name="title" id="title" class="form-control" value="<?=$exp['name']?>" placeholder="<?=$lang['Title']?>" required>
        </div>
    </div>

    <div class="form-group">
        <label for="" class="col-sm-2 control-label"><?=$lang['Employer']?></label>
        <div class="col-sm-10">
          <input type="text" name="emp" id="emp" class="form-control" value="<?=$exp['company']?>" placeholder="<?=$lang['Employer']?>" required>
        </div>
    </div>

    <div class="form-group">
        <label for="" class="col-sm-2 control-label"><?=$lang['Durations']?></label>
        <div class="col-sm-10">
          <div class="input-group">
            <input type="text" name="start" id="start" class="form-control" value="<?=$exp['start_at']?>" placeholder="<?=$lang['From']?>" data-date-format="yyyy-mm" data-link-field="startdate" data-link-format="yyyy-mm" required>
            <span class="input-group-addon"> <?=$lang['To']?> </span>
            <input type="text" name="end" id="end" class="form-control" value="<?=$exp['end_at']?>" placeholder="<?=$lang['To']?>" data-date-format="yyyy-mm" data-link-field="enddate" data-link-format="yyyy-mm" <?php if($exp['status'] == 1) echo "disabled"?>>
            <label class="input-group-addon"><input type="checkbox" name="now" id="now" <?php if($exp['status'] == 1) echo "checked"?>> <?=$lang['now']?></label>
          </div>
        </div>
        <input type='hidden' id='startdate' value='<?=$exp['start_at']?>' required/>
        <input type='hidden' id='enddate' value='<?=$exp['end_at']?>'/>
    </div>

    <div class="form-group">
      <div class="col-md-12 text-center">
        <button id="btnExpEdit" type="submit" class="btn btn-primary" data-loading-text="<?=$lang['processing']?>"><?=$lang['EditBtn']?></button>
        <button id="btnExpCancel" type="button" class="btn btn-default"><?=$lang['RemoveBtn']?></button>
      </div>
      <input type='hidden' name='id' value='<?=$_POST['id']?>' />
    </div>
  </form>
</div>

<script type="text/javascript">
  $(function () {
    $('#start').datetimepicker({
      viewMode: 'years',
      format: 'yyyy-mm',
      weekStart: 0,
      autoclose: 1,
      startView: 4,
      minView: 3,
      forceParse: 1,
      locale: 'th'
    });

    $('#end').datetimepicker({
      viewMode: 'years',
      format: 'yyyy-mm',
      weekStart: 0,
      autoclose: 1,
      startView: 4,
      minView: 3,
      forceParse: 1,
      locale: 'th'
    });
    moment().format();
  });

  $("#now").click(function(){
    if($(this).is(":checked")) {
      $("#end").prop('disabled', true);
    }else{
      $("#end").prop('disabled', false);
    }
  });

  $("#btnExpCancel").click(function(){
    setTimeout(function(){ window.location.reload(); }, 100);
  });

  $('#editexpform').submit(function(e){
    e.preventDefault();
    var btn = $('#btnExpEdit');
    btn.button('loading');

    var id = $('input[name="id"]').val();
    var title = $('#title').val();
    var emp = $('#emp').val();
    var startdate = $('#startdate').val();
    var enddate = $('#enddate').val();
    if($("#now").is(":checked")) {
      var now = 1;
    }else{
      var now = 0;
    }

    $.ajax({
      url: '/user/editexp/',
      type: 'POST',
      data: {id: id, title: title, emp: emp, start: startdate, end: enddate, now: now},
      success: function(result){
        if(result == "Success"){
          alert("Success");
          setTimeout(function(){ window.location.reload(); }, 100);
        }
      }
    });
  });
</script>
