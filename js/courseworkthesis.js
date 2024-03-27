
// Get Courses for CourseWork 
function get_courses_CW(id_prg) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/courseworkthesis/get_courses_CW.php",  
		data: "id_prg="+id_prg,  
		success: function(msg){  
			$("#getcourses_CW").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



// Get Course Resource Type
function get_ResourcesType(idtype) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/teachers/get_ResourcesType.php",  
		data: "idtype="+idtype,  
		success: function(msg){  
			$("#getResourcesType").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



// Get Course work / Thesis Details by type
function get_cwttype(cwttype) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/courseworkthesis/get_cwtDetail.php",  
		data: "cwttype="+cwttype,  
		success: function(msg){  
			$("#getcwtDetail").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

// Get Supervisor & Co-Supervisor by type for Thesis
function get_supType(sup_type,srno,co_sup12,id_faculty) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/courseworkthesis/get_supbytype.php",  
		data: "sup_type="+sup_type+"&srno="+srno+"&co_sup12="+co_sup12+"&id_faculty="+id_faculty,  
		success: function(msg){  
			if(co_sup12 == 1 ){
				$("#getsupType_"+srno).html(msg);
			}else if (co_sup12 == 2){
				$("#getcosupType_"+srno).html(msg);
			}
			 
			$("#loading").html(''); 
		}
	});  
}

// <!--Get Department by Faculty ID -->
function get_sessiontiming(for_sess,id) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/courseworkthesis/get_sessiontiming.php",  
		data: "forsess="+for_sess+"&offered_id="+id,  
		success: function(msg){  
			$("#getsessiontiming").html(msg); 
			$("#loading").html(''); 
		}
	});  
}
// <!--Get Department by Faculty ID -->
function get_semestercourses(tsess, id_prg, id_dept, timing, semeno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/courseworkthesis/get_semestercourses.php",  
		data: "semeno="+semeno+"&id_prg="+id_prg+"&timing="+timing+"&id_dept="+id_dept+"&tsess="+tsess,  
		success: function(msg){  
			$("#getsemestercourses").html(msg); 
			$("#loading").html(''); 
		}
	});  
}
// Get Supervisor & Co-Supervisor for Thesis
function get_thesis_detail(coursework_thesis_edit) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/courseworkthesis/get_thesis_detail.php",  
		data: "coursework_thesis_edit="+coursework_thesis_edit,  
		success: function(msg){  
			$("#getthesisdetail").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


