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
			$("#server"+id).find("#display").find("span").width(usage);
			$("#server"+id).find("#value").html(usage);
			$("#cpu_usage").find("#loader").fadeOut(10);
	})	
	
}