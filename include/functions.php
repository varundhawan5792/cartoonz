<?php

/*
$query = "SELECT * FROM base_url WHERE category = 'music'";
$result = executeQuery($query);
$row = mysql_fetch_array($result);
echo $row["url"].', '. basename($row["url"]);
getDirectory($row["url"], basename($row["url"]),  '10', 'music');
*/

function get_parent_path(){
	chdir('..');
	return getcwd();
}

function getDirectory( $path, $basepath, $level = 0, $dbname){ 
		
	$ignore = array( 'cgi-bin', '.', '..', '.svn' ); 
	$dh = @opendir( $path ); 
	while( false !== ( $file = readdir( $dh ) ) ){ 
		if( !in_array( $file, $ignore ) && isAllowed($file)){ 
		
			$spaces = str_repeat( '&nbsp;&nbsp;', ( $level * 2 ) ); 
			if( is_dir( "$path/$file" ) ){ 
			   
			   $basedir = basename($path);
			   $url = $path.'/'.$file;
			   //echo "$basedir, $url, $basepath<br/>";		   
			   $query = "SELECT * FROM {$dbname}_folders WHERE name like \"$file\"";
			   //echo "$query<br/>";
			   $result = executeQuery($query);
			   if(mysql_num_rows($result) == 0)
			   {
				   date_default_timezone_set('Asia/Calcutta');
				   $date = date(filemtime($url)); //"F d Y H:i:s."
				   if($basedir == $basepath){
					   $query = "INSERT INTO {$dbname}_folders(base_id, name, date_added) values((SELECT id FROM base_url WHERE name=\"$basedir\"), \"$file\", '$date')";
				   }
				   else{
						$query = "INSERT INTO {$dbname}_folders(base_id, parent_id, name, date_added) values((SELECT id FROM base_url WHERE name=\"$basedir\"), (SELECT id FROM {$dbname}_folders as {$dbname} WHERE name=\"$basedir\"), \"$file\", '$date')";   
						//echo "$query<br/>";
				   }
				   executeQuery($query);
			   }
			   getDirectory( "$path/$file", $basepath, ($level+1), $dbname);
			   
			} 
			else { 

			   $basedir = basename($path);
			   $dirname = basename(dirname($path));
			   
			   $parent1 = $basedir;
			   $parent2 = $dirname;
			   if($parent2 == $basepath){
					$query = "SELECT id FROM base_url WHERE name=\"$parent2\"";
					$result = executeQuery($query);
					$row = mysql_fetch_array($result);
					$base_id = $row["id"];
			   }
				else
					$base_id = "NULL";
			   
			   if($parent2 != $basepath)
				   $query_parent = "SELECT id FROM {$dbname}_folders WHERE name=\"$parent1\" and parent_id=(SELECT id FROM {$dbname}_folders WHERE name=\"$parent2\")";
			   else   
				   $query_parent = "SELECT id FROM {$dbname}_folders WHERE name=\"$parent1\" and parent_id is NULL";
			   $query = "SELECT * FROM {$dbname}_files WHERE parent_id=($query_parent) and name=\"$file\"";
			   $result = executeQuery($query);
			   if(mysql_num_rows($result) == 0)
			   {
				   //$query_parent = "SELECT id FROM {$dbname}_folders WHERE name=\"$parent1\" and parent_id=(SELECT id FROM {$dbname}_folders WHERE name=\"$parent2\")";
				   $query = "INSERT INTO {$dbname}_files(parent_id, name) values(($query_parent),\"$file\")";
				   executeQuery($query);
				   //echo "$file<br/>";
			   }
			} 
		} 
	} 
	closedir( $dh ); 
	// Close the directory handle 
	// echo "<br/>Files added from <br/>path = '$path' to <br/>database = $dbname";
} 

class dbOperations{
	
	function updateDb($category){
		
		getDirectory($row["url"], basename($row["url"]),  '10', 'music');
	}
	
	function getFileList($category){
		
		switch($category){
			case 'music':
				break;
			
		}
	}
	
