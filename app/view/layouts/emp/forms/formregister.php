<?php
use Controller\Job\Employer;
?>
<div class="row">
  <div class="col-8 offset-2 text-center" style="margin-top: 30px; margin-bottom: 30px;">
    <img src="/themes/images/logos/EmpBannerWhite.png" width="450px" />
  </div>
  <div class="col-md-8 offset-2 form-box">
    <div class="form-top">
      <h2>ลงทะเบียนผู้ประกอบการ</h2>
    </div>
    <div class="form-bottom">
      <div class="alert alert-danger" id="errorbox"></div>
      <form id="register-form" method="post" role="form" style="display: block;">
        <div class="form-group">
          <label for="email">อีเมล์สำหรับเข้าใช้</label>
          <input type="email" name="email" id="email" tabindex="1" class="form-control" value="" required>
          <div class="invalid-feedback">
            Please provide a valid e-mail address.
          </div>
        </div>
        <div class="form-group">
          <label for="password">รหัสผ่าน</label>
          <input type="password" name="password" id="password" tabindex="2" class="form-control" required>
          <div class="invalid-feedback">
            Password need at least 8 alphabeth.
          </div>
        </div>
        <div class="form-group">
          <label for="cpassword">ยืนยันรหัสผ่าน</label>
          <input type="password" name="password-confirm" id="password-confirm" tabindex="3" class="form-control" required>
          <div class="invalid-feedback">
            Your entered password is not equals.
          </div>
        </div>
        <hr/>
        <div class="form-group">
          <label for="contact">ชื่อบริษัท</label>
          <input type="text" name="name" id="name" tabindex="4" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="contact">ชื่อผู้ติดต่อ</label>
          <input type="text" name="contact" id="contact" tabindex="5" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="category">ประเภทธุรกิจ</label>
          <select class="form-control" name="category" tabindex="6" required>
            <option value=''>กรุณาเลือก</option>
            <?php
              $result = Employer::getAllCategory();
              while($row = $result->fetch_array()){
                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
              }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="contact">อีเมล์สำหรับติดต่อ</label>
          <input type="text" name="contactemail" id="contactemail" tabindex="7" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="contact">แผนก</label>
          <input type="text" name="section" id="section" tabindex="8" class="form-control">
        </div>
        <div class="form-group">
          <label for="contact">หมายเลขติดต่อ</label>
          <input type="text" name="telephone" id="telephone" tabindex="9" class="form-control" required>
        </div>
        <div class="form-group text-center" style="margin-top:40px;">
          <button id="btnRegister" type="submit" class="btn btn-primary btn-block btn-lg" tabindex="10" data-loading-text="<?=$lang['processing']?>" disabled><?=$lang['register']?></button><br/>
          <a href="/employer/" class="btn btn-default">มีผู้ใช้แล้ว? ลงชื่อเข้าใช้ที่นี่</a>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    $("#errorbox").hide();
  });

  $("#register-form").submit(function(e){
    e.preventDefault();
    register();
  });

  function register(){
    var button = $('#btnRegister');
    button.button('loading');

    $.ajax({
      url: '/employer/signup/',
      type: 'POST',
      data: $('#register-form').serialize(),
      dataType: "json",
      success: function(result){
        $(window).scrollTop(0);
        if(result.status){
          $("#errorbox").removeClass("alert-danger");
          $("#errorbox").addClass("alert-success");
          $("#errorbox").html("<?=$lang['RegisterSuccess']?>");
          $("#errorbox").fadeIn();
          setTimeout(function(){ window.location = "/home/"; }, 3000);
        }else{
          button.button('reset');
          if(result.reason == 1){
            $("#errorbox").html("<?=$lang['Emailhasbeenused']?>");
            $("#errorbox").fadeIn();
            $("#errorbox").delay(3000).fadeOut(300);
          }else if(result.reason == 2){
            $("#errorbox").html("Can't connect to the server.");
            $("#errorbox").fadeIn();
            $("#errorbox").delay(3000).fadeOut(300);
          }
        }
      }
    });
  }
</script>
