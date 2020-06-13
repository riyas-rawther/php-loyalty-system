data and index.php

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
$query = "SELECT SQL_CALC_FOUND_ROWS CustomerID, FirstName, LastName, Phone, Gender, Country FROM Customers LIMIT ?, ?";
$result = $mysqli->prepare($query);
$result->bind_param('ii', $start, $pagesize);
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
		$filterquery.= "SELECT SQL_CALC_FOUND_ROWS CustomerID, FirstName, LastName, Phone, Gender, Country FROM Customers" . $where;
		// build the query.
		$valuesPrep = $valuesPrep . "ii";
		$values[] = & $start;
		$values[] = & $pagesize;
		$query = "SELECT SQL_CALC_FOUND_ROWS CustomerID, FirstName, LastName, Phone, Gender, Country FROM Customers" . $where . " LIMIT ?, ?";
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
				$query = "SELECT SQL_CALC_FOUND_ROWS CustomerID, FirstName, LastName, Phone, Gender, Country FROM Customers ORDER BY" . " " . $sortfield . " DESC LIMIT ?, ?";
				}
			  else if ($sortorder == "asc")
				{
				$query = "SELECT SQL_CALC_FOUND_ROWS CustomerID, FirstName, LastName, Phone, Gender, Country FROM Customers ORDER BY" . " " . $sortfield . " ASC LIMIT ?, ?";
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
$result->bind_result($CustomerID, $FirstName, $LastName, $Phone, $Gender, $Country);
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
		'Country' => $Country
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
	
	
	
	Index.php
	
	<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <meta name="msapplication-tap-highlight" content="no" />
    <title id='Description'>JavaScript DataGrid Filtering and Sorting - Mobile Example
    </title>
    <link rel="stylesheet" href="styles/demo.css" type="text/css" />
    <link rel="stylesheet" href="styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="styles/jqx.windowsphone.css" type="text/css" />
    <link rel="stylesheet" href="styles/jqx.blackberry.css" type="text/css" />
    <link rel="stylesheet" href="styles/jqx.mobile.css" type="text/css" />
    <link rel="stylesheet" href="styles/jqx.android.css" type="text/css" />
    <script type="text/javascript" src="scripts/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="scripts/jqxcore.js"></script>
    <script type="text/javascript" src="scripts/jqxdata.js"></script>
    <script type="text/javascript" src="scripts/jqxbuttons.js"></script>
    <script type="text/javascript" src="scripts/jqxscrollbar.js"></script>
    <script type="text/javascript" src="scripts/jqxlistbox.js"></script>
    <script type="text/javascript" src="scripts/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="scripts/jqxmenu.js"></script>
    <script type="text/javascript" src="scripts/jqxgrid.js"></script>
    <script type="text/javascript" src="scripts/jqxcalendar.js"></script>
    <script type="text/javascript" src="scripts/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="scripts/jqxcheckbox.js"></script>
    <script type="text/javascript" src="scripts/globalization/globalize.js"></script>
    <script type="text/javascript" src="scripts/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="scripts/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="scripts/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="scripts/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="scripts/jqxpanel.js"></script>
    <script type="text/javascript" src="scripts/simulator.js"></script>
    <script type="text/javascript" src="scripts/generatedata.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // prepares the simulator. 
            var theme = prepareSimulator("grid");

         //   var data = generatedata(50);
            // prepare the data
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'CustomerID', type: 'string'},
                    { name: 'FirstName', type: 'string'},
                    { name: 'LastName', type: 'string'},
                    { name: 'Phone', type: 'string'},
                    { name: 'Gender', type: 'string'},
                    { name: 'Country', type: 'string'}
                ],
				id: 'CustomerID',
                url: 'data.php',
				root: 'Rows',
				cache: true,
                beforeprocessing: function (data) 
				{		
					if (data != null)
					{
						source.totalrecords = data[0].TotalRows;					
					}
				},
				filter: function()
				{
					// update the grid and send a request to the server.
					$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
				},
				sort: function()
				{
					$("#jqxgrid").jqxGrid('updatebounddata', 'sort');
				}				
            };

            var dataAdapter = new $.jqx.dataAdapter(source);
			
			var initrowdetails = function (index, parentElement, gridElement) {      
				var row = index;
				var id = $("#jqxgrid").jqxGrid('getrowdata', row)['CustomerID'];
			    var grid = $($(parentElement).children()[0]);
            
				var source =
				{
					url: 'data.php',
					dataType: 'json',
					data: {customerid: id},
					datatype: "json",
					cache: false,
					datafields: [
					{ name: 'OrderID' },
						 { name: 'OrderDate' },
						 { name: 'BilledAmount' }
					],
					root: 'Rows',
					beforeprocessing: function (data) {
						source.totalrecords = data[0].TotalRows;
					},    
					
					sort: function()
					{
						grid.jqxGrid('updatebounddata', 'sort');
					}
 				};
				var adapter = new $.jqx.dataAdapter(source);

				// init Orders Grid
				grid.jqxGrid(
				{
					virtualmode: true,
					//
				//	showfilterrow: true,
                //filterable: true,
               
                columnsheight: 40,
                columnsmenuwidth: 24,
                rowsheight: 34,
                filterrowheight: 40,
                theme: theme,
					//
					width: '100%',
                height: '100%',
					sortable: true,
					pageable: true,
					pagesize: 20,
					source: adapter,
					rendergridrows: function (obj) {
						return obj.data;
					},
					columns: [
						{ text: 'Order ID', datafield: 'OrderID' },
						  { text: 'Order Date', datafield: 'OrderDate', cellsformat: 'd'},
						  { text: 'Billed Amount', datafield: 'BilledAmount' }
					  ]
				});					
			};
			  
			// set rows details.
            $("#jqxgrid").bind('bindingcomplete', function (event) {
                if (event.target.id == "jqxgrid") {
                    $("#jqxgrid").jqxGrid('beginupdate');
                    var datainformation = $("#jqxgrid").jqxGrid('getdatainformation');
                    for (i = 0; i < datainformation.rowscount; i++) {
                        $("#jqxgrid").jqxGrid('setrowdetails', i, "<div id='grid" + i + "' style='margin: 10px;'></div>", 320, true);
                    }
                    $("#jqxgrid").jqxGrid('resumeupdate');
                }
            });
			
			$("#jqxgrid").jqxGrid(
            {
                source: dataAdapter,
				//
				showfilterrow: true,
                filterable: true,
                sortable: true,
                columnsheight: 40,
                columnsmenuwidth: 24,
                rowsheight: 34,
                filterrowheight: 40,
                theme: theme,
				
				//
                
				
				width: '100%',
                height: '100%',
				pageable: true,
				
				//autoheight: true,
               virtualmode: true,
                rowdetails: true,
                initrowdetails: initrowdetails,
                rendergridrows: function(obj)
				{
					 return obj.data;    
				},				
                columns: [
                  { text: 'Customer ID', datafield: 'CustomerID', width: 130 },
                  { text: 'First Name', datafield: 'FirstName' },
                  { text: 'Last Name', datafield: 'LastName' },
                  { text: 'Phone', datafield: 'Phone', width: 150 },
                  { text: 'Gender', datafield: 'Gender',width: 100 },
				  { text: 'Country', datafield: 'Country' }
              ]
            });
            initSimulator("jqxgrid");
        });
    </script>
</head>
<body class='default'>
    <div id="demoContainer" class="device-mobile-tablet">
        <div id="container" class="device-mobile-tablet-container">
            <div style="border: none;" id='jqxgrid'>
            </div>
        </div>
    </div>
</body>
</html>

