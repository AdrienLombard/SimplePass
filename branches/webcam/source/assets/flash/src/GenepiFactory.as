package 
{
	import flash.display.Bitmap;
	import flash.display.BitmapData;
	import flash.events.Event;
	import flash.events.MouseEvent;
	import flash.events.ProgressEvent;
	import flash.media.Camera;
	import flash.media.Video;
	import flash.net.FileFilter;
	import flash.net.FileReference;
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	import flash.net.URLRequestMethod;
	import flash.net.URLRequestHeader;
	import flash.net.URLLoaderDataFormat
	import flash.utils.ByteArray;
	
	
	/*
	 * GenepiFactory : module webcam de l'application courchevel [Made in Savoy] !
	 */
	
	public class GenepiFactory
	{
		
		private const REMOTE_URL:String = "http://localhost/courchevel_src/index.php/accreditation/upload";
		
		private var video:Video;
		private var camera:Camera;
		private var photo:BitmapData;
		private var byte:ByteArray;
		
		
		/*
		 * Affiche la webcam
		 */
		public function webcam():void {
			
			// démarrage des médias
			this.video = new Video();
			this.camera = Camera.getCamera();
			
			// paramètrage
			this.camera.setMode(640, 480, 30);
			this.video.attachCamera(this.camera);
			
			// listeners
			addEventListener(MouseEvent.CLICK, snapshot);
			
			// affichage dans flash
			addChild(this.video);
			
		}
		
		
		/*
		 * Prend une photo du flux video
		 */
		public function snapshot(Event e):void {
			
			// capture du flux video
			this.photo = new BitmapData(this.camera.width, this.camera.height);
			photo.draw(this.video);
			
			// encore en jpg
			this.byte = new JPGEncoder(100).encode(this.photo);
			
			// affichage
			addChild(this.photo);

		}
		 
		
		/*
		 * Upload un fichier vers URL_SERVER
		 */
		public function upload():void {
			
			// préparation de la requete
			var request:URLRequest = new URLRequest(this.REMOTE_URL);
			request.method = URLRequestMethod.POST;
			request.data = UploadPostHelper.getPostData('image.jpg', this.byte);
			request.requestHeaders.push( new URLRequestHeader( 'Cache-Control', 'no-cache' ) );
			
			// envoie de la requete
			var loader:URLLoader = new URLLoader();
			loader.dataFormat = URLLoaderDataFormat.BINARY;
			loader.load(request);
			
		}
		
	}
	
}