<?php

/*
$query = "SELECT * FROM base_url WHERE category = 'music'";
$result = executeQuery($query);
$row = mysql_fetch_array($result);
echo $row["url"].', '. basename($row["url"]);
getDirectory($row["url"], basename($row["url"]),  '10', 'music');
*/

//getLastModified("X:/wamp/www/songs");
function get_parent_path(){
	chdir('..');
	return getcwd();
}

function getUpdateDate($base_id){
	$result = executeQuery("SELECT date FROM db_status WHERE base_id=$base_id");
	$row = mysql_fetch_array($result);
	return $row["date"];
}

function getLastModified($dir){
	
	$cnt=0;
	$date='';
	$name='';
	if ($handle = opendir($dir)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				if($cnt == 0){
					$date = date(filemtime($dir.'/'.$entry));
					$cnt++;
				}
				if(date(filemtime($dir.'/'.$entry)) > $date){
					$name = $entry;
				    $date = date(filemtime($dir.'/'.$entry));
				}
				//echo "$dir/$entry    ".date(filemtime($dir.'/'.$entry))."<br/>";
			}
		}
    	closedir($handle);
	}
	//echo ",,".$dir.", ".$name;
	return $date;
}

function listdir($dbname, $base, $start_dir='.') {
  $files = array();
  if (is_dir($start_dir)) {
    $fh = opendir($start_dir);
    while (($file = readdir($fh)) !== false) {
      # loop through the files, skipping . and .., and recursing if necessary
       if (!isAllowed($file)) continue;
	   echo basename($start_dir)."--";
	   if(basename($start_dir) != $base){
	   		if(basename(dirname($start_dir)) != $base)
				$query = "SELECT * FROM {$dbname}_folders WHERE name like \"$file\" and parent_id=(SELECT id FROM {$dbname}_folders WHERE name=\"".basename($start_dir)."\" and parent_id=(SELECT id FROM {$dbname}_folders WHERE name=\"".basename(dirname($start_dir))."\"))";
			else
				$query = "SELECT * FROM {$dbname}_folders WHERE name like \"$file\" and parent_id=(SELECT id FROM {$dbname}_folders WHERE name=\"".basename($start_dir)."\" and parent_id is NULL)";
	   }
	   else
	   		$query = "SELECT * FROM {$dbname}_folders WHERE name like \"$file\" and parent_id is NULL";
	   echo "$query<br/>";
	   $result = executeQuery($query);
	   if(mysql_num_rows($result) == 0)
	   {
		  if (!isAllowed($file)) continue;
		  $filepath = $start_dir . '/' . $file;
		  if ( is_dir($filepath) ){
			$date = date(filemtime($filepath));
			if(basename($start_dir) != $base){
			  //echo "<tr><td>".basename(dirname($start_dir))."</td><td>".basename($start_dir)."</td><td> $file </td></tr>";
			  
			  $query = "INSERT INTO {$dbname}_folders(base_id, parent_id, name, date_added) values((SELECT id FROM base_url WHERE url like \"%$base%\"), (SELECT id FROM {$dbname}_folders as {$dbname} WHERE name=\"".basename($start_dir)."\"), \"$file\", '$date')";
			}
			else{
				$query = "INSERT INTO {$dbname}_folders(base_id, name, date_added) values((SELECT id FROM base_url WHERE url like \"%$base%\"), \"$file\", '$date')";
			}
			executeQuery($query);
			$files = array_merge($files, listdir($dbname, $base, $filepath));
		  }
		  else{
			$date = date(filemtime($filepath));
			//echo "<tr><td>".basename(dirname($start_dir))."</td><td>".basename($start_dir)."</td><td> $file </td></tr>";
			if(basename(dirname($start_dir)) != $base){
				$query_parent = "SELECT id FROM {$dbname}_folders WHERE name=\"".basename($start_dir)."\" and parent_id=(SELECT id FROM {$dbname}_folders WHERE name=\"".basename(dirname($start_dir))."\")";
			}
			else{
				$query_parent = "SELECT id FROM {$dbname}_folders WHERE name=\"".basename($start_dir)."\" and parent_id is NULL";
			}
			$query = "INSERT INTO {$dbname}_files(parent_id, name) values(($query_parent),\"$file\")";
			echo $query."<br/>";
			executeQuery($query);
			//array_push($files, $filepath);
		  }
	  }
	  else{
		  $row = mysql_fetch_array($result);
		  $date_in_db = $row["date_added"];
		  $date_now = date(filemtime($filepath));
		  if($date_in_db != $date_now){
			  
			  executeQuery("DELETE FROM {$dbname}_files WHERE parent_id=".$row['id']);
			  executeQuery("DELETE FROM {$dbname}_folders WHERE id=".$row['id']);
			  $date = date(filemtime($filepath));
				if(basename($start_dir) != $base){
				  //echo "<tr><td>".basename(dirname($start_dir))."</td><td>".basename($start_dir)."</td><td> $file </td></tr>";
				  
				  $query = "INSERT INTO {$dbname}_folders(base_id, parent_id, name, date_added) values((SELECT id FROM base_url WHERE url like \"%$base%\"), (SELECT id FROM {$dbname}_folders as {$dbname} WHERE name=\"".basename($start_dir)."\"), \"$file\", '$date')";
				}
				else{
					$query = "INSERT INTO {$dbname}_folders(base_id, name, date_added) values((SELECT id FROM base_url WHERE url like \"%$base%\"), \"$file\", '$date')";
				}
				executeQuery($query);
				listdir($dbname, $base, $filepath);
			  
		  }
	  }
    }
    closedir($fh);
  } else {
    # false if the function was called with an invalid non-directory argument
    $files = false;
  }

  return $files;

}

