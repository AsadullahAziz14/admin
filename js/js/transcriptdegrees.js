<!--Get Prgam Detail-->
function get_studentdatafortransdegree(regno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_studentdatafortransdegree.php",  
		data: "regno="+regno,  
		success: function(msg){  
			$("#getstudentdatafortransdegree").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


function get_otherfields(issue_to) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_studentdatafortransdegree.php",  
		data: "issue_to="+issue_to,  
		success: function(msg){  
			$("#getotherfields").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


function get_otherfieldsedit(issue_to_edit) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_studentdatafortransdegree.php",  
		data: "issue_to_edit="+issue_to_edit,  
		success: function(msg){  
			$("#getotherfieldsedit").html(msg); 
			$("#loading").html(''); 
		}
	});  
}
