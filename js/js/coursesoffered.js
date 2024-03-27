<!--Get Semesters by Program ID -->
function get_programsemesters(id_prg) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/academic/coursesoffered/get_programsemesters.php",  
		data: 'id_prg='+id_prg,  
		success: function(msg){  
			$("#getprogramsemesters").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Courses by Semester -->
function get_semestercourses(id_prg, semester) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/academic/coursesoffered/get_semestercourses.php",  
		data: 'id_prg='+id_prg+'&semester='+semester,  
		success: function(msg){  
			$("#getsemestercourses").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--Get Course Detail -->
function get_coursedetail(curs_code, srno) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/academic/coursesoffered/get_coursedetail.php",  
		data: 'curs_code='+curs_code+'&srno='+srno,  
		success: function(msg){  
			$("#getcoursedetail_" + srno).html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Calculate Sum-->
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