
 //Gross Pay-->
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

$(document).ready(function() {
    //this calculates values automatically 
   
  
$(".balance").on("keydown keyup", function() {
    var gross= document.getElementById("grand_total").value; 
	var deduction= document.getElementById("total_paids").value;
	 $('#balance').val(gross - deduction);

})
    
});






// --Get Employee Salary-->
function get_educationist(educationist, taxvalue) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/salary/get_educationist.php",  
		data: "educationist="+educationist+"&taxvalue="+taxvalue,  
		success: function(msg){  
			$("#geteducationist").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


// -Get Employee Salary-->
function get_srcitizen(srcitizen, taxvalue, education) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/salary/get_srcitizen.php",  
		data: "srcitizen="+srcitizen+"&taxvalue="+taxvalue+"&education="+education,  
		success: function(msg){  
			$("#getsrcitizen").html(msg); 
			$("#loading").html(''); 
		}
	});  
}
