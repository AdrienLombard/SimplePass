$(document).ready(function(){
	
	/*
	 * Init webcam
	 */
	var pos = new Array();
	var ctx = new Array();
	var image = new Array();
	var canvas = new Array();
	
	/*
	 * Nouveau canvas
	 */
	$('.ajoutMembrePlop&NomAModifier').live('click', function(){
		
		var id = 1;
		
		pos[id] = 0;
		ctx[id] = null;
		image[id] = null;
		canvas[id] = document.getElementById("canvas");
		if (canvas[id].getContext) {
			ctx = document.getElementById("canvas").getContext("2d");
			ctx.clearRect(0, 0, 160, 204);

			var img = new Image();
			image = ctx.getImageData(0, 0, 160, 204);
		}
		
	});
	

	/*
	 * Affiche la webcam
	 */
	$('.startWebcam').live('click', function(){
		
		var id = $(this).attr('data');
		
		$('.webcamWrapper[data=' + id + ']').show('fast');
		$('.webcam[data=' + id + ']').html('').webcam({
			
			height: 204,
			width: 272,
			mode: "callback",
			swffile: "http://localhost/courchevel_src/assets/flash/jscam_canvas_only.swf",
			
			onCapture: function() {
				
				$('.webcamWrapper[data=' + id + ']').hide('fast');
				image[id] = ctx[id].getImageData(0, 0, 160, 204);
				pos[id] = 0;
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
					pos[id] += 4;
				}

				if (pos[id] >= 4 * 160 * 204) {
					ctx[id].putImageData(img, 0, 0);
					pos[id] = 0;
				}
				
				$('input[name=photo_webcam][data=' + id + ']').val(canvas[id].toDataURL("image/png"));
				$('.photoMessage[data=' + id + ']').show().text('Photo prise, enregistrez pour valider ->');
			}
			
		});
		
	});
	
	$('.captureCam').live('click', function(){
		var id = $(this).attr('data');
		webcam.capture();
	})
	$('.closeCam').live('click', function(){
		var id = $(this).attr('data');
		$('.webcamWrapper[data=' + id + ']').hide('fast');
	});
	
});