<!--Get Prgam Detail-->
function get_deptfaculty(idfaculty) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_deptfaculty.php",  
		data: "idfaculty="+idfaculty,  
		success: function(msg){  
			$("#getdeptfaculty").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

