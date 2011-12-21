<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CARTOONZ</title>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var height;
	if( typeof( window.innerWidth ) == 'number' )
		height = window.innerHeight - 50;
	else if( document.documentElement && document.documentElement.clientHeight )
		height = document.documentElement.clientHeight - 50;
	else if( document.body && document.body.clientHeight )
		height = document.body.clientHeight - 50;
	//alert(height);
	$("#css-table .col").height(height);
	$(".resize").height(.88*height);
	loadMusic();
});
$(window).resize(function(){
	var height;
	if( typeof( window.innerWidth ) == 'number' )
		height = window.innerHeight - 50;
	else if( document.documentElement && document.documentElement.clientHeight )
		height = document.documentElement.clientHeight - 50;
	else if( document.body && document.body.clientHeight )
		height = document.body.clientHeight - 50;
	//alert(height);
	$("#css-table .col").height(height);
	$(".resize").height(.88*height);
	loadMusic();
})
</script>
<style type="text/css">
<!--
body {
	margin:0px;
	overflow:hidden;
	font:Arial, Helvetica, sans-serif;
	scrollbar-face-color:#c0c0c0;
    scrollbar-arrow-color:#FFFFFF;
    scrollbar-track-color:#F6F6F6;
	
	scrollbar-highlight-color: #c0c0c0;
	scrollbar-shadow-color: #c0c0c0; 
	scrollbar-3dlight-color: #f6f6f6;
	scrollbar-darkshadow-color: #f6f6f6;
}

.ellipsis span {

   white-space:nowrap;
   text-overflow:ellipsis; /* for internet explorer */
   overflow:hidden;
   width:190px;
   display:block;
}

html>body .ellipsis {
   clear:both;
}

html>body .ellipsis span:after {
   content: "...";
}

html>body .ellipsis span {
   max-width:180px;
   width:auto !important;
   float:left;
}

/** Scrollbar **/
::-webkit-scrollbar {
	background:transparent;
	width:8px;
	height:8px;
}
::-webkit-scrollbar-thumb {
	background-color: #c0c0c0;
	border:1px solid #9c9c9c;
}
::-webkit-scrollbar-thumb:hover {
	background-color: #909090;
	border:1px solid #676767;
}
::-webkit-scrollbar-track {
	background:#f2f2f2;
	border:1px solid #dadada;
}
::-webkit-scrollbar-corner {	
}


/** Top Bar **/
.topbar {
	height:50px;
	width:100%;
	background: #605f5f;
	background: -moz-linear-gradient(top,  #605f5f 0%, #4a4a4a 55%, #323232 99%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#605f5f), color-stop(55%,#4a4a4a), color-stop(99%,#323232));
	background: -webkit-linear-gradient(top,  #605f5f 0%,#4a4a4a 55%,#323232 99%);
	background: -o-linear-gradient(top,  #605f5f 0%,#4a4a4a 55%,#323232 99%);
	background: -ms-linear-gradient(top,  #605f5f 0%,#4a4a4a 55%,#323232 99%);
	background: linear-gradient(top,  #605f5f 0%,#4a4a4a 55%,#323232 99%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#605f5f', endColorstr='#323232',GradientType=0 );
	-webkit-box-shadow: 2px 1px 8px 3px rgba(0, 0, 0, 0.2);
	-moz-box-shadow: 2px 1px 8px 3px rgba(0, 0, 0, 0.2);
	-o-box-shadow: 2px 1px 8px 3px rgba(0, 0, 0, 0.2);
	box-shadow: 2px 1px 8px 3px rgba(0, 0, 0, 0.2);
	position:relative;
	z-index:5000;
}
#css-table { 
	display: table; 
	z-index:10;
	width:100%;
}
#css-table .col { 
	display: table-cell; 
	padding: 0px; 
}
#lane1 {
	height:680px;
	width:15.5%;
	-webkit-cell-width:18.6%;
	background:#eeeeee;
	border:1px solid #cccccc;
	border-top:none;
	border-bottom:none;
	border-left:none;
	position:relative;
	z-index:4000;
	-webkit-box-shadow: -2px 0px 11px 1px rgba(0, 0, 0, 0.2);
	-moz-box-shadow: -2px 0px 11px 1px rgba(0, 0, 0, 0.2);
	-o-box-shadow: -2px 0px 11px 1px rgba(0, 0, 0, 0.2);
	box-shadow: -2px 0px 11px 1px rgba(0, 0, 0, 0.2);
}
#lane2 {
	height:680px;
	width:26.5%;
	background:#f6f6f6;
	border:1px solid #cccccc;
	border-top:none;
	border-bottom:none;
	border-left:none;
	position:relative;
	z-index:3000;
	-webkit-box-shadow: -2px 0px 11px 1px rgba(0, 0, 0, 0.2);
	-moz-box-shadow: -2px 0px 11px 1px rgba(0, 0, 0, 0.2);
	-o-box-shadow: -2px 0px 11px 1px rgba(0, 0, 0, 0.2);
	box-shadow: -2px 0px 11px 1px rgba(0, 0, 0, 0.2);
}
#lane3 {
	height:680px;
	width:30.5%;
	background:#f6f6f6;
	border:1px solid #cccccc;
	border-top:none;
	border-bottom:none;
	border-left:none;
	position:relative;
	z-index:2000;
	-webkit-box-shadow: -2px 0px 11px 1px rgba(0, 0, 0, 0.2);
	-moz-box-shadow: -2px 0px 9px 1px rgba(0, 0, 0, 0.1);
	-o-box-shadow: -2px 0px 11px 1px rgba(0, 0, 0, 0.2);
	box-shadow: -2px 0px 11px 1px rgba(0, 0, 0, 0.1);
}
#lane4 {
	height:0px !important;
	width:27.5%;
	background:#eeeeee;
	border:1px solid #cccccc;
	border-top:none;
	border-bottom:none;
	border-left:none;
	position:relative;
	z-index:1000;
}
#container {
	width:98%; 
	overflow-x:hidden; 
	overflow-y:scroll;
	height:250px;
	margin-bottom:10px;
}

