$("document").ready( function() {

	$('.modifCat').live('click', function(){
		var id = $(this).attr('data');
		$('form[data='+id+']').removeClass('disabled').find('input[type=text]').focus().removeAttr('readonly');
	});

/*
$('.categorieAllInOne form').live("blur", function(){
	var init = $(this).attr("init");
	if(init == $(this).val())
		$(this).attr('readonly', 'readonly').removeClass('error').parent().addClass('disabled');
	else
		$(this).addClass('error');
});
*/

/*
 * Aymeric
 */




/*
 * Seb
 */
	
	$(".hide").hide();
	
	$(".colorpicker").click( function(){
		$(this).find("div.picker").toggle();
	});
	
	$("div.picker").children().live( "click", function() {
		var color = $(this).attr("ref");
		
		$(".colorpicker[data="+id+"]").css("background", color).find("input").attr("value", color)
		
	});
	
	
	
})













