var more = true;

$(function() {
  $(this).scrollTop(0);
  loadmore();
});

$(window).scroll(function() {
  if($(window).scrollTop() == $(document).height() - ($(window).height())) {
      loadmore();
    }
});

$("#post-form").submit(function(e){
  e.preventDefault();
  var uid = $('input#uid').val();
  var message = $('textarea[name="message"]').val();
  $.ajax({
    url: '/timeline/post/',
    type: 'POST',
    data: {id: uid, message: message},
    success: function(result){
      $('#timeline').prepend($(result).hide().fadeIn('slow'));
    }
  });
});

function post(element){
  var pid = $(element).attr('id').replace('comment-form-','');
  var uid = $('input#uid').val();
  var message = $(element).find('input[name="comment"]').val();
  var commentblock = $('#comment'+pid);
  $.ajax({
    url: '/timeline/comment/',
    type: 'POST',
    data: {id: uid, pid: pid, message: message},
    success: function(result){
      $(commentblock).append(result);
    }
  });
}

function comment(element){
  var pid = $(element).attr('id').replace('comment-form-','');
  var uid = $('input#uid').val();
  var message = $(element).find('input[name="comment"]').val();
  var commentblock = $('#comment'+pid);
  $.ajax({
    url: '/timeline/comment/',
    type: 'POST',
    data: {id: uid, pid: pid, message: message},
    success: function(result){
      $(commentblock).prepend(result);
    }
  });
}

function reply(element){
  var id = $(element).attr('id');
  $('#panel'+id).fadeIn();
  commentload(id, );
}

function commentload(id){
  var commentblock = $('#comment'+id);
  var perpage = 5;
  var limit = $(commentblock).children("div").last().attr('id');
  if(limit == null){
    limit = 0;
  }
  $.ajax({
    url: '/timeline/commentload/',
    type: 'POST',
    data: {id: id, perpage: perpage, limit: limit},
    success: function(result){
      $(commentblock).append(result);
    }
  });
}

function like(element){
  var id = $(element).attr('id');
  var uid = $('input#uid').val();
  var type = $(element).parent().attr('id');
  var num = $(element).children('span').text();
  $.ajax({
    url: '/timeline/like/',
    type: 'POST',
    data: {id: id, uid: uid, type: type},
    success: function(result){
      if(~result.indexOf("Add")){
        $(element).removeClass('btn-like');
        $(element).addClass('btn-liked');
        $(element).children('span').text(++num);
      }else if(~result.indexOf("Delete")){
        $(element).removeClass('btn-liked');
        $(element).addClass('btn-like');
        $(element).children('span').text(--num);
      }
    }
  });
}

function loadmore(){
  var limit = 10;
  var id = $('#timeline').children("div").last().attr('id');

  if(id == null){
    id = 0;
  }else if(id == 1){
    $('#timeline').append("<div>No More Result</div>");
    more = false;
  }

  if(more){
    $.ajax({
      url: '/timeline/load/',
      type: 'POST',
      data: {id: id, limit: limit},
      success: function(result){
        if(result.length){
          $('#timeline').append(result);
        }else{
          $('#timeline').append("<div>No More Result</div>");
          more = false;
        }
      }
    });
  }

}
