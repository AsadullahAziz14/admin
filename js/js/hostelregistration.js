<!--Get Floors of Hostel by hostel ID -->
function hostel_studentbyregno(regno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/hostel/hostel_studentbyregno.php",  
		data: "regno="+regno,  
		success: function(msg){  
			$("#hostelstudentbyregno").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Floors of Hostel by hostel ID -->
function get_hostelfloors(id_hostel) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_hostelregistration.php",  
		data: "id_hostel="+id_hostel,  
		success: function(msg){  
			$("#gethostelfloors").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Rooms of Floor by Floor ID -->
function get_floorrooms(id_floor) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_hostelregistration.php",  
		data: "id_floor="+id_floor,  
		success: function(msg){  
			$("#getfloorrooms").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Type of Registration  -->
function get_regtype(reg_type) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_hostelregistration.php",  
		data: "reg_type="+reg_type,  
		success: function(msg){  
			$("#getregtype").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Floors of Hostel by hostel ID -->
function get_catbooks(id_cat) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_hostelregistration.php",  
		data: "id_cat="+id_cat,  
		success: function(msg){  
			$("#getcatbooks").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Students by Program ID  -->
function get_programstudents(dept_cls) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_studentsbyprogram.php",  
		data: "dept_cls="+dept_cls,  
		success: function(msg){  
			$("#getprogramstudents").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Students by Program ID  -->
function get_deptemployees(dept_cls) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_employeesbydept.php",  
		data: "dept_cls="+dept_cls,  
		success: function(msg){  
			$("#getdeptemployees").html(msg); 
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