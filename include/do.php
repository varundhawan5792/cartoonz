<?php


include("connectDB.php");
include_once('functions.php');
define("ALLOWED", 1);
define("FORBIDDEN", 2);
$q = $_GET["q"];
$baseURL = "http://" . $_SERVER['HTTP_HOST'] . "/";
$permission = 1;

if($q == "alive"){
	echo base64_encode('alive');
}
else if($q == "ping_host"){
	
	header('Content-type: application/json');
	$start = $_GET["start"];
	$end = $_GET["end"];
	set_time_limit(($end-$start)*5); 
	$arr = array();
	$hosts_to_ping = array();
	$myip = getIp();
	$base = substr($myip, 0, strrpos($myip, '.', -1));
	for($i = $start; $i <= $end; $i++)
		array_push($hosts_to_ping, $base.".$i");
	foreach ($hosts_to_ping as $host): 
		$up = get_data("http://$host/cartoonz/include/do.php?q=alive", 1);
		if(base64_decode($up) == "alive"){
			$arr['query'][] = array('host' => $host);
		}
	endforeach;
	echo json_encode($arr);
	set_time_limit(5);
}
else if($q == "get_music_folder_list"){
	
	header('Content-type: application/json');
	$arr = array();
	$result = executeQuery("SELECT * FROM music_folders WHERE parent_id is NULL");
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
	$result = executeQuery("SELECT * FROM music_folders WHERE id=$parent_id");
	$row = mysql_fetch_array($result);
	$folder_name = $row["name"];
	$result = executeQuery("SELECT * FROM base_url WHERE category='Music'");
	$row = mysql_fetch_array($result);
	$url = $row["url"]."/".$folder_name;
	$files = scandir($url);
	$id = 1;
	foreach($files as $this_file) {
		if(!isAllowed($this_file))
				continue;
		if( is_dir("$url/$this_file" ) ) {
			$temp = array("id" => $id++, "name" => $this_file, "type" => "folder");
			$arr['query'][] = $temp;
		}
		else{ 
			$temp = array("id" => $id++, "name" => $this_file, "type" => "file");
			$arr['query'][] = $temp;
		}
	}
	echo json_encode($arr);
}
else if($q == "update_folder_db"){
	error_reporting(0);
	if($permission == FORBIDDEN)
		return;
	if(!empty($_GET['base_id'])){
		$result = executeQuery("SELECT * from base_url WHERE id=".$_GET['base_id']);
		$row = mysql_fetch_array($result);
		$url = $row["url"];
		$dbname = $row["dbname"];
		$query = "
		CREATE TABLE IF NOT EXISTS `".$dbname."_folders` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `base_id` int(11) DEFAULT NULL,
		  `parent_id` int(20) DEFAULT NULL,
		  `name` varchar(200) NOT NULL,
		  `date_added` varchar(200) NOT NULL,
		  `status` int(11) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
		executeQuery($query);
		set_time_limit(9999);
		include("php_file_tree.php");
		$allowed_extensions = array("mp3", "jpg", "jpeg", "png", "flac", "mkv", "avi", "wmv");
		php_file_tree( $url, $dbname, $allowed_extensions);
		//$files = listdir($name, basename($url), $url);
		//getDirectory($url, basename($url),  '10', $name);
		date_default_timezone_set('Asia/Calcutta');
		$date = date(filemtime($url)); //"F d Y H:i:s."
		executeQuery("DELETE FROM db_status WHERE base_id=".$_GET['base_id']);
		$mod_date = getLastModified($url);
		executeQuery("INSERT INTO db_status VALUES('".$_GET['base_id']."','1','$mod_date')");
		set_time_limit(5);
		
		echo "true";
	}
	else{
		echo 'false';
	}
	error_reporting(NULL);
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