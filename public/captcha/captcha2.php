<?php
session_start();
$string = '';
// for ($i = 0; $i < 4; $i++) $string .= chr(rand(97, 122));
$string = mt_rand(1000, 9999);
$_SESSION['captcha'] = $string;
$dir = 'fonts/';
$image = imagecreatetruecolor(165, 50);
$font = "PlAGuEdEaTH.ttf";
$color = imagecolorallocate($image, 163, 197, 82);
$dgrey = imagecolorallocate($image, 44, 44, 44);
$lgrey = imagecolorallocate($image, 136,136,136);
$white = imagecolorallocate($image, 255, 255, 255);
imagefilledrectangle($image,0,0,300,70,$dgrey); //bg
// imagettftext($image, 30, 0, 35, 40, $lgrey, $dir.$font, $_SESSION['captcha']);

header("Content-type: image/png");

imagepng($image);

?>
