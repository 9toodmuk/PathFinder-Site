<?php
use App\Controller\View\Language;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);
?>
<div id="expeditor" class="form-group col-md-12" style="border: 1px solid #eee; padding: 10px;">
  <form id="expform" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="" class="col-sm-2 control-label"><?=$lang['Title']?></label>
        <div class="col-sm-10">
          <input type="text" name="title" id="title" class="form-control" value="" placeholder="<?=$lang['Title']?>" required>
        </div>
    </div>

    <div class="form-group">
        <label for="" class="col-sm-2 control-label"><?=$lang['Employer']?></label>
        <div class="col-sm-10">
          <input type="text" name="emp" id="emp" class="form-control" value="" placeholder="<?=$lang['Employer']?>" required>
        </div>
    </div>

    <div class="form-group">
        <label for="" class="col-sm-2 control-label"><?=$lang['Durations']?></label>
        <div class="col-sm-10">
          <div class="input-group">
            <input type="text" name="start" id="start" class="form-control" value="" placeholder="<?=$lang['From']?>" data-date-format="yyyy-mm" data-link-field="startdate" data-link-format="yyyy-mm" required>
            <span class="input-group-addon"> <?=$lang['To']?> </span>
            <input type="text" name="end" id="end" class="form-control" value="" placeholder="<?=$lang['To']?>" data-date-format="yyyy-mm" data-link-field="enddate" data-link-format="yyyy-mm">
            <label class="input-group-addon"><input type="checkbox" name="now" id="now"> <?=$lang['now']?></label>
          </div>
        </div>
        <input type='hidden' id='startdate' value='' required/>
        <input type='hidden' id='enddate' value=''/>
    </div>

    <div class="form-group">
      <div class="col-md-12 text-center">
        <button id="btnEditExp" type="submit" class="btn btn-primary" data-loading-text="<?=$lang['processing']?>"><?=$lang['EditBtn']?></button>
        <button id="btnCancelExp" type="button" class="btn btn-default"><?=$lang['RemoveBtn']?></button>
      </div>
      <input type='hidden' name='id' value='<?=$_SESSION['social_id']?>' />
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

  $("#btnCancelExp").click(function(){
    var defaultbtn = '<button type="button" onclick="newexp()" class="btn btn-primary btn-lg btn-block">Add New</button>';
    $("#expblock").fadeOut('slow', function(){
      $("#expblock").html(defaultbtn);
      $("#expblock").fadeIn("fast");
    });
  });

  $('#expform').submit(function(e){
    e.preventDefault();
    var btn = $('#btnEditExp');
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
      url: '/user/newexp/',
      type: 'POST',
      data: {id: id, title: title, emp: emp, start: startdate, end: enddate, now: now},
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
