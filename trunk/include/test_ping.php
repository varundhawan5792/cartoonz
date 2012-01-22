<?php

include('functions.php');

function ping($ip){
	$str = exec("ping -n 1 -w 1 $ip", $input, $result);
	if ($result == 0){
		echo 'up';
	}else{
		echo 'down';
	}
}

$myip = getIp();
$hosts_to_ping = array();
$base = substr($myip, 0, strrpos($myip, '.', -1));
echo $base."<br/>";
for($i = 110; $i <= 115; $i++)
    array_push($hosts_to_ping, $base.".$i");



foreach ($hosts_to_ping as $host): 
	echo $host."  -  ";
	$up = get_data("http://$host/cartoonz/include/do.php?q=alive", 1);
	echo $up ;
	echo "<br/>";
endforeach;

?>