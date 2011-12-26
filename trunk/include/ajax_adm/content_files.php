<?php
	$baseURL = "http://" . $_SERVER['HTTP_HOST'] . "/";
	include('../functions.php');
?>
<!-- Content Box Start -->
<div class="contentcontainer" style="display:none;">
    <div class="headings alt">
        <h2>Files</h2>
    </div>
    <div class="contentbox">
        
      <div style="float:left;margin-bottom:30px;margin-right:40px;">
        <table id="cpu_usage">
            <tr>
                <th width="0" class="head"></th>
                <th width="60" class="head"><strong>Categories:</strong></th>
                <th width="180" class="head"></th>
                <th width="50" class="head" ><span id="loader" style="float:right;display:none;"><img src="img/ajax-loader.gif" height="10"></span></th>
             </tr>
             <tr style="font-weight:bold; font-style:italic;border-bottom:1px solid #ccc;">
             	<td></td>
                <td>Category</td>
                <td>URL</td>
                <td>Update</td>
             </tr>
             <?php
                
                load_category_status();
             
             ?>
             
        </table>
       </div>  
       <div style="float:left;margin-right:40px;width:45%;">
       	<table id="cpu_usage">
            <tr>
                <th width="100" class="head"><strong>Running:</strong></th>
                <th width="200" class="head"></th>
                <th width="50" class="head" ><span id="loader" style="float:right;display:none;"><img src="img/ajax-loader.gif" height="10"></span></th>
             </tr>
        	 <tr id="no_process">
                <td title="No process running." style="cursor:pointer;">
                   No process running.
                </td>
                <td id="display">
                </td>
                <td>
                </td>
		     </tr>
        </table>
           
       </div>    
    </div>
</div>
<!-- Content Box End -->

<div style="clear:both;"></div>

<!-- Content Box Start -->
<div class="contentcontainer" style="display:none;">
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
                <h4>Notice: </h4>
                <p></p>
                <p>Dhawan bhai, isko hata kar kuch achha sa daalna iski jagah.. Tab tak ke liye space holder =))</p>
                <p><a href="#" title="">Read more</a></p>
                
            </div>
        </div>

        <div style="clear: both;"></div>
    </div>
</div>
<!-- Content Box End -->