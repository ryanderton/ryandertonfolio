<?php

error_reporting(E_ALL);

// Some stuff for generating stats
function file_size($size)
{
	$units = array('b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb', 'Eb');

	for ($i = 0; $size > 1024; $i++)
		$size /= 1024;

	return round($size, 2).' '.$units[$i];
}

function get_microtime($microtime=false)
{
	if ($microtime === false)
		$microtime = microtime();

	list($usec, $sec) = explode(' ', $microtime);
	return ((float)$usec + (float)$sec);
}

$start_timer = microtime();

// Include class
require 'inc/imgbrowz0r.php';

// These are all settings (set to default). The settings are not validated since you have to configure everything.
// There is a chance that ImgBrowz0r stops working if you enter the wrong values.
$config = array(
	// Directory settings. These are required. Without trailing slash. (required)
	'images_dir'               => dirname(__FILE__).'/gallery',
	'cache_dir'                => dirname(__FILE__).'/cache',

	// Url settings. These are required. Without trailing slash. (required)
	// %PATH% is replaced with the directory location and page number
	'main_url'                 => 'http://ryanderton.com/gallery.php?q=%PATH%',
	'images_url'               => 'http://ryanderton.com/gallery',
	'cache_url'                => 'http://ryanderton.com/cache',

	// Sorting settings (optional)
	'dir_sort_by'              => 3, // 1 = filename, 2 = extension (dir), 3 = inode change time of file
	'img_sort_by'              => 3, // 1 = filename, 2 = extension (png, gif, etc.), 3 = inode change time of file or EXIF image data (Date Taken)

	// The sort order settings can have the following values:
	// SORT_ASC, SORT_DESC, SORT_REGULAR, SORT_NUMERIC, SORT_STRING
	// SORT_ASC = ascending, SORT_DESC = descending
	'dir_sort_order'           => SORT_DESC,
	'img_sort_order'           => SORT_DESC,

	// Thumbnail settings (optional)
	'thumbs_per_page'          => 12, // Amount of thumbnails per page
	'max_thumb_row'            => 4, // Amount of thumbnails on a row
	'max_thumb_width'          => 200, // Maximum width of thumbnail
	'max_thumb_height'         => 200, // Maximum height of thumbnail

	// Crop mode cuts out a random part of an image and uses it for the thumbnail
	'crop_mode'                => true,

	// Resize the image before cropping by 2.5. If the image mustn't be resized
	// the value can be set to 1.
	'crop_resize_factor'       => 2.5,

	// Date formatting. Look at the PHP date() for help: http://php.net/manual/en/function.date.php
	'time_format'              => 'F jS, Y',

	// Pick a valid timezone from http://en.wikipedia.org/wiki/List_of_tz_database_time_zones
	// Use `false` to disable the timezone option
	'time_zone'                => 'Canada/Pacific',

	// Daylight saving time (DST). Set this to true to enable it.
	'enable_dst'               => false,

	// Misc settings (optional)
	'ignore_port'              => false, // Ignore port in url. Set this to true to ignore the port.
	'dir_thumbs'               => true, // Show a thumbnail in a category box. Default is false.
	'random_thumbs'            => false, // Use random thumbnails for categories. Default is false.
	                                     // NOTE: random_thumbs will not work when the cache is enabled.
	'read_thumb_limit'         => 0 // See README for information about this setting.
	);

// Setup cache
$gallery_cache = new ImgBrowz0rCache(
	$config['cache_dir'], // The location of the cache directory. In this case the smae as imgBrowz0r's one.
	3600 // The amount of seconds the cache is valid.
);

// Start the class
$gallery = new ImgBrowz0r($config, $gallery_cache);

/* The cache is optional. If you don't want to use the cache you can remove
the "Setup cache" part and replace this:

    $gallery = new ImgBrowz0r($config, $gallery_cache);

With:

    $gallery = new ImgBrowz0r($config);

*/

// XHTML stuff
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
	
	
    <!-- Custom CSS -->
    <link href="css/test.css" rel="stylesheet">	
	<link href="css/lightbox.css" rel="stylesheet">	
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  
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
		<li><a href="index.php">Home</a></li>
        <li class="active"><a href="gallery.php">Gallery<span class="sr-only">(current)</span></a></li>
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

// Prepare everything. This function must be called before
// you call other functions. (required)
$gallery->init();

// Generate navigation and statistics. (optional, but remommended)
// The output of the functions are now assigned to variabled, but
// you can also call the functions directly.
$gallery_breadcrumbs = $gallery->breadcrumbs();
$gallery_pagination = $gallery->pagination();
$gallery_statistics = $gallery->statistics();

// Display description of the current directory. (optional)
echo $gallery->description();

// Display navigation
echo '<div class="imgbrowz0r-navigation">', "\n\t",
     $gallery_breadcrumbs, "\n\t",
	 $gallery_pagination, "\n\t",
//	 $gallery_statistics, "\n", 
	'</div>', "\n\n";

// Display images and directories. (required)
echo $gallery->browse();

// Display navigation
echo '<div class="imgbrowz0r-navigation">', "\n\t",
     $gallery_pagination, "\n\t",
	 $gallery_breadcrumbs, "\n", '</div>', "\n\n";

// Showing some stats (optional)
echo '<p>Processing time: ', round(get_microtime(microtime()) - get_microtime($start_timer), 5),
	' &amp;&amp; Memory usage: ', file_size(memory_get_usage()),
	' &amp;&amp; Memory peak: ', file_size(memory_get_peak_usage()), '</p>';

?>

<!--

<video poster="img/saxepoint.jpg" autoplay="true" muted>
	<source src="video/1saxe.mp4" type="video/mp4">
	<source src="video/1saxe.webm" type="video/webm">
</video>

-->

	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>
	<script src="js/lightbox.js"></script>
	
  </body>
</html>