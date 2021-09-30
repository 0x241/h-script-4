<?php

error_reporting(0);

$type = $_cfg['Captcha_View']; // type of captcha
if (!$type)
	$type = 1;

$width = 100;
$height = 50;
$length = 4;
$bgcolor = array(250, 250, 250);

$cdir = 'module/captcha/default';
$fdir = 'fonts';

$numbers = '0123456789';
$bletters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$sletters = 'abcdefghijklmnopqrstuvwxyz';
$wosim = '2345678abcdehkmnpqsuvxyz'; // without similar symbols (o=0, 1=l, i=j, t=f)

//$symbols = $numbers . $bletters . $sletters;
//$symbols = $numbers . $bletters;
$symbols = $numbers;
global $code;
do 
{
	$code = '';
	for ($i = 0; $i < $length; $i++)
		$code .= $symbols{mt_rand(0, strlen($symbols) - 1)};
} while (preg_match('/cp|cb|ck|c6|c9|rn|rm|mm|co|do|cl|db|qp|qb|dp|ww/', strtolower($code)));

$form = @$_GET['f'];
unset($_SESSION['_capt'][$form]);
$_SESSION['_capt'][$form] = $code;
if (count($_SESSION['_capt']) > 10)
	array_shift($_SESSION['_capt']);
session_write_close();

global $fonts;
$fonts = array();
if ($d = opendir("$cdir/$fdir")) 
{
	while (false !== ($f = readdir($d)))
		if (($f != '.') and ($f != '..'))
			$fonts[] = "$cdir/$fdir/$f";
	closedir($d);
}

header('Cache-Control: private, no-cache="set-cookie"');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Expires: 0');
header('Pragma: no-cache');

global $image;
$image = imagecreatetruecolor($width, $height);

function GetColor(&$im, $r, $g, $b) 
{
	return imagecolorallocate($im, $r, $g, $b); 
}

function GetFont() 
{
	global $fonts;
	return $fonts[rand(0, count($fonts) - 1)];
}

function DrawText(&$im, $x, $y, $size, $text, $color = 0, $angle = 0, $font = '') 
{
	global $fonts;
	if ($font == '*') $font = GetFont();
	if (!$font) $font = $fonts[0];
	return imagettftext($im, $size, $angle, $x, $y, $color, $font, $text);
}

@include("$cdir/type$type.php");

if (function_exists("imagepng")) {
	header("Content-type: image/png");
	imagepng($image);
} elseif (function_exists("imagegif")) {
	header("Content-type: image/gif");
	imagegif($image);
} elseif (function_exists("imagejpeg")) {
	header("Content-type: image/jpeg");
	imagejpeg($image);
}
imagedestroy($image);

?>