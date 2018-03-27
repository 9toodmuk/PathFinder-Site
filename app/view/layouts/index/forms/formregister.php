<div class="row">
  <div class="col-sm-8 col-sm-offset-2 form-box" id="main-form">
<div class="form-top">
  <div class="form-top-left">
    <h3><?=$lang['register']?></h3>
    <p><?=$lang['registersubtitle']?>:</p>
  </div>
  <div class="form-top-right">
    <i class="fa fa-key"></i>
  </div>
</div>
<div class="form-bottom">
  <div class="alert alert-danger" id="errorbox" style="display: none;"></div>
  <form id="register-form" method="post" style="display: block;">
    <div class="row">
      <div class="form-group col-lg-6">
        <input type="text" name="firstname" id="firstname" tabindex="1" class="form-control" placeholder="<?=$lang['name']?>" value="" required>
      </div>
      <div class="form-group col-lg-6">
        <input type="text" name="lastname" id="lastname" tabindex="2" class="form-control" placeholder="<?=$lang['lastname']?>" value="" required>
      </div>
      <div class="form-group col-lg-12">
        <label class="sr-only" for="email"><?=$lang['email']?></label>
        <input type="email" name="email" id="email" tabindex="3" class="form-control" placeholder="<?=$lang['email']?>" value="" required>
      </div>
      <div class="form-group input-password col-lg-6">
        <label class="sr-only" for="password"><?=$lang['password']?></label>
        <input type="password" name="password" id="password" tabindex="4" class="form-control" data-min-length="8" placeholder="<?=$lang['password']?>" required>
      </div>
      <div class="form-group password-confirm col-lg-6">
        <label class="sr-only" for="password-confirm"><?=$lang['confirmpassword']?></label>
        <input type="password" name="password-confirm" id="password-confirm" tabindex="5" class="form-control" placeholder="<?=$lang['confirmpassword']?>" data-min-length="8" required>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-lg-12">
        <div class="funkyradio">
          <div class="funkyradio-success">
            <input type="checkbox" name="tandcm" id="tandcm" checked required>
            <label for="tandcm"><span class="content"><?=$lang['registerterm']?></label>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-md-6 col-md-offset-3"><button id="btnRegister" type="submit" class="btn btn-primary btn-block btn-lg" data-loading-text="<?=$lang['processing']?>" disabled><?=$lang['registerbutton']?></button></div>
    </div>
  </form>
</div>
</div>
</div>

<div class="row">
  <div class="col-sm-6 col-sm-offset-3 form-box">
    <a href="/"><?=$lang['haveanaccount']?> </a><span class="clearfix"></span>
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
    var name = $("input#firstname").val();
    var lastname = $("input#lastname").val();
    var email = $("input#email").val();
    var pass = $("input#password").val();

    var $button = $('#btnRegister');
    $button.button('loading');

    $.ajax({
      url: '<?=$_ENV['API_LOCATION']?>/auth/register',
      type: 'POST',
      data: {firstname : name, lastname: lastname, email: email, password: pass},
      success: function (result) {
        $(window).scrollTop(0);
        $("#errorbox").removeClass("alert-danger");
        $("#errorbox").addClass("alert-success");
        $("#errorbox").html("<?=$lang['RegisterSuccess']?>");
        $("#errorbox").fadeIn();
        setTimeout(function(){ window.location = "/home/"; }, 3000);
      },
      error: function (xhr) {
        if (xhr.status == 400) {
          $("#errorbox").html("<?=$lang['Emailhasbeenused']?>");
          $("#errorbox").fadeIn();
          $("#errorbox").delay(3000).fadeOut(300);
          $button.button('reset');
        } else if (xhr.status == 500) {
          $("#errorbox").html("<?=$lang['AlertErrorText']?>");
          $("#errorbox").fadeIn();
          $("div#errorbox").delay(3000).fadeOut(300);
          $button.button('reset');
        }
      }
    });
  }
</script>

<div id="t_and_c_m" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?=$lang['TermandConditions']?></h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=$lang['Close']?></button>
      </div>
    </div>

  </div>
</div>
