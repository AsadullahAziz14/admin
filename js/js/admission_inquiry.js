
<!--Get Student Data by formno or Reg.no for Fee record-->
function get_source(source) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/admission/get_source.php",  
		data: "source="+source,  
		success: function(msg){  
			$("#getsource").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get scholarship Fields-->
function get_scholarship(scholarship) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/admission/get_scholarship.php",  
		data: "scholarship="+scholarship,  
		success: function(msg){  
			$("#getscholarship").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Student Data by formno or Reg.no for Fee record-->
function get_prgsemestersattendance(idprg) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/admission/get_prgsemestersattendance.php",  
		data: "idprg="+idprg,  
		success: function(msg){  
			$("#getprgsemestersattendance").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Student Data by formno or Reg.no for Fee record-->
function get_prgsection(semester, idprg) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/admission/get_prgsection.php",  
		data: 'semester='+semester+'&idprg='+idprg,  
		success: function(msg){  
			$("#getprgsection").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Student Data by formno or Reg.no for Fee record-->
function get_sectioncourses(section, idprg, semester) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/admission/get_sectioncourses.php",  
		data: 'semester='+semester+'&idprg='+idprg+'&section='+section,  
		success: function(msg){  
			$("#getsectioncourses").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Student Data by formno or Reg.no for Fee record-->
function get_sectioncoursdetail(idcurs, idprg, semester, section) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/admission/get_sectioncoursdetail.php",  
		data: 'semester='+semester+'&idprg='+idprg+'&idcurs='+idcurs+'&section='+section,  
		success: function(msg){  
			$("#getsectioncoursdetail").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Student Data by formno or Reg.no for Fee record-->
function get_prgcoursdetail(idcurs, idprg, semester) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/admission/get_prgcoursdetail.php",  
		data: 'semester='+semester+'&idprg='+idprg+'&idcurs='+idcurs,  
		success: function(msg){  
			$("#getprgcoursdetail").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Student Data by formno or Reg.no for Fee record-->
function get_studentstiming(timing, idprg, semester) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/admission/get_studentstiming.php",  
		data: 'semester='+semester+'&idprg='+idprg+'&timing='+timing,  
		success: function(msg){  
			$("#getstudentstiming").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



<!--Get Student Data by formno or Reg.no for Fee record-->
function get_coursdetail(idcurs, idprg, semester, timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/admission/get_coursdetail.php",  
		data: 'semester='+semester+'&idprg='+idprg+'&timing='+timing+'&idcurs='+idcurs,  
		success: function(msg){  
			$("#getcoursdetail").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Student Data by formno or Reg.no for Fee record-->
function get_studentstimingsection(section, idprg, semester, timing, idcurs) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/admission/get_studentstimingsection.php",  
		data: 'semester='+semester+'&idprg='+idprg+'&timing='+timing+'&section='+section+'&idcurs='+idcurs,  
		success: function(msg){  
			$("#getstudentstimingsection").html(msg); 
			$("#loading").html(''); 
		}
	});  
}
<!--Get Student Data by formno or Reg.no for Fee record-->
function get_prgsemestersstruck(idprg) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/admission/get_prgsemestersstruck.php",  
		data: "idprg="+idprg,  
		success: function(msg){  
			$("#getprgsemestersstruck").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Student Data by formno or Reg.no for Fee record-->
function get_prgstudentsstruck(semester, idprg) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/admission/get_prgstudentsstruck.php",  
		data: 'semester='+semester+'&idprg='+idprg,  
		success: function(msg){  
			$("#getprgstudentsstruck").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Prgam Detail-->
function get_prgdeptfaculty(id_prg) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_prgdeptfaculty.php",  
		data: "id_prg="+id_prg,  
		success: function(msg){  
			$("#getprgdeptfaculty").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Secondary Program Detail-->
function get_prgsecondary(id_prgsecondary) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_prgsecondary.php",  
		data: "id_prgsecondary="+id_prgsecondary,  
		success: function(msg){  
			$("#getprgsecondary").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Program by Department-->
function get_prgbydept(id_dept) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_prgbydept.php",  
		data: "id_dept="+id_dept,  
		success: function(msg){  
			$("#getprgbydept").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Program by Department-->
function get_studentbyformno(std_formno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/Staffs/ajax/get_studentbyformno.php",  
		data: "std_formno="+std_formno,  
		success: function(msg){  
			$("#getstudentbyformno").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Program by Department-->
function get_1stchallandetail(challan, id_prg) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/Staffs/ajax/fee/get_1stchallandetail.php",  
		data: 'challan='+challan+'&id_prg='+id_prg,  
		success: function(msg){  
			$("#get1stchallandetail").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Program by Department-->7
function get_regnofield(yesno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/Staffs/ajax/get_regnofield.php",  
		data: 'yesno='+yesno,  
		success: function(msg){  
			$("#getregnofield").html(msg); 
			$("#loading").html(''); 
		}
	});  
}
