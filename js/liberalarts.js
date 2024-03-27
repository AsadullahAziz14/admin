//Get Course Sections Schedule 
function get_course_sections_schedule(id_course, timing, academic_session, srno) {
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/get_course_sections_schedule.php",
		data: "id_course="+id_course+"&timing="+timing+"&academic_session="+academic_session+"&srno="+srno, 
		success: function(msg){  
			console.log(msg);
			$("#getcoursesectionsschedule"+srno).html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//Get Major/Minor Admission Criteria 
function get_major_minor_criteria(id_prg, srno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/get_major_minor_criteria.php",  
		data: "id_prg="+id_prg+"&srno="+srno, 
		success: function(msg){  
			$("#getmajorminorcriteria"+srno).html(msg); 
			$("#loading").html(''); 
		}
	});  
}

// get 2nd major
function get_2ndmajor(idmajor) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/get_2ndmajor.php",  
		data: "idmajor="+idmajor,  
		success: function(msg){  
			$("#get2ndmajor").html(msg); 
			$("#loading").html(''); 
		}
	});  
}
// end get 2nd major


// get Minors of Major
function get_majoroneminor(idmajor) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/get_majoroneminor.php",  
		data: "idmajor="+idmajor,  
		success: function(msg){  
			$("#getmajoroneminor").html(msg); 
			$("#loading").html(''); 
		}
	});  
}
// end get Minors of Major


// get two Minors of Major
function get_major2minors(idmajor) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/get_major2minors.php",  
		data: "idmajor="+idmajor,  
		success: function(msg){  
			$("#getmajor2minors").html(msg); 
			$("#loading").html(''); 
		}
	});  
}
// end get two Minors of Major


function get_liberalartdepartmentprograms(iddept) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/get_liberalartdepartmentprograms.php",  
		data: "iddept="+iddept,  
		success: function(msg){  
			$("#getliberalartdepartmentprograms").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

function get_liberalartsdepatcoursedetail(curs_code) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/get_liberalartsdepatcoursedetail.php",  
		data: "curs_code="+curs_code,  
		success: function(msg){  
			$("#getliberalartsdepatcoursedetail").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

function get_liberalartsdepatmultiplecoursedetail(curs_code, srno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/get_liberalartsdepatmultiplecoursedetail.php",  
		data: "curs_code="+curs_code+"&srno="+srno,  
		success: function(msg){  
			$("#getliberalartsdepatmultiplecoursedetail_" + srno).html(msg); 
			$("#loading").html(''); 
		}
	});  
}



function get_statusliberalarts(liberalart) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/offering_courses/get_statusliberalarts.php",  
		data: "liberalart="+liberalart,  
		success: function(msg){  
			$("#getstatusliberalarts").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


function get_deptsequencing(id_dept, liberalart) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/offering_courses/get_deptsequencing.php",  
		data: "id_dept="+id_dept+"&liberalart="+liberalart,  
		success: function(msg){  
			$("#getdeptsequencing").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


function get_departmentsequencingcourses(scat, id_dept, liberalart) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/offering_courses/get_departmentsequencingcourses.php",  
		data: "scat="+scat+"&id_dept="+id_dept+"&liberalart="+liberalart,  
		success: function(msg){  
			$("#getdepartmentsequencingcourses").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


function get_sequencingsemester(scat, id_dept, liberalart) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/get_sequencingsemester.php",  
		data: "scat="+scat+"&id_dept="+id_dept+"&liberalart="+liberalart,  
		success: function(msg){  
			$("#getsequencingsemester").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


function get_sequencingsemestercourses(semester, scat, id_dept, liberalart) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/get_sequencingsemestercourses.php",  
		data: "semester="+semester+"&scat="+scat+"&id_dept="+id_dept+"&liberalart="+liberalart,  
		success: function(msg){  
			$("#getsequencingsemestercourses").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

function get_liberalartssessdepatdetail(sess) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/get_liberalartssessdepatdetail.php",  
		data: "sess="+sess,  
		success: function(msg){  
			$("#getliberalartssessdepatdetail").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


function get_liberalartsdepatcourseteachers(iddept, sess) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/get_liberalartsdepatcourseteachers.php",  
		data: "sess="+sess+"&iddept="+iddept,  
		success: function(msg){  
			$("#getliberalartsdepatcourseteachers").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


function get_liberalartsdeptcourseregistrations(id_dept) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/get_liberalartsdeptcourseregistrations.php",  
		data: "id_dept="+id_dept,  
		success: function(msg){  
			$("#getliberalartsdeptcourseregistrations").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

function get_studentdegreescenario(degreescenario) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/get_studentdegreescenario.php",  
		data: "degreescenario="+degreescenario,  
		success: function(msg){  
			$("#getstudentdegreescenario").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

function get_studentmajorminorcourses(curs_type, id_std, stdseme, stdtiming, srno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/get_studentmajorminorcourses.php",  
		data: "curs_type="+curs_type+"&id_std="+id_std+"&stdseme="+stdseme+"&stdtiming="+stdtiming+"&srno="+srno,  
		success: function(msg){  
			$("#getstudentmajorminorcourses_" + srno).html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//For Multiple Students Allocation of Advisor
function getStudentDetailByReg(regno, srno) {  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/librealarts/getStudentDetailByReg.php",  
		data: "regno="+regno+"&srno="+srno,  
		success: function(msg){  
			$("#getStudentDetailByReg_"+srno).html(msg); 
		}
	});  
}