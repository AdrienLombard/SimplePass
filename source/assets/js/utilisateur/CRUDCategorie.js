$("document").ready( function() {

	var newCat = true;
	var updateCat = true;
	
	$('.modifCat').live('click', function(){
		if(updateCat == true) {
			var id = $(this).attr('data');
			$('form[data='+id+']').removeClass('disabled').find('input[type=text]').removeAttr('readonly').focus();
			updateCat = false;
		}
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


$('.afficheNouvelleCatMere').live('click', function(){
	if(newCat == true){
		$('.nouvelleCatMere').show().find('input[type=text]').focus();
		newCat = false;
	}
});

$('.deleteNouvelleCatMere').live('click', function(){
	$('.nouvelleCatMere').hide();
	newCat = true;
});


$('.addCat').live('click', function(){
	if(newCat == true){
		var id = $(this).attr('data');
		$('.nouvelleSousCat[data='+id+']').show();
		newCat = false;
	}
});

$('.removeCat').live('click', function(){
	var id = $(this).attr('data');
	$('.nouvelleSousCat[data='+id+']').hide();
	newCat = true;
});


$("form").bind("submit", function(){
		
		var bool = true;
		
		$(this).find('input.required').each(function(){
			if($(this).val() == "") {
				bool = false;
				$(this).css('backgroundColor', '#F7D2E1').focus();
			}
		});
		
		return bool;
	});



/*
 * Seb
 */
	
	$(".hide").hide();
	
	$(".colorpicker").click( function(){
		$(this).next("div.picker").toggle();
	});
	
	$("div.picker span").live( "click", function() {
		var color = $(this).attr("ref");
		var id = $(this).parent().attr("colorId");
		
		$(".colorpicker[colorId="+id+"]").css("backgroundColor", "#"+color).find("input").attr('value', color);
		
		$(this).parent().toggle();
		
	});
	
	
	
})













