<?php
#Include the connect.php file
include('connect.php');
#Connect to the database
//connection String
$connect = mysql_connect($hostname, $username, $password)
or die('Could not connect: ' . mysql_error());
//select database
mysql_select_db($database, $connect);
//Select The database
$bool = mysql_select_db($database, $connect);
if ($bool === False){
	print "can't find $database";
}
// get data and store in a json array ---- products
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
$query = "SELECT * FROM Customers";

$from = 0; 
$to = 300;
$query .= " LIMIT ".$from.",".$to;


$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$countries[] = array(
        'FirstName' => $row['FirstName'],
		'LastName' => $row['LastName'],
		'CustomerID' => $row['CustomerID'],
		'Phone' => $row['Phone']
      );
}

echo json_encode($countries);




?>