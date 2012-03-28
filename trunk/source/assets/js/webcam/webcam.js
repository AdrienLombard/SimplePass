$(document).ready(function(){
	
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
				image = ctx.getImageData(0, 0, 160, 204);
				pos = 0;
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
				
				$('input[name=photo_webcam]').val(canvas.toDataURL("image/png"));
				$('.photoMessage').show().text('Photo prise, enregistrez pour valider ->');
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