<?php

function isAllowedName($read)
{
	if($read=='AlbumArtSmall' || $read=='Folder' || strpos($read,'AlbumArt')==true || strpos($read,'AlbumArt_')==true)
		return false;
    else		
		return true;
	
}

function php_file_tree($directory, $dbname, $extensions = array()) {
	// Generates a valid XHTML list of all directories, sub-directories, and files in $directory
	// Remove trailing slash
	$name_extensions = array("AlbumArt");
	if( substr($directory, -1) == "/" ) 
		$directory = substr($directory, 0, strlen($directory) - 1);
	php_file_tree_dir($directory, $dbname, $extensions, $name_extensions);
}

function php_file_tree_dir($directory, $dbname, $extensions = array(), $name_extensions = array(), $first_call = true) {
	// Recursive function called by php_file_tree() to list directories/files
	$php_file_tree='';
	// Get and sort directories/files
	if( function_exists("scandir") ) 
		$file = scandir($directory); 
	else 
		$file = php4_scandir($directory);
	natcasesort($file);
	
	// Make directories first
	$files = $dirs = array();
	foreach($file as $this_file) {
		if( is_dir("$directory/$this_file" ) ) 
			$dirs[] = $this_file; 
		else 
			$files[] = $this_file;
	}
	$file = array_merge($dirs, $files);
	
	// Filter unwanted extensions
	if( !empty($extensions) ) {
		foreach( array_keys($file) as $key ) {
			if( !is_dir("$directory/$file[$key]") ) {
				$ext = substr($file[$key], strrpos($file[$key], ".") + 1);
				$name =  substr($file[$key], 0, strrpos($file[$key], "."));
				if( !isAllowedName($name)) 
					   unset($file[$key]);
				if( !in_array($ext, $extensions) ) 
					unset($file[$key]);
			}
		}
	}
	$i_am_root = '';
	if( count($file) > 2 ) { // Use 2 instead of 0 to account for . and .. "directories"
		
		if( $first_call ) { 
			$first_call = false; 
			$i_am_root = $directory;
		}	
		foreach( $file as $this_file ) {
			if( $this_file != "." && $this_file != ".." ) {
				$flag = 0;
				if( is_dir("$directory/$this_file") ) {
					// Directory
					
					$parent = $directory;
					if($parent == $i_am_root)
						$parent = 'NULL';
					else
						$parent = basename($directory);
					$file = $this_file;
					//echo "<br/>$parent / $file<br/>";
					/****
					   STORE TO MYSQL
					 ****/
					 $date = date(filemtime($directory."/".$this_file));
					 if($parent == 'NULL'){
						$result = executeQuery("SELECT * FROM {$dbname}_folders WHERE name=\"$file\" and parent_id is NULL"); 
						if(mysql_num_rows($result) == 0){
					 	   executeQuery("INSERT INTO {$dbname}_folders(parent_id, name, date_added) values((SELECT id FROM {$dbname}_folders as {$dbname} WHERE name is NULL), \"$file\", '$date')");
						   $flag = 1;
						}
						else{
						   $row = mysql_fetch_array($result);
						   if($date != $row["date_added"]){
							   executeQuery("UPDATE {$dbname}_folders SET date_added='$date' WHERE id='".$row['id']."'");
							   $flag = 1;
							   executeQuery("DELETE FROM {$dbname}_files WHERE id='".$row['id']."'");
						   }
						}
					 }
					 else{
						$result = executeQuery("SELECT * FROM {$dbname}_folders WHERE name=\"$file\" and parent_id=(SELECT id FROM {$dbname}_folders as {$dbname} WHERE name like \"".$parent."\")"); 
						if(mysql_num_rows($result) == 0){
					 	   executeQuery("INSERT INTO {$dbname}_folders(parent_id, name, date_added) values((SELECT id FROM {$dbname}_folders as {$dbname} WHERE name like \"".$parent."\"), \"$file\", '$date')");
						   $flag = 1;
						}
						else{
						   $row = mysql_fetch_array($result);
						   if($date != $row["date_added"]){
							   executeQuery("UPDATE {$dbname}_folders SET date_added='$date' WHERE id='".$row['id']."'");
							   $flag = 1;
							   executeQuery("DELETE FROM {$dbname}_files WHERE id='".$row['id']."'");
						   }
						}
					 }
					 /****
					   END
					 ****/
					php_file_tree_dir("$directory/$this_file", $dbname, $extensions, $name_extensions, false);
					
				} else {
					// File  -- Do Nothing
				}
			}
		}
	}
}

// For PHP4 compatibility
function php4_scandir($dir) {
	$dh  = opendir($dir);
	while( false !== ($filename = readdir($dh)) ) {
	    $files[] = $filename;
	}
	sort($files);
	return($files);
}
