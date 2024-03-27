/* [ ---- Multi Input Feilds---- ] */

$(document).ready(function() {
    
    //* clone row
    var id = 0;
    $(".inv_clone_btn").click(function() {
        id++;
        var table = $(this).closest("table");
        var clonedRow = table.find(".inv_row").clone();
        clonedRow.removeAttr("class")
        clonedRow.find(".id").attr("value", id);
        clonedRow.find(".inv_clone_btn").html('<a class ="inv_remove_btn"> <i class="fa fa-minus "></i></a>');
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
    
});
