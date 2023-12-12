<?php
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'edit' => '1'))) { 
	
	echo '
	<!--WI_EDIT_TASK_MODAL-->
	<div class="row">
	<div id="editPLOModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	<form class="form-horizontal" action="obeplos.php" method="POST" id="editRecord">
	<div class="modal-content">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
		<h4 class="modal-title" style="font-weight:700;"> Edit PLO Detail</h4>
	</div>

	<div class="modal-body">
		<div class="form-group">
			<label class="control-label req col-lg-12" style="width:auto;"><b>Program</b></label>
			<div class="col-lg-12">
				<select id="id_prg_edit" name="id_prg_edit" style="width:100%" autocomplete="off" required>
					<option value="">Select Program</option>';
				foreach($programsArray as $valueProgram) {
					echo '<option value="'.$valueProgram['prg_id'].'">'.$valueProgram['prg_name'].'</option>';
				} 
				echo '
				</select>
			</div>
		</div>
		<div style="clear:both;"></div>
		<div class="form-group">
			<label class="control-label req col-lg-12" style="width:auto;"><b>PLO Number</b></label>
			<div class="col-lg-12">
				<select id="plo_number_edit" name="plo_number_edit" style="width:100%" autocomplete="off" required>
					<option value="">Select Option</option>';
				for($i = 1; $i <= 50; $i++) { 
					echo '<option value="'.$i.'">'.$i.'</option>';
				}
				echo '
				</select>
			</div>
		</div>
		<div style="clear:both;"></div>
		<div class="form-group">
			<label for="plo_statement" class="control-label req col-lg-12" style="width:auto;"> <b>PLO Statement</b></label>
			<div class="col-lg-12">
				<textarea class="form-control" id="plo_statement_edit" name="plo_statement_edit" style="height:100px!important;" required></textarea>
			</div>
		</div>
		<div style="clear:both;"></div>
		<div class="form-group">
			<label class="control-label req col-lg-12" style="width:auto;"><b>Status</b></label>
			<div class="col-lg-12">
				<select id="plo_status_edit" name="plo_status_edit" style="width:100%" autocomplete="off" required>
					<option value="">Select Option</option>';
				foreach($status as $ploStatus) { 
					echo '<option value="'.$ploStatus['id'].'">'.$ploStatus['name'].'</option>';
				}
				echo '
				</select>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
		<input type="hidden" id="plo_id" name="plo_id" value="">
		<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
	</div>
	</div>
	</form>
	</div>
	</div>
	</div>
	<!--WI_EDIT_TASK_MODAL-->

	<!--JS_EDIT_TASK_MODAL-->
	<script type="text/javascript">
		$().ready(function() {
			$("#editRecord").validate({
				rules: {
						id_prg_edit		: "required",
						plo_number_edit		: "required",
						plo_statement_edit : "required",
						plo_status_edit : "required",
					},
			messages: {
						id_prg_edit		: "This field is required",
						plo_number_edit		: "This field is required",
						plo_statement_edit : "This field is required",
						plo_status_edit : "This field is required",
					},
				submitHandler: function(form) { 
					form.submit();
				}
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			//---edit item link clicked-------
			$(".edit-prgm-modal").click(function(){

				//get variables from "edit link" data attributes
				var plo_id 							= $(this).attr("data-plo-id");
				var id_prg_edit 					= $(this).attr("data-plo-prg");
				var plo_number_edit 				= $(this).attr("data-plo-number");
				var plo_statement_edit 				= $(this).attr("data-plo-statement");
				var plo_status_edit 				= $(this).attr("data-plo-status");
				
				//set modal input values dynamically
				$("#plo_id")						.val(plo_id);
				$("#plo_statement_edit")			.val(plo_statement_edit);

				//pre-select data in pull down lists
				$("#id_prg_edit")					.select2().select2("val", id_prg_edit); 
				$("#plo_number_edit")				.select2().select2("val", plo_number_edit); 
				$("#plo_status_edit")				.select2().select2("val", plo_status_edit);
			});
		});
	</script>';
}