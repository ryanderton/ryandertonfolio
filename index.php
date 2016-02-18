<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Image Gallery By FolioPages.com</title>

<link type="text/css" rel="stylesheet" href="css/bootstrap.css" />
<link type="text/css" rel="stylesheet" href="css/foliogallery.css" />
<link type="text/css" rel="stylesheet" href="css/colorbox.css" />
<link type="text/css" rel="stylesheet" href="css/ryanderton.css" />
<script type="text/javascript" src="js/jquery.1.11.js"></script>
<script type="text/javascript" src="js/jquery.colorbox-min.js"></script>
<script src="js/bootstrap.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    // initiate colorbox
	$('.albumpix').colorbox({rel:'albumpix', maxWidth:'96%', maxHeight:'96%', slideshow:true, slideshowSpeed:3500, slideshowAuto:false});
	$('.vid').colorbox({rel:'albumpix', iframe:true, width:'80%', height:'96%'});
});
</script>
</head>
<body class="full">

	<nav class="navbar navbar-inverse">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Ryanderton</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
			<ul class="nav navbar-nav navbar-right">
		<li class="active"><a href="index.php">Home<span class="sr-only">(current)</span></a></li>
				<li><a href="gallery.php">Gallery</a></li>
				<li><a href="blog/index.php">Blog</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Action</a></li>
						<li><a href="#">Another action</a></li>
						<li><a href="#">Something else here</a></li>
						<li class="divider"></li>
						<li><a href="#">Separated link</a></li>
						<li class="divider"></li>
						<li><a href="#">One more separated link</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	</nav>

<div class="container content">

	<?php

	require_once 'inc/Parsedown.php';

	$text = file_get_contents('blog/home.md');

	$Parsedown = new Parsedown();

	echo $Parsedown->text($text);

	?>

<br />
<br />

</div>

</body>
</html>
