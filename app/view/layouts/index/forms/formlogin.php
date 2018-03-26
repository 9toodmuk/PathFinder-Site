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
          <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="<?=$lang['email']?>" value="" required>
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

    if (!isEmail(email)) {
      $("#errorbox").html("<?=$lang['EnterValidEmail']?>");
      $("#errorbox").fadeIn();
      $("div#errorbox").delay(3000).fadeOut(300);
      $button.button('reset');
    }

    $.ajax({
      url: '<?=$_ENV['API_LOCATION']?>/auth/login',
      type: 'POST',
      data: {email: email, password: pass},
      dataType: 'json',
      success: function (result) {
        $.ajax({
          url: 'registration/session',
          type: 'POST',
          data: {id: result.id, lang: result.language},
          success: function (result) {
            setTimeout(function(){ window.location.reload(); }, 1000);
          }
        });
      },
      error: function (xhr, status, err) {
        if (xhr.status == 401) {
          $("#errorbox").html("<?=$lang['AlertErrorText']?>");
          $("#errorbox").fadeIn();
          $("div#errorbox").delay(3000).fadeOut(300);
          $button.button('reset');
        } else if (xhr.status == 404) {
          $("#errorbox").html("<?=$lang['LoginNoUser']?>");
          $("#errorbox").fadeIn();
          $("div#errorbox").delay(3000).fadeOut(300);
          $button.button('reset');
        } else if (xhr.status == 422) {
          $("#errorbox").html("<?=$lang['LoginNoUser']?>");
          $("#errorbox").fadeIn();
          $("div#errorbox").delay(3000).fadeOut(300);
          $button.button('reset');
        }
      }
    });
  }

  function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }
</script>
