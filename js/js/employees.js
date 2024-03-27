<!--Get Prev Fee-->
function get_deptemployees(reg_dept_cls) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/get_deptemployees.php",  
		data: "reg_dept_cls="+reg_dept_cls,  
		success: function(msg){  
			$("#getdeptemployees").html(msg); 
			$("#loading").html(''); 
		}
	});  
}