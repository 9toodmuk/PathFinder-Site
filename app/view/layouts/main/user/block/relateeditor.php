<?php
use Controller\View\Language;
use Controller\User\Profile;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);
if(isset($id)){
  $relate = Profile::profileLoad($id);
  $relate = mysqli_fetch_array($relate);
}
?>

<div class="alert" id="editor-error" style="display:none;"></div>
<div id="relatetiveeditor" class="form-group col-md-12" style="border: 1px solid #eee; padding: 10px;">
  <form id="relatetiveform" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <div class="col-md-2 col-sm-12"><img class="thumbnail pull-right" style="margin:0px;" src="/uploads/profile_image/<?php if(isset($id)) { echo $relate['profile_image']; }else{ echo 'default.png'; } ?>" id="relateprofile" width="48px" /></div>
        <div class="col-sm-10" id="friendrelate">
          <input type="text" name="friend" value="" class="form-control typeahead" placeholder="ชื่อเพื่อน" <?php if(isset($id)) echo "disabled" ?> required>
          <input type="hidden" name="fid" id="fid" value="<?php if(isset($id)) echo $id ?>" required>
        </div>
    </div>

    <div class="form-group">
        <label for="" class="col-sm-2 control-label">ความสัมพันธ์</label>
        <div class="col-sm-10">
          <select class="form-control" name="relationship" id="relationship" required>
            <option value="">กรุณากรอกชื่อเพื่อน</option>
          </select>
        </div>
    </div>

    <div class="form-group">
      <div class="col-md-12 text-center">
        <button id="btnEditRelate" type="submit" class="btn btn-primary" data-loading-text="<?=$lang['processing']?>">อัพเดท</button>
        <button id="btnCancelRelate" type="button" class="btn btn-default">ยกเลิก</button>
      </div>
      <input type='hidden' name='id' value='<?=$_SESSION['social_id']?>' />
    </div>
  </form>
</div>

<script type="text/javascript">
  var id = <?=$_SESSION['social_id']?>;

  var substringMatcher = function(strs) {
    return function findMatches(q, cb) {
      var matches, substringRegex;
      matches = [];
      substrRegex = new RegExp(q, 'i');
      $.each(strs, function(i, str) {
        if (substrRegex.test(str)) {
          matches.push(str);
        }
      });
      cb(matches);
    };
  };

  data = [];
  map = {};

  $.getJSON('/utilities/getFriendsName/'+id, function(json){
    $.each(json, function(i, name){
      map[name.name] = name;
      data.push(name.name);
    });
  });

  $('#friendrelate .typeahead').typeahead({
    hint: true,
    highlight: true,
    minLength: 1
  },
  {
    name: 'friendsname',
    source: substringMatcher(data),
    templates: {
      empty: '<div style="padding: 3px 20px">No matches.</div>'
    },
    freeInput: false
  }).on('typeahead:selected', function(obj, datum){
    $('#fid').val(map[datum].id);
    getGenderSelect(map[datum].gender);
    $('#relateprofile').attr('src', '/uploads/profile_image/'+map[datum].profile_image);
  });

  <?php
    if(isset($id)){
      echo '$(function(){ getGenderSelect('.$relate['sex'].')});';
      echo '$("#friendrelate .typeahead").typeahead("val","'.$relate['first_name'].' '.$relate['last_name'].'");';
    }
  ?>

  function getGenderSelect(gender){
    if(gender == 0){
      $('#relationship').load('/utilities/malerelateoption/');
    }else if(gender == 1){
      $('#relationship').load('/utilities/femalerelateoption/');
    }
  }

  $('#btnCancelRelate').click(function(){
    setTimeout(function(){ window.location.reload(); }, 100);
  });

  $('#relatetiveform').submit(function(e){
    e.preventDefault();
    var btn = $('#btnEditRelate');
    btn.button('loading');

    var user1 = id;
    <?php if(isset($id)){ ?>
      var rid = <?=$id?>;
    <?php } ?>
    var user2 = $('input[name="fid"]').val();
    var relationship = $('select[name="relationship"]').val();

    $.ajax({
      <?php if(isset($id)){ ?>
        url: '/user/editRelative/',
      <?php }else{ ?>
        url: '/user/addRelative/',
      <?php } ?>
      data: {user1: user1, user2: user2, relationship: relationship},
      type: 'POST',
      dataType: "json",
      success: function(result){
        if(result.status){
          $('#editor-error').addClass('alert-success');
          $('#editor-error').removeClass('alert-danger');
          $('#editor-error').html("<?=$lang['AlertSuccessText']?>");
          $('#editor-error').fadeIn();
          $("#editor-error").delay(3000).fadeOut(300);
          setTimeout(function(){ window.location.reload(); }, 100);
        }else{
          if(result.error == 'multiple'){
            $('#editor-error').addClass('alert-danger');
            $('#editor-error').removeClass('alert-success');
            $('#editor-error').html("Error: This user has been add to your relative.");
            $('#editor-error').fadeIn();
            $("#editor-error").delay(3000).fadeOut(300);
            btn.button('reset');
          }else{
            $('#editor-error').addClass('alert-danger');
            $('#editor-error').removeClass('alert-success');
            $('#editor-error').html("Error: "+result.error);
            $('#editor-error').fadeIn();
            $("#editor-error").delay(3000).fadeOut(300);
            btn.button('reset');
          }
        }
      }
    });
  });
</script>
