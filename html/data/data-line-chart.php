<?php
// settings
// host, user and password settings
$host = "localhost";
$user = "logger";
$password = "password";
$database = "temperatures";
//how many hours backwards do you want results to be shown in web page.
$hours = 12;
// make connection to database
$con = mysql_connect($host,$user,$password);
// select db
mysql_select_db($database,$con);
// sql command that selects all entires from current time and X hours backwards
$sql="SELECT * FROM temperaturedata WHERE dateandtime >= (NOW() - INTERVAL $hours HOUR) AND sensor = 'ServerRoom' ORDER BY dateandtime DESC";
//NOTE: If you want to show all entries from current date in web page uncomment line below by removing //
//$sql="select * from temperaturedata where date(dateandtime) = curdate();";
// set query to variable
$temperatures = mysql_query($sql);

$rows['datetime'] = 'DateTime';
$rows['temp'] = 'Temperature';

while ($r = mysql_fetch_array($temperatures)) {
    $rows['data'][] = array($r['dateandtime'], $r['temperature']);
}

$rslt = array();
array_push($rslt,$rows);
print json_encode($rslt, JSON_NUMERIC_CHECK);
mysql_close($con);
?>
