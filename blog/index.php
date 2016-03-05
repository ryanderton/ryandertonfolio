<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Our Trips and Adventures!</title>

<link type="text/css" rel="stylesheet" href="../css/bootstrap.css" />
<link type="text/css" rel="stylesheet" href="../css/foliogallery.css" />
<link type="text/css" rel="stylesheet" href="../css/colorbox.css" />
<link type="text/css" rel="stylesheet" href="../css/ryanderton.css" />
<script type="text/javascript" src="../js/jquery.1.11.js"></script>
<script type="text/javascript" src="../js/jquery.colorbox-min.js"></script>
<script src="../js/bootstrap.js"></script>
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
			<a class="navbar-brand" href="http://www.ryanderton.com">Ryanderton</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="../index.php">Home</a></li>
				<li><a href="../gallery.php">Gallery</a></li>
				<li class="active"><a href="blog/index.php">Blog<span class="sr-only">(current)</span></a></li>
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
function pagnation($data0, $data, $data2, $data3){
	echo "<div class=\"pagnation\">";
		echo "<div id='newleft'>";
			if ($data0 < $data){
				echo "<span class='pages'><a href='index.php?index=" . $data2 . "'>Newer Posts</a></span>";
			}
		echo "</div>";
		echo "<div id='oldright'>";
			if ($data0 > 10){
				echo "<span class='pages'><a href='index.php?index=" . $data3 . "'>Older Posts</a></span>";
			}else{
				echo "<span class='pagesnot'>Older Posts</span>";
			}
		echo "</div>";
	echo "</div>";
}
require_once '../inc/Parsedown.php';
$images_find = array();
foreach (glob("*.md") as $filename) {
	$images_find[] = $filename;
	$count++;
}
$index = $count;
$check = $_GET['index'];
$single_page = $_GET['p'];
if (isset($single_page)){
	$index = strip_tags($_GET['p']);
}else{
	$index = $count;
}
if (isset($check)){
	$index = strip_tags($_GET['index']);
}else{
	$index = $count;
}
?>


<?php
if ($index > 20){
	$next = $index - 10;
}else{
	$next = 10;
}
if ($index < $count){
	$prev = $index + 10;
}else if($index == $count){
	$prev = $count;
}
$menu = $index;
if (!isset($single_page)){
	pagnation($menu, $count, $prev, $next);
}
if (isset($single_page)){
	echo Parsedown::instance()->text(file_get_contents($single_page . ".md"));
}else{
	$total = $index - 10;
	if ($index > 0){
		while ($index > $total){
			if (isset($images_find[$index])){
				if (file_exists($index . ".md") == "True") {
					echo Parsedown::instance()->text(file_get_contents($index . ".md"));
					echo "<div class=\"article\">Article: " . $index . "</div><br />";
				}
			}
		$index--;
		}
	}
}
if (!isset($single_page)){
	pagnation($menu, $count, $prev, $next);
}
?>

<br />
<br />

</div>

</body>
</html>
