<!DOCTYPE html>
<html lang="en">
<head>
    <title id='Description'>Enter customer transactions</title>
    <link rel="stylesheet" href="styles/jqx.base.css" type="text/css" />
    <script type="text/javascript" src="scripts/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="scripts/jqxcore.js"></script>
    <script type="text/javascript" src="scripts/jqxdata.js"></script> 
    <script type="text/javascript" src="scripts/jqxbuttons.js"></script>
    <script type="text/javascript" src="scripts/jqxscrollbar.js"></script>
    <script type="text/javascript" src="scripts/jqxlistbox.js"></script>
    <script type="text/javascript" src="scripts/jqxcombobox.js"></script>
    <script type="text/javascript" src="scripts/jqxgrid.js"></script>
    <script type="text/javascript" src="scripts/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="scripts/jqxmenu.js"></script>
	<script type="text/javascript" src="scripts/jqxradiobutton.js"></script>
	 <script type="text/javascript" src="scripts/jqxinput.js"></script>
    
	
    <script type="text/javascript">
	$(document).ready(function () {
	 $("#billedamount").jqxInput({placeHolder: "Enter the Billed amount", height: 25, width: 200, minLength: 1 });
	// create jqxRadioButton.
            $("#jqxradiobutton1").jqxRadioButton({ width: 120, height: 25 });
            $("#jqxradiobutton2").jqxRadioButton({ width: 120, height: 25 });
			 $("#jqxradiobutton3").jqxRadioButton({ width: 120, height: 25 });
            // bind to change event.
            $("#jqxradiobutton1").bind('change', function (event) {
               $("#jqxcombobox").jqxComboBox({ displayMember: 'FirstName' });
            });
            $("#jqxradiobutton2").bind('change', function (event) {
                $("#jqxcombobox").jqxComboBox({ displayMember: 'Phone' });
            });
			$("#jqxradiobutton3").bind('change', function (event) {
                $("#jqxcombobox").jqxComboBox({ displayMember: 'CustomerID' });
            });
		
		// prepare the data
		var employeeSource =
		{
			datatype: "json",
			datafields: [
			{ name: 'CustomerID', type: 'int'},
			{ name: 'FirstName', type: 'string'},
			{ name: 'LastName', type: 'string'},
			{ name: 'Phone', type: 'string'}
			],
			url: "json-customers.php",
			async: false
		};
		var employeesDataAdapter = new $.jqx.dataAdapter(employeeSource);
		// create a comboBox. 
		// The displayMember specifies that the list item's text will be the Employee's Name. 
		// The valueMember specifies that the list item's value will be the Employee's ID.
		$("#jqxcombobox").jqxComboBox(
		{
			width: 250,
			height: 25,
			searchMode: 'containsignorecase',
			autoComplete: true,
			source: employeesDataAdapter,
			
			promptText: 'Select Customer',
			selectedIndex: -1,
			displayMember: 'FirstName',
			valueMember: 'CustomerID'
		});
		$("#jqxcombobox").bind('select', function(event)
		{
			// get employee's ID.
			var employeeID = event.args.item.value;
			var elem = document.getElementById("customerid");

elem.value = event.args.item.value;
			// prepare the data
			
			var ordersSource =
			{
				datatype: "json",
				datafields: [
				{ name: 'CustomerID', type: 'string'},
				{ name: 'FirstName', type: 'string'},
				{ name: 'LastName', type: 'string'},
				{ name: 'Phone', type: 'string'}
				],
				type: 'POST',
				data: {CustomerID:employeeID},
				url: "json-findcustomer.php"
			};
			var dataAdapter = new $.jqx.dataAdapter(ordersSource);
			$("#grid").jqxGrid({ 
			height: 90,
			source: dataAdapter,
			columns: 
			[
				{datafield: "CustomerID", text: "CustomerID", width: '30%'},
				{datafield: "FirstName", text: "First Name", width: '25%'},
				{datafield: "LastName", text: "Last Name", width: '25%'},
				{datafield: "Phone", text: "Phone", width: '20%'}
			]
			});
		}); 
	});
    </script>
</head>
<body class='default'>
    <div id='jqxWidget' style="font-size: 13px; font-family: Verdana; float: left;">
        <span>Find Customer:</span>
		<div id='jqxradiobutton1'>
        Find by Name</div>
    <div id='jqxradiobutton2'>
        Find by Phone</div>
	<div id='jqxradiobutton3'>
        Find by Card</div>
        <div style="margin-top: 7px; margin-bottom: 5px;" id="jqxcombobox"></div>
		<div id="grid"></div>
		<form class="form" id="form"  method="post" action="insert-customer-data.php" >        
		<input name="billedamount" type="text" id="billedamount"/>
		<input name="customerid" type="hidden"  id="customerid">
		<input type="submit" value="Submit">
		</form>
    </div>
</body>
</html>