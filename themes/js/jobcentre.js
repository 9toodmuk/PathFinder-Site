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
  var perpage = 10;
  var limit = $('#jobscentre').children().last().attr('id');
  if(limit == null){
    limit = 0;
  }
  $.ajax({
    url: '/job/loadmore/',
    type: 'POST',
    data: {limit: limit, perpage: perpage},
    success: function(result){
      $('#jobscentre').append(result);
    }
  });
}
