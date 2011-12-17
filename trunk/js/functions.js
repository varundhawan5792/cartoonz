// JavaScript Document

function shortText(string, length){
	return string.substring(0, length) + "...";
}

function searchit(){
   var keyword = $("#lane2").find("#search").val().toLowerCase();
   var val;
   $("#lane2").find("li").each(function(){
	  val = $(this).find("a").text().toLowerCase(); 
	  if(val.indexOf(keyword) < 0) 
	     $(this).css("display","none");
	  else
	     $(this).css("display","block");
   });
   
}

function loadMusic(){
	
	$("#lane2").find("#loader").fadeIn(1000);
	target = $("#lane2").find("#other_list");
	$(target).html('');
	var cntr=0, time=0;
	$.getJSON("./include/do.php?q=get_music_folder_list", 
		function(data){
			data = data.query;
			data1 = data;
			time = data.length*2;
			$(data).each(function(){
				if(cntr == 0){
					setTimeout(function(){
						$("#lane2").find("#loader").animate({"height":"0", "opacity":"0"}, 200).fadeOut(0);
						$("#form").addClass("form_vis");
						$("#form").animate({"marginTop":"0px"}, 500, "linear");
						$("#form").fadeIn(0);
						$("input").focus(function(){
							if($(this).val() == $(this).attr("alt"))
								$(this).val("");
						});
						$("input").blur(function(){
							if($(this).val()=="")
								$(this).val($(this).attr("alt"));
						});
						$("#lane2").find("#search").keyup(function(){searchit();});
						$("#lane2").find("#search").keydown(function(){searchit();});
						$("#lane2").find("#search").keypress(function(){searchit();});
						$("#lane2").find("#search").change(function(){searchit();});
					}, time);
				}
				var id = $(this)[0].id;
				var name = $(this)[0].name;
				setTimeout(function(){
					$(target).append("<li><a class='folder' id='" + id + "'>" + name + "&nbsp;&nbsp;&nbsp;</a></li>");
					
				},50+cntr);
				cntr+=2;
				
			});
	});	
	
}