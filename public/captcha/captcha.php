<?php
$width = 300;
$height = 120;
$font_size = 24;
$codelengh = 4;
$font = "fonts/PlAGuEdEaTH.ttf";

$letters = array(0,1,2,3,4,5,6,7,8,9);

$image = imagecreatetruecolor($width,$height);
$bg = imagecolorallocate($image,44,44,44);
imagefill($image,0,0,$bg);

for($i=0;$i<$codelengh;$i++):
   $color = imagecolorallocate($image,144,144,144);
   $letter = $letters[rand(0,sizeof($letters)-1)];
   $size = rand($font_size*2-2,$font_size*2+2);
   $x = ($i+4)*$font_size + rand(2,5);
   $y = (($height*2)/3) + rand(2,10);
   $code[] = $letter;
   imagettftext($image,$size,rand(-15,15),$x,$y,$color,$font,$letter);
endfor;

$code = implode("",$code);
$_SESSION['captcha_code'] = $code;
header("Content-type: image/gif");
imagegif($image);
