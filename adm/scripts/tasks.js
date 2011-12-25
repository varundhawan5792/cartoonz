// Side Navigation Menu Slide
var refresh_load = true;
var categoryId;
var loadDetect = true;


$(document).ready(function() {
	
	getUrlHash();
	startUsageLoader();

	//$("#dashboard").click(function(){ loadDashboard(false); });
	//$("#categories").click(function(){ loadCategories(false); });
	
	$("ul.navigation li").click(function(){	
		var value, cat;
		if($(this).find("a").length == 0)
			return;
		else{
			value = $(this).find("a").text();
			cat = removeSpaces(value.toLowerCase());
		}
		window.location.hash = "#!/"+cat;
		$("ul.navigation li").each(function(){
			$(this).removeClass("selected");
			if($(this).find("a").length == 0){
				if($(this).html().trim() == "Dashboard")
				  $(this).html('<a href="javascript:;" title="" class="heading">' + $(this).html() + '</a>');
				else
				  $(this).html('<a href="javascript:;" title="">' + $(this).html() + '</a>');
			}
			
		})
		$("li#"+cat).html($("li#"+cat).find("a").text().trim());
		$("li#"+cat).addClass("selected");
		if($(this).html().trim() == "Dashboard")
		   $(".current").html("Dashboard");
		else
		   $(".current").html($(this).parent().prev().text().trim());
	})
	
});
$(window).bind( 'hashchange', function(){
	getUrlHash();
});

function ajaxLoader(){
	$(".ajax_loader").fadeIn("50");
}
function ajaxLoaderRemove(){
	$(".ajax_loader").fadeOut("50");
}

function removeSpaces(string) {
	return string.split(' ').join('');
}
function getUrlHash() {
	
	//alert(window.location.hash);
	if(window.location.hash == "#!/" || window.location.hash == "#!" ){
		window.location.hash = "#!/dashboard";
	}
	if(window.location.hash.indexOf("#!/") != 0){
		loadDetect = false;
		return;
	}
	
	
	var hash = window.location.hash.substr(3);
	switch(hash){
		case 'categories':
		    loadCategories(true);
			break;
		case 'dashboard':
		    loadDashboard(true);
			break;
		case 'files':
		    loadFiles(true);
			break;	
	}
	
	loadDetect = false;
}
function doClick(val){	
	var value, cat;
	if($(val).find("a").length == 0)
		return;
	else{
		value = $(val).find("a").text();
		cat = removeSpaces(value.toLowerCase());
	}
	//window.location.hash = "#!/"+cat;
	$("ul.navigation li").each(function(){
		$(this).removeClass("selected");
		if($(this).find("a").length == 0){
			if($(this).html().trim() == "Dashboard")
			  $(this).html('<a href="javascript:;" title="" class="heading">' + $(this).html() + '</a>');
			else
			  $(this).html('<a href="javascript:;" title="">' + $(this).html() + '</a>');
		}
		
	})
	$("li#"+cat).html($("li#"+cat).find("a").text().trim());
	$("li#"+cat).addClass("selected");
	if($(val).html().trim() == "Dashboard")
	   $(".current").html("Dashboard");
	else
	   $(".current").html($(val).parent().prev().text().trim());
}
function loadDashboard(bypass){
	
	ajaxLoader();
	refresh_load = true;
	if($("li#dashboard").hasClass("selected")  && !bypass)
		return;
	doClick("li#dashboard");
	$("#ajaxcontainer div").animate({"height":"0", "opacity":"0"});
	$("#ajaxcontainer").load("../include/ajax_adm/content_dashboard.php", function(){ $("#ajaxcontainer div").fadeIn(150); ajaxLoaderRemove(); });
	startUsageLoader();
}
function loadCategories(bypass){
	
	ajaxLoader()
	refresh_load = false;	
	if($("li#categories").hasClass("selected") && !bypass)
		return;	
	doClick("li#categories");	
	$("#ajaxcontainer div").animate({"height":"0", "opacity":"0"}, {"duration":"200"});
	$("#ajaxcontainer").load("../include/ajax_adm/content_categories.php", function(){ 
		$("#ajaxcontainer div").fadeIn(150);
		ajaxLoaderRemove();
		$("button#add_category").click(function(){
			addCategory();
		})
		$("button#cancel_add_category").click(function(){
			$("form#add_category").find("#category").val('');
			$("form#add_category").find("#url").val('');
			$("form#add_category").find("#alias").val('');
			$("select#parent").val('0');
			$("button#add_category").fadeIn(0);
			$("button#edit_category").fadeOut(0);
			
		})
	});
	
}
function editCategory(id){
	
	//window.scrollTo(0,$("#ajaxcontainer").offset().top);
	$("form#add_category").find("#category").val($("#category_list_"+id).find("#category").text().trim());
	$("form#add_category").find("#url").val($("#category_list_"+id).find("#url").text().trim());
	$("form#add_category").find("#alias").val($("#category_list_"+id).find("#alias").text().trim());
	$("select#parent").val($("#category_list_"+id).find("#parent").find("input").val());
	$("button#add_category").fadeOut(0);
	$("form#add_category").fadeIn(50);
	$("button#edit_category").fadeIn(0);
	$("button#cancel_add_category").fadeIn(0);
	categoryId = id;
	$("button#edit_category").click(function(){
		addEditCategory(categoryId);
	})
	return false;
}
function addEditCategory(id){
	
	var cat = $("form#add_category").find("#category").val().trim();
	var url = $("form#add_category").find("#url").val().trim();
	var alias = $("form#add_category").find("#alias").val().trim();
	var parent = $('select#parent').find('option:selected').val();
	if(alias=='NULL')
		alias='';
	if(cat.length == 0 || url.length == 0){
		alert("Man! Don't leave them empty.");
		return false;
	}
	url = encodeURI(url);
	$.getJSON("../include/do.php?q=add_category&category="+cat+"&url="+url+"&id="+id+"&parent="+parent+"&alias="+alias, 
		function(data){
			if(data == true){
				loadCategories(true);
			}
			else if(data == 'duplicate'){
				alert("A similar entry already exists. Duplicates not allowed!");
			}
			else{
				alert(data+": Error! Category not edited.");
				
			}
		}
	);
	return false;
}
function addCategory(){

	var cat = $("form#add_category").find("#category").val().trim();
	var url = $("form#add_category").find("#url").val().trim();
	var alias = $("form#add_category").find("#alias").val().trim();
	var parent = $('select#parent').find('option:selected').val();
	if(alias=='NULL')
		alias='';
	if(cat.length == 0 || url.length == 0){
		alert("Man! Don't leave them empty.");
		return false;
	}
	url = encodeURI(url);
	$.getJSON("../include/do.php?q=add_category&category="+cat+"&url="+url+"&parent="+parent+"&alias="+alias, 
		function(data){
			
			if(data == "duplicate"){
				alert("A similar entry already exists. Duplicates not allowed!");
			}
			else if(data == true){
				loadCategories(true);
			}
			else{
				alert(data+": Error! Category not added.");
				
			}
		}
	);
	return false;
}
function removeCategory(id){
	
	if(!confirm("Are you sure you want to delete this?"))
		return false;
	$.getJSON("../include/do.php?q=remove_category&id="+id, 
		function(data){
			if(data == true){
				loadCategories(true);
			}
			else{
				alert(data+": Error! Category not removed.");
				
			}
		}
	);
	return false;
}
function loadFiles(bypass){
	
	ajaxLoader()
	refresh_load = false;	
	if($("li#files").hasClass("selected") && !bypass)
		return;	
	doClick("li#files");	
	$("#ajaxcontainer div").animate({"height":"0", "opacity":"0"}, {"duration":"200"});
	$("#ajaxcontainer").load("../include/ajax_adm/content_files.php", function(){ 
		$("#ajaxcontainer div").fadeIn(150);
		ajaxLoaderRemove();
	});
	
}
function startUsageLoader(){
	displayLoad();
	setTimeout(function(){startUsageLoader();}, 7000);
}
function displayLoad(){
	
	if(refresh_load == false)
	    return;
	//alert('geting usage..')	;
	$.getJSON("../include/do.php?q=get_server_list", 
		function(data){
			data1 = data;
			data = data.query;
			$(data).each(function(){
				var id = $(this)[0].id;
				var ip = $(this)[0].server_ip;
				fetchLoad(id, ip);
			})
			
		}
	);
	
}

