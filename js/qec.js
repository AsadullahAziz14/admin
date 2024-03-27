<!--POST REPORT TYPE-->
function get_report_type(rtype) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/qec/get_report_type.php",  
		data: "rtype="+rtype,  
		success: function(msg){  
			$("#getreporttype").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--POST SESSION TEACHERS-->
function get_session_teachers(academic_session, rtype) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/qec/get_session_teachers.php",  
		data: "academic_session="+academic_session+"&rtype="+rtype,  
		success: function(msg){  
			$("#getsessionteachers").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--GET TEACHER COURSES-->
function get_teacher_subjects(teacher, acd_session) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/qec/get_teacher_subjects.php",  
		data: "teacher="+teacher+"&acd_session="+acd_session,  
		success: function(msg){  
			$("#getteachersubjects").html(msg); 
			$("#loading").html(''); 
		}
	});  
}