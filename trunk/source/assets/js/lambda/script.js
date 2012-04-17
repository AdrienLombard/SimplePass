
function change_link_lambda() {
    var idGroupe = $("select[name='evenement'] option:selected").val();
    var cate = $("select[name='categorie']").find('option:selected').val();
    var base = $("#baseURL").val();

    if(cate == 0) {
        $('#lienLambda').attr('href', base+'index.php/inscription/ajouter/'+idGroupe);
        $('#lienEquipe').attr('href', base+'index.php/inscription/groupe/'+idGroupe);
    }
    else {
        $('#lienLambda').attr('href', base+'index.php/presse/ajouter/'+idGroupe+'/'+cate);
        $('#lienEquipe').attr('href', base+'index.php/presse/groupe/'+idGroupe+'/'+cate);
    }
}


$(document).ready(function(){


    /**
     * Changement dynamique des liens pour le point d'accés web.
     */
	$('#evenement').change(function() {
		change_link_lambda();
	});

    $('#categorie').change( function() {
        change_link_lambda();
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
	 * Init webcam
	 */
	var pos = 0;
	var ctx = null;
	var image = null;
	var canvas = document.getElementById("canvas");
	if (canvas.getContext) {
		ctx = document.getElementById("canvas").getContext("2d");
		ctx.clearRect(0, 0, 160, 204);

		var img = new Image();
		image = ctx.getImageData(0, 0, 160, 204);
	}
	
	/*
	 * Affiche la webcam
	 */
	$('.startWebcam').live('click', function(){
		$('.webcamWrapper').show('fast');
		$('.webcam').html('').webcam({
			
			height: 204,
			width: 272,
			mode: "callback",
			swffile: "http://localhost/courchevel_src/assets/flash/jscam_canvas_only.swf",
			
			onCapture: function() {
				
				$('.webcamWrapper').hide('fast');			
				webcam.save();
			},
			
			onSave: function(data) {
				
				var col = data.split(";");
				var img = image;

				for(var i = 80; i < 240; i++) {
					var tmp = parseInt(col[i]);
					img.data[pos + 0] = (tmp >> 16) & 0xff;
					img.data[pos + 1] = (tmp >> 8) & 0xff;
					img.data[pos + 2] = tmp & 0xff;
					img.data[pos + 3] = 0xff;
					pos+= 4;
				}

				if (pos >= 4 * 160 * 204) {
					ctx.putImageData(img, 0, 0);
					pos = 0;
				}
				
				var lang = $('#lang').val();
				
				$('input[name=photo_webcam]').val(canvas.toDataURL("image/png"));
				if(lang == 'fra')
					$('.photoMessage').show().text('Photo prise, enregistrez pour valider ->');
				else
					$('.photoMessage').show().text('Photo taken, save to validate ->');
			}
			
		});
		
	});
	
	$('.captureCam').live('click', function(){
		webcam.capture();
	})
	$('.closeCam').live('click', function(){
		$('.webcamWrapper').hide('fast');
	});
	
});