/** CSS for Lane 1 **/
ul#main_list {
	margin:0px;
	padding-left:0px;
	font-size:18px;
}
ul#main_list, ul#main_list ul, ul#main_list li {
	list-style-type: none;
}
ul#main_list li {
	text-shadow:1px 1px #ccc;
}
ul#main_list li:hover {
	color:#fff;
	text-shadow:1px 1px #666;
	background: #a7c7dc;
	background: -moz-linear-gradient(top, #a7c7dc 0%, #85b2d3 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#a7c7dc), color-stop(100%,#85b2d3));
	background: -webkit-linear-gradient(top, #a7c7dc 0%,#85b2d3 100%);
	background: -o-linear-gradient(top, #a7c7dc 0%,#85b2d3 100%);
	background: -ms-linear-gradient(top, #a7c7dc 0%,#85b2d3 100%);
	background: linear-gradient(top, #a7c7dc 0%,#85b2d3 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a7c7dc', endColorstr='#85b2d3',GradientType=0 );
	cursor:pointer;
	box-shadow: -1px 1px 1px 1px rgba(0, 0, 0, 0.2);
}
ul#main_list li a {
	text-decoration: none;
	font-family:Georgia, "Times New Roman", Times, serif !important;
	display: block;
	padding: 9px;
	padding-left:40px;
	margin-left:25px;
}
ul#main_list li a.home {
	background:url(images/icons/home-icon.png) left no-repeat;
}
ul#main_list li a.music {
	background:url(images/icons/music-icon.png) left no-repeat;
}
ul#main_list li a.videos {
	background:url(images/icons/video-icon.png) left no-repeat;
}
ul#main_list li a.movies {
	background:url(images/icons/movie-icon.png) left no-repeat;
}

