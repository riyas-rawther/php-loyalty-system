<?php
// Include the connect.php file
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
if (isset($_GET['customerid']))
	{
	$pagenum = $_GET['pagenum'];
	$pagesize = $_GET['pagesize'];
	$customerid = $_GET['customerid'];
	$start = $pagenum * $pagesize;
	$query = "SELECT SQL_CALC_FOUND_ROWS OrderID, OrderDate, BilledAmount FROM Orders WHERE CustomerID=? LIMIT ?,?";
	if (isset($_GET['sortdatafield']))
		{
		$sortfields = array(
			"OrderID",
			"OrderDate",
			"BilledAmount"
		);
		$sortfield = $_GET['sortdatafield'];
		$sortorder = $_GET['sortorder'];
		if (($sortfield != NULL) && (in_array($sortfield, $sortfields)))
			{
			if ($sortorder == "desc")
				{
				$query = "SELECT SQL_CALC_FOUND_ROWS OrderID, OrderDate, BilledAmount FROM Orders WHERE CustomerID=? ORDER BY " . $sortfield . " DESC LIMIT ?,?";
				}
			  else if ($sortorder == "asc")
				{
				$query = "SELECT SQL_CALC_FOUND_ROWS OrderID, OrderDate, BilledAmount FROM Orders WHERE CustomerID=? ORDER BY " . $sortfield . " ASC LIMIT ?,?";
				}
			}
		}
	$result = $mysqli->prepare($query);
	$result->bind_param('sii', $customerid, $start, $pagesize);
	$result->execute();
	/* bind result variables */
	$result->bind_result($OrderID,$OrderDate,$BilledAmount);
	/* fetch values */
	while ($result->fetch())
		{
		$orders[] = array(
			'OrderID' => $OrderID,
			'OrderDate' => $OrderDate,
			'BilledAmount' => $BilledAmount
		);
		}
	$result = $mysqli->prepare("SELECT FOUND_ROWS()");
	$result->execute();
	$result->bind_result($total_rows);
	$result->fetch();
	$data[] = array(
		'TotalRows' => $total_rows,
		'Rows' => $orders
	);
	echo json_encode($data);
	}
  else
	{
	////
	
	
	$pagenum = $_GET['pagenum'];
$pagesize = $_GET['pagesize'];
$start = $pagenum * $pagesize;
$query = "SELECT SQL_CALC_FOUND_ROWS CustomerID, FirstName, LastName, Phone, Gender, DOB, Country, Total_Orders, Total_Value, days_till_bday FROM main_view LIMIT ?, ?";
$result = $mysqli->prepare($query);
$result->bind_param('ii', $start, $pagesize);
// add new row
if (isset($_GET['insert']))
	{
	// INSERT COMMAND
	$query = "INSERT INTO `Orders`(`BilledAmount`) VALUES (1)";
	$result = $mysqli->prepare($query);
	//$result->bind_param('s', $_GET['OrderID'], $_GET['OrderDate'], $_GET['BilledAmount']);
	//$res = $result->execute() or trigger_error($result->error, E_USER_ERROR);
	 printf ("New Record has id %d.\n", $mysqli->insert_id);
	echo $res;
	}
//


$filterquery = "";
// filter data.
if (isset($_GET['filterscount']))
	{
	$filterscount = $_GET['filterscount'];
	if ($filterscount > 0)
		{
		$where = " WHERE (";
		$tmpdatafield = "";
		$tmpfilteroperator = "";
		$valuesPrep = "";
		$value = [];
		for ($i = 0; $i < $filterscount; $i++)
			{
			// get the filter's value.
			$filtervalue = $_GET["filtervalue" . $i];
			// get the filter's condition.
			$filtercondition = $_GET["filtercondition" . $i];
			// get the filter's column.
			$filterdatafield = $_GET["filterdatafield" . $i];
			// get the filter's operator.
			$filteroperator = $_GET["filteroperator" . $i];
			if ($tmpdatafield == "")
				{
				$tmpdatafield = $filterdatafield;
				}
			  else if ($tmpdatafield <> $filterdatafield)
				{
				$where.= ") AND (";
				}
			  else if ($tmpdatafield == $filterdatafield)
				{
				if ($tmpfilteroperator == 0)
					{
					$where.= " AND ";
					}
				  else $where.= " OR ";
				}
			// build the "WHERE" clause depending on the filter's condition, value and datafield.
			switch ($filtercondition)
				{
			case "CONTAINS":
				$condition = " LIKE ";
				$value[0][$i] = "%{$filtervalue}%";
				$values[] = & $value[0][$i];
				break;

			case "DOES_NOT_CONTAIN":
				$condition = " NOT LIKE ";
				$value[1][$i] = "%{$filtervalue}%";
				$values[] = & $value[1][$i];
				break;

			case "EQUAL":
				$condition = " = ";
				$value[2][$i] = $filtervalue;
				$values[] = & $value[2][$i];
				break;

			case "NOT_EQUAL":
				$condition = " <> ";
				$value[3][$i] = $filtervalue;
				$values[] = & $value[3][$i];
				break;

			case "GREATER_THAN":
				$condition = " > ";
				$value[4][$i] = $filtervalue;
				$values[] = & $value[4][$i];
				break;

			case "LESS_THAN":
				$condition = " < ";
				$value[5][$i] = $filtervalue;
				$values[] = & $value[5][$i];
				break;

			case "GREATER_THAN_OR_EQUAL":
				$condition = " >= ";
				$value[6][$i] = $filtervalue;
				$values[] = & $value[6][$i];
				break;

			case "LESS_THAN_OR_EQUAL":
				$condition = " <= ";
				$value[7][$i] = $filtervalue;
				$values[] = & $value[7][$i];
				break;

			case "STARTS_WITH":
				$condition = " LIKE ";
				$value[8][$i] = "{$filtervalue}%";
				$values[] = & $value[8][$i];
				break;

			case "ENDS_WITH":
				$condition = " LIKE ";
				$value[9][$i] = "%{$filtervalue}";
				$values[] = & $value[9][$i];
				break;

			case "NULL":
				$condition = " IS NULL ";
				$value[10][$i] = "%{$filtervalue}%";
				$values[] = & $value[10][$i];
				break;

			case "NOT_NULL":
				$condition = " IS NOT NULL ";
				$value[11][$i] = "%{$filtervalue}%";
				$values[] = & $value[11][$i];
				break;
				}
			$where.= " " . $filterdatafield . $condition . "? ";
			$valuesPrep = $valuesPrep . "s";
			if ($i == $filterscount - 1)
				{
				$where.= ")";
				}
			$tmpfilteroperator = $filteroperator;
			$tmpdatafield = $filterdatafield;
			}
		$filterquery.= "SELECT SQL_CALC_FOUND_ROWS CustomerID, FirstName, LastName, Phone, Gender, DOB, Country, Total_Orders, Total_Value, days_till_bday FROM main_view" . $where;
		// build the query.
		$valuesPrep = $valuesPrep . "ii";
		$values[] = & $start;
		$values[] = & $pagesize;
		$query = "SELECT SQL_CALC_FOUND_ROWS CustomerID, FirstName, LastName, Phone, Gender, DOB, Country, Total_Orders, Total_Value, days_till_bday FROM main_view" . $where . " LIMIT ?, ?";
		$result = $mysqli->prepare($query);
		call_user_func_array(array(
			$result,
			"bind_param"
		) , array_merge(array(
			$valuesPrep
		) , $values));
		}
	}
if (isset($_GET['sortdatafield']))
	{
	$sortfield = $_GET['sortdatafield'];
	$sortorder = $_GET['sortorder'];
	if ($sortorder != '')
		{
		if ($_GET['filterscount'] == 0)
			{
			if ($sortorder == "desc")
				{
				$query = "SELECT SQL_CALC_FOUND_ROWS CustomerID, FirstName, LastName, Phone, Gender, DOB, Country, Total_Orders, Total_Value, days_till_bday FROM main_view ORDER BY" . " " . $sortfield . " DESC LIMIT ?, ?";
				}
			  else if ($sortorder == "asc")
				{
				$query = "SELECT SQL_CALC_FOUND_ROWS CustomerID, FirstName, LastName, Phone, Gender, DOB, Country, Total_Orders, Total_Value, days_till_bday FROM main_view ORDER BY" . " " . $sortfield . " ASC LIMIT ?, ?";
				}
			$result = $mysqli->prepare($query);
			$result->bind_param('ii', $start, $pagesize);
			}
		  else
			{
			if ($sortorder == "desc")
				{
				$filterquery.= " ORDER BY " . $sortfield . " DESC LIMIT ?, ?";
				}
			  else if ($sortorder == "asc")
				{
				$filterquery.= " ORDER BY " . $sortfield . " ASC LIMIT ?, ?";
				}
			// build the query.
			$query = $filterquery;
			$result = $mysqli->prepare($query);
			call_user_func_array(array(
				$result,
				"bind_param"
			) , array_merge(array(
				$valuesPrep
			) , $values));
			}
		}
	}
$result->execute();
/* bind result variables */
$result->bind_result($CustomerID, $FirstName, $LastName, $Phone, $Gender, $DOB, $Country, $Total_Orders, $Total_Value, $days_till_bday);
/* fetch values */
$orders = null;
// get data and store in a json array
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
		'Total_Value' => $Total_Value,
		'days_till_bday' => $days_till_bday,
	);
	}
$result = $mysqli->prepare("SELECT FOUND_ROWS()");
$result->execute();
$result->bind_result($total_rows);
$result->fetch();
if ($new_total_rows > 0) $total_rows = $new_total_rows;
$data[] = array(
	'TotalRows' => $total_rows,
	'Rows' => $orders
);
echo json_encode($data);
}
/* close statement */
$result->close();
/* close connection */
$mysqli->close();
?>
	
	