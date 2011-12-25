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
else if($q == "get_server_list"){
	
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
		$result = executeQuery("UPDATE server_list SET server_load='$data' WHERE id=$id");
		echo $data;
	}
	
}
else if($q == "add_category"){

	if(empty($_GET["category"]) || empty($_GET["url"])){	
		echo "false";
	}
	else{
		
		$category = $_GET["category"];
		$parent = $_GET["parent"];
		$url = urldecode($_GET["url"]);
		$alias = $_GET["alias"];
		$name = basename($url);		
		if(!empty($_GET["id"])){	
			$id = $_GET["id"];
			$q = "UPDATE base_url SET category='$category', url='$url', name='$name', parent_id='$parent', alias='$alias' WHERE id=$id";
			$result = executeQuery($q);
			echo "true";
		}
		else{
			$q = "SELECT * FROM base_url WHERE category='$category' AND url ='$url'";
			$result = executeQuery($q);
			if(mysql_num_rows($result) > 0){
				echo "duplicate";
			}
			else{
				$q = "INSERT INTO base_url(parent_id, name, category, url, alias) values('$parent', '$name', '$category', '$url', '$alias')";
				$result = executeQuery($q);
				echo "true";		
			}
		}	
	}
}
else if($q == "remove_category"){

	if(empty($_GET["id"])){	
		echo "false";
	}
	else{
		$id = $_GET["id"];
		$q = "DELETE FROM base_url WHERE id=$id or parent_id=$id";
		$result = executeQuery($q);
		echo "true";
	}
	
}
?>