<?php

$src = imagecreatefrompng(__DIR__.'/../public/logo.png');
$size = imagesx($src);

imagesavealpha($src, true);

$badgeColor = imagecolorallocate($src, 13, 148, 136); // #0d9488
$whiteColor = imagecolorallocate($src, 255, 255, 255);

$stripeHeight = (int) round($size * 0.16);
$y = $size - $stripeHeight;

imagefilledrectangle($src, 0, $y, $size, $size, $badgeColor);

$font = 'C:/Windows/Fonts/arialbd.ttf';
$text = 'ADMIN';
$fontSize = (int) round($stripeHeight * 0.5);

if (is_file($font)) {
    $box = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = abs($box[4] - $box[0]);
    $textHeight = abs($box[5] - $box[1]);
    $x = (int) round(($size - $textWidth) / 2);
    $ty = (int) round($y + $stripeHeight / 2 + $textHeight / 2);
    imagettftext($src, $fontSize, 0, $x, $ty, $whiteColor, $font, $text);
}

imagepng($src, __DIR__.'/../public/logo-admin.png');
imagedestroy($src);

echo "done\n";
