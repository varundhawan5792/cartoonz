<?php

function executeQuery($query){
	//echo $query."<br/>";
	include('connectDB.php');
	$result = mysql_query($query,$con);
	mysql_close($con);
	return $result;
}

function isAllowed($read)
{
	if($read=='.' || $read=='..' || $read=='createzip.php' || $read=='CreateZipFile.inc.php' || $read=='D0Wl0Ad3d bY dANkY' || $read=='D0Wl0Ad3d bY CaRtOoNz' || $read=='AlbumArtSmall.jpg' || $read=='Folder.jpg' || $read=='desktop.ini' || strpos($read,'.db')==true || strpos($read,'AlbumArt')==true || strpos($read,'.zip')==true || strpos($read,'.nfo')==true)
		return false;
    else		
		return true;
	
}

function listdir($dbname, $base, $start_dir='.') {
  $files = array();
  if (is_dir($start_dir)) {
    $fh = opendir($start_dir);
    while (($file = readdir($fh)) !== false) {
      # loop through the files, skipping . and .., and recursing if necessary
       $query = "SELECT * FROM {$dbname}_folders WHERE name like \"$file\"";
	   $result = executeQuery($query);
	   if(mysql_num_rows($result) == 0)
	   {
		  if (!isAllowed($file)) continue;
		  $filepath = $start_dir . '/' . $file;
		  if ( is_dir($filepath) ){
			$date = date(filemtime($filepath));
			if(basename($start_dir) != $base){
			  echo "<tr><td>".basename(dirname($start_dir))."</td><td>".basename($start_dir)."</td><td> $file </td></tr>";
			  
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
			echo "<tr><td>".basename(dirname($start_dir))."</td><td>".basename($start_dir)."</td><td> $file </td></tr>";
			if(basename(dirname($start_dir)) != $base){
				$query_parent = "SELECT id FROM {$dbname}_folders WHERE name=\"".basename($start_dir)."\" and parent_id=(SELECT id FROM {$dbname}_folders WHERE name=\"".basename(dirname($start_dir))."\")";
			}
			else{
				$query_parent = "SELECT id FROM {$dbname}_folders WHERE name=\"".basename($start_dir)."\" and parent_id is NULL";
			}
			$query = "INSERT INTO {$dbname}_files(parent_id, name) values(($query_parent),\"$file\")";
			executeQuery($query);
			array_push($files, $filepath);
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
date_default_timezone_set('Asia/Calcutta');
	
echo print_r( stat('X:/wamp/www/songs'), true);
echo "<table>";
//$files = listdir('music','songs','X:/wamp/www/songs');
echo "</table>";
//print_r($files);
?>
