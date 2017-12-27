<div class="row">
  <div class="col-8 offset-2 text-center" style="margin-top: 30px; margin-bottom: 30px;">
    <img src="/themes/images/logos/EmpBannerWhite.png" width="450px" />
  </div>
  <div class="col-md-8 offset-2 form-box">
    <div class="form-top">
      <h2>ลงชื่อเข้าใช้</h2>
    </div>
    <div class="form-bottom">
      <div class="alert alert-danger" id="errorbox"></div>
      <form id="login-form" method="post" role="form" style="display: block;">
        <div class="form-group">
          <label for="email">อีเมล์สำหรับเข้าใช้</label>
          <input type="text" name="email" id="email" tabindex="1" class="form-control" value="" required>
        </div>
        <div class="form-group">
          <label for="password">รหัสผ่าน</label>
          <input type="password" name="password" id="password" tabindex="2" class="form-control" required>
        </div>
        <div class="form-group text-center" style="margin-top:40px;">
          <button id="btnLogin" type="submit" class="btn btn-primary btn-block btn-lg" data-loading-text="<?=$lang['processing']?>"><?=$lang['login']?></button><br/>
          <a href="/employer/register" class="btn btn-default"><?=$lang['register']?></a>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    $("#errorbox").hide();
  });

  $("#login-form").submit(function(e){
    e.preventDefault();
    login();
  });

  function login(){
    var email = $("input#email").val();
    var pass = $("input#password").val();

    var $button = $('#btnLogin');
    $button.button('loading');

    $.ajax({
      url: '/employer/login/',
      type: 'POST',
      data: {email: email, password: pass},
      dataType: 'json',
      success: function (result) {
        if(result.status){
          setTimeout(function(){ window.location.reload(); }, 3000);
        }else{
          if(result.error == "nouser"){
            $("#errorbox").html("<?=$lang['LoginNoUser']?>");
            $("#errorbox").fadeIn();
            $("div#errorbox").delay(3000).fadeOut(300);
            $button.button('reset');
          }else{
            $("#errorbox").html(result.error);
            $("#errorbox").fadeIn();
            $("div#errorbox").delay(3000).fadeOut(300);
            $button.button('reset');
          }
        }
      }
    });
  }
</script>
