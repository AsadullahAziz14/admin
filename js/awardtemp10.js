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
        $('#inv_form').on('keyup','.jQinv_item_crdhurs, .jQinv_item_totalcrdhrs, .jQinv_item_cgp, .jQinv_item_cgp1, .jQinv_item_cgp2, .jQinv_item_cgp3, .jQinv_item_cgp4, .jQinv_item_cgp5, .jQinv_item_cgp6, .jQinv_item_cgp7, .jQinv_item_cgp8, .jQinv_item_cgp9', function() {
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
				var $itemcgp2 		= $('.jQinv_item_cgp2', this).val();
				var $itemcgp3 		= $('.jQinv_item_cgp3', this).val();
				var $itemcgp4 		= $('.jQinv_item_cgp4', this).val();
				var $itemcgp5 		= $('.jQinv_item_cgp5', this).val();
				var $itemcgp6 		= $('.jQinv_item_cgp6', this).val();
				var $itemcgp7 		= $('.jQinv_item_cgp7', this).val();
				var $itemcgp8 		= $('.jQinv_item_cgp8', this).val();
				var $itemcgp9 		= $('.jQinv_item_cgp9', this).val();

				
				var $lineitemtotal 	= (($('.jQinv_item_cgp', this).val() * 1) + ($('.jQinv_item_cgp1', this).val() * 1) + ($('.jQinv_item_cgp2', this).val() * 1) + ($('.jQinv_item_cgp3', this).val() * 1) + ($('.jQinv_item_cgp4', this).val() * 1) + ($('.jQinv_item_cgp5', this).val() * 1) + ($('.jQinv_item_cgp6', this).val() * 1) + ($('.jQinv_item_cgp7', this).val() * 1) + ($('.jQinv_item_cgp8', this).val() * 1) + ($('.jQinv_item_cgp9', this).val() * 1));  
				
				var parsedSubTotal 	= parseFloat( ('0' + $lineitemtotal).replace(/[^0-9-\.]/g, ''), 10 );	
				
                $('.jQinv_item_totalcgp',this).val(parsedSubTotal.toFixed(2));
				if(parsedSubTotal && $totalcrdhrs) {
					var $linecgpa 	= ((parsedSubTotal/$totalcrdhrs)); 
				} else { 
					var $linecgpa 	= 0; 
				}
				$('.jQinv_item_totalcgpa',this)	.val($linecgpa.toFixed(2));
                
            });
		
			
			
        }

        function clearInvForm() {
            $('#inv_form').find('input').each(function() {
                $(this).val('');
				$(".inV_grandtotal span").html('0.00');
            })
        }
       
    });
