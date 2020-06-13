<?php
 include('phpqrcode-master/qrlib.php'); 
     
    // outputs image directly into browser, as PNG stream 
$imageqr =  QRcode::png('PHP QR Code :)');
	

//$n1 = $_GET['n1'];
//$n2 = $_GET['n2'];
$n1 = "Test";
$n2 = "Shafna";

$image = imageCreateFromJPEG("http://amorecafe.ae/royalty/images/amore-club-front.jpg");

Header ("Content-type: image/jpeg");


$color = ImageColorAllocate($image, 255, 255, 255);

// Calculate horizontal alignment for the names.
$BoundingBox1 = imagettfbbox(13, 0, 'fonts/MYRIADPRO-REGULAR.OTF', $n1);
$boyX = ceil((125 - $BoundingBox1[2]) / 2); // lower left X coordinate for text
$BoundingBox2 = imagettfbbox(13, 0, 'fonts/MYRIADPRO-REGULAR.OTF', $n2);
$girlX = ceil((107 - $BoundingBox2[2]) / 2); // lower left X coordinate for text

// Write names.
imagettftext($image, 35, 0, $boyX+100, 550, $color, 'fonts/MYRIADPRO-REGULAR.OTF', $n1);
imagettftext($image, 40, 0, $girlX+700, 550, $color, 'fonts/MYRIADPRO-REGULAR.OTF', $n2);

// Return output.
ImageJPEG($image, NULL, 93);
ImageDestroy($image);
?>