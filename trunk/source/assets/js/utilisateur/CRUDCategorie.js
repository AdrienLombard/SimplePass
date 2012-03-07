$('.modifCat').live('click', function(){
	var id = $(this).attr('data');
	$('form[data='+id+']').removeClass('disabled').find('input[type=text]').removeAttr('readonly');
})