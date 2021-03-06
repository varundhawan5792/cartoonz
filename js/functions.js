// JavaScript Document

function doClick(){
	$("#lane2").find("#other_list").find("a").click(function(){
		loadMusicFiles($(this).attr("id"));
	})
	$("#lane3").find("#other_list").find("a.folder").dblclick(function(){
		alert("it's a folder!");
	})
	$("#lane3").find("#other_list").find("a.file").click(function(){
		alert("it's a file!");
	})
}
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
			time = data.length*2;
			$(data).each(function(){
				if(cntr == 0){
					setTimeout(function(){
						$("#lane2").find("#loader").animate({"height":"0", "opacity":"0"}, 200).fadeOut(0);
						
						doClick();
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
					
				},0+cntr);
				cntr+=2;
				
			});
	});	
	
}

function loadMusicFiles(parent){
	
	//alert(parent);
	target = $("#lane3").find("#other_list");
	$(target).html('');
	var cntr=0, time=0;
	$.getJSON("./include/do.php?q=get_music_files_list&parent="+parent, 
		function(data){
			
			time = data.length*2;
			data = data.query;
			data1 = data;
			$(data).each(function(){

				var id = $(this)[0].id;
				var name = $(this)[0].name;
				var type = $(this)[0].type;
			
				if(type=="folder")
				  $(target).append("<li><a class='folder' id='" + id + "'>" + name + "&nbsp;&nbsp;&nbsp;</a></li>");
				else
				  $(target).append("<li><a class='file music' id='" + id + "'>" + name + "&nbsp;&nbsp;&nbsp;</a></li>");
				
				cntr+=2;
				data="";
			});
	});	
	
}

//*******************  Lane 1 - Menu *******************//
jQuery.fn.initMenu = function() {  
    return this.each(function(){
        var theMenu = $(this).get(0);
        $('.acitem', this).hide();
        $('li.expand > .acitem', this).show();
        $('li.expand > .acitem', this).prev().addClass('active');
        $('li a', this).click(
            function(e) {
                e.stopImmediatePropagation();
                var theElement = $(this).next();
                var parent = this.parentNode.parentNode;
                if($(parent).hasClass('noaccordion')) {
                    if(theElement[0] === undefined) {
                        window.location.href = this.href;
                    }
                    $(theElement).slideToggle('normal', function() {
                        if ($(this).is(':visible')) {
                            $(this).prev().addClass('active');
                        }
                        else {
                            $(this).prev().removeClass('active');
                        }    
                    });
                    return false;
                }
                else {
                    if(theElement.hasClass('acitem') && theElement.is(':visible')) {
                        if($(parent).hasClass('collapsible')) {
                            $('.acitem:visible', parent).first().slideUp('normal', 
                            function() {
                                $(this).prev().removeClass('active');
                            }
                        );
                        return false;  
                    }
                    return false;
                }
                if(theElement.hasClass('acitem') && !theElement.is(':visible')) {         
                    $('.acitem:visible', parent).first().slideUp('normal', function() {
                        $(this).prev().removeClass('active');
                    });
                    theElement.slideDown('normal', function() {
                        $(this).prev().addClass('active');
                    });
                    return false;
                }
            }
        }
    );
});
};

$(document).ready(function() {$('.menu').initMenu();});