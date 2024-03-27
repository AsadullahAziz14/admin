<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="cursAddAssignModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="addAssign" enctype="multipart/form-data">
<input type="hidden" name="id_curs" name="id_curs" value="'.$_GET['id'].'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Assignment Detail</h4>
</div>

<div class="modal-body">

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Title </label>
			<input type="text" name="caption" id="caption" class="form-control" required autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Status</label>
			<select id="status" name="status" style="width:100%" autocomplete="off" required>';
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
			<textarea class="form-control" id="detail" name="detail" required autocomplete="off"></textarea>
		</div>
	</div>
		
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Start Date </label>
			<input type="text" name="date_start" id="date_start" class="form-control pickadate" required autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">End Date</label>
			<input type="text" name="date_end" id="date_end" class="form-control pickadate" required autocomplete="off" >
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Total Marks </label>
			<input type="number" name="total_marks" min="1" id="total_marks" required class="form-control" autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Passing Marks</label>
			<input type="text" name="passing_marks" id="passing_marks" class="form-control" autocomplete="off" >
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px; margin-top:10px;"><b> Attach File</b></label>
		<div class="col-lg-12">
			<input id="assign_file" name="assign_file" class="btn btn-mid btn-primary clearfix" type="file"> 
			<span style="font-weight:700;">File extension must be: ( <span style="color:red; font-weight:700;">jpg,jpeg, gif, png, pdf, docx, doc, xlsx, xls</span> )</span>
		</div>
	</div>
	
	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<input class="btn btn-primary" type="submit" value="Add Record" id="submit_assignment" name="submit_assignment"> 
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#status").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addAssign").validate({
		rules: {
             status			: "required",
			 caption		: "required",
			 date_start		: "required",
			 date_end		: "required",
			 detail			: "required" ,
			 total_marks: {
                required: true,
                number: true
            },
			passing_marks: {
                required: false,
                number: true
            }
		},
		messages: {
			status			: "This field is required",
			caption			: "This field is required",
			date_start		: "This field is required",
			date_end		: "This field is required",
			detail			: "This field is required" ,
			total_marks: {
                required: "Please enter Total Marks",
                number: "Please enter only numeric value"
            },
			passing_marks: {
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
<!--WI_ADD_NEW_TASK_MODAL-->

<div class="row">
<div id="cursEditAssignModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editAssign" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Assignment Detail</h4>
</div>

<div class="modal-body">

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Title </label>
			<input type="text" name="caption_edit" id="caption_edit" class="form-control" required autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Status</label>
			<select id="status_edit" name="status_edit" style="width:100%" autocomplete="off" required>
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
			<textarea class="form-control" id="detail_edit" name="detail_edit" required autocomplete="off"></textarea>
		</div>
	</div>
		
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Start Date </label>
			<input type="text" name="date_start_edit" id="date_start_edit" class="form-control pickadate" required autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">End Date</label>
			<input type="text" name="date_end_edit" id="date_end_edit" class="form-control pickadate" required autocomplete="off" >
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Total Marks </label>
			<input type="number" name="total_marks_edit" min="1" id="total_marks_edit" required class="form-control" autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Passing Marks</label>
			<input type="text" name="passing_marks_edit" id="passing_marks_edit" class="form-control" autocomplete="off" >
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px; margin-top:10px;"><b> Attach File</b></label>
		<div class="col-lg-12">
			<input id="assign_file_edit" name="assign_file_edit" class="btn btn-mid btn-primary clearfix" type="file"> 
			<span style="font-weight:700;">File extension must be: ( <span style="color:red; font-weight:700;">jpg,jpeg, gif, png, pdf, docx, doc, xlsx, xls</span> )</span>
		</div>
	</div>
	
	<div style="clear:both;"></div>
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
	<input type="hidden" id="assignid_edit" name="assignid_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_assignment" name="changes_assignment">
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