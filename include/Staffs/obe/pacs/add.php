<?php
if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'add' => '1'))) {
	if(LMS_VIEW == 'add' && !isset($_GET['id'])) {
		echo '
		<div class="row">
			<div class="modal-dialog" style="width:95%;">
				<form class="form-horizontal" action="obepacs.php" method="POST"enctype="multipart/form-data" autocomplete="off">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
							<h4 class="modal-title" style="font-weight:700;">Add PAC</h4>
						</div>
						<div class="modal-body">
							<div class="col-sm-61" style="margin-bottom:10px;">
								<label for="pac_number" class="req" style="width:150px;"> <b>PAC Number</b></label>
								<input type="number" class="form-control" id="pac_number" name="pac_number" data-required="true">
							</div>
							<div class="col-sm-61" style="margin-bottom:10px;">
								<label for="pac_weightage" class="req" style="width:150px;"> <b>PAC Weightage</b></label>
								<input type="number" class="form-control" id="pac_weightage" name="pac_weightage" data-required="true">
							</div>
				
							<div style="clear:both;"></div>
				
							<div class="col-sm-91" style="margin-bottom:10px;">
								<label for="pac_statement" class="control-label req" style="width:150px;"> <b>PAC Statement</b></label>
								<textarea class="form-control" name="pac_statement" id="pac_statement" cols="30" rows="10" required></textarea>
							</div>
							<div style="clear:both;"></div>
							<div class="col-sm-61" style="margin-bottom:10px;">
								<label for="program" class="control-label req" style="width:150px;"> <b>PAC Program</b></label>
								<select id="program" class="form-control" name="program" style="width:100%" autocomplete="off" required>
									<option value="">Select Program</option>';
									foreach($programs as $item_programs) {
										echo '<option value="'.$item_programs['id'].'">'.$item_programs['name'].'</option>';
									}
									echo'
								</select>
							</div>
							<div class="col-sm-61" style="margin-bottom:10px;">
								<label for="pac_status" class="control-label req" style="width:150px;"> <b>Status</b></label>
								<select id="pac_status" class="form-control" name="pac_status" style="width:100%" required>
									<option value="">Select Status</option>';
									foreach ($status as $pacStatus) {
										echo '<option value="'.$pacStatus['id'].'">'.$pacStatus['name'].'</option>';
									}
									echo'
								</select>
							</div>
							<div style="clear:both;"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
							<input class="btn btn-primary" type="submit" value="Add Record" id="submit_pac" name="submit_pac">
						</div>
					</div>
				</form>
			</div>
		</div>

		<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
		<script>
			$(".select2").select2({
				placeholder: "Select Any Option"
			})
		</script>';
	}
}
?>
