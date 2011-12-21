<?php


include("connectDB.php");
include_once('functions.php');
$q = $_GET["q"];
$baseURL = "http://" . $_SERVER['HTTP_HOST'] . "/";

if($q == "get_music_folder_list"){
	header('Content-type: application/json');
	$arr = array();
	$result = executeQuery("SELECT * FROM music_folders WHERE base_id in (SELECT id FROM base_url WHERE category='music')");
	while($row = mysql_fetch_array($result)){	
			$arr['query'][] = $row;
	}
	echo json_encode($arr);
	
	
}
else if($q == "get_music_files_list"){
	header('Content-type: application/json');
	if(empty($_GET["parent"])){
		echo '{"query":[{}]}';
		return;
	}
	else
		$parent_id = $_GET["parent"];
	
	$arr = array();
	$result = executeQuery("SELECT * FROM music_folders WHERE parent_id=$parent_id and base_id is NULL");
	while($row = mysql_fetch_array($result)){	
			array_put_to_position($row, "folder", 0, "type");
			$arr['query'][] = $row;
	}
	$result = executeQuery("SELECT * FROM music_files WHERE parent_id=$parent_id");
	while($row = mysql_fetch_array($result)){	
			array_put_to_position($row, "file", 0, "type");
			$arr['query'][] = $row;
	}
	echo json_encode($arr);
}
if($q == "get_server_list"){
	header('Content-type: application/json');
	$arr = array();
	$result = executeQuery("SELECT * FROM server_list");
	while($row = mysql_fetch_array($result)){	
			$arr['query'][] = $row;
	}
	echo json_encode($arr);
	
}
else if($q == "get_server_load"){
	
	if(empty($_GET["id"])){
		echo get_server_load(1);	
	}
	else{
		$id = $_GET["id"];
		$result = executeQuery("SELECT * FROM server_list WHERE id = $id");
		$row = mysql_fetch_array($result);
		$ip = $row["server_ip"];
		$data = get_data("http://$ip/cartoonz/include/do.php?q=get_server_load");
		echo $data;
	}
	
}
?>