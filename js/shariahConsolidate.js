/* [ ---- Beoro Admin - invoices ---- ] */

    $(document).ready(function() {
		
       //* subtotal sum
        $('#inv_form').on('keyup','.jQinv_semester_total, .jQinv_semester_total1, .jQinv_semester_total2', function() {
            rowInputs();
        });

        function rowInputs() {
            var balance = 0;
            var subTotal = 0;
			var grandTotal = 0;
            var taxTotal = 0;
            $(".invE_table tr").not('.last_row').each(function () {
                var $crdhrs 		= $('.jQinv_item_crdhurs', this).val();
				var $totalcrdhrs 	= $('.jQinv_item_totalcrdhrs', this).val();
			    var $itemcgp 		= $('.jQinv_item_cgp', this).val();
				var $itemcgp1 		= $('.jQinv_item_cgp1', this).val();
				var $lineitemtotal 	= (($('.jQinv_semester_total', this).val() * 1) + ($('.jQinv_semester_total1', this).val() * 1) + ($('.jQinv_semester_total2', this).val() * 1)); 
				
				
				var parsedSubTotal 	= parseFloat( ('0' + $lineitemtotal).replace(/[^0-9-\.]/g, ''), 10 );	
				
                $('.jQinv_semester_grand_total',this).val(parsedSubTotal.toFixed(2));
				if(parsedSubTotal && $totalcrdhrs) {
					var $linecgpa 	= ((parsedSubTotal/$totalcrdhrs)); 
				} else { 
					var $linecgpa 	= 0; 
				}
				$('.jQinv_semester_grand_total',this)	.val($linecgpa.toFixed(2));
                
            });
		
			
			
        }

        function clearInvForm() {
            $('#inv_form').find('input').each(function() {
                $(this).val('');
				$(".inV_grandtotal span").html('0.00');
            })
        }
       
    });
