<?php
#Include the connect.php file
  include ('connect.php');
// Connect to the database
// connection String
$mysqli = new mysqli($hostname, $username, $password, $database);
/* check connection */
if (mysqli_connect_errno())
	{
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
	}
// get data and store in a json array
$query = "SELECT CustomerID, FirstName, LastName, Phone, Gender, DOB, Country, Total_Orders, Total_Value FROM main_view WHERE CustomerID=?";
$result = $mysqli->prepare($query);
$result->bind_param('i', $_POST["CustomerID"]);
$result->execute();
/* bind result variables */
$result->bind_result($CustomerID, $FirstName, $LastName, $Phone, $Gender, $DOB, $Country, $Total_Orders, $Total_Value);
/* fetch values */
while ($result->fetch())
	{
	$orders[] = array(
		'CustomerID' => $CustomerID,
		'FirstName' => $FirstName,
		'LastName' => $LastName,
		'Phone' => $Phone,
		'Gender' => $Gender,
		'DOB' => $DOB,
		'Country' => $Country,
		'Total_Orders' => $Total_Orders,
		'Total_Value' => $Total_Value
	);
	}
echo json_encode($orders);
/* close statement */
$result->close();
/* close connection */
$mysqli->close();







?>
	