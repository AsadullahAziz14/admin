
//-- For Report get Block Rooms -->
function lecturerreport_type(lecturereport) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/timetable/lecturereport_type.php",  
		data: "lecturereport="+lecturereport,  
		success: function(msg){  
			$("#lecturerreporttype").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


//-- For Report get Block Rooms -->
function report_type(reporttype) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/timetable/report_type.php",  
		data: "reporttype="+reporttype,  
		success: function(msg){  
			$("#reporttype").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


//-- For Report get Block Rooms -->
function report_blockrooms(block) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/timetable/report_blockrooms.php",  
		data: "block="+block,  
		success: function(msg){  
			$("#reportblockrooms").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


//--Get Department by Faculty ID -->
function get_lasessiontiming(for_sess) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/timetable/get_lasessiontiming.php",  
		data: "forsess="+for_sess,  
		success: function(msg){  
			$("#getlasessiontiming").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


//--Get Department by Faculty ID -->
function get_latimingcourses(timing, acdsess) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/timetable/get_latimingcourses.php",  
		data: 'timing='+timing+'&acdsess='+acdsess,  
		success: function(msg){  
			$("#getlatimingcourses").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//--Get Department by Faculty ID -->
function get_lacoursesections(idcurs, timing, acdsess) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/timetable/get_lacoursesections.php",  
		data: 'idcurs='+idcurs+'&timing='+timing+'&acdsess='+acdsess,  
		success: function(msg){  
			$("#getlacoursesections").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//--Get Department by Faculty ID -->
function get_lasectioncoursedetail(section, timing, idcurs, acdsess) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/timetable/get_lasectioncoursedetail.php",  
		data: 'section='+section+'&idcurs='+idcurs+'&timing='+timing+'&acdsess='+acdsess,  
		success: function(msg){  
			$("#getlasectioncoursedetail").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//--Get Department by Faculty ID -->
function get_latimingdepartment(timing, acdsess) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/timetable/get_latimingdepartment.php",  
		data: 'timing='+timing+'&acdsess='+acdsess,  
		success: function(msg){  
			$("#getlatimingdepartment").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//--Get Department by Faculty ID -->
function get_ladepartmentsemester(iddept, timing, acdsess) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/timetable/get_ladepartmentsemester.php",  
		data: 'timing='+timing+'&acdsess='+acdsess+'&iddept='+iddept,  
		success: function(msg){  
			$("#getladepartmentsemester").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



//--Get Department by Faculty ID -->
/*function get_latimingsemester(timing, acdsess) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/timetable/get_latimingsemester.php",  
		data: 'timing='+timing+'&acdsess='+acdsess,  
		success: function(msg){  
			$("#getlatimingsemester").html(msg); 
			$("#loading").html(''); 
		}
	});  
}*/




//--Get Department by Faculty ID -->
function get_lasemestersection(semester, timing, iddept, acdsess) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/timetable/get_lasemestersection.php",  
		data: 'timing='+timing+'&acdsess='+acdsess+'&semester='+semester+'&iddept='+iddept,  
		success: function(msg){  
			$("#getlasemestersection").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


//--Get Department by Faculty ID -->
function get_lasemestersectioncourses(section, semester, timing, iddept, acdsess) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/timetable/get_lasemestersectioncourses.php",  
		data: 'timing='+timing+'&acdsess='+acdsess+'&semester='+semester+'&section='+section+'&iddept='+iddept,  
		success: function(msg){  
			$("#getlasemestersectioncourses").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//--Get Department by Faculty ID -->
function get_sessiontiming(for_sess) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/timetable/get_sessiontiming.php",  
		data: "forsess="+for_sess,  
		success: function(msg){  
			$("#getsessiontiming").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//--Get Department by Faculty ID -->
function get_programs(timing, prgsess) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/timetable/get_programs.php",  
		data: 'timing='+timing+'&prgsess='+prgsess,  
		success: function(msg){  
			$("#getprograms").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


//--Get Department by Faculty ID -->
function get_programsemesters(id_prg, timing, prgsess) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/timetable/get_programsemesters.php",  
		data: 'prgsess='+prgsess+'&timing='+timing+'&id_prg='+id_prg,  
		success: function(msg){  
			$("#getprogramsemesters").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



//--Get Department by Faculty ID -->
function get_semestercourses(tsess, id_prg, id_dept, timing, semeno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/timetable/get_semestercourses.php",  
		data: "semeno="+semeno+"&id_prg="+id_prg+"&timing="+timing+"&id_dept="+id_dept+"&tsess="+tsess,  
		success: function(msg){  
			$("#getsemestercourses").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//--Get Department by Faculty ID -->
function get_daysperiods(timing, semeno, id_prg, id_dept, tsess, tstds) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/timetable/get_daysperiods.php",  
		data: "timing="+timing+"&semeno="+semeno+"&id_prg="+id_prg+"&id_dept="+id_dept+"&tsess="+tsess+"&tstds="+tstds,  
		success: function(msg){  
			$("#getdaysperiods").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


//--Get Department by Faculty ID -->
function checkclassroom(idroom, srno, sess, idperiod, dyname) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/timetable/checkclassroom.php",  
		data: "idroom="+idroom+"&sess="+sess+"&idperiod="+idperiod+"&dyname="+dyname,  
		success: function(msg){  
			$("#checkclassroom_" + srno).html(msg); 
			$("#loading").html(''); 
		}
	});  
}


//--Get Department by Faculty ID -->
function checkteacher(idteacher, srno, sess, idperiod, dyname) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/timetable/checkteacher.php",  
		data: "idteacher="+idteacher+"&sess="+sess+"&idperiod="+idperiod+"&dyname="+dyname,  
		success: function(msg){  
			$("#checkteacher_" + srno).html(msg); 
			$("#loading").html(''); 
		}
	});  
}
