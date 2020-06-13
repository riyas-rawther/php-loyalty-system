<?php
// Print two names on the picture, which accepted by query string parameters.

$n1 = $_GET['n1']; // First Name
$n2 = $_GET['n2']; // ID

Header ("Content-type: image/jpeg");
$image = imageCreateFromJPEG("../images/amore-club-front.jpg");
$color = ImageColorAllocate($image, 51, 51, 51);

// Calculate horizontal alignment for the names.
$BoundingBox1 = imagettfbbox(13, 0, '../fonts/MYRIADPRO-REGULAR.OTF', $n1);
$boyX = ceil((125 - $BoundingBox1[2]) / 2); // lower left X coordinate for text
$BoundingBox2 = imagettfbbox(13, 0, '../fonts/MYRIADPRO-REGULAR.OTF', $n2);
$girlX = ceil((107 - $BoundingBox2[2]) / 2); // lower left X coordinate for text

// Write names.
imagettftext($image, 30, 0, $boyX+75, 600, $color, '../fonts/MYRIADPRO-REGULAR.OTF', $n1);
imagettftext($image, 30, 0, $girlX+650, 600, $color, '../fonts/MYRIADPRO-REGULAR.OTF', $n2);

// Return output.
ImageJPEG($image, NULL, 93);
ImageDestroy($image);


?>