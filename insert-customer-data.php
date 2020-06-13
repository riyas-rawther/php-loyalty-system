<?php
$con=mysqli_connect("localhost","clickpic_99oopp","99oopp00","clickpic_amoreroyalty");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

date_default_timezone_set('Asia/Dubai');
$date = date('Y-m-d H:i:s');

$customerid = mysqli_real_escape_string($con, $_POST['customerid']);

$billedamount = mysqli_real_escape_string($con, $_POST['billedamount']);

$sql="INSERT INTO Orders (CustomerID, OrderDate, BilledAmount)
VALUES ('$customerid', '$date', '$billedamount')";

if (!mysqli_query($con,$sql)) {
  die('Error: ' . mysqli_error($con));
}
echo "1 record added"; echo "<br />";
echo "Customer ID ";echo $customerid;
echo "<br />";
echo "Dated "; echo $date;
echo "<br />";
echo "Amount "; echo $billedamount; 
header('Location: http://amorecafe.ae/royalty/');
exit;
//echo $_POST["color_value"];

mysqli_close($con);
?>