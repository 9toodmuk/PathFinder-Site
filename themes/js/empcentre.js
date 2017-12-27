$(function() {
  $(this).scrollTop(0);
  loadmore();
});

$(window).scroll(function() {
  if($(window).scrollTop() == $(document).height() - ($(window).height())) {
      loadmore();
    }
});

function loadmore(){
  var div = $('div[id^="empcentre"]');
  var id = div.attr('id').replace("empcentre","");
  var perpage = 5;
  var limit = div.children().last().attr('id');
  if(limit == null){
    limit = 0;
  }
  $.ajax({
    url: '/job/loademp/',
    type: 'POST',
    data: {id: id, limit: limit, perpage: perpage},
    success: function(result){
      div.append(result);
    }
  });
}
