<!--Get Report Department / Faculty /Programs -->
function get_register(registerwise) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_register.php",  
		data: "registerwise="+registerwise,  
		success: function(msg){  
			$("#getregister").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Report on behalf Faculty Department/Programs -->
function get_faculty_report_for(faculty) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/fee/reports/get_faculty_report_for.php",  
		data: "faculty="+faculty,  
		success: function(msg){  
			$("#getfacultyreportfor").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Report on behalf Faculty Department/Programs -->
function get_faculty_report(reporttype, faculty) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/fee/reports/get_report.php",  
		data: "reporttype="+reporttype+"&faculty="+faculty,  
		success: function(msg){  
			$("#getfacultyreport").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Report Department / Faculty /Programs -->
function get_report(reporttype) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/fee/reports/get_report.php",  
		data: "reporttype="+reporttype,  
		success: function(msg){  
			$("#getreport").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

function get_feeprogrmsemester(prgsemester) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/fee/reports/get_feeprogrmsemester.php",  
		data: "prgsemester="+prgsemester,  
		success: function(msg){  
			$("#getprgsemester").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Report Department / Faculty /Programs -->
function get_defaultertype(reporttype) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/fee/reports/get_defaultertype.php",  
		data: "reporttype="+reporttype,  
		success: function(msg){  
			$("#getdefaultertype").html(msg); 
			$("#loading").html(''); 
			console.log(msg);
		}
	});  
}

<!--Get Report Department / Faculty /Programs -->
function get_incometype(reporttype) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/fee/reports/get_incometype.php",  
		data: "reporttype="+reporttype,  
		success: function(msg){  
			$("#getincometype").html(msg); 
			$("#loading").html(''); 
		}
	});  
}
<!--Get Department by Faculty ID -->
function get_deptbyfaculty(id_faculty) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_deptbyfaculty.php",  
		data: "id_faculty="+id_faculty,  
		success: function(msg){  
			$("#getdeptbyfaculty").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Department by Faculty ID -->
function get_deptbyfacultyedit(id_faculty_edit) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_deptbyfaculty.php",  
		data: "id_faculty_edit="+id_faculty_edit,  
		success: function(msg){  
			$("#getdeptbyfacultyedit").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Floors of Hostel by hostel ID -->
function get_hostelfloors(id_hostel) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_hostelfloors.php",  
		data: "id_hostel="+id_hostel,  
		success: function(msg){  
			$("#gethostelfloors").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Floors of Hostel by hostel ID -->
function get_hostelfloorstop(hostel) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_hostelfloorstop.php",  
		data: "hostel="+hostel,  
		success: function(msg){  
			$("#gethostelfloortop").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



<!--Get Floors of Hostel by hostel ID EDit Area -->
function get_hostelfloorsedit(id_hostel_edit) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_hostelfloors.php",  
		data: "id_hostel_edit="+id_hostel_edit,  
		success: function(msg){  
			$("#gethostelfloorsedit").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Floors of Hostel by hostel ID EDit Area -->
function get_loginemployeesbydept(id_dept) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/Staffs/ajax/get_loginemployeesbydept.php",  
		data: "id_dept="+id_dept,  
		success: function(msg){  
			$("#getloginemployeesbydept").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Floors of Hostel by hostel ID EDit Area -->
function get_loginemployeedetail(id_emply) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/Staffs/ajax/get_loginemployeedetail.php",  
		data: "id_emply="+id_emply,  
		success: function(msg){  
			$("#getloginemployeedetail").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Floors of Hostel by hostel ID EDit Area -->
function get_loginstudentbyregno(regno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/Staffs/ajax/get_loginstudentbyregno.php",  
		data: "regno="+regno,  
		success: function(msg){  
			$("#getloginstudentbyregno").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Student by Reg # -->
function get_studentbyregno(regno) { 
	$.ajax({  
		type: "POST",  
		url: "include/Staffs/ajax/get_studentbyregno.php",  
		data: "regno="+regno,  
		success: function(msg){ 
			$("#getstudentbyregno").html(msg);
		}
	});  
}

function get_studentbyregno_forledger(regno) { 
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/Staffs/ajax/get_studentbyregno.php",  
		data: "regno="+regno,  
		success: function(msg){
			$("#getstudentbyregno_ledger").html(msg);
			// $("#loading").html(''); 
		}
	});  
}

<!--Get Report Faculty -->
function get_report_faculty(report_type) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/fee/reports/get_detail_faculty.php",  
		data: "report_type="+report_type,  
		success: function(msg){  
			$("#getreportfaculty").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Report Type Concession Authoriy -->
function get_concessionbyauthority(report_type) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/fee/reports/get_concession_by_authority.php",  
		data: "report_type="+report_type,  
		success: function(msg){  
			$("#getconcessionbyauthority").html(msg); 
			$("#loading").html(''); 
		}
	});  
}