function array_put_to_position(&$array, $object, $position, $name = null)
{
        $count = 0;
        $return = array();
        foreach ($array as $k => $v) 
        {   
                // insert new object
                if ($count == $position)
                {   
                        if (!$name) $name = $count;
                        $return[$name] = $object;
                        $inserted = true;
                }   
                // insert old object
                $return[$k] = $v; 
                $count++;
        }   
        if (!$name) $name = $count;
        if (!$inserted) $return[$name];
        $array = $return;
        return $array;
}

function get_data($url, $timeout = 50)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function shortText($text, $length) {
	if( strlen($text) > $length ) return substr(preg_replace("/(<\/?)(\w+)([^>]*>)/", "", $text), 0, $length)."...";
	return preg_replace("/(<\/?)(\w+)([^>]*>)/", "", $text);
}
					
function executeQuery($query){
	include('connectDB.php');
	$result = mysql_query($query,$con);
	mysql_close($con);
	return $result;
}

function writeFile($file, $data, $mode="a+"){
	$fp = fopen($file, $mode);
	flock($fp, LOCK_EX);
	$i = 0;
	fwrite($fp, $data);
	flock($fp, LOCK_UN);
	fclose($fp);
}

function fileRead($dataFile){
	
	  $fp = fopen($dataFile,"r");
	  $temp="";
	  while(!feof($fp))
  	  {
  		$temp += fgets($fp);
 	  }
	  fclose($fp);
	  return $temp;
}

function isAllowed($read)
{
	if($read=='.' || $read=='..' || $read=='createzip.php' || $read=='CreateZipFile.inc.php' || $read=='D0Wl0Ad3d bY dANkY' || $read=='D0Wl0Ad3d bY CaRtOoNz' || $read=='AlbumArtSmall.jpg' || $read=='Folder.jpg' || $read=='desktop.ini' || strpos($read,'.db')==true || strpos($read,'AlbumArt')==true || strpos($read,'AlbumArt_')==true || strpos($read,'AlbumArt_{')==true || strpos($read,'.zip')==true  || strpos($read,'.nfo')==true)
		return false;
    else		
		return true;
	
}

function getDirectorySize($path) 
{ 
  $totalsize = 0; 
  $totalcount = 0; 
  $dircount = 0; 
  if ($handle = opendir ($path)) 
  { 
    while (false !== ($file = readdir($handle))) 
    { 
      $nextpath = $path . '/' . $file; 
      if ($file != '.' && $file != '..' && !is_link ($nextpath)) 
      { 
        if (is_dir ($nextpath)) 
        { 
          $dircount++; 
          $result = getDirectorySize($nextpath); 
          $totalsize += $result['size']; 
          $totalcount += $result['count']; 
          $dircount += $result['dircount']; 
        } 
        elseif (is_file ($nextpath)) 
        { 
          $totalsize += filesize ($nextpath); 
          $totalcount++; 
        } 
      } 
    } 
  } 
  closedir ($handle); 
  $total['size'] = $totalsize; 
  $total['count'] = $totalcount; 
  $total['dircount'] = $dircount; 
  return $total; 
} 

