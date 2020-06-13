<?php
date_default_timezone_set('Indian/Mauritius');
$date = date('Y-m-d H:i:s');


echo $date; // ISO8601 formated datetime
//echo $objDateTime->format(DateTime::ISO8601); // Another way to get an ISO8601 formatted string

/**
On my local machine this results in: 

2013-03-01T16:15:09+01:00
2013-03-01T16:15:09+0100

Both of these strings are valid ISO8601 datetime strings, but the latter is not accepted by the constructor of JavaScript's date object on iPhone. (Possibly other browsers as well)
*/

?>