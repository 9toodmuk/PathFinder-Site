function edit(element){
  var id = $(element).parent().attr('id');
  if(id == "name"){
    loadnameeditor(element);
  }else if(id == "gender"){
    loadgendereditor(element);
  }else if(id == "birthdate"){
    loaddateeditor(element);
  }else if(id == "disability"){
    loaddisabilityeditor(element);
  }else{
    loadfieldeditor(element);
  }
}

function newedu(){
  $("#edublock").load('/utilities/edueditor');
}

function newexp(){
  $("#expblock").load('/utilities/expeditor');
}

function newskill(){
  $("#skillblock").load('/utilities/skilleditor');
}

function newrelative(){
  $.ajax({
    url: '/utilities/relateeditor',
    type: 'POST',
    success: function(result){
      $("#relativeblock").hide();
      $("#relateblock").html(result);
    }
  });
}

function editexp(element){
  var id = $(element).parents('table').attr('id');
  var now = $(element).parents('table').parent().html();

  $.ajax({
    url: '/utilities/expeditor2',
    type: 'POST',
    data: {id:id},
    success: function(result){
      $(element).parents('table').parent().html(result);
    }
  });
}

function editedu(element){
  var id = $(element).parents('table').attr('id');
  var now = $(element).parents('table').parent().html();

  $.ajax({
    url: '/utilities/edueditor2',
    type: 'POST',
    data: {id:id},
    success: function(result){
      $(element).parents('table').parent().html(result);
    }
  });
}

function editrelate(element){
  var id = $(element).parents('.margin-bottom-10').parent().attr('id');
  var now = $(element).parents('div').parent().html();

  $.ajax({
    url: '/utilities/relateeditor',
    type: 'POST',
    data: {id:id},
    success: function(result){
      $("#relativeblock").hide();
      $("#relateblock").html(result);
    }
  });
}

function editskill(element){
  var id = $(element).parents('tr').attr('id');

  $.ajax({
    url: '/utilities/skilleditor',
    type: 'POST',
    data: {id:id},
    success: function(result){
      $('#skilllist').html(result);
      $('#skillblock').hide();
    }
  });
}

function removeexp(element){
  var id = $(element).parents('table').attr('id');

  $.ajax({
    url: '/user/removeexp',
    type: 'POST',
    data: {id:id},
    success: function(result){
      if(result == "Success"){
        alert("Success");
        $(element).parents('table').parent().fadeOut('slow');
      }
    }
  });
}

function removeskill(element){
  var id = $(element).parents('tr').attr('id');

  $.ajax({
    url: '/user/removeskill',
    type: 'POST',
    data: {id:id},
    dataType: "json",
    success: function(result){
      if(result.status){
        alert("Success");
        $(element).parents('tr').fadeOut('slow');
      }
    }
  });
}

function removeedu(element){
  var id = $(element).parents('table').attr('id');

  $.ajax({
    url: '/user/removeedu',
    type: 'POST',
    data: {id:id},
    success: function(result){
      if(result == "Success"){
        alert("Success");
        $(element).parents('table').parent().fadeOut('slow');
      }
    }
  });
}

function loadnameeditor(element){
  var id = $('input#uid').val();
  $.ajax({
    url: '/utilities/nameeditor',
    type: 'POST',
    data: {id:id},
    success: function(result){
      $(element).parent().html(result);
    }
  });
}

function loadgendereditor(element){
  var id = $('input#uid').val();
  $.ajax({
    url: '/utilities/gendereditor',
    type: 'POST',
    data: {id:id},
    success: function(result){
      $(element).parent().html(result);
    }
  });
}

function loaddisabilityeditor(element){
  var id = $('input#uid').val();
  $.ajax({
    url: '/utilities/disabilityeditor',
    type: 'POST',
    data: {id:id},
    success: function(result){
      $(element).parent().html(result);
    }
  });
}

function loadfieldeditor(element){
  var id = $('input#uid').val();
  var field = $(element).parent().attr('id');
  $.ajax({
    url: '/utilities/fieldeditor',
    type: 'POST',
    data: {id:id, field: field},
    success: function(result){
      $(element).parent().html(result);
    }
  });
}

function loaddateeditor(element){
  var id = $('input#uid').val();
  $.ajax({
    url: '/utilities/dateeditor',
    type: 'POST',
    data: {id:id},
    success: function(result){
      $(element).parent().html(result);
    }
  });
}
