<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <meta name="msapplication-tap-highlight" content="no" />
    <title id='Description'>Amore Cafe Royalty Club Customer Dashboard</title>
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
			var theme = prepareSimulator("menu");
			$("#menu").jqxMenu({ theme: theme, width: '100%' });
            $("#menu").css('visibility', 'visible');
			
			var billedamount = "1001";
var generaterow = function () {
                var row = {};
                

                
                row["BilledAmount"] = billedamount;
				alert ("hi");
              
                return row;
            }
         
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
					{ name: 'DOB', type: 'date'},
                    { name: 'Country', type: 'string'},
					{ name: 'Total_Orders', type: 'string'},
					{ name: 'Total_Value', type: 'string'},
					{ name: 'days_till_bday', type: 'string'}
                ],
				  
                
				id: 'CustomerID',
                url: 'data.php',
				root: 'Rows',
				sortcolumn: 'CustomerID',
    // sortdirection: 'asc',
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
					pagesize: 10,
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
				
                //
				
				width: '100%',
                height: '95.5%',
				pageable: true,
				
				//autoheight: true,
               virtualmode: true,
                rowdetails: true,
				pagesize: 20,
				altrows: true,
                enabletooltips: true,
                initrowdetails: initrowdetails,
                rendergridrows: function(obj)
				{
					 return obj.data;    
				},				
                columns: [
                  { text: 'Customer ID', datafield: 'CustomerID', width: 140 },
                  { text: 'First Name', datafield: 'FirstName', width: 125 },
                  { text: 'Last Name', datafield: 'LastName', width: 120},
                  { text: 'Phone', datafield: 'Phone', width: 150 },
                  { text: 'Gender', datafield: 'Gender',width: 63 },
				  { text: 'Spent', datafield: 'Total_Value', width: 70 },
				  { text: 'Visits', datafield: 'Total_Orders', width: 50 },
				  { text: 'DOB', datafield: 'DOB',cellsformat: 'dd/M/y', width: 72 },
				  { text: 'Day till Bday', datafield: 'days_till_bday', width: 107 },
				  { text: 'Country', datafield: 'Country',width: 80 }
              ]
            });
            initSimulator("jqxgrid");
        });
    </script>
</head>
<body class='default'>
	<style>     
        .green {
            color: black\9;
            background-color: #b6ff00\9;
        }
        .yellow {
            color: black\9;
            background-color: yellow\9;
        }
        .red {
            color: black\9;
            background-color: #e83636\9;
        }
        .green:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .green:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
            color: black;
            background-color: #b6ff00;
        }
        .yellow:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .yellow:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
            color: black;
            background-color: yellow;
        }
        .red:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .red:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
            color: black;
            background-color: #e83636;
        }
    </style>
    <div id="demoContainer" class="device-mobile-tablet">
        <div id="container" class="device-mobile-tablet-container">
		<div id='menu' style='position: relative; border: none; visibility: hidden;'>
                <ul>
                    <li><a href="http://amorecafe.ae/royalty/new-customer.php">New Customer</a></li>
					<li><a href="http://amorecafe.ae/royalty/transactions.php">Enter Transactions</a></li>
                    </li>
                    
                </ul>
            </div>
            <div style="border: none;" id='jqxgrid'>
            </div>
        </div>
    </div>

    
</body>
</html>
