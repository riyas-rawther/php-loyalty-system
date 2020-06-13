<?php

require_once("qrphp/qrcode.php");

$qr = QRCode::getMinimumQRCode("QR???", QR_ERROR_CORRECT_LEVEL_L);

// ??????(??:???,????)
$im = $qr->createImage(2, 4);



header("Content-type: image/gif");
//imagegif($im);

//imagedestroy($im);

$imgData = imagegif($im);

?>

<html>
<body>

<p>If a browser cannot find an image, it will display the alternate text:</p>

<img src="<?=$imgData ?>" alt="HTML5 Icon" style="width:128px;height:128px;">

</body>
</html>