	function getDirectory( $path, $basepath, $level = 0, $dbname){ 
		
		$ignore = array( 'cgi-bin', '.', '..', '.svn' ); 
		$dh = @opendir( $path ); 
		while( false !== ( $file = readdir( $dh ) ) ){ 
			if( !in_array( $file, $ignore ) && isAllowed($file)){ 
			
				$spaces = str_repeat( '&nbsp;&nbsp;', ( $level * 2 ) ); 
				if( is_dir( "$path/$file" ) ){ 
				   
				   $basedir = basename($path);
				   $url = $path.'/'.$file;
				   //echo "$basedir, $url, $basepath<br/>";		   
				   $query = "SELECT * FROM {$dbname}_folders WHERE name like \"$file\"";
				   //echo "$query<br/>";
				   $result = executeQuery($query);
				   if(mysql_num_rows($result) == 0)
				   {
					   date_default_timezone_set('Asia/Calcutta');
					   $date = date(filemtime($url)); //"F d Y H:i:s."
					   if($basedir == $basepath){
						   $query = "INSERT INTO {$dbname}_folders(base_id, name, date_added) values((SELECT id FROM base_url WHERE name=\"$basedir\"), \"$file\", '$date')";
					   }
					   else{
							$query = "INSERT INTO {$dbname}_folders(base_id, parent_id, name, date_added) values((SELECT id FROM base_url WHERE name=\"$basedir\"), (SELECT id FROM {$dbname}_folders as {$dbname} WHERE name=\"$basedir\"), \"$file\", '$date')";   
							//echo "$query<br/>";
					   }
					   executeQuery($query);
				   }
				   getDirectory( "$path/$file", $basepath, ($level+1), $dbname);
				   
				} 
				else { 
	
				   $basedir = basename($path);
				   $dirname = basename(dirname($path));
				   
				   $parent1 = $basedir;
				   $parent2 = $dirname;
				   if($parent2 == $basepath){
						$query = "SELECT id FROM base_url WHERE name=\"$parent2\"";
						$result = executeQuery($query);
						$row = mysql_fetch_array($result);
						$base_id = $row["id"];
				   }
					else
						$base_id = "NULL";
				   
				   if($parent2 != $basepath)
					   $query_parent = "SELECT id FROM {$dbname}_folders WHERE name=\"$parent1\" and parent_id=(SELECT id FROM {$dbname}_folders WHERE name=\"$parent2\")";
				   else   
					   $query_parent = "SELECT id FROM {$dbname}_folders WHERE name=\"$parent1\" and parent_id is NULL";
				   $query = "SELECT * FROM {$dbname}_files WHERE parent_id=($query_parent) and name=\"$file\"";
				   $result = executeQuery($query);
				   if(mysql_num_rows($result) == 0)
				   {
					   //$query_parent = "SELECT id FROM {$dbname}_folders WHERE name=\"$parent1\" and parent_id=(SELECT id FROM {$dbname}_folders WHERE name=\"$parent2\")";
					   $query = "INSERT INTO {$dbname}_files(parent_id, name) values(($query_parent),\"$file\")";
					   executeQuery($query);
					   //echo "$file<br/>";
				   }
				} 
			} 
		} 
		closedir( $dh ); 
		// Close the directory handle 
		// echo "<br/>Files added from <br/>path = '$path' to <br/>database = $dbname";
	} 
	
	function shortText($text, $length) {
		if( strlen($text) > $length ) return substr(preg_replace("/(<\/?)(\w+)([^>]*>)/", "", $text), 0, $length)."...";
		return preg_replace("/(<\/?)(\w+)([^>]*>)/", "", $text);
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

function get_data($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_TIMEOUT, 100);
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
	if($read=='.' || $read=='..' || $read=='createzip.php' || $read=='CreateZipFile.inc.php' || $read=='D0Wl0Ad3d bY dANkY' || $read=='D0Wl0Ad3d bY CaRtOoNz' || $read=='AlbumArtSmall.jpg' || $read=='Folder.jpg' || $read=='desktop.ini' || strpos($read,'.db')==true || strpos($read,'AlbumArt_')==true || strpos($read,'.zip')==true)
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

function load_category_list($sub = 0){
	
	include('connectDB.php');
	$query = "CREATE TABLE IF NOT EXISTS `base_url` (
  				`id` int(20) NOT NULL AUTO_INCREMENT,
				`parent_id` int(20) NOT NULL DEFAULT '0',
  				`category` varchar(100) NOT NULL,
				`name` varchar(100) NOT NULL,
			    `url` varchar(200) NOT NULL,
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
		echo "
		<tr id='category_list_".$row['id']."'>
			<td title='".$row['category']."' style='cursor:pointer;'>Category #$cntr</td>
			<td id='parent'><input type='hidden' value='".$row['parent_id']."'></td>
			<td id='category'>
				".$row['category']."
			</td>
			<td id='url'>
				".$row['url']."
			</td>
			<td>
				<a href='' onclick='editCategory(".$row['id'].");return false;'><img src='img/icons/icon_edit.png' border=0 style='display:inline;'></a>
				<a href='' onclick='removeCategory(".$row['id'].");return false;'><img src='img/icons/icon_unapprove.png' border=0></a>
			</td>
		</tr>
		";
		$query = "SELECT * FROM base_url WHERE parent_id=".$row["id"];
		$result1 = executeQuery($query);
		$cntr1 = 0;
		while($row1 = mysql_fetch_array($result1)){
			$cntr1 ++;
			echo "
			<tr id='category_list_".$row1['id']."' style='color:#BBB;'>
				<td title='".$row1['category']."' style='cursor:pointer;'>&nbsp;&nbsp;&nbsp;Category #$cntr.$cntr1</td>
				<td id='parent'><input type='hidden' value='".$row1['parent_id']."'></td>
				<td id='category'>
					".$row1['category']."
				</td>
				<td id='url'>
					".$row1['url']."
				</td>
				<td>
					<a href='' onclick='editCategory(".$row1['id'].");return false;'><img src='img/icons/icon_edit.png' border=0 style='display:inline;'></a>
					<a href='' onclick='removeCategory(".$row1['id'].");return false;'><img src='img/icons/icon_unapprove.png' border=0></a>
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