function sizeFormat($size) 
{ 
	if($size<1024) 
	{ 
		return $size." bytes"; 
	} 
	else if($size<(1024*1024)) 
	{ 
		$size=round($size/1024,1); 
		return $size." KB"; 
	} 
	else if($size<(1024*1024*1024)) 
	{ 
		$size=round($size/(1024*1024),1); 
		return $size." MB"; 
	} 
	else 
	{ 
		$size=round($size/(1024*1024*1024),1); 
		return $size." GB"; 
	} 
}  

function get_server_load($windows = 0) {
	$os = strtolower(PHP_OS);
	if(strpos($os, "win") === false) {
	  if(file_exists("/proc/loadavg")) {
		 $load = file_get_contents("/proc/loadavg");
		 $load = explode(' ', $load);
		 return $load[0];
	  }
	  elseif(function_exists("shell_exec")) {
		 $load = explode(' ', `uptime`);
		 return $load[count($load)-1];
	  }
	  else {
		 return "";
	  }
	}
	elseif($windows) {
	  $Script = "usage.exe";
  	  $DIR = get_parent_path() . "\\adm\\etc\\";
	  $runScript = $DIR. $Script;
	  exec( $runScript,$out,$ret);
	  return $out[0]."%";
	}
    else {
	 return "";
    }

}

function get_quick_server_load($windows = 0) {
	$os = strtolower(PHP_OS);
	if(strpos($os, "win") === false) {
	  if(file_exists("/proc/loadavg")) {
		 $load = file_get_contents("/proc/loadavg");
		 $load = explode(' ', $load);
		 return $load[0];
	  }
	  elseif(function_exists("shell_exec")) {
		 $load = explode(' ', `uptime`);
		 return $load[count($load)-1];
	  }
	  else {
		 return "";
	  }
	}
	elseif($windows) {
	  $Script = "quickusage.exe";
  	  $DIR = get_parent_path() . "\\adm\\etc\\";
	  $runScript = $DIR. $Script;
	  exec( $runScript,$out,$ret);
	  return $out[0]."%";
	}
    else {
	 return "";
    }

}

function getIp()
{
	$Script = "getip.exe";
	$DIR = get_parent_path() . "\\adm\\etc\\";
	$runScript = $DIR. $Script;
	exec( $runScript,$out,$ret);
	return $out[0];
}

function load_server_list(){
	
	include('connectDB.php');
	$query = "CREATE TABLE IF NOT EXISTS `server_list` (
			  `id` int(10) NOT NULL AUTO_INCREMENT,
			  `server_ip` varchar(15) NOT NULL,
			  `server_load` VARCHAR(10) NOT NULL,
			  PRIMARY KEY (`id`)
			 ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
	$result = executeQuery($query);
	$query = "SELECT * FROM server_list";
	$result = executeQuery($query);
	if(mysql_num_rows($result) == 0){
		$ip = getIp();
		$query = "INSERT INTO server_list(server_ip) values('$ip')";
		$result = executeQuery($query);
	}
	$query = "SELECT * FROM server_list";
	$result = executeQuery($query);
	$cntr=0;
	while($row = mysql_fetch_array($result)){
		$cntr++;
		echo "
		<tr id='server".$row['id']."'>
			<td title='".$row['server_ip']."' style='cursor:pointer;'>Server #$cntr</td>
			<td id='display'>
				<div class='usage nostripes'>
					<span style='width: 0%'></span>
				</div>
			</td>
			<td id='value'>0%</td>
		</tr>
		";
	}
}

