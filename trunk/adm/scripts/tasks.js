// Side Navigation Menu Slide

$(document).ready(function() {
	displayLoad();
});

var data1;
function displayLoad(){

	$.getJSON("../include/do.php?q=get_server_list", 
		function(data){
			data1 = data;
			data = data.query;
			$(data).each(function(){
				var id = $(this)[0].id;
				var ip = $(this)[0].server_ip;
				fetchLoad(id, ip);
			})
			setTimeout(function(){displayLoad();}, 8000);
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