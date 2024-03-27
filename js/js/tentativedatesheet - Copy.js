//--get liberalarts timing semesters -->
function get_liberalartstimingsemesters(timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/datesheet/get_liberalartstimingsemesters.php",  
		data: "timing="+timing,  
		success: function(msg){  
			$("#getliberalartstimingsemesters").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//--get liberalarts timing semester courses -->
function get_liberalartstimingsemestercourses(sems,timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/datesheet/get_liberalartstimingsemestercourses.php",  
		data: 'sems='+sems+'&timing='+timing,  
		success: function(msg){  
			$("#getliberalartstimingsemestercourses").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//--get liberalarts timingsemestercourse detail -->
function get_liberalartstimingsemestercoursedetail(idcurs, sems,timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/datesheet/get_liberalartstimingsemestercoursedetail.php",  
		data: 'idcurs='+idcurs+'&sems='+sems+'&timing='+timing,  
		success: function(msg){  
			$("#getliberalartstimingsemestercoursedetail").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//--Get Department by Faculty ID -->
function get_timingprograms(timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/datesheet/get_timingprograms.php",  
		data: "timing="+timing,  
		success: function(msg){  
			$("#gettimingprograms").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


//--Get Department by Faculty ID -->
function get_programsemesters(id_prg, timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/datesheet/get_programsemesters.php",  
		data: 'id_prg='+id_prg+'&timing='+timing,  
		success: function(msg){  
			$("#getprogramsemesters").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


//--Get Department by Faculty ID -->
function get_semestertimetable(semester, id_prg, timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/datesheet/get_semestertimetable.php",  
		data: 'semester='+semester+'&id_prg='+id_prg+'&timing='+timing,  
		success: function(msg){  
			$("#getsemestertimetable").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//--Get Department by Faculty ID -->
function get_semestersectiontimetable(section, id_prg, timing, semester) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/datesheet/get_semestersectiontimetable.php",  
		data: 'section='+section+'&id_prg='+id_prg+'&timing='+timing+'&semester='+semester,  
		success: function(msg){  
			$("#getsemestersectiontimetable").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//--Get Shift by Timing -->
function get_timing_shift(timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/datesheet/get_timingshift.php",  
		data: "timing="+timing,  
		success: function(msg){  
			$("#gettimingshift").html(msg); 
			$("#loading").html(''); 
		}
	});  
}