function load_category_list($sub = 0, $options = 0){
	
	include('connectDB.php');
	$query = "CREATE TABLE IF NOT EXISTS `base_url` (
  				`id` int(20) NOT NULL AUTO_INCREMENT,
				`parent_id` int(20) NOT NULL DEFAULT '0',
  				`category` varchar(100) NOT NULL,
				`name` varchar(100) NOT NULL,
			    `url` varchar(200) NOT NULL,
				`alias` varchar(30) DEFAULT NULL,
  				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
    $result = executeQuery($query);
	if($sub == 0)
	   $query = "SELECT * FROM base_url WHERE parent_id = '0'";
	else if($sub == 1)
 	   $query = "SELECT * FROM base_url WHERE parent_id != '0'";
	$result = executeQuery($query);
	$cntr=0;
	while($row = mysql_fetch_array($result)){
		$cntr++;
		//<td title='".$row['category']."' style='cursor:pointer;'>Category #$cntr</td>
		if(empty($row['alias']))
			$row['alias'] = "NULL";
		echo "
		<tr id='category_list_".$row['id']."'>
			<td id='parent'><input type='hidden' value='".$row['parent_id']."'></td>
			<td id='category'>
				".$row['category']."
			</td>
			<td id='url'>
				".$row['url']."
			</td>";
		if($options == 0)	
			echo "				
				<td id='alias'>
					".$row['alias']."
				</td>
				<td>	
					<a href='' onclick='editCategory(".$row['id'].");return false;'><img src='img/icons/icon_edit.png' border=0 style='display:inline;'></a>
					<a href='' onclick='removeCategory(".$row['id'].");return false;'><img src='img/icons/icon_unapprove.png' border=0></a>
				</td>
			</tr>
			";
		else	
			echo "	
				<td>
					<a href='' onclick='updateFileDB(".$row['id'].");return false;'><img src='img/icons/icon_warning.png' border=0 style='display:inline;'></a>
					<a href='' onclick='javascript:;'><img src='img/icons/icon_approve.png' border=0 style='display:none;'></a>
				</td>
			</tr>
			";
		$query = "SELECT * FROM base_url WHERE parent_id=".$row["id"];
		$result1 = executeQuery($query);
		$cntr1 = 0;
		while($row1 = mysql_fetch_array($result1)){
			$cntr1 ++;
			//<td title='".$row1['category']."' style='cursor:pointer;'>&nbsp;&nbsp;&nbsp;Category #$cntr.$cntr1</td>
			if(empty($row1['alias']))
			   $row1['alias'] = "NULL";
			echo "
			<tr id='category_list_".$row1['id']."' style='color:#BBB;'>
				
				<td id='parent'><input type='hidden' value='".$row1['parent_id']."'></td>
				<td id='category' >
					".$row1['category']."
				</td>
				<td id='url'>
					".$row1['url']."
				</td>";
			if($options == 0)	
				echo "	
					<td id='alias'>
						".$row1['alias']."
					</td>
					<td>	
						<a href='' onclick='editCategory(".$row1['id'].");return false;'><img src='img/icons/icon_edit.png' border=0 style='display:inline;'></a>
						<a href='' onclick='removeCategory(".$row1['id'].");return false;'><img src='img/icons/icon_unapprove.png' border=0></a>
					</td>
				</tr>
				";
			else	
				echo "	
					<td>
						<a href='' onclick='updateFileDB(".$row1['id'].");return false;'><img src='img/icons/icon_warning.png' border=0 style='display:inline;'></a>
						<a href='' onclick='javascript:;'><img src='img/icons/icon_approve.png' border=0 style='display:none;'></a>
					</td>
				</tr>
				";
		}
		
	}
	if($cntr == 0){
		echo '<tr id="category_list1">
			    <td title="Nothing here! :|" style="cursor:pointer;">
				   Nothing here! :|
				</td>
			    <td id="display">
			    </td>
			    <td>
				</td>
		      </tr>';
	}
}

