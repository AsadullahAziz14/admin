
// Get Question Type
function get_questionoption(question_type) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/teachers/get_question-options.php",  
		data: "question_type="+question_type,  
		success: function(msg){  
			$("#getquestionoption").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



// Get Course Resource Type
function get_ResourcesType(idtype) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/teachers/get_ResourcesType.php",  
		data: "idtype="+idtype,  
		success: function(msg){  
			$("#getResourcesType").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


// Get Course Resource Type
function get_assignmentmidtermmarks(ismidterm, timing) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/teachers/get_assignmentmidtermmarks.php",  
		data: "ismidterm="+ismidterm+"&timing="+timing,  
		success: function(msg){  
			$("#getassignmentmidtermmarks").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



function get_coursedetail(curs_code, srno, sem) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_coursedetail.php",  
		data: "curs_code="+curs_code+"&srno="+srno+"&semno="+sem,  
		success: function(msg){  
			$("#getcoursedetail_" + srno).html(msg); 
			$("#loading").html(''); 
		}
	});  
}



function get_programsemesters(id_prg) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/get_programsemesters.php",  
		data: "id_prg="+id_prg,  
		success: function(msg){  
			$("#getprogramsemesters").html(msg); 
			$("#loading").html(''); 
		}
	});  
}



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
 
	$("input#totalcredithours").val(sum.toFixed(0));	
}

$(document).ready(function() { 
  $(".sumcrd").on('keydown keyup', calculateSumcrd);
});

function calculateSumcrd() {
  var $input = $(this);
  var $row = $input.closest('.countcrd');
  var sumcrd = 0;

  $row.find(".sumcrd").each(function() {
    sumcrd += parseFloat(this.value) || 0;
  });

  $row.find(".sumcrd_sum").html(sumcrd.toFixed(0));
}

