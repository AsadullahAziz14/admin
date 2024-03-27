<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>


<div class="row">
<div id="cursEditAssignModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editAssign" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Assignment Detail</h4>
</div>

<div class="modal-body">

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Title </label>
			<input type="text" name="caption_edit" id="caption_edit" class="form-control" required autocomplete="off" readonly >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Status</label>
			<select id="status_edit" name="status_edit" style="width:100%" autocomplete="off" required disabled>
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadm_status) {
				echo "<option value='$itemadm_status[status_id]'>$itemadm_status[status_name]</option>";
			}
	echo'
			</select>
		</div> 
	</div>
	<div style="clear:both;"></div>
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Detail</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="detail_edit" name="detail_edit" required autocomplete="off" ></textarea>
		</div>
	</div>
		
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Start Date </label>
			<input type="text" name="date_start_edit" id="date_start_edit" class="form-control " required autocomplete="off" readonly >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">End Date</label>
			<input type="text" name="date_end_edit" id="date_end_edit" class="form-control " required autocomplete="off" readonly >
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Total Marks </label>
			<input type="number" name="total_marks_edit" min="1" id="total_marks_edit" required class="form-control" autocomplete="off" readonly >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Passing Marks</label>
			<input type="text" name="passing_marks_edit" id="passing_marks_edit" class="form-control" autocomplete="off" readonly>
		</div> 
	</div>
	
	
	<div style="clear:both;"></div>
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
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
	$("#editAssign").validate({
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
			total_marks_edit: {
                required: "Please enter Total Marks",
                number: "Please enter only numeric value"
            },
			passing_marks_edit: {
                required: "Please enter Passing Marks",
                number: "Please enter only numeric value"
            }
		},
		submitHandler: function(form) {
        //alert("form submitted");
		form.submit();
        }
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
    $(".edit-assignment-modal").click(function(){
    

        var status_edit 		= $(this).attr("data-assignstatus");
		var caption_edit 		= $(this).attr("data-assignname");
		var date_start_edit 	= $(this).attr("data-assignsdat");
		var date_end_edit 		= $(this).attr("data-assignedate");
		var total_marks_edit 	= $(this).attr("data-assigntotalmarks");
		var passing_marks_edit 	= $(this).attr("data-assignpassingmarks");
		var detail_edit 		= $(this).attr("data-assigndetail");
		var assignid_edit		= $(this).attr("data-assignid");

		$("#caption_edit")			.val(caption_edit);
		$("#date_start_edit")		.val(date_start_edit);
		$("#date_end_edit")			.val(date_end_edit);
		$("#total_marks_edit")		.val(total_marks_edit);
		$("#passing_marks_edit")	.val(passing_marks_edit);
		$("#detail_edit")			.val(detail_edit);
		$("#assignid_edit")			.val(assignid_edit);
        $("#status_edit")			.select2().select2("val", status_edit); 
  });
    
});
</script>';
?>