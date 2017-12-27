$(document).ready(function() {
  $.backstretch("/themes/images/backgrounds/1.jpg");

  $("#register-form input").on("click input", function(){
		validate($(this).closest(".form-group"));
	});
});

function validate(target){
  var error = 0;
  target.find("input").each(function(){
    var type = $(this).attr("type");

    if($(this).attr("name") == "password-confirm" && type == "password"){
      var type = "cpassword";
    }

    var Parent = $(this).parent();
    var val = $(this).val();

    switch (type) {
      case "email":
        error += setRow(validateEmail(val), Parent);
        break;
      case "cpassword":
        var initialPassword = $(".input-password input").val();
        error += setRow(initialPassword  == val && initialPassword.length > 0, Parent);
        break;
      case "password":
        var minLength = $(this).data("min-length");
        if(typeof minLength == "undefined")
          minLength = 0;
        error += setRow(val.length >= minLength, Parent);
        break;
      case "text":
        var minLength = $(this).data("min-length");
        if(typeof minLength == "undefined")
          minLength = 3;
        error += setRow(val.length >= minLength, Parent);
        break;
    }
  });

  if(error >= 1){
    $("#btnRegister").prop('disabled', true);
  }else{
    $("#btnRegister").prop('disabled', false);
  }
}

function validateEmail(email) {
  $.ajax({
    url: '/dist/admin/users/emailcheck.php',
    type: 'POST',
    data: {email:target},
    success: function(result){
      if(result >= 1){
        $('#register-form input#email').parent().addClass("has-error");
        $('#register-form input#email').next(".help-block").html("อีเมล์ถูกใช้แล้ว");
      }else{
        $('#register-form input#email').parent().removeClass("has-error");
        $('#register-form input#email').next(".help-block").html("");
      }
    }
  });
}

function setRow(valid, Parent){
	var error = 0;
	if(valid){
		Parent.addClass("has-success");
		Parent.removeClass("has-error");
	} else {
		error = 1;
		Parent.addClass("has-error");
		Parent.removeClass("has-success");
	}
	return error;
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
