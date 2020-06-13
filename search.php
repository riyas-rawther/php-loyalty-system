<!DOCTYPE html>
<html lang="en">
<head>
    <title id='Description'>Enter Customer History</title>
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
	   <script type="text/javascript" src="scripts/jqxcheckbox.js"></script>
	   <script type="text/javascript" src="scripts/jqxradiobutton.js"></script>
	   <script type="text/javascript" src="scripts/jqxinput.js"></script>
   
    <script type="text/javascript">
	$(document).ready(function () {
		//$('#sendButton').jqxButton({ width: 70});
		//$("#jqxInput").jqxInput({  placeHolder: "Billed Amount:", width: '120px' });
		$('#SearchByName').jqxRadioButton({ width: '120px'});
		$('#SearchByPhone').jqxRadioButton({ checked: true, width: '120px'});
		$('#SearchByCard').jqxRadioButton({ width: '120px'});
		$('#SearchByName').on('change', function (event) {
                    // enable or disable.
                    var checked = !event.args.checked;
                    $("#jqxcombobox").jqxComboBox({ displayMember: 'FirstName' });
                });
		$('#SearchByPhone').on('change', function (event) {
                    // enable or disable.
                    var checked = !event.args.checked;
                    $("#jqxcombobox").jqxComboBox({ displayMember: 'Phone' });
                });	
		$('#SearchByCard').on('change', function (event) {
                    // enable or disable.
                    var checked = !event.args.checked;
                    $("#jqxcombobox").jqxComboBox({ displayMember: 'CustomerID' });
                });			
		// prepare the data
		var employeeSource =
		{
			datatype: "json",
			datafields: [
			{ name: 'FirstName', type: 'string'},
                    //{ name: 'LastName', type: 'string'},
					{ name: 'CustomerID', type: 'string'},
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
			source: employeesDataAdapter,
			
			promptText: 'Select a Customer',
			selectedIndex: -1,
			displayMember: 'Phone',
			valueMember: 'CustomerID'
		});
		$("#jqxcombobox").bind('select', function(event)
		{
			var elem = document.getElementById("customerid");
			elem.value = event.args.item.value;
			// get employee's ID.
			var customerID = event.args.item.value;
			// prepare the data
			var customerSource =
			{
				datatype: "json",
				datafields: [
				{ name: 'CustomerID', type: 'string'},
				{ name: 'FirstName', type: 'string'},
				{ name: 'LastName', type: 'string'},
				{ name: 'Phone', type: 'string'},
				{ name: 'Gender', type: 'string'}
				],
				type: 'POST',
				data: {CustomerID:customerID},
				url: "json-findcustomer.php"
			};
			var dataAdapter = new $.jqx.dataAdapter(customerSource);
			$("#grid").jqxGrid({ 
			width: 900,
                height: 55,
			source: dataAdapter,
			columns: 
			[
				{datafield: "CustomerID", text: "Customer ID", width: '30%'},
				
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
        <div style='margin-top: 10px;' id='SearchByPhone'>Search by Phone</div>
		<div style='margin-top: 10px;' id='SearchByName'>Search by Name</div>
		<div style='margin-top: 10px;' id='SearchByCard'>Search by Card</div>
		<div style="margin-top: 7px; margin-bottom: 5px;" id="jqxcombobox"></div>
		 <form class="form" id="form" target="_self"  method="post" action="insert-customer-data.php">   
		<input name="customerid" type="hidden"  id="customerid"> <br />
		<div id="grid"></div>
		<input placeholder="Please enter the billed amount!" width="200" type="number" name="billedamount" />
		<input  type="submit" value="Submit"  /> 
		</form>
		
    </div>
</body>
</html>