
<!--Get Student Data by formno or Reg.no for Fee record-->
function get_timingprograms(timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/tempaward/get_timingprograms.php",  
		data: "timing="+timing,  
		success: function(msg){  
			$("#gettimingprograms").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Student Data by formno or Reg.no for Fee record-->
function get_programsemesters(idprg, timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/tempaward/get_programsemesters.php",  
		data: 'idprg='+idprg+'&timing='+timing,  
		success: function(msg){  
			$("#getprogramsemesterstemps").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Student Data by formno or Reg.no for Fee record-->
function get_programsectionstemps(semester, idprg, timing ) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/tempaward/get_programsectionstemps.php",  
		data: 'semester='+semester+'&timing='+timing+'&idprg='+idprg,  
		success: function(msg){  
			$("#getprogramsectionstemps").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Student Data by formno or Reg.no for Fee record-->
function get_studentssection(section, idprg, semester, timing ) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/tempaward/get_studentssection.php",  
		data: 'section='+section+'&semester='+semester+'&timing='+timing+'&idprg='+idprg,  
		success: function(msg){  
			$("#getstudentssection").html(msg); 
			$("#loading").html(''); 
		}
	});  
}
