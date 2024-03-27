
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




<!--Get Student Data by formno or Reg.no for Fee record-->
function get_getstudentdatabyformno(formno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_getstudentdatabyformno.php",  
		data: "formno="+formno,  
		success: function(msg){  
			$("#getstudentdatabyformno").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Student Data by formno or Reg.no for Fee record-->
function fee_studentdatabyregno(regno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/fee_studentdatabyregno.php",  
		data: "regno="+regno,  
		success: function(msg){  
			$("#feestudentdatabyregno").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Student Data by formno or Reg.no for Fee record-->
function fee_studentmonthlyInstalment(regno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/fee_studentmonthlyInstalment.php",  
		data: "regno="+regno,  
		success: function(msg){  
			$("#feestudentmonthlyInstalment").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



<!--Get Student Data by formno or Reg.no for Fee record-->
function fee_admissionchallan(formno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/fee_admissionchallan.php",  
		data: "formno="+formno,  
		success: function(msg){  
			$("#feeadmissionchallan").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Student Data by formno or Reg.no for Fee record-->
function fee_mischallan(challanno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/fee_mischallan.php",  
		data: "challanno="+challanno,  
		success: function(msg){  
			$("#feemischallan").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Student Detail for Fee by Reg #-->
function get_studentdatabyregno(regno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/fee/get_studentdatabyregno.php",  
		data: "regno="+regno,  
		success: function(msg){  
			$("#getstudentdetailbyregno").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Fee by Other Fee Type-->
function get_otherfee(id_type) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/fee/get_otherfee.php",  
		data: "id_type="+id_type,  
		success: function(msg){  
			$("#otherfee").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Normal/Urgent Fee-->
function get_normalurgentfee(normalurgent) {  
    $("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
    var id_type = $("#id_type").val();
	$.ajax({  
		type: "POST",  
		url: "include/ajax/fee/get_normalurgentfee.php",  
        data: "id_type="+id_type+"&normalurgent="+normalurgent,  
		success: function(msg){  
			$("#normalurgentfee").html(msg); 
			$("#loading").html(''); 
		}
	});  
}