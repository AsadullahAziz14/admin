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
        $('#inv_form').on('keyup','.jQinv_price,.jQinv_dprice,.bill_balance', function() {
            rowInputs();
        });

        function rowInputs() {
            var balance 	= 0;
            var subTotal 	= 0;
			var subdisTotal = 0;
            var taxTotal 	= 0;
			var grandtotal 	= 0;
			var grandwithbalance 	= 0;
            $(".invE_table tr").not('.last_row').each(function () {
                var $unit_price 	= $('.jQinv_price', this).val();
				var $unit_dprice 	= $('.jQinv_dprice', this).val();
                var $total 			= $unit_price;
				var $dtotal 		= $unit_dprice;
                
                
                //var parsedTotal = parseFloat( ('0' + $total).replace(/[^0-9-\.]/g, ''), 10 );
                var parsedSubTotal 		= parseFloat( ('0' + $total).replace(/[^0-9-\.]/g, ''), 10 );
				var parsedSubdisTotal 	= parseFloat( ('0' + $dtotal).replace(/[^0-9-\.]/g, ''), 10 );
                
               // $('.jQinv_item_total',this).val(parsedTotal.toFixed(2));
                
                subTotal += parsedSubTotal;
				subdisTotal += parsedSubdisTotal;
				grandtotal = subTotal - subdisTotal;
                 
            });
            
            grandwithbalance = (grandtotal + parseFloat( ('0' + $('.bill_balance').val()).replace(/[^0-9-\.]/g, ''), 10 ));
			
            $(".bill_total span").html(subTotal.toFixed(2));
			$('#bill_total').val(subTotal.toFixed(2));
			$(".bill_discount span").html(subdisTotal.toFixed(2));
			$('#bill_discount').val(subdisTotal.toFixed(2));
			$(".bill_grandtotal span").html(grandwithbalance.toFixed(2));
			$('#bill_grandtotal').val(grandwithbalance.toFixed(2));
            
        }

        function clearInvForm() {
            $('#inv_form').find('input').each(function() {
                $(this).val('');
                $(".bill_total span").html('0.00');
				$(".bill_discount span").html('0.00');
				$(".bill_grandtotal span").html('0.00');
            })
        }
       
    });