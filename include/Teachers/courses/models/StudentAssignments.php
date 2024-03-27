<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>

<div class="row">
<div id="cursStudentAssignModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editStdAssign" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Student Assignment Detail</h4>
</div>

<div class="modal-body">


	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px;"><b> Assignment Title</b></label>
		<div class="col-lg-12">
			<input type="text" name="assign_caption" id="assign_caption" class="form-control" readonly autocomplete="off" >
		</div>
	</div>
	<div style="clear:both;"></div>
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Registration #</label>
			<input type="text" class="form-control" id="std_regno" name="std_regno" readonly autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Student Name</label>
			<input type="text" class="form-control" id="std_name" name="std_name" readonly autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Due Date</label>
			<input type="text" class="form-control" id="date_end" name="date_end" readonly autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Total Marks</label>
			<input type="text" class="form-control" id="total_marks" name="total_marks" readonly autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Submit Date</label>
			<input type="text" class="form-control" id="submit_date" name="submit_date" readonly autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Obtain Marks</label>
			<input type="number" class="form-control" min="0" id="obtain_marks" name="obtain_marks" autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
</div>

<div class="modal-footer">
	<input type="hidden" id="assignid_edit" name="assignid_edit" value="">
	<input class="btn btn-primary" type="submit" value="Submit Changes" id="submit_stdassignment" name="submit_stdassignment"> 
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#status_edit").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#editStdAssign").validate({
		rules: {
             status_edit			: "required",
			 caption_edit			: "required",
			 date_start_edit		: "required",
			 date_end_edit			: "required",
			 detail_edit			: "required" ,
			 total_marks_edit: {
                required: true,
                number: true
            },
			passing_marks_edit: {
                required: true,
                number: true
            }
		},
		messages: {
			status_edit			: "This field is required",
			caption_edit		: "This field is required",
			date_start_edit		: "This field is required",
			date_end_edit		: "This field is required",
			detail_edit			: "This field is required" ,
		
		},
		submitHandler: function(form) {
        //alert("form submitted");
		form.submit();
        }
	});
});

function filevalidate(file) {
    var ext = file.split(".");
    ext = ext[ext.length-1].toLowerCase();      
    var arrayExtensions = ["pptx" , "ppt", "pdf", "docx", "doc", "xlsx", "xls"];

    if (arrayExtensions.lastIndexOf(ext) == -1) {
        alert("Wrong extension type, please attach valid file.");
        $("#student_file").val("");
    }
}
</script>
<script type="text/javascript">
$(document).ready(function(){
    $(".student-assignment-modal").click(function(){
    

        var std_name 			= $(this).attr("data-assignstdname");
		var assign_caption 		= $(this).attr("data-assignname");
		var std_regno			= $(this).attr("data-assignstdregno");
		var date_end	 		= $(this).attr("data-assignduedat");
		var submit_date		 	= $(this).attr("data-assignsubmitdate");
		var total_marks			= $(this).attr("data-assigntotalmarks");
		var obtain_marks 		= $(this).attr("data-assignobtainmarks");
		var assignid_edit		= $(this).attr("data-assignid");

		$("#std_name")				.val(std_name);
		$("#std_regno")				.val(std_regno);
		$("#assign_caption")		.val(assign_caption);
		$("#date_end")				.val(date_end);
		$("#submit_date")			.val(submit_date);
		$("#total_marks")			.val(total_marks);
		$("#obtain_marks")			.val(obtain_marks);
		$("#assignid_edit")			.val(assignid_edit);
        $("#status_edit")			.select2().select2("val", status_edit); 
  });
    
});
</script>';
?>