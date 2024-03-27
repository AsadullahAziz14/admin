
function getStudentDetails(regno,type) {  
	//$("#loading").html("<img src="images/ajax-loader-horizintal.gif"> loading...");  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/library/getStudentDetails.php",  
		data: "regno="+regno+"&type="+type,  
		async:false,
		cache:false,
		success: function(msg){  
			$("#BorrowerDetails").html(msg); 
			$("#loading").html(""); 
		}
	});  
}
function getFormLoad(formid) {  
	//$("#loading").html("<img src="images/ajax-loader-horizintal.gif"> loading...");  
	$.ajax({  
		type: "GET",  
		async:false,
		cache:false,
		url: "include/ajax/library/getFormLoad.php",  
		data: "formid="+formid,  
		success: function(msg){  
			$("#getFormLoad").html(msg); 
			$("#loading").html(""); 
		}
	});  
}

function getBooksearch(srch,barcode) {  
	//$("#loading").html("<img src="images/ajax-loader-horizintal.gif"> loading...");  
	$.ajax({  
		type: "GET",  
		async:false,
		cache:false,
		url: "include/ajax/library/getBooksearch.php",  
		data: "srch="+srch+"&barcode="+barcode,  
		success: function(msg){  
			$("#getBooksearch").html(msg); 
			$("#loading").html(""); 
		}
	});  
}

function getBiblioFormLoad(formid) {  
	//$("#loading").html("<img src="images/ajax-loader-horizintal.gif"> loading...");  
	$.ajax({  
		type: "GET",  
		async:false,
		cache:false,
		url: "include/ajax/library/getBiblioFormLoad.php",  
		data: "formid="+formid,  
		success: function(msg){  
			$("#getBiblioFormLoad").html(msg); 
			$("#loading").html(""); 
		}
	});  
}
function getEmplyDetails(emply_card,type) {  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/library/getEmplyDetails.php",  
		data: "emply_card="+emply_card+"&type="+type, 
		async:false,
		cache:false, 
		success: function(msg){  
			$("#BorrowerDetails").html(msg); 
			$("#loading").html(""); 
		}
	});  
}


function getBookReturn(accession_no, srno) {  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/library/getBookReturn.php", 
		async:false,
		cache:false, 
		data: "accession_no="+accession_no+"&srno="+srno,  
		success: function(msg){  
			$("#getBookReturn_" + srno).html(msg); 
			$("#loading").html(""); 
		}
	});  
}



