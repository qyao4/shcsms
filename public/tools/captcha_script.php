<?php
session_start();

// Generate a random CAPTCHA string
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$randomString = '';
for ($i = 0; $i < 6; $i++) {
    $randomString .= $characters[rand(0, strlen($characters) - 1)];
}

// Store the CAPTCHA in session
$_SESSION['captcha'] = $randomString;

// Create an image
$image = imagecreatetruecolor(120, 50);

// Define colors
// $bgColor = imagecolorallocate($image, 255, 255, 255); // White background
$bgColor = imagecolorallocate($image, 173, 216, 230); // Light Blue
$textColor = imagecolorallocate($image, 0, 0, 0); // Black text

// Fill background
imagefilledrectangle($image, 0, 0, 200, 50, $bgColor);

// Draw the random string on the image
//imagettftext($image, 20, 0, 10, 40, $textColor, 'Roboto_Mono/RobotoMono-Italic-VariableFont_wght.ttf', $randomString);
imagettftext($image, 20, 0, 10, 40, $textColor, __DIR__.'/../fonts/Open_Sans/OpenSans-Italic-VariableFont_wdth,wght.ttf', $randomString);

// Output the image
header('Content-Type: image/png');
imagepng($image);

// Clean up resources
imagedestroy($image);
?>
