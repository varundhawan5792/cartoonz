<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
include('connectDB.php');
include('functions.php');
if(!empty($_GET["q"])){
	$arr = array();
	$result = executeQuery("".urldecode($_GET["q"]));
	$cnt = 0;
	while($row = mysql_fetch_array($result)){	
			
			$arr[] = $row;
	}
	preg_match_all('/from (\w+)/', $_GET["q"], $tables);
	$results = print_r($tables[1], true);
	echo '{"query":'.json_encode($arr).'}';
}