function fetchLoad(id, ip){
	//alert(id+","+ip);
	$("#cpu_usage").find("#loader").fadeIn(10);
	var url = "../include/do.php?q=get_server_load&id="+id;
	$.get(url, function(usage){
			//alert('data received');
			//alert('usage='+usage+".");
			if(usage.length == 0){
				$("#server"+id).find("#display").find("span").width(0);
				$("#server"+id).find("#value").html("Down");
				$("#cpu_usage").find("#loader").fadeOut(10);
				return;
			}
			if(usage.substr(0, usage.length-1) <= 50)
			{
				$("#server"+id).find("#display").find(".usage").removeClass("red");
				$("#server"+id).find("#display").find(".usage").removeClass("orange");
			}
			else if(usage.substr(0, usage.length-1) > 50 && usage.substr(0, usage.length-1) <= 80)
			{
				$("#server"+id).find("#display").find(".usage").removeClass("red");
				$("#server"+id).find("#display").find(".usage").addClass("orange");

			}
			else
			{
				$("#server"+id).find("#display").find(".usage").removeClass("orange");
				$("#server"+id).find("#display").find(".usage").addClass("red");
				showWarning("High traffic load on Server #"+id+" detected.");
			}
			$("#server"+id).find("#display").find("span").width(usage);
			$("#server"+id).find("#value").html(usage);
			$("#cpu_usage").find("#loader").fadeOut(10);
	})	
	
}

function showWarning(msg){
	
	var alert = '<div class="status warning">'+
    '<p class="closestatus"><a href="" title="Close" onclick="removeWarning(this); return false;">x</a></p>'+
    '<p><img src="img/icons/icon_warning.png" alt="Warning"><span>WARNING!</span> '+msg+'</p>' +
    '</div>';
	var val = $("#warning_container").html();
	if(val.indexOf(msg) < 0)
	   $("#warning_container").append(alert);
}

function removeWarning(object){
	$(object).parent().parent().remove();
	return false;
}

function voided(){	
	return false;
}