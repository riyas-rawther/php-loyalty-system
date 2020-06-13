<?php
$sms1 = "http://api.clickatell.com/http/sendmsg?user=";
$sms2 = "riyasrawther&password=p@ssw0rd@123&api_id=3585454&to=";
$sms3 = '971509756011';
$sms4 = "&text=";
$sms5 = "Message";
$smsapi = $sms1.$sms2.$sms3.$sms4.$sms5;

echo $smsapi;

echo '<iframe id="sms" width="560" height="315" frameborder="2" 
src="'. $smsapi .'" ></iframe>';


?>