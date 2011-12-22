// Side Navigation Menu Slide
var refresh_load = true;
var categoryId;

$(document).ready(function() {
	startUsageLoader();
	$("#dashboard").click(function(){ loadDashboard(); });
	$("#categories").click(function(){ loadCategories(); });
});

function loadDashboard(){
	
	refresh_load = true;
	$("#ajaxcontainer div").animate({"height":"0", "opacity":"0"});
	$("#ajaxcontainer").load("../include/ajax_adm/content_dashboard.php", function(){ $("#ajaxcontainer div").fadeIn(150) });
	startUsageLoader();
}
function loadCategories(){
	
	refresh_load = false;
	$("#ajaxcontainer div").animate({"height":"0", "opacity":"0"});
	$("#ajaxcontainer").load("../include/ajax_adm/content_categories.php", function(){ 
		$("#ajaxcontainer div").fadeIn(150);
		$("button#add_category").click(function(){
			if($(this).text() == "Add"){
				addCategory();
			}
			else{
				$("form#add_category").fadeIn(50);
				$("button#cancel_add_category").fadeIn(0);
				$(this).text("Add");
			}
		})
		$("button#cancel_add_category").click(function(){
			$("form#add_category").fadeOut(0);
			$("button#add_category").text("Add Category");
			$("button#add_category").fadeIn(0);
			$("button#edit_category").fadeOut(0);
			$(this).fadeOut(0);
		})
	});
	
}
function editCategory(id){
	
	$("form#add_category").find("#category").val($("#category_list_"+id).find("#category").text().trim());
	$("form#add_category").find("#url").val($("#category_list_"+id).find("#url").text().trim());
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

	if(cat.length == 0 || url.length == 0){
		alert("Man! Don't leave them empty.");
		return false;
	}
	url = encodeURI(url);
	$.getJSON("../include/do.php?q=add_category&category="+cat+"&url="+url+"&id="+id, 
		function(data){
			//alert(data);
			if(data == true){
				loadCategories();
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

	if(cat.length == 0 || url.length == 0){
		alert("Man! Don't leave them empty.");
		return false;
	}
	url = encodeURI(url);
	$.getJSON("../include/do.php?q=add_category&category="+cat+"&url="+url, 
		function(data){
			if(data == true){
				loadCategories();
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
				loadCategories();
			}
			else{
				alert(data+": Error! Category not removed.");
				
			}
		}
	);
	return false;
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