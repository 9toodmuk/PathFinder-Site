<?php
use Controller\View\Language;
use Controller\Employer\Detail;
use Controller\Utils\Address;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);

if(isset($_POST['id'])){
  $location = Detail::getLocation($_POST['id'], false, false);
  $location = mysqli_fetch_array($location);
}

if($language == "en"){
  $province = Address::getAllProvince(false);
}else{
  $province = Address::getAllProvince();
}
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h4 class="modal-title custom_align" id="Heading"><?=$lang[$formname]?></h4>
</div>
<form role="form" id="<?=$formname?>form" class="form-horizontal" method="post">
<div class="modal-body">

  <?php if(isset($_POST['id'])) echo '<input type="hidden" name="id" id="id" value="'.$_POST['id'].'">' ?>
  <div class="form-group">
      <label for="" class="col-sm-2 control-label">ชื่อ</label>
      <div class="col-sm-10">
        <input type="text" name="name" id="name" class="form-control" placeholder="ชื่อ" value="<?php if(isset($_POST['id'])) echo $location['name'] ?>" required>
      </div>
  </div>

  <div class="form-group">
      <label for="" class="col-sm-2 control-label">ที่อยู่</label>
      <div class="col-sm-10">
        <input type="text" name="address1" id="address1" class="form-control" placeholder="ที่อยู่ (เลขที่, อาคาร, ตรอก/ซอย)" value="<?php if(isset($_POST['id'])) echo $location['address'] ?>" required>
      </div>
  </div>

  <div class="form-group">
      <label for="" class="col-sm-2 control-label"></label>
      <div class="col-sm-10">
        <input type="text" name="address2" id="address2" class="form-control" placeholder="ที่อยู่ (ถนน, แขวง/ตำบล)" value="<?php if(isset($_POST['id'])) echo $location['address2'] ?>">
      </div>
  </div>

  <div class="form-group">
      <label for="" class="col-sm-2 control-label">เขต/อำเภอ</label>
      <div class="col-sm-10">
        <select name="city" id="city" class="form-control" required>
          <option value="">กรุณาเลือกจังหวัด</option>
        </select>
      </div>
  </div>

  <div class="form-group">
      <label for="" class="col-sm-2 control-label">จังหวัด</label>
      <div class="col-sm-10">
        <select name="province" id="province" class="form-control" required>
          <option value="">กรุณาเลือกจังหวัด</option>
          <?php
            while ($row = mysqli_fetch_assoc($province)) {
              echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
          ?>
        </select>
      </div>
  </div>

  <div class="form-group">
      <label for="" class="col-sm-2 control-label">รหัสไปรษณีย์</label>
      <div class="col-sm-10">
        <input type="text" pattern="[0-9]{5}" name="postcode" id="postcode" class="form-control" placeholder="รหัสไปรษณีย์" value="<?php if(isset($_POST['id'])) echo $location['postcode'] ?>" required>
      </div>
  </div>

  <div class="form-group">
      <label for="" class="col-sm-2 control-label">หมายเลขโทรศัพท์</label>
      <div class="col-sm-10">
        <input type="tel" name="telephone" id="telephone" class="form-control" placeholder="หมายเลขโทรศัพท์" value="<?php if(isset($_POST['id'])) echo $location['telephone'] ?>">
      </div>
  </div>

</div>
<div class="modal-footer">
  <button type="submit" id="<?=$formname?>btn" class="btn btn-primary btn-lg btn-block"><?=$lang[$formname."btn"]?></button>
</div>
</form>

<script type="text/javascript">
  $('#newlocationform').submit(function(e){
    e.preventDefault();
    $.ajax({
      url: '/employer/addlocation/',
      type: 'POST',
      data: $("#newlocationform").serialize(),
      dataType: "json",
      success: function(result){
        if(result.status){
          setTimeout(function(){ window.location.reload(); }, 100);
        }
      }
    });
  });

  var province = <?php echo isset($_POST['id']) ? $location['province'] : 0 ?>;

  $(function(){
    if(province != 0){
      $('select#province').val(province);
      getAmphur(province);
    }
  });

  function markSelected(){
    var amphur = <?php echo isset($_POST['id']) ? $location['city'] : 0 ?>;
    $('select#city').val(amphur);
  }

  function getAmphur(value){
    $.ajax({
      url: '/utilities/getAmphurList/'+value+"/<?=$language?>/",
      type: 'GET',
      dataType: "json",
      success: function(result){
        if(Object.keys(result).length > 0){
          $('select#city').html("");
          $.each(result, function(index) {
            $('select#city').append('<option value="'+result[index].id+'">'+result[index].name+'</option>')
          });
          if(province != 0){
            markSelected();
          }
        }else{
          $('select#city').html("");
          $('select#city').append('<option value="">กรุณาเลือกจังหวัด</option>');
        }
      }
    });
  }

  $('select#province').on('change', function(){
    getAmphur(this.value);
  });

  $('#editlocationform').submit(function(e){
    e.preventDefault();
    $.ajax({
      url: '/employer/editlocation/',
      type: 'POST',
      data: $("#editlocationform").serialize(),
      dataType: "json",
      success: function(result){
        if(result.status){
          setTimeout(function(){ window.location.reload(); }, 100);
        }
      }
    });
  });
</script>
