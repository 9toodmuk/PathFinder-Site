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
  var pid = $('input#pid').val();
  var message = $('textarea[name="message"]').val();
  $.ajax({
    url: '/timeline/post/',
    type: 'POST',
    data: {id: uid, message: message, fid: pid},
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
  commentload(id);
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
      if(result == "SuccessAdd"){
        $(element).removeClass('btn-like');
        $(element).addClass('btn-liked');
        $(element).children('span').text(++num);
      }else if(result == "SuccessDelete"){
        $(element).removeClass('btn-liked');
        $(element).addClass('btn-like');
        $(element).children('span').text(--num);
      }
    }
  });
}

function loadmore(){
  var perpage = 10;
  var limit = $('#timeline').children("div").last().attr('id');
  var fid = $('input#pid').val();
  if(limit == null){
    limit = 0;
  }
  $.ajax({
    url: '/user/load/',
    type: 'POST',
    data: {limit: limit, perpage: perpage, pid:fid},
    success: function(result){
      $('#timeline').append(result);
    }
  });
}
