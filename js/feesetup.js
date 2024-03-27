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
        $('#inv_form').on('keyup','.jQinv_item_unit,.jQinv_item_qty,.jQinv_item_id, #setupduration, #setupsemester', function() {
            rowInputs();
        });

        function rowInputs() {
            var actpackge = 0;
			var otherchge = 0;
            var subTotal = 0;
			var grandTotal = 0;
            var taxTotal = 0;
            $(".invE_table tr").not('.last_row').each(function () {
                var $unit_price = $('.jQinv_item_unit', this).val();
                var $qty = $('.jQinv_item_qty', this).val();
				var $itemid = $('.jQinv_item_id', this).val();
//                var $semester = $('#setupsemester', this).val();
//				var $duration = $('#setupduration', this).val();
                
               if($('.jQinv_item_qty', this).val() == 1) { 				
				// once;
					var $total = (($unit_price * 1));
				} else if($('.jQinv_item_qty', this).val() == 2) { 				
				//Yearly;
					var $total = (($unit_price * $('#setupduration').val()));
				} else if($('.jQinv_item_qty', this).val() == 3) {
					// Semester

					var $total = (($unit_price * 1) * ($('#setupsemester').val() * 1));
				} else  if($('.jQinv_item_qty', this).val() == 4) { 				
				//monthly
					var $total = (($unit_price * ($('#setupduration').val() * 12)));
				} 
    			
				if(($('.jQinv_item_id', this).val() == 2)) { 	
				
					var $othercharges = ($total );
				} else { 
					var $othercharges = 0;
				}
				if(($('.jQinv_item_id', this).val() == 1)) { 	
				
					var $actpackage = ($total );
				} else { 
					var $actpackage = 0;
				}
				          
//			  var $actpackage = ($total - $othercharges);
			  //  var $tax_amount = (($unit_price * 1) * ($qty * 1)) * ($tax/parseFloat("100"));
               // var $total_tax = (($unit_price * 1) * ($qty * 1)) - $tax_amount;
                
//				var $total_withtax = ($total + $tax_amount);
              //  var parsedTotal = parseFloat( ('0' + $total_tax).replace(/[^0-9-\.]/g, ''), 10 );
//                var parsedTax = parseFloat( ('0' + $tax_amount).replace(/[^0-9-\.]/g, ''), 10 );
                var parsedSubTotal = parseFloat( ('0' + $total).replace(/[^0-9-\.]/g, ''), 10 );
				var parsedOthers = parseFloat( ('0' + $othercharges).replace(/[^0-9-\.]/g, ''), 10 );
				var parsedActuall = parseFloat( ('0' + $actpackage).replace(/[^0-9-\.]/g, ''), 10 );
               
			   
			    
				//var parsedTotalwithtax = parseFloat( ('0' + $total_withtax).replace(/[^0-9-\.]/g, ''), 10 );
				
                $('.jQinv_item_total',this).val(parsedSubTotal.toFixed(0));
				
                
                subTotal += parsedSubTotal;
				actpackge += parsedActuall;
				otherchge += parsedOthers;
				
                
            });

            
			$(".setup_package span").html(subTotal.toFixed(0));
			$('#setup_package').val(subTotal.toFixed(0));
			
			$(".setup_othercharges span").html(otherchge.toFixed(0));
			$('#setup_othercharges').val(otherchge.toFixed(0));
			
			$(".setup_actualpackage span").html(actpackge.toFixed(0));
			$('#setup_actualpackage').val(actpackge.toFixed(0));
			
			
			
			
        }

        function clearInvForm() {
            $('#inv_form').find('input').each(function() {
                $(this).val('');
				$(".setup_package span").html('0');
				$(".setup_othercharges span").html('0');
				$(".setup_actualpackage span").html('0');
            })
        }
       
    });


<!--Get Student Data by formno or Reg.no for Fee record-->
function feesetup_program(id_prg) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "GET",  
		url: "include/ajax/feesetup_program.php",  
		data: "id_prg="+id_prg,  
		success: function(msg){  
			$("#feesetupprogram").html(msg); 
			$("#loading").html(''); 
		}
	});  
}