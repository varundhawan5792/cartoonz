<!DOCTYPE html>
<html lang="en">
<?php

include_once('../include/functions.php');

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CARTOONZ - Control Room</title>
<link href="styles/main.css" rel="stylesheet" type="text/css" />
<link href="styles/override.css" rel="stylesheet" type="text/css" />
	<script type='text/javascript' src='scripts/jquery.min.js'></script>
	<script>
		$(function() {
			$(".usage > span").each(function() {
				$(this)
					.data("origWidth", $(this).width())
					.width(0)
					.animate({
						width: $(this).data("origWidth")
					}, 1200);
			});
		});
	</script>
</head>
<body id="homepage">
	<div id="header">
    	<a href="" title=""><img src="img/cp_logo.png" alt="Control Panel" class="logo" /></a>
    	<div id="user-info">
            <p class="notifycount"><a href="" title="You have new notifications!" class="notifypop">3</a></p>
        	<p class="user-other">Logged in as:</p>
            <p class="username">admin</p>
            <p class="userbtn"><a href="#" title="">Log out</a></p>
        </div>
    </div>
        
    <!-- Top Breadcrumb Start -->
    <div id="breadcrumb">
    	<ul>	
        	<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
        	<li><strong>You are here :</strong></li>
            <li><a href="#" title="">ACP Index</a></li>
            <li>»</li>
            <li class="current">Dashboard</li>
        </ul>
    </div>
    <!-- Top Breadcrumb End -->
     
    <!-- Right Side/Main Content Start -->
    <div id="rightside">
    
    	<!-- Warnings! -->
        <div id="warning_container">
        </div>
        <!-- Warnings End -->
        
        <!-- Content Box Start -->
        <div class="contentcontainer">
            <div class="headings alt">
                <h2>Usages & Stats</h2>
            </div>
            <div class="contentbox">
            	<table id="cpu_usage">
                	<tr>
                    	<th width="100" class="head"><strong>CPU Usage:</strong></th>
                        <th width="200" class="head"></th>
                        <th width="50" class="head" ><span id="loader" style="float:right;display:none;"><img src="img/ajax-loader.gif" height="10"></span></th>
                     </tr>
                     <?php
					 	
						load_server_list();
					 
					 ?>
                </table>
            </div>
        </div>
        <!-- Content Box End -->
        
        <div style="clear:both;"></div>

        <!-- Content Box Start -->
        <div class="contentcontainer">
            <div class="headings">
                <h2>File Stats</h2>
            </div>
            <div class="contentbox">
                <div class="noticeboxalt">
                    <div class="innernotice">
                        <h4>Top Downloads</h4>
                        <table>
                			<tr>
                            	<td width="5%">#1</td>
                    			<td width="auto">Ladies vs. Ricky Bahl</td>
                        		<td width="20%">247</td>
                     		</tr>
                            <tr class="alt">
                            	<td width="5%">#2</td>
                    			<td width="auto">Band Baaja Baraat</td>
                        		<td width="20%">201</td>
                     		</tr>
                            <tr>
                            	<td width="5%">#3</td>
                    			<td width="auto">Patiala House</td>
                        		<td width="20%">162</td>
                     		</tr>
                            <tr class="alt">
                            	<td width="5%">#4</td>
                    			<td width="auto">Badmaash Company</td>
                        		<td width="20%">101</td>
                     		</tr>
                            <tr>
                            	<td width="5%">#5</td>
                    			<td width="auto">Rab Ne Bana Di Jodi</td>
                        		<td width="20%">72</td>
                     		</tr>
                         </table>
                    </div>
                </div>
                <div class="noticeboxalt">
                    <div class="innernotice">
                         <h4>Top Requests</h4>
                        <table>
                			<tr>
                            	<td width="5%">#1</td>
                    			<td width="auto">Ladies vs. Ricky Bahl</td>
                        		<td width="20%">247</td>
                     		</tr>
                            <tr class="alt">
                            	<td width="5%">#2</td>
                    			<td width="auto">Band Baaja Baraat</td>
                        		<td width="20%">201</td>
                     		</tr>
                            <tr>
                            	<td width="5%">#3</td>
                    			<td width="auto">Patiala House</td>
                        		<td width="20%">162</td>
                     		</tr>
                            <tr class="alt">
                            	<td width="5%">#4</td>
                    			<td width="auto">Badmaash Company</td>
                        		<td width="20%">101</td>
                     		</tr>
                            <tr>
                            	<td width="5%">#5</td>
                    			<td width="auto">Rab Ne Bana Di Jodi</td>
                        		<td width="20%">72</td>
                     		</tr>
                         </table>
                    </div>
                </div>
                <div class="noticeboxalt">
                    <div class="innernotice">
                        <h4>Notice</h4>
                        <p></p>
                        <p>Dhawan bhai, isko hata kar kuch achha sa daalna iski jagah.. Tab tak ke liye space holder =))</p>
                        <p><a href="#" title="">Read more</a></p>
                    </div>
                </div>

                <div style="clear: both;"></div>
            </div>
        </div>
        <!-- Content Box End -->
        <div id="footer" >
        	&copy; No-Copyright 2012 <!-- You still can't copy us. Yes, we are that good! --> 
        </div> 
          
    </div>
    <!-- Right Side/Main Content End -->
    
    <!-- Left Dark Bar Start -->
    <div id="leftside">
        <div class="item-container" align="center">
            <p><a>Space Holder</a></p>
            <p class="smltxt">&lt;!--Insert content in future--&gt;</p>
        </div>
        
        <ul id="nav">
        	<li>
                <ul class="navigation">
                    <li class="heading selected">Dashboard</li>
                </ul>
            </li>
            <li>
                <a class="collapsed heading">Users</a>
                <ul class="navigation">
                    <li><a href="#" title="">Manage users</a></li>
                    <li><a href="#" title="">User log</a></li>
                </ul>
            </li>
            <li><a class="collapsed heading">Downloads</a>
                 <ul class="navigation">
                    <li><a href="#" title="">Categories</a></li>
                    <li><a href="#" title="">Settings</a></li>
                    <li><a href="#" title="">File Types</a></li>
                    <li><a href="#" title="">Files</a></li>
                </ul>
            </li>             
            <li><a class="expanded heading">Miscellaneous</a>
                 <ul class="navigation">
                    <li><a href="#" title="">Upcoming</a></li>
                    <li><a href="#" title="">Requests</a></li>
                </ul>
            </li>            
        </ul>
    </div>
    <!-- Left Dark Bar End --> 
    
    <!-- Notifications Box/Pop-Up Start --> 
    <div id="notificationsbox">
        <h4>Notifications</h4>
        <ul>
            <li>
            	<a href="#" title=""><img src="img/icons/icon_square_close.png" alt="Close" class="closenot" /></a>
            	<h5>New member registration</h5>
                <p>Scyther joined on 18.02.2012 [172.16.8.47]</p>
            </li>
            <li>
            	<a href="#" title=""><img src="img/icons/icon_square_close.png" alt="Close" class="closenot" /></a>
            	<h5>Unfair usage/High load</h5>
                <p>Large number of requests from ip 172.16.8.247</p>
            </li>
            <li>
            	<a href="#" title=""><img src="img/icons/icon_square_close.png" alt="Close" class="closenot" /></a>
              	<h5>New member registration</h5>
                <p>DeX joined on 18.02.2012 [172.16.8.137]</p>
            </li>
        </ul>
        <p class="loadmore"><a href="#" title="">Load more notifications</a></p>
    </div>
    <!-- Notifications Box/Pop-Up End --> 
    
    <script type='text/javascript' src='scripts/jquery-ui.min.js'></script>
    <script type="text/javascript" src='scripts/functions.js'></script>
    <script type="text/javascript" src='scripts/tasks.js'></script>
    <!--[if IE 6]>
    <script type='text/javascript' src='scripts/png_fix.js'></script>
    <script type='text/javascript'>
      DD_belatedPNG.fix('img, .notifycount, .selected');
    </script>
    <![endif]--> 
</body>
</html>