/** CSS for Lane 2 **/
ul#other_list {
	margin:0px;
	padding-left:0px;
	font-size:16px;
}
ul#other_list, ul#other_list ul, ul#other_list li {
	list-style-type: none;
}
ul#other_list li {
	white-space: nowrap;
	width: 100%;
	text-overflow:ellipsis;
	-o-text-overflow: ellipsis;  
    -ms-text-overflow: ellipsis; 
	overflow:hidden;
	white-space:nowrap;
	
}
ul#other_list li:hover {
	text-shadow:1px 1px #eee;
	background: #dcdce1;
	background: -moz-linear-gradient(top,  #dcdce1 0%, #bec3c8 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#dcdce1), color-stop(100%,#bec3c8));
	background: -webkit-linear-gradient(top,  #dcdce1 0%,#bec3c8 100%);
	background: -o-linear-gradient(top,  #dcdce1 0%,#bec3c8 100%);
	background: -ms-linear-gradient(top,  #dcdce1 0%,#bec3c8 100%);
	background: linear-gradient(top,  #dcdce1 0%,#bec3c8 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#dcdce1', endColorstr='#bec3c8',GradientType=0 );

	cursor:pointer;
	box-shadow: -1px 1px 1px 1px rgba(0, 0, 0, 0.2);
}
ul#other_list li a {
	text-decoration: none;
	//font-family:Georgia, "Times New Roman", Times, serif !important;
	display: block;
	padding: 5px;
	padding-left:35px;
	margin-left:15px;
	text-overflow:ellipsis;
	-o-text-overflow: ellipsis;  
    -ms-text-overflow: ellipsis; 
	overflow:hidden;
	white-space:nowrap;
	width: 290px;
}
ul#other_list li a.folder {
	background:url(images/icons/folder-icon.png) left no-repeat;
	text-overflow:ellipsis;
	overflow:hidden;
	white-space:nowrap;
}
ul#other_list li a.music {
	background:url(images/icons/music-icon.png) left no-repeat;
}
ul#other_list li a.videos {
	background:url(images/icons/video-icon.png) left no-repeat;
}
ul#other_list li a.movies {
	background:url(images/icons/movie-icon.png) left no-repeat;
}
ul#other_list li a.avi {
	background:url(images/icons/avi-icon.png) left no-repeat;
}
ul#other_list li a.playlist {
	background:url(images/icons/file-icon.png) left no-repeat;
}
#loader {
	text-align: center;
	background: white;
	width: 90%;
	margin: auto;
	margin-bottom:5px;
	margin-top:5px;
	padding: 3px;
	border: 1px solid #CCC;
	border-radius:3px;
	-webkit-border-radius:3px;
	-moz-border-radius:3px;
	-o-border-radius:3px;
	box-shadow:0px 1px 3px 1px rgba(0,0,0,0.1);
	-webkit-box-shadow:0px 1px 3px 1px rgba(0,0,0,0.1);
	-moz-box-shadow:0px 1px 3px 1px rgba(0,0,0,0.1);
	-o-box-shadow:0px 1px 3px 1px rgba(0,0,0,0.1);
	opacity: 0.8;
	color: #666;
	font-variant:small-caps;
	display:none;
}
#form {
	width:90%;
	height:12%;
	background:#3e3e3e;
	margin:auto;
	margin-top:15%;
	text-align:center;
	padding-top:15px;
	-webkit-border-radius:5px;
	-moz-border-radius:5px;
	-o-border-radius:5px;
	box-shadow:0px -3px 12px 1px rgba(0,0,0,0.2);
	-webkit-box-shadow:0px -3px 12px 1px rgba(0,0,0,0.2);
	-moz-box-shadow:0px -3px 12px 1px rgba(0,0,0,0.2);
	-o-box-shadow:0px -3px 12px 1px rgba(0,0,0,0.2);
}
.form_vis {
	transition: all 0.5s ease-in-out;
	-moz-transition: all 0.5s ease-in-out; 
	-webkit-transition: all 0.5s ease-in-out; 
	-o-transition: all 0.5s ease-in-out;  
}
.form_vis:hover {
	background:#000000;
	transition: all 0.5s ease-in-out;
	-moz-transition: all 0.5s ease-in-out; 
	-webkit-transition: all 0.5s ease-in-out; 
	-o-transition: all 0.5s ease-in-out;  
}
#form input {
	-webkit-border-radius:3px;
	-moz-border-radius:3px;
	-o-border-radius:3px;
	box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
	-moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
	-webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
	-o-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
	color: #666;
	border:1px solid #ccc;
	padding:3px 5px;
	height:32%;
}


-->
</style>
</head>

<body>
	<div class="topbar" id="top_bar">
    </div>
    <div id="css-table">
			<div class="col" id="lane1">
             <div class="resize">
              <ul id="main_list">
              	<li>
                   <a class="home">Home</a>
                </li>
                <li>
                   <a class="music">Music</a>
                </li>
                <li>
                   <a class="videos">Videos</a>
                </li>
                <li>
                   <a class="movies">Movies</a>
                </li>
              </ul>
             </div> 
            </div>
			<div class="col" id="lane2">
             <div id="container" class="resize">
              <div id="loader" style="text-align:center;">
                 <img src="images/ajax-loader1.gif">&nbsp;&nbsp;just a second, getting it for you!
              </div>   
              <ul id="other_list">
              	<li><a>Oh, maybe you havn't selected anything!</a></li>
              </ul>
              
             </div>
             <div id="form" style="display:none;">
              	<input id="search" type="text" style="width:80%;margin:auto;" value="Search" alt="Search">	
              </div>
            </div>
			<div class="col" id="lane3">
             <div id="container" class="resize">
               <ul id="other_list">
              	<li>
                   <a class="folder">Screens</a>
                </li>
                <li>
                   <a class="avi">Ladies vs Ricky Bahl.avi</a>
                </li>
                <li>
                   <a class="avi">Ladies vs Ricky Bahl(Sample).avi</a>
                </li>
                <li>
                   <a class="playlist">Ladies vs Ricky Bahl.srt</a>
                </li>
              </ul>
             </div> 
            </div>
			<div class="col" id="lane4">
               <iframe src="fileinfo.php" style="width:100%;height:400px;overflow:hidden;margin-bottom:-400px;" frameborder="0" scrolling="no">
               </iframe>
            </div>
	</div>

</body>
</html>
