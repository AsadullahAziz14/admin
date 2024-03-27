

function get_prgsemestersfinalterm(idprg) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/finalterm/get_prgsemestersfinalterm.php",  
		data: "idprg="+idprg,  
		success: function(msg){  
			$("#getprgsemestersfinalterm").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



function get_prgfinaltiming(semester, idprg) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/finalterm/get_prgfinaltiming.php",  
		data: 'semester='+semester+'&idprg='+idprg,  
		success: function(msg) { 
			$("#getprgfinaltiming").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



function get_sesionfinaltiming(timing, idprg, semester) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/finalterm/get_sesionfinaltiming.php",  
		data: 'semester='+semester+'&idprg='+idprg+'&timing='+timing,  
		success: function(msg){  
			$("#getsesionfinaltiming").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


function get_studentsfinaltiming(adsess, idprg, semester, timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/finalterm/get_studentsfinaltiming.php",  
		data: 'semester='+semester+'&idprg='+idprg+'&adsess='+adsess+'&timing='+timing,  
		success: function(msg){  
			$("#getstudentsfinaltiming").html(msg); 
			$("#loading").html(''); 
		}
	});  
}




function get_coursfinaldetail(idcurs, idprg, semester, adsess, timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/finalterm/get_coursfinaldetail.php",  
		data: 'semester='+semester+'&idprg='+idprg+'&timing='+timing+'&idcurs='+idcurs+'&adsess='+adsess,  
		success: function(msg){  
			$("#getcoursfinaldetail").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


function get_coursetype(curstype, idprg, semester, timing, adsess, idcurs) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/finalterm/get_coursetype.php",  
		data: 'semester='+semester+'&idprg='+idprg+'&timing='+timing+'&curstype='+curstype+'&idcurs='+idcurs+'&adsess='+adsess,  
		success: function(msg){  
			$("#getcoursetype").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

function get_coursestudents(curstype, idprg, semester, timing, adsess, idcurs) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/finalterm/get_coursestudents.php",  
		data: 'semester='+semester+'&idprg='+idprg+'&timing='+timing+'&curstype='+curstype+'&idcurs='+idcurs+'&adsess='+adsess,  
		success: function(msg){  
			$("#getcoursestudents").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


function get_studentsfinaltimingsection(section, idprg, semester, timing, idcurs, adsess, curstype) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/finalterm/get_studentsfinaltimingsection.php",  
		data: 'semester='+semester+'&idprg='+idprg+'&timing='+timing+'&section='+section+'&idcurs='+idcurs+'&curstype='+curstype+'&adsess='+adsess,  
		success: function(msg){  
			$("#getstudentsfinaltimingsection").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

