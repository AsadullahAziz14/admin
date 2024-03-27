<!--Get Session-->
function comprehensive_studentbyregno(regno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/comprehensive/comprehensive_studentbyregno.php",  
		data: "regno="+regno,  
		success: function(msg){  
			$("#comprehensivestudentbyregno").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Students by Program and Session-->
function comprehensive_studentbyregno(regno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/comprehensive/comprehensive_studentbyregno.php",  
		data: "regno="+regno,  
		success: function(msg){  
			$("#comprehensivestudentbyregno").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Student Data by Reg# for Comprehensive Registration-->
function comprehensive_studentbyregno(regno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/comprehensive/comprehensive_studentbyregno.php",  
		data: "regno="+regno,  
		success: function(msg){  
			$("#comprehensivestudentbyregno").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Department by Faculty ID -->
function get_semestercourses(semester, tsess, srno, idprg) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/summer/get_semestercourses.php",  
		data: "semester="+semester+"&tsess="+tsess+"&srno="+srno+"&idprg="+idprg,  
		success: function(msg){  
			$("#getsemestercourses_" + srno).html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Department by Faculty ID -->
function get_coursedetail(idcurs, tsess, semester, srno, idprg) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/summer/get_coursedetail.php",  
		data: "semester="+semester+"&tsess="+tsess+"&idcurs="+idcurs+"&srno="+srno+"&idprg="+idprg,  
		success: function(msg){  
			$("#getcoursedetail_" + srno).html(msg); 
			$("#loading").html(''); 
		}
	});  
}



<!--Gross Pay-->
$(document).ready(function() {
    //this calculates values automatically 
    calculateSum();

    $(".txtpay").on("keydown keyup", function() {
        calculateSum();
    });
});

function calculateSum() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".txtpay").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);
           
        }
        else if (this.value.length != 0){
           
        }
    });
 
	$("input#grand_total").val(sum.toFixed(0));	
}
<!--Deduction Pay-->
$(document).ready(function() {
    //this calculates values automatically 
    calculatedeductionSum();

    $(".txtdedpay").on("keydown keyup", function() {
        calculatedeductionSum();
    });
});

function calculatedeductionSum() {
    var sum1 = 0;
    //iterate through each textboxes and add the values
    $(".txtdedpay").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum1 += parseFloat(this.value);
           
        }
        else if (this.value.length != 0){
           
        }
    });
 
	$("input#total_paids").val(sum1.toFixed(0));
}
<!--Net Salary-->
$(document).ready(function() {
    //this calculates values automatically 
   
  
$(".balance").on("keydown keyup", function() {
    var gross= document.getElementById("grand_total").value; 
	var deduction= document.getElementById("total_paids").value;
	 $('#balance').val(gross - deduction);

})
    
});





<!--Gross Pay-->
$(document).ready(function() {
    //this calculates values automatically 
    calculateSumedit();

    $(".txtpay").on("keydown keyup", function() {
        calculateSumedit();
    });
});

function calculateSumedit() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".txtpay").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);
           
        }
        else if (this.value.length != 0){
           
        }
    });
 
	$("input#total_amount_edit").val(sum.toFixed(0));	
}
<!--Deduction Pay-->
$(document).ready(function() {
    //this calculates values automatically 
    calculatedeductionSumedit();

    $(".txtdedpay").on("keydown keyup", function() {
        calculatedeductionSumedit();
    });
});

function calculatedeductionSumedit() {
    var sum1 = 0;
    //iterate through each textboxes and add the values
    $(".txtdedpay").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum1 += parseFloat(this.value);
           
        }
        else if (this.value.length != 0){
           
        }
    });
 
	$("input#total_paids").val(sum1.toFixed(0));
}
<!--Net Salary-->
$(document).ready(function() {
    //this calculates values automatically 
   
  
$(".balance").on("keydown keyup", function() {
    var gross= document.getElementById("total_amount_edit").value; 
	var deduction= document.getElementById("total_paids").value;
	 $('#balance').val(gross - deduction);

})
    
});

