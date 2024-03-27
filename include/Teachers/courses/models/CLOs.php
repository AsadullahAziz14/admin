<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>

<div class="row">
<div id="cursEditCLOModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editCLO" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit CLO Details</h4>
</div>

<div class="modal-body">

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">CLO Number</label>
			<select id="clo_number_edit" name="clo_number_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Option</option>';
			for($i = 1; $i <= 50; $i++) { 
				echo '<option value="'.$i.'">'.$i.'</option>';
			}
			echo '
			</select>
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Status</label>
			<select id="clo_status_edit" name="clo_status_edit" style="width:100%" autocomplete="off" required>';
			foreach($status as $cloStatus) { 
				echo '<option value="'.$cloStatus['id'].'">'.$cloStatus['name'].'</option>';
			}
			echo '
			</select>
		</div> 
	</div>

	<div style="clear:both;"></div>

	<div class="form-group">
		<label for="clo_statement" class="control-label req col-lg-12" style="width:250px;"> <b>CLO Statement</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" name="clo_statement_edit" id="clo_statement_edit" style="height:100px!important;" required></textarea>
		</div>
	</div>

	<div style="clear:both;"></div>

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:250px;"><b>Mapped PLOs</b></label>
		<div class="col-lg-12">
			<select id="id_plo_edit" class="select2" name="id_plo_edit[]" style="width:100%" multiple>';
			$queryPLOs = $dblms->querylms("SELECT plo_id, plo_statement 
												FROM ".OBE_PLOS." 
												WHERE plo_status = '1'
												AND id_prg = '".$rowsurs['prg_id']."'
												AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'
												ORDER BY plo_number ASC");
			while($valuePLO = mysqli_fetch_array($queryPLOs)) {
				echo '<option value="'.$valuePLO['plo_id'].'">'.$valuePLO['plo_statement'].'</option>';
			}
			echo '
			</select>
		</div>
	</div>

	<div style="clear:both;"></div>
	
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
			<input type="text" name="total_marks_edit" min="1" id="total_marks_edit" required class="form-control" autocomplete="off"  onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"  >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Passing Marks</label>
			<input type="text" name="passing_marks_edit" id="passing_marks_edit" class="form-control" autocomplete="off"  onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"  >
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
	<input type="hidden" id="id_clo" name="id_clo" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_assignment" name="changes_assignment">
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#clo_number_edit").select2({
        allowClear: true
    });
	$("#clo_status_edit").select2({
        allowClear: true
    });
	$("#id_plo_edit").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
	$().ready(function() {
		$("#editCLO").validate({
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
		$(".edit-clo-modal").click(function(){
			var id_clo 				= $(this).attr("data-clo-id");
			var clo_status_edit 	= $(this).attr("data-clo-status");
			var clo_number_edit 	= $(this).attr("data-clo-number");
			var clo_statement_edit 	= $(this).attr("data-clo-statement");
			var total_marks_edit 	= $(this).attr("data-clo-domain-level");
			var id_plo_edit 		= $(this).attr("data-clo-plos");

			$("#id_clo")				.val(id_clo);
			$("#clo_statement_edit")	.val(clo_statement_edit);
			$("#total_marks_edit")		.val(total_marks_edit);
			$("#passing_marks_edit")	.val(passing_marks_edit);
			$("#detail_edit")			.val(detail_edit);

			$("#clo_status_edit")		.select2().select2("val", clo_status_edit); 
			$("#clo_number_edit")		.select2().select2("val", clo_number_edit); 
			$("#id_plo_edit")			.select2().select2("val", id_plo_edit); 
		});
	});
</script>';
?>