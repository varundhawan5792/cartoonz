<?php


getDirectory('X:/wamp/www/songs', '10', 'music');

function getDirectory( $path = '.', $level = 0, $dbname){ 
	
    $ignore = array( 'cgi-bin', '.', '..', '.svn' ); 
    $dh = @opendir( $path ); 
    while( false !== ( $file = readdir( $dh ) ) ){ 
        if( !in_array( $file, $ignore ) && isAllowed($file)){ 
        // Check that this file is not to be ignored 
            $spaces = str_repeat( '&nbsp;&nbsp;', ( $level * 2 ) ); 
            if( is_dir( "$path/$file" ) ){ 
               // Its a directory, so we need to keep reading down... 
               //echo "$spaces Folder DB: ".basename($path).", $file, $path/$file<br/>";
			   $basedir = basename($path);
			   $url = $path.'/'.$file;
			   $record = "\r\n'$basedir','$file','$url'";
			   if(strpos(fileRead($dbname."_folders.txt"), $record) == false){
 			      $query = "INSERT INTO {$dbname}_folders(parent_name, name, url) values('$basedir','$file','$url')";
  			      executeQuery($query);
			      writeFile($dbname."_folders.txt", $record);
			   }
               getDirectory( "$path/$file", ($level+1), $dbname);
			   //echo "<br/>Folder path = '$path' added to <br/>database = $dbname";
            } 
			else { 
               //echo "$spaces File DB: ".basename($path).", $file<br />";
			   $basedir = basename($path);
			   $record = "\r\n'$basedir','$file'";
			   if(strpos(fileRead($dbname."_files.txt"), $record) == false){
				   $query = "INSERT INTO {$dbname}_files(parent_name, name) values('$basedir','$file')";
				   executeQuery($query);
			   	   writeFile($dbname."_files.txt", $record);
			   }
            } 
        } 
    } 
    closedir( $dh ); 
    // Close the directory handle 
	echo "<br/>Files added from <br/>path = '$path' to <br/>database = $dbname";
} 

function executeQuery($query){
	include('connectDB.php');
	$result=mysql_query($query,$con);
	mysql_close($con);
	return $result;
}

function writeFile($file, $data){
	$fp = fopen($file, "a+");
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