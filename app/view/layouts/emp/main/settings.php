<?php
use App\Controller\Employer\Detail;
$emp = Detail::getDetails($_SESSION['emp_id']);
$settings = Detail::getSettings($_SESSION['emp_id']);
?>
<div class="row">
  <div class="col-12">
    <div class="portlet margin-bottom-30">
      <div class="portlet-title">
        <div class="caption caption-green">
          <i class="fa fa-cogs" aria-hidden="true"></i>
          <span class="caption-subject text-uppercase"> ตั้งค่า</span>
        </div>
      </div>
      <div class="portlet-body">
      <form id="settingsform" class="form" method="post">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div id='errorbox'></div>
            <legend>ตั้งค่าบัญชีผู้ใช้</legend>

            <div class="form-group col-md-12">
              <label class="col-md-4 control-label" for="newpassword">อีเมล์สำหรับเข้าใช้</label>
              <div class="col-md-8">
                <span><?=$emp['email']?></span>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-md-4 control-label" for="newpassword">เปลี่ยนรหัสผ่าน</label>
              <div class="col-md-8">
                <div class="form-group">
                  <input id="password" name="password" type="password" placeholder="รหัสผ่านใหม่" class="form-control input-md">
                </div>
                <div class="form-group">
                  <input id="password-confirm" name="password-confirm" type="password" placeholder="ยืนยันรหัสผ่านใหม่" class="form-control input-md">
                </div>
              </div>
            </div>

            <legend>ตั้้งค่าการรับสมัครงาน</legend>
            <div class="form-group col-md-12">
              <label class="col-md-4 control-label" for="checkboxes">ตั้งค่าการรับสมัคร</label>
              <div class="col-md-8">

                <div class="input-group">
                  <label for="sendemail">
                    <input type="checkbox" name="sendemail" id="sendemail" value="1" <?php if($settings['sendemail'] == 1) echo "checked" ?>>
                    ส่งอีเมล์แจ้งเตือนเมื่อมีผู้ส่งใบสมัคร
                  </label>
                </div>

                <div class="input-group">
                  <label for="senddetail">
                    <input type="checkbox" name="senddetail" id="senddetail" value="1" <?php if($settings['senddetail'] == 1) echo "checked" ?>>
                    ส่งรายละเอียดผู้สมัครไปที่อีเมล์ของคุณ
                  </label>
                </div>

              </div>
            </div>

            <legend>ยืนยันรหัสผ่าน</legend>
            <div class="form-group col-md-12">
              <label class="col-md-4 control-label" for="confirm-password">รหัสผ่านเดิม</label>
              <div class="col-md-8">
                <input id="oldpassword" name="oldpassword" type="password" placeholder="รหัสผ่านเดิม" class="form-control input-md" required>
              </div>
            </div>

            <div class="form-group col-md-12">
              <button type="submit" id="btnEdit" class="btn btn-primary btn-lg btn-block">ยืนยัน</button>
            </div>

          </form>

          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $("#settingsform input").on('click input', function(){
    validate($(this));
  });

  function validate(target){
    var error = 0;
    var type = target.attr("type");
    var val = target.val();

    if(target.attr("name") == "oldpassword"){
      return false;
    }

    if(target.attr("name") == "password"){
      if(val == ""){
        $("input#password-confirm").removeAttr("required");
        $("input#password").parent().removeClass("has-error");
        $("input#password-confirm").parent().removeClass("has-error");
        $("input#password-confirm").val("");
        $("#btnEdit").prop('disabled', false);
        return false;
      }else{
        $("input#password-confirm").prop("required", true);
      }
    }

    if(target.attr("name") == "password-confirm" && type == "password"){
      var type = "cpassword";
    }

    switch (type) {
      case "cpassword":
        var initialPassword = $("input#password").val();
        error += setRow(initialPassword == val && initialPassword.length > 0, target);
        break;
      case "password":
        var minLength = $(this).data("min-length");
        if(typeof minLength == "undefined")
          minLength = 8;
        error += setRow(val.length >= minLength, target);
        break;
    }

    if(error > 0){
      $("#btnEdit").prop('disabled', true);
    }else{
      $("#btnEdit").prop('disabled', false);
    }
  }

  function setRow(valid, target){
  	var error = 0;
  	if(valid){
  		target.parent().removeClass("has-error");
  	} else {
  		error = 1;
  		target.parent().addClass("has-error");
  	}
  	return error;
  }

  $("#settingsform").submit(function(e){
    e.preventDefault();
    $.ajax({
      url: "/employer/editsettings/",
      type: "post",
      data: $("#settingsform").serialize(),
      dataType: "json",
      success: function(result){
        if(result.updated){
          $("#errorbox").append("<div id='updatedbox' class='alert alert-success'><?=$lang['AlertSuccessText']?></div>");
          $("#updatedbox").delay(3000).fadeOut(300, function(){
            $("#updatedbox").remove();
          });
        }
        if(result.error == "wrongpassword"){
          $("#errorbox").append("<div id='passwordbox' class='alert alert-danger'><strong>Error!</strong> Your password is wrong!</div>");
          $("#passwordbox").delay(3000).fadeOut(300, function(){
            $("#passwordbox").remove();
          });
        }
        if(result.passchanged){
          $("#errorbox").append("<div id='passchanged' class='alert alert-success'><strong>Success!</strong> Your password has been changed!</div>");
          $("#passchanged").delay(3000).fadeOut(300, function(){
            $("#passchanged").remove();
          });
        }
      }
    });
  });
</script>
