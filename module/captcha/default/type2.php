<?php 

# Рисуем фон
if (!$bgcolor) $bgcolor = array(rand(230, 255), rand(230, 255), rand(230, 255));
$background = GetColor($image, $bgcolor[0], $bgcolor[1], $bgcolor[2]);
imagecolortransparent($image, $background);
imagefill($image, 0, 0, $background);

# Рисуем "шахматную" доску 
$cube_sd = rand(8, 24); # размер грани квадратика

$q = 0; 
while($q <= $height / $cube_sd) { 
	$i = 0; 

	while($i <= $width) { 
		if(fmod($q, 2)) {    
			$cube_side = rand(4, $cube_sd * 2); # Размер стороны квадратика
			$color = GetColor($image, rand(150, 255), rand(150, 255), rand(150, 255)); 
			imagefilledrectangle ($image, $i*2+$cube_side, $q*$cube_side, $i*2+$cube_side*2, $q*$cube_side+$cube_side, $color ); 
		} else {
			$cube_side = rand(4, $cube_sd * 2); # Размер стороны квадратика
			$color = GetColor($image, rand(150, 255), rand(150, 255), rand(150, 255)); 
			imagefilledrectangle ($image, $i*2, $q*$cube_side, $i*2+$cube_side, $q*$cube_side+$cube_side, $color ); 
		}

	$i = $i + $cube_side; 
	} 

	$q++; 
} 

# Рисуем строку 
$cw = 20;
$i = round(($width - $length * $cw) / 2); 
for ($j = 0; $j < $length; $j++) {
	$value = $code{$j};
	$str_color = GetColor($image, rand(50, 150), rand(50, 150), rand(50, 150));
	DrawText($image, $i, rand(25, 45), rand(20, 30), $value, $str_color, rand(-30, 30), '*');
	$i = $i + $cw + rand(-5, 5); 
} 

?>