<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Amore Royalty Club Membership Form</title>
   <!-- <script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script> -->


    
    
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css'>
<link rel='stylesheet prefetch' href='http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css'>

     <link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="styles/intlTelInput.css">

    
    
    
  </head>

  <body>
	

    <form class="well form-horizontal" action="insert-customer.php" method="post"  id="contact_form">
<fieldset>

<!-- Form Name -->
<legend>New Royalty Membership Registration Form</legend>
<!-- generate UID -->
<div class="form-group">
  <label class="col-md-4 control-label">Customer ID</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
		<?php
date_default_timezone_set('Asia/Dubai');

//$comp = "2";
$stamp = date("dmyGHis");
//$ip = $_SERVER['REMOTE_ADDR'];

$orderid = "$stamp";
$orderid = str_replace(".", "", "$orderid");

echo '<input name="uid" id="uid"  class="form-control input-lg"  type="text" value="'.$orderid.'">';

?>
 
    </div>
  </div>
</div>
<!-- end UID -->
<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label">First Name</label>  
  <div class="col-md-4 inputGroupContainer">
  <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input  name="first_name" onblur="this.value=ucFirstAllWords(this.value);"  placeholder="First Name" class="form-control input-lg"  type="text" onchange="myFunction()">
    </div>
  </div>
</div>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label" >Last Name</label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input name="last_name" onblur="this.value=ucFirstAllWords(this.value);"   placeholder="Last Name" class="form-control input-lg"  type="text">
    </div>
  </div>
</div>

<!-- Text input
       <div class="form-group">
  <label class="col-md-4 control-label">E-Mail</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
  <input name="email" placeholder="E-Mail Address" class="form-control input-lg"  type="text">
    </div>
  </div>
</div>


<!-- Text input-->
       
<div class="form-group">
  <label class="col-md-4 control-label">Phone #</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
 <input name="phone" id="phone" onblur="this.value=removeSpaces(this.value);" class="form-control input-lg" type="tel">
<span id="valid-msg" class="hide">Valid</span>
<span id="error-msg" class="hide">Invalid number</span>
    </div>
  </div>
</div>

   <!--
      <input id="phone" onblur="this.value=removeSpaces(this.value);" type="tel">
<span id="valid-msg" class="hide">? Valid</span>
<span id="error-msg" class="hide">Invalid number</span>
    -->

<div class="form-group">
  <label class="col-md-4 control-label">Birthday</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
  <input name="dob"  class="form-control input-lg" type="date">
    </div>
  </div>
</div>


<!-- Text input
      
<div class="form-group">
  <label class="col-md-4 control-label">Address</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
  <input name="address" placeholder="Address" class="form-control input-lg" type="text">
    </div>
  </div>
</div>

<!-- Text input-->
 
<div class="form-group">
  <label class="col-md-4 control-label">Nationality | جنسية</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
  <input name="city" onblur="this.value=ucFirstAllWords(this.value);"   placeholder="Lebanon/Syria/KSA" class="form-control input-lg"  type="text">
    </div>
  </div>
</div>

<!-- Select Basic 
   
<div class="form-group"> 
  <label class="col-md-4 control-label">State</label>
    <div class="col-md-4 selectContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
    <select name="state" class="form-control input-lg selectpicker" >
      <option value=" " >Please select your state</option>
      <option>Alabama</option>
      <option>Alaska</option>
      <option >Arizona</option>
      <option >Arkansas</option>
      <option >California</option>
      <option >Colorado</option>
      <option >Connecticut</option>
      <option >Delaware</option>
      <option >District of Columbia</option>
      <option> Florida</option>
      <option >Georgia</option>
      <option >Hawaii</option>
      <option >daho</option>
      <option >Illinois</option>
      <option >Indiana</option>
      <option >Iowa</option>
      <option> Kansas</option>
      <option >Kentucky</option>
      <option >Louisiana</option>
      <option>Maine</option>
      <option >Maryland</option>
      <option> Mass</option>
      <option >Michigan</option>
      <option >Minnesota</option>
      <option>Mississippi</option>
      <option>Missouri</option>
      <option>Montana</option>
      <option>Nebraska</option>
      <option>Nevada</option>
      <option>New Hampshire</option>
      <option>New Jersey</option>
      <option>New Mexico</option>
      <option>New York</option>
      <option>North Carolina</option>
      <option>North Dakota</option>
      <option>Ohio</option>
      <option>Oklahoma</option>
      <option>Oregon</option>
      <option>Pennsylvania</option>
      <option>Rhode Island</option>
      <option>South Carolina</option>
      <option>South Dakota</option>
      <option>Tennessee</option>
      <option>Texas</option>
      <option> Uttah</option>
      <option>Vermont</option>
      <option>Virginia</option>
      <option >Washington</option>
      <option >West Virginia</option>
      <option>Wisconsin</option>
      <option >Wyoming</option>
    </select>
  </div>
</div>
</div>

<!-- Text input

<div class="form-group">
  <label class="col-md-4 control-label">Zip Code</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
  <input name="zip" placeholder="Zip Code" class="form-control input-lg"  type="text">
    </div>
</div>
</div>

<!-- Text input
<div class="form-group">
  <label class="col-md-4 control-label">Website or domain name</label>  
   <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
  <input name="website" placeholder="Website or domain name" class="form-control input-lg" type="text">
    </div>
  </div>
</div>

<!-- radio checks -->
 <div class="form-group">
                        <label class="col-md-4 control-label">Gender</label>
                        <div class="col-md-4">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="sex" value="Male" /> Male
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="sex" value="Female" /> Female
                                </label>
                            </div>
                        </div>
                    </div>
<!-- radio checks -->
 <div class="form-group">
                        <label class="col-md-4 control-label">Send me special Offers</label>
                        <div class="col-md-4">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="subscribed" value="Yes" /> Yes
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="subscribed" value="No" /> No
                                </label>
                            </div>
                        </div>
                    </div>
 
<!-- Text area 
  
<div class="form-group">
  <label class="col-md-4 control-label">Project Description</label>
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
        	<textarea class="form-control input-lg" name="comment" placeholder="Project Description"></textarea>
  </div>
  </div>
</div>

<!-- Hidden -->


<!-- Success message 
<div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Thanks for contacting us, we will get back to you shortly.</div>
-->
<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
    <button type="submit" >Send <span class="glyphicon glyphicon-send"></span></button>
  </div>
</div>

</fieldset>
</form>
</div>
   
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js'></script>

        <script src="js/index.js"></script>
<!-- <script src="js/prism.js"></script> 
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
    <script src="js/intlTelInput.js"></script>
    <script src="js/isValidNumber.js"></script>
	<script>
	function removeSpaces(string) {
	var ntlNumber = $("#phone").intlTelInput("getNumber", intlTelInputUtils.numberFormat.INTERNATIONAL);
	return (ntlNumber);
}
function ucFirstAllWords( str )
{
    var pieces = str.split(" ");
    for ( var i = 0; i < pieces.length; i++ )
    {
        var j = pieces[i].charAt(0).toUpperCase();
        pieces[i] = j + pieces[i].substr(1);
    }
    return pieces.join(" ");
}
	</script>
	
  </body>
</html>
