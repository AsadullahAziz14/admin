<!--Get Prev Fee-->
function get_hostelfloors(id_hostel) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/get_hostelfloors.php",  
		data: "id_hostel="+id_hostel,  
		success: function(msg){  
			$("#gethostelfloors").html(msg); 
			$("#loading").html(''); 
		}
	});  
}
function get_reghostelfloors(id_hostel) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/get_reghostelfloors.php",  
		data: "id_hostel="+id_hostel,  
		success: function(msg){  
			$("#getreghostelfloors").html(msg); 
			$("#loading").html(''); 
		}
	});  
}
<!--Get Prev Fee-->
function get_regfloorrooms(id_floor) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/get_reghostelrooms.php",  
		data: "id_floor="+id_floor,  
		success: function(msg){  
			$("#getregfloorrooms").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Prev Fee-->
function get_hostelfloorsedit(id_hostel_edit) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/get_hostelfloors.php",  
		data: "id_hostel_edit="+id_hostel_edit,  
		success: function(msg){  
			$("#gethostelfloorsedit").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Prev Fee-->
function get_hostelrooms(id_floor) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/get_hostelrooms.php",  
		data: "id_floor="+id_floor,  
		success: function(msg){  
			$("#gethostelrooms").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Prev Fee-->
function get_hostelroomsedit(id_floor_edit) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/get_hostelrooms.php",  
		data: "id_floor_edit="+id_floor_edit,  
		success: function(msg){  
			$("#gethostelroomedit").html(msg); 
			$("#loading").html(''); 
		}
	});  
}