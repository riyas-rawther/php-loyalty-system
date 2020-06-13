<?php
$con=mysqli_connect("localhost","clickpic_99oopp","99oopp00","clickpic_amoreroyalty");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
date_default_timezone_set('Asia/Dubai');
$entrydate = date('Y-m-d H:i:s');
// escape variables for security
$uid = mysqli_real_escape_string($con, $_POST['uid']);
$first_name = mysqli_real_escape_string($con, $_POST['first_name']);
$first_name = mysqli_real_escape_string($con, $_POST['first_name']);
$last_name = mysqli_real_escape_string($con, $_POST['last_name']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$dob = mysqli_real_escape_string($con, $_POST['dob']);
$city = mysqli_real_escape_string($con, $_POST['city']); // AED or USD
$sex = mysqli_real_escape_string($con, $_POST['sex']); // Converted amount (price * USD)
$subscribed = mysqli_real_escape_string($con, $_POST['subscribed']); // Converted amount (price * USD)




$sql="INSERT INTO Customers (CustomerID, FirstName, LastName, Phone, Country, Gender, DOB, DateCreated, Subscribed)
VALUES ('$uid', '$first_name', '$last_name', '$phone', '$city', '$sex', '$dob', '$entrydate', '$subscribed')";

if (!mysqli_query($con,$sql)) {
  die('Error: ' . mysqli_error($con));
}

mysqli_close($con);
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

<!DOCTYPE html>
<html>
<head></head>

<body>

<img src="<?php echo("idcard/imggenerate.php?n1=").$first_name; echo("&n2=").$uid; ?>" width="400" height="251" /> 
 <?php
//$first_name = "Riyas Rawther";
//$id = "01021611111440";
echo "<h2>Successfully added new customer into the Database. </h2> "; echo "<br />";
echo "The Registration # is "; echo '<h1>' . $uid  . '</h1>'; 

echo "The Name is "; echo '<h1>' . $first_name. '</h1>'; echo "<br />";
echo '<a href="http://amorecafe.ae/royalty/">Go the Dashboard</a>';echo "<br />";echo "<br />";
echo "SMS ID";echo "<br />";
//echo '<iframe id="sms" width="560" height="100" frameborder="0" src="'. $smsapi .'" ></iframe>';
echo "<br />";
// echo ($urlfull);
// sms
$imgurl1 = "http://amorecafe.ae/royalty/idcard/imggenerate.php?n1=";
$url2 = "&n2=";
$imgurlfull = $imgurl1.$first_name.$url2.$uid;
$sms1 = "http://api.clickatell.com/http/sendmsg?user=";
$sms2 = "riyasrawther&password=p@ssw0rd@123&api_id=3585454&to=";

$sms4 = "&text=";
$msg1 = "Dear ";
$msg2 = ", Welcome to Amore Club. Your ID is ";
$bitlyrslt = bit_ly_short_url($imgurlfull);
$smsurl = ". your card ";
$msg3 = ". For reservations please call 045584595. Thank you.";
$url2 = "&n2=";

$smsmsg = $msg1.$first_name.$msg2.$uid.$smsurl.$bitlyrslt.$msg3;
$urlstr = "http://amorecafe.ae/royalty/idcard/imggenerate.php?n1=";
$urlfull = $urlstr.$first_name.$url2.$uid;
$smsapi = $sms1.$sms2.$phone.$sms4.$smsmsg;

//echo $smsapi;
echo '<iframe id="sms" width="560" height="100" frameborder="0" src="'. $smsapi .'" ></iframe>';

?>
</body>
</html>