

//-------------------------
function examclearance_studentbyregno(regno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/exam/examclearance_studentbyregno.php",  
		data: "regno="+regno,  
		success: function(msg){  
			$("#examclearancestudentbyregno").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//-------------------
function examclearance_termpapers(term, stdid, prgid, timing, semester, section) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/exam/examclearance_termpapers.php",  
		data: "term="+term+"&stdid="+stdid+"&prgid="+prgid+"&timing="+timing+"&semester="+semester+"&section="+section,  
		success: function(msg){  
			$("#examclearancetermpapers").html(msg); 
			$("#loading").html('');  
		}
	});  
}
