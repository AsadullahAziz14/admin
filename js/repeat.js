<!--Forward Repeat Registration Type-->
function reg_type(type) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/repeat/get_regtype.php",  
		data: "type="+type,  
		success: function(msg){  
			$("#getregtype").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Student Data by Reg.no for Repeat/Migration Record-->
function summer_studentbyregno(regno, type) {
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/repeat/get_studentbyregno.php",  
		data: "regno="+regno+"&type="+type,  
		success: function(msg){  
			$("#getstudentbyregno").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Semester Courses -->
function get_semestercourses(semester, tsess, srno, idprg, timing, type, maxCredit, currentCredit) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/repeat/get_semestercourses.php",  
		data: "semester="+semester+"&tsess="+tsess+"&srno="+srno+"&idprg="+idprg+"&timing="+timing+"&type="+type+"&maxCredit="+maxCredit+"&currentCredit="+currentCredit,  
		success: function(msg){  
			$("#getsemestercourses_" + srno).html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Course Details -->
function get_coursedetail(idcurs, tsess, semester, srno, idprg, timing, type, maxCredit, currentCredit) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/repeat/get_coursedetail.php",  
		data: "semester="+semester+"&tsess="+tsess+"&idcurs="+idcurs+"&srno="+srno+"&idprg="+idprg+"&timing="+timing+"&type="+type+"&maxCredit="+maxCredit+"&currentCredit="+currentCredit,  
		success: function(msg){  
			$("#getcoursedetail_" + srno).html(msg); 
			$("#loading").html(''); 
		}
	});  
}