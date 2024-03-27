$(document).ready(function() {
    
    //* subtotal sum
    $('#inv_form').on('keyup','.jQinv_actual,.jQinv_percentage,.jQinv_increase_decrease', function() {
        rowInputs();
    });

    function rowInputs() {
        $(".invE_table tr").not('.last_row').each(function () {
            var $actualbudget = $('.jQinv_actual', this).val();
            var $percentage = $('.jQinv_percentage', this).val();

            var $onePercentAmount = (($actualbudget / 100));
            var $budgetedPercentageChange = (($onePercentAmount * $percentage));
            
            if($('.jQinv_increase_decrease', this).val() == 1) { 				
            // once;
                var $totalBudgeted = (($actualbudget * 1) + ($budgetedPercentageChange * 1));

            } else if($('.jQinv_increase_decrease', this).val() == 2) { 				
            //Yearly;
                var $totalBudgeted = (($actualbudget * 1) - ($budgetedPercentageChange * 1));
            }
            
            var parsedTotal = parseFloat( ('0' + $totalBudgeted).replace(/[^0-9-\.]/g, ''), 10 );
        
            
            $('.jQinv_total',this).val(parsedTotal.toFixed(0));            
            
        });        
        
    }
    
});
