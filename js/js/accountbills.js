

function get_cnicrecord(cnic) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/finance/get_cnicrecord.php",  
		data: "cnic="+cnic,  
		success: function(msg){  
			$("#getcnicrecord").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


function get_paymode(pmode, cnic) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/finance/get_paymode.php",  
		data: "pmode="+pmode+"&cnic="+cnic,  
		success: function(msg){  
			$("#getpaymode").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


function get_report_type(type) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/finance/get_report_type.php",  
		data: "type="+type,  
		success: function(msg){  
			$("#getreporttype").html(msg); 
			$("#loading").html(''); 
		}
	});  
}