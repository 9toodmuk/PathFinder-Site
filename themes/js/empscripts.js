$(function() {
  'use strict';

  $.backstretch("/themes/images/backgrounds/header.jpg");

  $("#register-form input").on("click input", function(){
		validate($(this));
	});
});

function validate(target){
  var error = 0;
  var type = target.attr("type");

  if(target.attr("name") == "password-confirm" && type == "password"){
    var type = "cpassword";
  }
  var val = target.val();

  switch (type) {
    case "email":
      error += setRow(validateEmail(val), target);
      break;
    case "cpassword":
      var initialPassword = $("input#password").val();
      error += setRow(initialPassword  == val && initialPassword.length > 0, target);
      break;
    case "password":
      var minLength = $(this).data("min-length");
      if(typeof minLength == "undefined")
        minLength = 8;
      error += setRow(val.length >= minLength, target);
      break;
    case "text":
      if(target.prop('required')){
        var minLength = 3;
      }else{
        var minLength = 0;
      }
      error += setRow(val.length >= minLength, target);
      break;
  }

  var isValid = 0;
  $("#register-form input").each(function() {
     var element = $(this);
     if (element.val() == "") {
         isValid += 1;
     }

     if (element.val() == "" && !element.prop('required')) {
       isValid = 0;
     }
  });

  if(error >= 1 || isValid >= 1){
    $("#btnRegister").prop('disabled', true);
  }else if(error == 0 && isValid == 0){
    $("#btnRegister").prop('disabled', false);
  }
}

function setRow(valid, target){
	var error = 0;
	if(valid){
		target.addClass("valid");
		target.removeClass("invalid");
    target.next('div').hide();
	} else {
		error = 1;
		target.addClass("invalid");
		target.removeClass("valid");
    target.next('div').show();
	}
	return error;
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
