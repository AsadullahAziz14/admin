
<!--Get Student Data by formno or Reg.no for Fee record-->
function get_deptemployees(id_dept) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/salary/get_deptemployees.php",  
		data: "id_dept="+id_dept,  
		success: function(msg){  
			$("#getdeptemployees").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

