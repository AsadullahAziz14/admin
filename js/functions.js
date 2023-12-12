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
 
	$("input#gross_salary").val(sum.toFixed(2));
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
 
	$("input#total_deduction").val(sum1.toFixed(2));
}
<!--Net Salary-->
$(document).ready(function() {
    //this calculates values automatically    
$(".net_salary").click(function(){
    var gross= document.getElementById("gross_salary").value; 
	var deduction= document.getElementById("total_deduction").value;
	 $('#net_salary').val(gross - deduction);

})
    
});


<!--Gross Pay-->
$(document).ready(function() {
    //this calculates values automatically 
    calculateSum1();

    $(".txtpay").on("keydown keyup", function() {
        calculateSum1();
    });
});

function calculateSum1() {
    var sum1 = 0;
    //iterate through each textboxes and add the values
    $(".txtpay").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum1 += parseFloat(this.value);
           
        }
        else if (this.value.length != 0){
           
        }
    });
 
	$("input#gross_salary_edit").val(sum1.toFixed(2));
}
<!--Deduction Pay-->
$(document).ready(function() {
    //this calculates values automatically 
    calculatedeductionSum1();

    $(".txtdedpay").on("keydown keyup", function() {
        calculatedeductionSum1();
    });
});

function calculatedeductionSum1() {
    var sum2 = 0;
    //iterate through each textboxes and add the values
    $(".txtdedpay").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum2 += parseFloat(this.value);
           
        }
        else if (this.value.length != 0){
           
        }
    });
 
	$("input#total_deduction_edit").val(sum2.toFixed(2));
}
<!--Net Salary-->
$(document).ready(function() {
    //this calculates values automatically    
$(".net_salary_edit").click(function(){
    var gross1= document.getElementById("gross_salary_edit").value; 
	var deduction1= document.getElementById("total_deduction_edit").value;
	 $('#net_salary_edit').val(gross1 - deduction1);

})
    
});