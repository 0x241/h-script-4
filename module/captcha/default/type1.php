<?php 

# Рисуем фон
$white = GetColor($image, 255, 255, 255);
$black = GetColor($image, 0, 0, 0);
imagefill($image, 0, 0, $white);

# Рисуем строку
$font = GetFont();
$cw = 16;
$i = round(($width - $length * $cw) / 2); 
for ($j = 0; $j < $length; $j++) {
	$value = $code{$j};
	DrawText($image, $i, rand(25, 45), 28, $value, $black, 0, $font);
	$i = $i + $cw; 
} 
$center=($length - 1) * $cw;

$image2=imagecreatetruecolor($width, $height);
$foreground_color = array(mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
$background_color = $bgcolor ? $bgcolor : array(mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));
$foreground=imagecolorallocate($image2, $foreground_color[0], $foreground_color[1], $foreground_color[2]);
$background=imagecolorallocate($image2, $background_color[0], $background_color[1], $background_color[2]);
imagecolortransparent($image2, $background);
imagefill($image2, 0, 0, $background);
// periods
$rand1=mt_rand(750000,1200000)/10000000;
$rand2=mt_rand(750000,1200000)/10000000;
$rand3=mt_rand(750000,1200000)/10000000;
$rand4=mt_rand(750000,1200000)/10000000;
// phases
$rand5=mt_rand(0,31415926)/10000000;
$rand6=mt_rand(0,31415926)/10000000;
$rand7=mt_rand(0,31415926)/10000000;
$rand8=mt_rand(0,31415926)/10000000;
// amplitudes
$rand9=mt_rand(330,420)/110;
$rand10=mt_rand(330,450)/110;

//wave distortion

for($x=0;$x<$width;$x++){
	for($y=0;$y<$height;$y++){
		$sx=$x+(sin($x*$rand1+$rand5)+sin($y*$rand3+$rand6))*$rand9-$width/2+$center+1;
		$sy=$y+(sin($x*$rand2+$rand7)+sin($y*$rand4+$rand8))*$rand10;

		if($sx<0 || $sy<0 || $sx>=$width-1 || $sy>=$height-1){
			continue;
		}else{
			$color=imagecolorat($image, $sx, $sy) & 0xFF;
			$color_x=imagecolorat($image, $sx+1, $sy) & 0xFF;
			$color_y=imagecolorat($image, $sx, $sy+1) & 0xFF;
			$color_xy=imagecolorat($image, $sx+1, $sy+1) & 0xFF;
		}

		if($color==255 && $color_x==255 && $color_y==255 && $color_xy==255){
			continue;
		}else if($color==0 && $color_x==0 && $color_y==0 && $color_xy==0){
			$newred=$foreground_color[0];
			$newgreen=$foreground_color[1];
			$newblue=$foreground_color[2];
		}else{
			$frsx=$sx-floor($sx);
			$frsy=$sy-floor($sy);
			$frsx1=1-$frsx;
			$frsy1=1-$frsy;

			$newcolor=(
				$color*$frsx1*$frsy1+
				$color_x*$frsx*$frsy1+
				$color_y*$frsx1*$frsy+
				$color_xy*$frsx*$frsy);

			if($newcolor>255) $newcolor=255;
			$newcolor=$newcolor/255;
			$newcolor0=1-$newcolor;

			$newred=$newcolor0*$foreground_color[0]+$newcolor*$background_color[0];
			$newgreen=$newcolor0*$foreground_color[1]+$newcolor*$background_color[1];
			$newblue=$newcolor0*$foreground_color[2]+$newcolor*$background_color[2];
		}

		imagesetpixel($image2, $x, $y, imagecolorallocate($image2, $newred, $newgreen, $newblue));
	}
}

$image = $image2;

?>
