<?php

header('Content-type: application/json');
include("connectDB.php");
include_once('functions.php');
$q = $_GET["q"];

if($q == "get_music_folder_list"){
	
	$arr = array();
	$result = executeQuery("SELECT * FROM music_folders WHERE base_id in (SELECT id FROM base_url WHERE category='music')");
	while($row = mysql_fetch_array($result)){	
			$arr['query'][] = $row;
	}
	echo json_encode($arr);
	
	
}
else if($q == ""){
	
}
	
?>