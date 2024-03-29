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
        $('#inv_form').on('keyup','.jQinv_item_unit', function() {
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
                
				var $total = (($unit_price * 1));
				
                var parsedSubTotal = parseFloat( ('0' + $total).replace(/[^0-9-\.]/g, ''), 10 );
			   	    
				
                $('.jQinv_item_total',this).val(parsedSubTotal.toFixed(0));
				
                
                subTotal += parsedSubTotal;

                
            });

            
			$(".group_total span").html(subTotal.toFixed(0));
			$('#group_total').val(subTotal.toFixed(0));
		
			
			
			
        }

        function clearInvForm() {
            $('#inv_form').find('input').each(function() {
                $(this).val('');
				$(".group_total span").html('0');          
			})
        }
       
    });
