	

$(document).ready(function(){
	
	$('#evenement').change(function() {
		var idGroupe = $("select[name='evenement'] option:selected").val();

		$('#lienLambda').attr('href', 'http://localhost/courchevel_src/index.php/inscription/ajouter/'+idGroupe);
		
		$('#lienEquipe').attr('href', 'http://localhost/courchevel_src/index.php/inscription/groupe/'+idGroupe);
	});
	
	//$("input[name=fonction]").hide();
	$("input.choixFonction").change(function() {
		$("input[name=fonction]").toggle();
		
	});
	
	/*
	 * upload fichier
	 */
	$('#photo_file').css('opacity', 0).css('position', 'absolute');
	$('.uploadFichier').live('click', function(){
		$('#photo_file').trigger('click');
	})
	
	
	/*
	 * Crop d'image
	 */
	$('.cropper img').Jcrop({
		onChange:		changeCoords,
		aspectRatio:	160 / 240,
		minSize:		[160, 204],
		setSelect:		[10, 10, 160, 204]
	});
	function changeCoords(c) {
		$('input[name=x]').val(c.x);
		$('input[name=y]').val(c.y);
		$('input[name=w]').val(c.w);
		$('input[name=h]').val(c.h);
	}
	
	
	/*
	 * Affiche la webcam
	 */
	$('.startWebcam').live('click', function(){
		
		$('.webcam').show();
		$('.webcam').webcam({
			height: 195,
			width: 260,
			mode: "callback",
			swffile: "http://localhost/courchevel_src/assets/flash/jscam_canvas_only.swf",
			onTick: function() {},
			onSave: function() {},
			onCapture: function() {},
			debug: function() {},
			onLoad: function() {}
		});
		
	});	
	
});