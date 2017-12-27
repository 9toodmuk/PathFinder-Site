function addfavjob(element){
	var id = $(element).attr("id");
	var button = $(element);
	$.ajax({
		url: '/job/save/',
		type: 'POST',
		data: {id: id},
		dataType: 'json',
		success: function (result) {
			if(result.success){
				if(result.add){
					button.addClass('active');
				}else{
					button.removeClass('active');
				}
			}
		}
	});
}

$(function(){
	var url = window.location;

	var element = $('ul.nav a').filter(function() {
			return this.href == url;
	}).parent().addClass('active');
});

function updateNotification(id){
	$.ajax({
		url: '/utilities/notifications/',
		type: 'POST',
		data: {id: id},
		success: function (result) {
			updateBadge(id);
			updateDiv(result);
		}
	});
}

function updateDiv(result){
	$('ul#notification').html(result);
}

function updateBadge(id){
	$.ajax({
		url: '/utilities/noticount/',
		type: 'POST',
		data: {id: id},
		success: function (result) {
			if(result > 0){
				$('span#notinums').html(result);
			}else{
				$('span#notinums').html('');
			}
		}
	});
}

function markread(element) {
	var id = $(element).attr('id');
	$.ajax({
		url: '/utilities/markread/',
		type: 'POST',
		data: {id: id}
	});
}
