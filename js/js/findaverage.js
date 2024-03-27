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
        $('#inv_form').on('keyup','.jQinv_total_marks, .jQinv_obtain_marks', function() {
            rowInputs();
        });

        function rowInputs() {
            var balance = 0;
            var subTotal = 0;
			var grandTotal = 0;
            var taxTotal = 0;
            $(".invE_table tr").not('.last_row').each(function () {
                var $total_marks 	= $('.jQinv_total_marks', this).val();
				var $obtain_marks 	= $('.jQinv_obtain_marks', this).val();
				
				if($total_marks == '' && $obtain_marks == '') { 				
				// once;
					 var $total = ''; 
				} else { 				
				//monthly
					 var $total = ((($obtain_marks * 1) / ($total_marks * 1)) * 100); 
				} 
                            
  
                var parsedSubTotal = parseFloat( ('0' + $total).replace(/[^0-9-\.]/g, ''), 10 );

				
                $('.jQinv_average',this).val($total.toFixed(0));
                
                subTotal += parsedSubTotal;
                
            });

            
			
			
			
        }

        function clearInvForm() {
            $('#inv_form').find('input').each(function() {
                $(this).val('');
				$(".setup_package span").html('0');
            })
        }
       
    });
