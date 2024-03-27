/* [ ---- Beoro Admin - invoices ---- ] */
$(document).ready(function() {
	
    //* subtotal sum
     $('#inv_form').on('keyup','.monthly, .alreadyPaid, .telephone', function() {
         rowInputs();
     });
 
     function rowInputs() {
         
         var subTotal = 0;
         var total = 0;
        

         $(".invE_table tr").not('.last_row').each(function () {
             var $alreadyPaid = $('.alreadyPaid', this).val();
             var $telephone = $('.telephone', this).val();
 
             var $basicMonth = (($alreadyPaid * 1) * ($telephone * 1));
                       
             var parsedSubTotal = parseFloat( ('0' + $basicMonth).replace(/[^0-9-\.]/g, ''), 10 );
             
             $('.tokenTax',this).val(parsedSubTotal.toFixed(0));
             
             subTotal += parsedSubTotal;
             
         });
         
         
        $(".netTax span").html(subTotal.toFixed(0));
        $('#netTax').val(subTotal.toFixed(0));
         
    }

 });