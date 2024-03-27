// Get Studnet by Reg #
function get_studentbyregno(regno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/academic/get_studentbyregno.php",  
		data: "regno="+regno,  
		success: function(msg){  
			$("#getstudentbyregno").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

// Get Supervisor & Co-Supervisor for Thesis
function get_thesis_detail(coursework_thesis_edit) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/academic/get_thesis_detail.php",  
		data: "coursework_thesis_edit="+coursework_thesis_edit,  
		success: function(msg){  
			$("#getthesisdetail").html(msg); 
			$("#loading").html(''); 
		}
	});  
}