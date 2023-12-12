<!--Get Prev Fee-->
function get_studentprevfee(id_std) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/get_studentprevfee.php",  
		data: "id_std="+id_std,  
		success: function(msg){  
			$("#getstudentprevfee").html(msg); 
			$("#loading").html(''); 
		}
	});  
}