function load_category_status($sub = 0){
	
	include('connectDB.php');
	if($sub == 0)
	   $query = "SELECT * FROM base_url WHERE parent_id = '0'";
	else if($sub == 1)
 	   $query = "SELECT * FROM base_url WHERE parent_id != '0'";
	$result = executeQuery($query);
	$cntr=0;
	while($row = mysql_fetch_array($result)){
		$cntr++;
		$url = $row["url"];
		$last_updated = getUpdateDate($row["id"]);
		$last_modified = getLastModified($row["url"]);
		if($last_modified > $last_updated)
		   $error_flag = 1;
		else
		   $error_flag = 0;
		$temp = executeQuery("SELECT * FROM base_url WHERE parent_id=".$row["id"]);
		if(mysql_num_rows($temp) > 0)
			$tool_flag = 0;
		else
			$tool_flag = 1;
		//echo "$last_updated, $last_modified, $error_flag<br/>";  
		//<td title='".$row['category']."' style='cursor:pointer;'>Category #$cntr</td>
		echo "
		<tr id='category_list_".$row['id']."'>
			<td id='parent'><input type='hidden' value='".$row['parent_id']."'></td>
			<td id='category'>
				".$row['category']."
			</td>
			<td id='url'>
				".$row['url']."
			</td>";
		if($tool_flag == 1){
			echo "	
				<td>";
			if($error_flag == 1)
				echo "<img id='error_".$row['parent_id']."_".$row['id']."' src='img/icons/icon_warning.png' border=0 style='cursor:pointer;display:inline;' onclick='updateFileDB(".$row['id'].");return false;'>
					  <img id='done_".$row['parent_id']."_".$row['id']."' src='img/icons/icon_approve.png' border=0 style='display:none;'>";
			else
				echo "<img id='error_".$row['parent_id']."_".$row['id']."' src='img/icons/icon_warning.png' border=0 style='cursor:pointer;display:none;' onclick='updateFileDB(".$row['id'].");return false;'>
					  <img id='done_".$row['parent_id']."_".$row['id']."' src='img/icons/icon_approve.png' border=0 style='display:inline;'>";
			echo "	
					<img id='loader_".$row['parent_id']."_".$row['id']."' src='img/ajax-loader.gif' height='15' style='display:none;'>
			";
			echo "
				</td>";
		}
		else
			echo "<td></td>";
		echo"
		</tr>
		";
		$query = "SELECT * FROM base_url WHERE parent_id=".$row["id"];
		$result1 = executeQuery($query);
		$cntr1 = 0;
		while($row1 = mysql_fetch_array($result1)){
			$cntr1 ++;
			$url = $row1["url"];
			$last_updated = getUpdateDate($row1["id"]);
			$last_modified = getLastModified($row1["url"]);
			if($last_modified > $last_updated)
			   $error_flag = 1;
			else
			   $error_flag = 0;
			//echo "$last_updated, $last_modified, $error_flag<br/>";
			//<td title='".$row1['category']."' style='cursor:pointer;'>&nbsp;&nbsp;&nbsp;Category #$cntr.$cntr1</td>
			echo "
			<tr id='category_list_".$row1['id']."' style='color:#BBB;'>
				
				<td id='parent'><input type='hidden' value='".$row1['parent_id']."'></td>
				<td id='category' >
					".$row1['category']."
				</td>
				<td id='url'>
					".$row1['url']."
				</td>";
			echo "	
				<td>";
			if($error_flag == 1)
				echo "<img id='error_".$row1['parent_id']."_".$row1['id']."' src='img/icons/icon_warning.png' border=0 style='cursor:pointer;display:inline;' onclick='updateFileDB(".$row1['id'].");return false;'>
					  <img id='done_".$row1['parent_id']."_".$row1['id']."' src='img/icons/icon_approve.png' border=0 style='display:none;'>";
			else
				echo "<img id='error_".$row1['parent_id']."_".$row1['id']."' src='img/icons/icon_warning.png' border=0 style='cursor:pointer;display:none;' onclick='updateFileDB(".$row1['id'].");return false;'>
					  <img id='done_".$row1['parent_id']."_".$row1['id']."' src='img/icons/icon_approve.png' border=0 style='display:inline;'>";
			echo "	
					<img id='loader_".$row1['parent_id']."_".$row1['id']."' src='img/ajax-loader.gif' height='15' style='display:none;'>
			";
			echo "
			</td>
			</tr>
			";
		}
		
	}
	if($cntr == 0){
		echo '<tr id="category_list1">
			    <td title="Nothing here! :|" style="cursor:pointer;">
				   Nothing here! :|
				</td>
			    <td id="display">
			    </td>
			    <td>
				</td>
		      </tr>';
	}
}

function get_category_as_option(){
	
	include('connectDB.php');
	$query = "SELECT * FROM base_url WHERE parent_id=0";
	$result = executeQuery($query);
	echo "<option id='0'>No Parent</option>";
	$cntr=0;
	while($row = mysql_fetch_array($result)){	
		echo "<option id='".$row["id"]."' value='".$row["id"]."'>".$row["category"]."</option>";
	}
}