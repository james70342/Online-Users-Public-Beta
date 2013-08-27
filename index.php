<?php
require_once("config.php");
$con = new mysqli($host,$username,$password,$database);
function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}
if($result = $con->query("SELECT * FROM server_status"))
{
	while($row = $result->fetch_assoc())
{
	$count = $row['users_online'];
}
	if (strpos($bannerURL,'.gif') !== false) 
	{
	require_once("GifFrameExtractor.php");
require_once("GifCreator.php");
$gifFilePath = $bannerURL;

if (GifFrameExtractor::isAnimatedGif($gifFilePath)) { // check this is an animated GIF

    $gfe = new GifFrameExtractor();
    $gfe->extract($gifFilePath);

	$frameImages = $gfe->getFrameImages();
	$frameDurations = $gfe->getFrameDurations();
	$gc = new GifCreator();
	$color_hi = hex2rgb($text_color);
	$gc->create($frameImages, $frameDurations, 0, $count, $font, $top, $left, $text_before, $text_after, $color_hi, $text_size, $text_rotation);
	$gifBinary = $gc->getGif();
	header('Content-Disposition: filename="banner.gif"');
	header('Content-Type: image/gif');
	echo $gifBinary;
	}
	}
	if(strpos($bannerURL, '.png') !== false)
	{
$im = imagecreatefrompng($bannerURL);
if(!$im)
{
die("");
}
$mm = hex2rgb($text_color);
$yellow = imagecolorallocate($im, $mm[0], $mm[1], $mm[2]);
$black = imagecolorallocate($im, 0, 0, 0);
$width = imagesx($im);
$height = imagesy($im);
$text = $text_before . " " . $count . " " . $text_after;
$leftTextPos = $left;
imagettftext($im, $text_size, $text_rotation, $left, $top, $yellow, $font, $text);
header("Content-Type: image/png");
imagepng($im);
imagedestroy($im);
	}
	if(strpos($bannerURL, '.jpg') !== false || strpos($bannerURL, '.jpeg') !== false)
	{
$im = imagecreatefromjpeg($bannerURL);
if(!$im)
{
die("");
}
$mm = hex2rgb($text_color);
$yellow = imagecolorallocate($im, $mm[0], $mm[1], $mm[2]);
$black = imagecolorallocate($im, 0, 0, 0);
$width = imagesx($im);
$height = imagesy($im);
$text = $text_before . " " . $count . " " . $text_after;
$leftTextPos = $left;
imagettftext($im, $text_size, $text_rotation, $left, $top, $yellow, $font, $text);
Header('Content-type: image/png');
imagejpeg($im);
imagedestroy($im);
	}
else
{
	echo "Error";
}
}
else
{
	echo "Error.";
	echo $con->error;
}
?>
