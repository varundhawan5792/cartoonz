<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CARTOONZ - Bigger. Better. Faster.</title>

<link href="css/main-alpha.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/functions.js"></script>  
 <script type="text/javascript">
$(document).ready(function(){
	var height, offset = $("#breadcrumb").offset().top + $("#breadcrumb").height();
	if( typeof( window.innerWidth ) == 'number' )
		height = window.innerHeight - offset;
	else if( document.documentElement && document.documentElement.clientHeight )
		height = document.documentElement.clientHeight - offset;
	else if( document.body && document.body.clientHeight )
		height = document.body.clientHeight - offset;
	//alert(height);
	$("#lane2 #container").height(0.93*height);
	$("#lane3 #container").height(0.93*height);
	loadMusic();
});
$(window).resize(function(){
	var height, offset = $("#breadcrumb").offset().top + $("#breadcrumb").height();
	if( typeof( window.innerWidth ) == 'number' )
		height = window.innerHeight - offset;
	else if( document.documentElement && document.documentElement.clientHeight )
		height = document.documentElement.clientHeight - offset;
	else if( document.body && document.body.clientHeight )
		height = document.body.clientHeight - offset;
	//alert(height);
	$("#container").height(0.93*height);
})
</script>
</head>

<body>

<!-- Top navigation bar -->
<div id="topNav">
    <div class="fixed">

            <div class="welcome"><a href="#" title=""><img src="images/userPic.jpg" alt="" height="40px" /></a><span>Howdy, Ankur!<br /><a href="#"><img src="images/icons/topnav/logout.png" alt="logout"> Logout</a></span></div>
            <div class="userNav">
                <ul>
                    <li><a href="#" title=""><img src="images/icons/topnav/profile.png" alt="" /><span>Profile</span></a></li>
                    <li><a href="#" title=""><img src="images/icons/topnav/tasks.png" alt="" /><span>Tasks</span></a></li>
                    <li><a href="#" title=""><img src="images/icons/topnav/messages.png" alt="" /><span>Messages</span><span class="numberTop">7</span></a></li>
                    <li><a href="#" title=""><img src="images/icons/topnav/settings.png" alt="" /><span>Settings</span></a></li>
                </ul>
            </div>
            <div id="form">
              	<input id="search" type="text" value="Search.." onblur="if(this.value == '') { this.value='Search..'}" onfocus="if (this.value == 'Search..') {this.value=''}"  alt="Search">	
            </div>
            <div class="fix"></div>
            

    </div>
</div>

<!-- Lane 1 - Menu -->
   <div class="sidebar">
      
   <ul class="menu">
		<li>
			<a href="#"><span class="dashboard icon2">Home</span></a>
		</li>
		<li class="expand">
			<a href="#"><span class="audio icon2">Audios</span><span class="num">2435</span></a>
			<ul class="acitem">
            	<li><a href="#"><span class="forms icon">Bollywood OST</span></a></li>
       			<li><a href="#"><span class="tables icon">Hindi Pop & Remix</span></a></li>
			</ul>
		</li>
		<li>
			<a href="#"><span class="video icon2">Videos</span><span class="num">116</span></a>
			<ul class="acitem">
                <li><a href="#"><span class="invoice icon">Bollywood Movies</span></a></li>
                <li><a href="#"><span class="youtube icon">English Movies</span></a></li>
                <li><a href="#"><span class="w-editor icon">Documentaries</span></a></li>	
       		    <li><a href="#"><span class="files icon">Video Songs</span></a></li>
			</ul>
		</li>
		<li>
			<a href="#"><span class="tv icon2">TV Series</span><span class="num">73</span></a>
			<ul class="acitem">
                <li><a href="#"><span class="errors icon">Hindi</span></a></li>
                <li><a href="#"><span class="errors icon">English</span></a></li>
                <li><a href="#"><span class="errors icon">Animé</span></a></li>
			</ul>
		</li>
        <li>
			<a href="#"><span class="four-prong icon2">Forum</span></a>
		</li>
	</ul>	
    
	</div>
<!-- Lane 1 - Menu End -->

    <!-- Top Breadcrumb Start -->
    <div id="breadcrumb">
		&nbsp;
    </div>
    <!-- Top Breadcrumb End -->
   
    <!-- Lane 2 - Index--> 
    		<div id="lane2">
             <div id="container" >
              <ul id="other_list">
              	<li>
                   <a class="folder">Don 2</a>
                </li>
                <li>
                   <a class="folder">Rockstar</a>
                </li>
                <li>
                   <a class="folder">Ladies vs Ricky Bahl</a>
                </li>
                <li>
                   <a class="folder">Pyaar Ka Punchnama</a>
                </li>
              </ul>
             </div>
            </div>
    <!-- Lane 2 - Index End --> 	
    		
    <!-- Lane 3 - Folder Details -->             
            <div id="lane3">
            	
                <div id="container">
            		<div id="pic_container" align="center">
                		<img src="./images/lvrb.jpg" height="150px" id="series_pic" alt="Ladies vs. Ricky Bahl">
                	</div>
                
               		 <div id="series_detail">
                		Title: Ladies vs. Ricky Bahl<br />Format: video/avi &nbsp; &nbsp; Size: 770mb<br />Rip: DVDScr<br />16/12/2011 3:42PM
             	   </div>
                
               		 <div align="center">
                		<div class="button" onclick="return false;">
    						Download as .zip
   						 </div>  
               		 </div>
                
              		  <div id="series_options">
							..or download individual files:
             		   </div>
               		<ul id="other_list">
              			<li>
                   			<a class="folder">Screens</a>
                		</li>
                		<li>
                   			<a class="avi">Ladies vs Ricky Bahl.avi</a>
                		</li>
                		<li>
                   			<a class="avi">Ladies vs Ricky Bahl (Sample).avi</a>
                		</li>
                		<li>
                   			<a class="playlist">Ladies vs Ricky Bahl.srt</a>
                		</li>
              		</ul>
             	</div> 
            </div>
    <!-- Lane 3 - Folder Details End-->  
    
    <!-- Lane 4 - Dynamic -->
    	<div id="lane4">
          	<div id="ribbon1">
            </div>
            <div align="center" style="position:relative; margin-top:-70px; z-index:-1;">
            	<img src="./images/heroes.jpg" height="150px" id="series_pic" alt="Heroes">
            </div>
            <div id="featured">
            	<span>They thought they were like everyone else.. Until they woke up with incredible abilities.</span>
			</div>   
            <div id="ribbon2">
            </div>  
            <div id="upcoming" style="position:relative; margin-top: -70px; z-index:-1;">
               		 Agneepath<span id="upcoming_type">Movie (B) &nbsp; - - -</span><br />
                     The Vampire Diaries<span id="upcoming_type">S03E12 &nbsp; - - -</span><br />
                     The Mentalist<span id="upcoming_type">S04E11 &nbsp; - - -</span><br />
                     Nikita<span id="upcoming_type">S02E11 &nbsp; - - -</span><br />
                     Chuck<span id="upcoming_type">S07E11 &nbsp; - - -</span><br />
                     Wrath of The Titans<span id="upcoming_type">Movie (H) &nbsp; - - -</span><br />
                     The Big Bang Theory<span id="upcoming_type">S04E15  &nbsp;  - - -</span>
            </div>
            <div id="copyright" align="center">
            	DISCLAIMER: All rights reserved. No, no copyright.
            </div>       
        </div>

</body>