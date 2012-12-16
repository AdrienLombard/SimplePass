<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $titre; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>" />
		
		<?php foreach($css as $url): ?>
			<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $url; ?>" />
		<?php endforeach; ?>
		
		<?php foreach($js as $url): ?>
			<script type="text/javascript" src="<?php echo $url; ?>"></script> 
		<?php endforeach; ?>
		
		<?php if(isset($redirect[1])) header('Refresh: '.$redirect[1].';Url='.site_url($redirect[0])); ?>
	</head>
	
	<body>
		<header id="banniere" >
			Titre du site
		</header>
		
		<div id="content">

			<?php echo $output; ?>
		
		</div>
		
		<footer>
			Design and Code par Pampa22. 
		</footer>
	</body>


</html>



