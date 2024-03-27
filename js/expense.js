$(document).ready(function() {
    
    //* subtotal sum
    $('#inv_form').on('keyup','.jQinv_actual,.jQinv_percentage,.jQinv_increase_decrease', function() {
        rowInputs();
    });

    function rowInputs() {

        var grandTotal = 0;

        $(".invE_table tr").not('.last_row').each(function () {

            var $actualbudget = $('.jQinv_actual', this).val();
            var $percentage = $('.jQinv_percentage', this).val();

            var $onePercentAmount = (($actualbudget / 100));
            var $budgetedPercentageChange = (($onePercentAmount * $percentage));
            
            if($('.jQinv_increase_decrease', this).val() == 1) { 				
                // Increase Value;
                var $totalBudgeted = (($actualbudget * 1) + ($budgetedPercentageChange * 1));

            } else if($('.jQinv_increase_decrease', this).val() == 2) { 				
                //Decrease Value;
                var $totalBudgeted = (($actualbudget * 1) - ($budgetedPercentageChange * 1));
            }
            
            var parsedTotal = parseFloat( ('0' + $totalBudgeted).replace(/[^0-9-\.]/g, ''), 10 );
            
            $('.jQinv_total',this).val(parsedTotal.toFixed(0));
            
            grandTotal += parsedTotal;
            
        });

        $(".inV_grandtotal span").html(grandTotal.toFixed(2));
		$('#inV_grandtotal').val(grandTotal.toFixed(2));
        
    }
    
});
