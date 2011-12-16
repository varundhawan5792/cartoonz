<?php

	$domain="localhost";
	$username="root";
	$pwd="";
	$database="cartoonz-alpha";
	$con=mysql_connect($domain,$username,$pwd);
	if(!$con)
	{
		die("Cannot connect to database: ".mysql_error());
	}
	mysql_select_db($database,$con);
	
?>