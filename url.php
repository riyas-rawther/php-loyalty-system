<?php
function bit_ly_short_url($url, $format='txt') {
    $login = "technetinfoin";
    $appkey = "R_51315ae9ae4e113429ad4e47ed1fc77b";
    $bitly_api = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&uri='.urlencode($url).'&format='.$format;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$bitly_api);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
?>

<html>
<head>
</head>



<body>

<?php
$long_url = "http://webgalli.com/blog/this-is-an-example-of-a-long-url";
echo bit_ly_short_url($long_url);
?>




</body>
</html>