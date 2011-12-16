<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="js/jquery.min.js"></script>
<style type="text/css">
body {
	background:#eeeeee;
	overflow:hidden;
	font-family:Arial, Helvetica, sans-serif;
	/*font-family:Georgia, "Times New Roman", Times, serif !important;*/
	font-size:14px;
}
/** File Information **/
#mime_type {
	text-align:center;
	margin:auto;
	margin-top: 20px;
}
#mime_type .space {
	height:40px;
}
#mime_type .avi {
	width:128px;
	height:128px;
	margin:auto;
	background:url(images/icons/avi-icon-big.png) center no-repeat;
}
.file_info {
	width:75%;
	padding:0 13px 5px 13px;
	margin:auto;
	margin-top:5px;
	margin-bottom: 20px;
	background:#ffffff;
	border-radius:3px;
	-webkit-border-radius:3px;;
	-moz-border-radius:3px;
	-o-border-radius:3px;
	box-shadow:0px 1px 3px 1px rgba(0,0,0,0.1);
	-webkit-box-shadow:0px 1px 3px 1px rgba(0,0,0,0.1);
	-moz-box-shadow:0px 1px 3px 1px rgba(0,0,0,0.1);
	-o-box-shadow:0px 1px 3px 1px rgba(0,0,0,0.1);
	border:1px solid #ccc;
}
.file_info p {
	line-height:9px;
}

.options {
	width:95%;
	text-align:center;
	margin:auto;
	margin-top:15px;
}
/** Buttons **/
div.button {
	display:inline-block;
	width:93px;
	padding:7px;
	margin:5px 5px;
	color:#fff;
	font-weight:bold;
	font-size:18px;
	text-align:center;
	text-shadow:0px 1px rgba(0,0,0,0.2);
	background: #a7c7dc;
	background: -moz-linear-gradient(top, #a7c7dc 0%, #85b2d3 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#a7c7dc), color-stop(100%,#85b2d3));
	background: -webkit-linear-gradient(top, #a7c7dc 0%,#85b2d3 100%);
	background: -o-linear-gradient(top, #a7c7dc 0%,#85b2d3 100%);
	background: -ms-linear-gradient(top, #a7c7dc 0%,#85b2d3 100%);
	background: linear-gradient(top, #a7c7dc 0%,#85b2d3 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a7c7dc', endColorstr='#85b2d3',GradientType=0 );
	cursor:pointer;
	-webkit-border-radius:3px;;
	-moz-border-radius:3px;
	-o-border-radius:3px;
	box-shadow:0px 1px 3px 1px rgba(0,0,0,0.1);
	-webkit-box-shadow:0px 1px 3px 1px rgba(0,0,0,0.1);
	-moz-box-shadow:0px 1px 3px 1px rgba(0,0,0,0.1);
	-o-box-shadow:0px 1px 3px 1px rgba(0,0,0,0.1);
}
div.button:hover {
	background: #88bfe8;
	background: -moz-linear-gradient(top, #88bfe8 0%, #70b0e0 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#88bfe8), color-stop(100%,#70b0e0));
	background: -webkit-linear-gradient(top, #88bfe8 0%,#70b0e0 100%);
	background: -o-linear-gradient(top, #88bfe8 0%,#70b0e0 100%);
	background: -ms-linear-gradient(top, #88bfe8 0%,#70b0e0 100%);
	background: linear-gradient(top, #88bfe8 0%,#70b0e0 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#88bfe8', endColorstr='#70b0e0',GradientType=0 );
}
</style>
</head>

<body>
<div class="container" style="margin-top:10px;">
<div id="mime_type">
    <img src="images/icons/avi-icon-big.png" />
</div><br />

<div class="file_info">
    <p>Ladies vs Ricky Bahl.avi</p>
    <p>video/avi</p>
    <p>770 mb</p>
    <p>16/12/2011 8:16 PM</p>
</div>

<div class="options">
	<div class="button" onclick="return false;">
    	Play
    </div>  
    <div class="button" onclick="return false;">
    	Download
    </div>   
</div>
</div>
</body>
</html>
