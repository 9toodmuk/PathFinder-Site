<?php
use Controller\View\Language;
use Controller\Admin\Postings;
use Controller\User\Skills;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);
if(isset($_POST['id'])){
  $skill = Skills::skillLoadbyId($_POST['id']);
}
?>
<div id="skilleditor" class="form-group col-md-12" style="border: 1px solid #eee; padding: 10px;">
  <form id="skillform" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="" class="col-sm-2 control-label">ชื่อทักษะ</label>
        <div class="col-sm-10">
          <input type="text" name="skill" id="skill" class="form-control" value="<?php if(isset($_POST['id'])) echo $skill['name'] ?>" placeholder="ชื่อทักษะ" required>
        </div>
    </div>

    <div class="form-group">
      <div class="col-md-12 text-center">
        <button id="btnSkillEdit" type="submit" class="btn btn-primary" data-loading-text="<?=$lang['processing']?>">อัพเดท</button>
        <button id="btnSkillCancel" type="button" class="btn btn-default">ยกเลิก</button>
      </div>
      <input type='hidden' name='id' value='<?=$_SESSION['social_id']?>' />
    </div>
  </form>
</div>

<script type="text/javascript">
  $("#btnSkillCancel").click(function(){
    setTimeout(function(){ window.location.reload(); }, 100);
  });

  $('#skillform').submit(function(e){
    e.preventDefault();
    var btn = $('#btnSkillEdit');
    btn.button('loading');

    <?php if(isset($_POST['id'])) {
      echo "var id = ".$_POST['id'].";";
    } ?>
    var skill = $('input#skill').val();

    $.ajax({
      <?php if(isset($_POST['id'])) { ?>
        url: '/user/editSkill/',
        data: {id: id, skill: skill},
      <?php }else{ ?>
        url: '/user/newSkill/',
        data: {skill: skill},
      <?php } ?>
      type: 'POST',
      dataType: "json",
      success: function(result){
        if(result.status){
          alert("Success");
          setTimeout(function(){ window.location.reload(); }, 100);
        }
      }
    });
  });
</script>
