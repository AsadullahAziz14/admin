
<!--Get Student Data by formno or Reg.no for Fee record-->
function get_prgsemestersmidterm(idprg) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/midterm/get_prgsemestersmidterm.php",  
		data: "idprg="+idprg,  
		success: function(msg){  
			$("#getprgsemestersmidterm").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Program by Department-->
function get_deptprograms(iddept) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/midterm/get_deptprograms.php",  
		data: 'iddept='+iddept,  
		success: function(msg){  
			$("#getdeptprograms").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Student Data by formno or Reg.no for Fee record-->
function get_prgmidtiming(semester, idprg) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/midterm/get_prgmidtiming.php",  
		data: 'semester='+semester+'&idprg='+idprg,  
		success: function(msg){  
			$("#getprgmidtiming").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Student Data by formno or Reg.no for Fee record-->
function get_studentsmidtiming(timing, idprg, semester) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/midterm/get_studentsmidtiming.php",  
		data: 'semester='+semester+'&idprg='+idprg+'&timing='+timing,  
		success: function(msg){  
			$("#getstudentsmidtiming").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



<!--Get Student Data by formno or Reg.no for Fee record-->
function get_coursmiddetail(idcurs, idprg, semester, timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/midterm/get_coursmiddetail.php",  
		data: 'semester='+semester+'&idprg='+idprg+'&timing='+timing+'&idcurs='+idcurs,  
		success: function(msg){  
			$("#getcoursmiddetail").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Student Data by formno or Reg.no for Fee record-->
function get_studentsmidtimingsection(section, idprg, semester, timing, idcurs) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/midterm/get_studentsmidtimingsection.php",  
		data: 'semester='+semester+'&idprg='+idprg+'&timing='+timing+'&section='+section+'&idcurs='+idcurs,  
		success: function(msg){  
			$("#getstudentsmidtimingsection").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

