<?php 

# Рисуем фон
if (!$bgcolor) $bgcolor = array(rand(230, 255), rand(230, 255), rand(230, 255));
$white = GetColor($image, $bgcolor[0], $bgcolor[1], $bgcolor[2]);
$black = GetColor($image, 0, 0, 0);
imagecolortransparent($image, $white);
imagefill($image, 0, 0, $white);

# Рисуем строку
$font = GetFont();
$cw = 20;
$i = round(($width - $length * $cw) / 2); 
for ($j = 0; $j < $length; $j++) {
	$value = $code{$j};
	$y = rand(25, 45);
	$a = rand(-30, 30);
	DrawText($image, $i + 1, $y + 1, 30, $value, $black, $a, $font);
	DrawText($image, $i, $y, 30, $value, $white, $a, $font);
	$i = $i + $cw; 
} 

?>
