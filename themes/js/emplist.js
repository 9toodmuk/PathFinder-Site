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

function loadmore(){
  var div = $('div#empcentre');
  var limit = 10;
  var offset = div.children().last().attr('id');

  if(offset == null){
    offset = 0;
  }else if(offset == 1){
    more = false;
  }

  if(more){
    $.ajax({
      url: '/job/getallemp/',
      type: 'POST',
      data: {limit: limit, offset: offset},
      success: function(result){
        if(result.length){
          div.append(result);
        }else{
          more = false;
        }
      }
    });
  }
}
