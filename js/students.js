<!--Get Prev Fee-->
function get_hostelclasstudents(reg_dept_cls) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/get_hostelclasstudents.php",  
		data: "reg_dept_cls="+reg_dept_cls,  
		success: function(msg){  
			$("#gethostelclasstudents").html(msg); 
			$("#loading").html(''); 
		}
	});  
}