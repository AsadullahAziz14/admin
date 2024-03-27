<!--Get Prgam Detail-->
function get_studentdatabyregno(regno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_studentdatabyregno.php",  
		data: "regno="+regno,  
		success: function(msg){  
			$("#getstudentdatabyregno").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!-- Input Field-->
function add_fielddegreetranscript(application_type) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/add_fielddegreetranscript.php",  
		data: "application_type="+application_type,  
		success: function(msg){  
			$("#addfielddegreetranscript").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!-- Input Field-->
function add_fielddegreetranscript1(applicationtype) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/add_fielddegreetranscript.php",  
		data: "applicationtype="+applicationtype,  
		success: function(msg){  
			$("#addfielddegreetranscript1").html(msg); 
			$("#loading").html(''); 
		}
	});  
}
