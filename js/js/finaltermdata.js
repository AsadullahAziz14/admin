/* [ ---- Beoro Admin - invoices ---- ] */

    $(document).ready(function() {

        //* clone row
        var id = 0;
        $(".inv_clone_btn").click(function() {
            id++;
            var table = $(this).closest("table");
            var clonedRow = table.find(".inv_row").clone();
            clonedRow.removeAttr("class")
            clonedRow.find(".id").attr("value", id);
            clonedRow.find(".inv_clone_row").html('<i class="icon-minus inv_remove_btn"></i>');
            clonedRow.find("input").each(function() {
                $(this).val('');
            });
            table.find(".last_row").before(clonedRow);
        });
        //* remove row
        $(".invE_table").on("click",".inv_remove_btn", function() {
            $(this).closest("tr").remove();
            rowInputs();
        });
		
       //* subtotal sum
        $('#inv_form').on('keyup','.jQinv_item_obtained, .jQinv_item_credithour', function() {
            rowInputs();
        });

        function rowInputs() {
            var balance = 0;
            var subTotal = 0;
			var grandTotal = 0;
            var taxTotal = 0;
            $(".invE_table tr").not('.last_row').each(function () {
     			var $obtainmarks		= $('.jQinv_item_obtained', this).val();
				var $itemcredithour 	= $('.jQinv_item_credithour', this).val();
		
				var $lineitemtotal 	= (($obtainmarks * 1)); 
				var parsedSubTotal 	= parseFloat( ('0' + $lineitemtotal).replace(/[^0-9-\.]/g, ''), 10 );	
				
                $('.jQinv_item_obtained',this).val($lineitemtotal.toFixed(0));

				if($lineitemtotal>=85) { 
					 var $itemletter 		= "A+"; 
					 var $itemnumpoints 	= 4; 
					 var $itemremarks 		= "Pass"; 
				} else if($lineitemtotal>=80) { 
					 var $itemletter 		= "A"; 
					 var $itemnumpoints 	= 3.7; 
					 var $itemremarks 		= "Pass"; 
				} else if($lineitemtotal>=75) { 
					 var $itemletter 		= "B+"; 
					 var $itemnumpoints 	= 3.3; 
					 var $itemremarks 		= "Pass"; 
				} else if($lineitemtotal>=70) { 
					 var $itemletter 		= "B"; 
					 var $itemnumpoints 	= 3; 
					 var $itemremarks 		= "Pass"; 
				} else if($lineitemtotal>=65) { 
					 var $itemletter 		= "B-"; 
					 var $itemnumpoints 	= 2.7; 
					 var $itemremarks 		= "Pass"; 
				} else if($lineitemtotal>=61) { 
					 var $itemletter 		= "C+"; 
					 var $itemnumpoints 	= 2.3; 
					 var $itemremarks 		= "Pass"; 
				} else if($lineitemtotal>=58) { 
					 var $itemletter 		= "C"; 
					 var $itemnumpoints 	= 2; 
					 var $itemremarks 		= "Pass"; 
				} else if($lineitemtotal>=55) { 
					 var $itemletter 		= "C-"; 
					 var $itemnumpoints 	= 1.7; 
					 var $itemremarks 		= "Pass"; 
				} else if($lineitemtotal>=50) { 
					 var $itemletter 		= "D"; 
					 var $itemnumpoints 	= 1; 
					 var $itemremarks 		= "Pass"; 
				} else { 
					 var $itemletter 		= "F"; 
					 var $itemnumpoints 	= 0; 
					 var $itemremarks 		= "Fail";
				}	
				
				
				
				var $linegradepoint 				= (($itemcredithour * $itemnumpoints)); 
				$('.jQinv_item_gradepoint',this)	.val($linegradepoint.toFixed(2));
				
				$('.jQinv_item_numerical',this)		.val($itemnumpoints.toFixed(2));
				$('.jQinv_item_lettergrade',this)	.val($itemletter);
				$('.jQinv_item_remarks',this)		.val($itemremarks);
				

                
				grandTotal += parsedSubTotal;
                
            });

            
			$(".inV_grandtotal span").html(grandTotal.toFixed(2));
			$('#inV_grandtotal').val(grandTotal.toFixed(2));
			
			
			
        }

        function clearInvForm() {
            $('#inv_form').find('input').each(function() {
                $(this).val('');
				$(".inV_grandtotal span").html('0.00');
            })
        }
       
    });



<!--Get Department by Faculty ID -->
function get_sessionsemester(id_prg) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/finalterm/get_sessionsemester.php",  
		data: "id_prg="+id_prg,  
		success: function(msg){  
			$("#getsessionsemester").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Department by Faculty ID -->
function get_programcourses(id_prg, stdsession) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/finalterm/get_programcourses.php",  
		data: 'stdsession='+stdsession+'&id_prg='+id_prg,  
		success: function(msg){  
			$("#getprogramcourses").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


<!--Get Department by Faculty ID -->
function get_programstudents(stsession, id_prg, idcurs) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/finalterm/get_programstudents.php",  
		data: 'idcurs='+idcurs+'&stsession='+stsession+'&id_prg='+id_prg,  
		success: function(msg){  
			$("#getprogramstudents").html(msg); 
			$("#loading").html(''); 
		}
	});  
}
