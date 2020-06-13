<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="styles/jqx.classic.css" type="text/css" />
    <script type="text/javascript" src="scripts/jquery-1.10.2.min.js"></script>  
	<script type="text/javascript" src="scripts/jqxcore.js"></script>
    <script type="text/javascript" src="scripts/jqxbuttons.js"></script>
    <script type="text/javascript" src="scripts/jqxscrollbar.js"></script>
    <script type="text/javascript" src="scripts/jqxlistbox.js"></script>
    <script type="text/javascript" src="scripts/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="scripts/jqxmenu.js"></script>
    <script type="text/javascript" src="scripts/jqxdata.js"></script>
    <script type="text/javascript" src="scripts/jqxgrid.js"></script>
	<script type="text/javascript" src="scripts/jqxgrid.sort.js"></script>	
	<script type="text/javascript" src="scripts/jqxgrid.selection.js"></script>
  	<script type="text/javascript" src="scripts/jqxgrid.pager.js"></script>
   <script type="text/javascript">
        $(document).ready(function () {
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
					{ name: 'Total_Value', type: 'string'}
					
                ],
				id: 'CustomerID',
                url: 'data.php',
				root: 'Rows',
				cache: false,
                beforeprocessing: function (data) {
                    source.totalrecords = data[0].TotalRows;
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
					height: 190,
					width: 530,
					sortable: true,
					pageable: true,
					pagesize: 5,
					source: adapter,
					theme: 'classic',
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
                        $("#jqxgrid").jqxGrid('setrowdetails', i, "<div id='grid" + i + "' style='margin: 10px;'></div>", 220, true);
                    }
                    $("#jqxgrid").jqxGrid('resumeupdate');
                }
            });
			
			$("#jqxgrid").jqxGrid(
            {
                source: dataAdapter,
                theme: 'classic',
				width: 1000,
				pagesize: 20,
				pageable: true,
				sortable: true,
				autoheight: true,
                virtualmode: true,
                rowdetails: true,
                initrowdetails: initrowdetails,
                rendergridrows: function () {
                    return dataAdapter.records;
                },				
                columns: [
                  { text: 'Customer ID', datafield: 'CustomerID', width: 145 },
                  { text: 'First Name', datafield: 'FirstName', width: 130 },
                  { text: 'Last Name', datafield: 'LastName', width: 130},
                  { text: 'Phone', datafield: 'Phone', width: 150 },
                  { text: 'Gender', datafield: 'Gender',width: 85 },
				  { text: 'Spent', datafield: 'Total_Value', width: 70 },
				  { text: 'Visits', datafield: 'Total_Orders', width: 50 },
				  { text: 'Date of Birth', datafield: 'DOB',cellsformat: 'dd/M/y', width: 100 },
				  { text: 'Country', datafield: 'Country',width: 100 }
              ]
            });        	
        });
    </script>
</head>
<body class='default'>
   <div id="jqxgrid"></div>
</body>
</html>