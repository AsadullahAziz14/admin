<?php

if(LMS_VIEW == 'add' && !isset($_GET['id'])) { 
	echo '
	<div class="row">
		<div class="modal-dialog" style="width:95%;">
			<form class="form-horizontal" action="inventory-issuance.php" method="POST" enctype="multipart/form-data" autocomplete="off">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" style="font-weight:700;">Add Issuance</h4>
					</div>

					<div class="modal-body">

						<!-- <div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="issuance_quantity" class="req"><b>Issuance Quantity</b></label>
								<input type="text" class="form-control" id="issuance_quantity" name="issuance_quantity" required>
							</div>
						</div> -->

						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="issuance_remarks" class="req"><b>Remarks</b></label>
								<input type="text" class="form-control" id="issuance_remarks" name="issuance_remarks" required>
							</div>
						</div>
						
						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="id_item" class="req"><b>Items</b></label>
								<select id="id_item" class="select2" style="width: 100%;" name="id_item[]" required multiple>
									<option value="">Select Item</option>';
									$sqllms = $dblms->querylms("SELECT item_id, item_title 
															FROM ".SMS_ITEMS." 
															WHERE item_status = 1");
									while($rowstd = mysqli_fetch_array($sqllms)) {
										echo '<option value="'.$rowstd['item_id'].'">'.$rowstd['item_title'].'</option>';
									}	
								echo '
								</select>
							</div>
						</div>
						<div class="col-sm-61">
							<div style="margin-top:5px;">
							<label for="issuance_status" class="req"><b>Status</b></label>
								<select id="issuance_status" class="form-control" name="issuance_status" required>
									<option value="">Select Status</option>';
									foreach ($status as $adm_status) {
										echo '<option value="'.$adm_status['id'].'">'.$adm_status['name'].'</option>';
									}
									echo '
								</select>
							</div>
						</div>
						<div style="clear:both;"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" onclick="location.href=\'inventory-issuance.php\'">Close</button>
						<input class="btn btn-primary" type="submit" id="submit_issuance" name="submit_issuance" value="Add Record">
					</div>
				</div>
			</form>
		</div>
	</div>

	<script src="js/select2/jquery.select2.js"></script>

	<script>
		$(".select2").select2({

			placeholder: "Select Any Option"

		})

	</script>
	';
}

?>