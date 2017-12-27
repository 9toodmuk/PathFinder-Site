<div class="row">
  <div class="col-sm-6 col-sm-offset-3 form-box">
    <div class="form-top">
      <div class="form-top-left">
        <h3><?=$lang['login']?></h3>
        <p><?=$lang['loginsubtitle']?></p>
      </div>
      <div class="form-top-right">
        <i class="fa fa-key"></i>
      </div>
    </div>
    <div class="form-bottom">
      <div class="alert alert-danger" id="errorbox"></div>
      <form id="login-form" method="post" role="form" style="display: block;">
        <div class="form-group">
          <label class="sr-only" for="email"><?=$lang['email']?></label>
          <input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="<?=$lang['email']?>" value="" required>
        </div>
        <div class="form-group">
          <label class="sr-only" for="password"><?=$lang['password']?></label>
          <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="<?=$lang['password']?>" required>
        </div>
        <!-- <div class="form-group text-center">
          <div class="g-recaptcha text-center" data-sitekey="6LfEsjsUAAAAACAIpcFUaa9VQuo2k9pTOINX-Rcc"></div>
        </div> -->
        <button id="btnLogin" type="submit" class="btn btn-primary btn-block btn-lg" data-loading-text="<?=$lang['processing']?>"><?=$lang['login']?></button>
        <div class="form-group">
          <a href="#" class="pull-right need-help"><?=$lang['needhelp']?> </a><span class="clearfix"></span>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-6 col-sm-offset-3 form-box">
    <a href="/home/registration/"><?=$lang['RegisterLink']?> </a><span class="clearfix"></span>
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
      url: '/home/login/',
      type: 'POST',
      data: {email: email, password: pass},
      success: function (result) {
        if(~result.indexOf("Success")){
          setTimeout(function(){ window.location.reload(); }, 3000);
        }else if(result == "FailedNoUsers"){
          $("#errorbox").html("<?=$lang['LoginNoUser']?>");
          $("#errorbox").fadeIn();
          $("div#errorbox").delay(3000).fadeOut(300);
          $button.button('reset');
        }else{
          $("#errorbox").html("<?=$lang['AlertErrorText']?>");
          $("#errorbox").fadeIn();
          $("div#errorbox").delay(3000).fadeOut(300);
          $button.button('reset');
        }
      }
    });
  }
</script>
