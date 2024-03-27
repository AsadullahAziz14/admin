// Get Department by Faculty ID -->
function get_deptprgram(iddept) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/datesheet/get_deptprgram.php",  
		data: "iddept="+iddept,  
		success: function(msg){  
			$("#getdeptprgram").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


// -----------

function get_timingtoexamtermattendance(timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/datesheet/get_timingtoexamtermattendance.php",  
		data: "timing="+timing,  
		success: function(msg){  
			$("#gettimingtoexamtermattendance").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



function get_examtermbatchattendance(term, timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/datesheet/get_examtermbatchattendance.php",  
		data: "timing="+timing+'&term='+term,  
		success: function(msg){  
			$("#getexamtermbatchattendance").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



// -----------

function get_timingtoexamterm(timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/datesheet/get_timingtoexamterm.php",  
		data: "timing="+timing,  
		success: function(msg){  
			$("#gettimingtoexamterm").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



function get_examtermbatch(term, timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/datesheet/get_examtermbatch.php",  
		data: "timing="+timing+'&term='+term,  
		success: function(msg){  
			$("#getexamtermbatch").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


//--get liberalarts timing semesters -->
function get_liberalartstimingdate(timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/datesheet/final/get_liberalartstimingdate.php",  
		data: "timing="+timing,  
		success: function(msg){  
			$("#get_liberalartstimingdate").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//--get liberalarts timing semester courses -->
function get_liberalartstimingdatebatches(dated,timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/datesheet/final/get_liberalartstimingdatebatches.php",  
		data: 'dated='+dated+'&timing='+timing,  
		success: function(msg){  
			$("#get_liberalartstimingdatebatches").html(msg); 
			$("#loading").html(''); 
		}
	});  
}