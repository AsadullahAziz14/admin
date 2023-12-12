<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'add' => '1'))) 
{
	echo '
	<!--WI_ADD_NEW_TASK_MODAL-->
	<div class="row">
	<div id="addNewPLOModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	<form class="form-horizontal" action="obeplos.php" method="post" id="addNew" enctype="multipart/form-data">
	<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
		<h4 class="modal-title" style="font-weight:700;"> Add PLO Details</h4>
	</div>

	<div class="modal-body">

		<div class="form-group">
			<label class="control-label req col-lg-12" style="width:auto;"><b>Program</b></label>
			<div class="col-lg-12">
				<select id="id_prg" name="id_prg" style="width:100%" autocomplete="off" required>
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
				<select id="plo_number" name="plo_number" style="width:100%" autocomplete="off" required>
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
				<textarea class="form-control" name="plo_statement" id="plo_statement" style="height:100px!important;" required></textarea>
			</div>
		</div>

		<div style="clear:both;"></div>

		<div class="form-group">
			<label class="control-label req col-lg-12" style="width:auto;"><b>Status</b></label>
			<div class="col-lg-12">
				<select id="plo_status" name="plo_status" style="width:100%" autocomplete="off" required>
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
		<input class="btn btn-primary" type="submit" value="Add Record" id="submit_plo" name="submit_plo">
	</div>

	</div>
	</form>
	</div>
	</div>
	</div>
	<!--WI_ADD_NEW_TASK_MODAL-->
	<!--JS_ADD_NEW_TASK_MODAL-->
	<script type="text/javascript">
		$().ready(function() {
			$("#addNew").validate({
				rules: {
					id_prg		: "required",
					plo_number	: "required",
					},
			messages: {
					id_prg		: "This field is required",
					plo_number	: "This field is required"
					},
				submitHandler: function(form) {
					form.submit();
				}
			});
		});
	</script>
	<!--JS_ADD_NEW_TASK_MODAL-->';
}