<?php
if(LMS_VIEW == 'add' && !isset($_GET['id'])) { 
	echo '
	<div class="row">
		<div class="modal-dialog" style="width:95%;">
			<form class="form-horizontal" action="inventory-inventory.php" method="POST" enctype="multipart/form-data" autocomplete="off">
				<div class="modal-content">
					<div class="modal-header"> 
						<h4 class="modal-title" style="font-weight:700;">Add Inventory</h4>
					</div>

					<div class="modal-body">
						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="id_item" class="req"><b>Item</b></label>
								<select name="id_item" class="form-control" id="id_item" required>
									<option value="">Select Item</option>';
									$queryItem = $dblms->querylms("SELECT item_id, item_title 
																		FROM ".SMS_ITEM);
									while($valueItem = mysqli_fetch_array($queryItem)) {
										echo '<option value="'.$valueItem['item_id'].'">'.$valueItem['item_title'].'</option>';
									}
									echo '
								</select>
							</div>
						</div>
						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="inventory_reorder_point" class="req">Re-Order Point</label>
								<input class="form-control" type="number" name="inventory_reorder_point" id="inventory_reorder_point" min="0" required>
							</div>
						</div>
						<div class="col-sm-41">
							<div style="margin-top:5px;">
							<label for="po_status" class="req"><b>Status</b></label>
								<select id="po_status" class="form-control" name="po_status" required>
									<option value="">Select Status</option>';
									foreach ($status as $inventoryStatus) {
										echo '<option value="'. $inventoryStatus['id'].'">'.$inventoryStatus['name'].'</option>';
									}
									echo '
								</select>
							</div>
						</div>
						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="inventory_description" class="req">Description</label>
								<input class="form-control" type="text" name="inventory_description" id="inventory_description" required>
							</div>
						</div>
						
						<div style="clear:both;"></div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" onclick="location.href=\'inventory-inventory.php\'">Close</button>
						<input class="btn btn-primary" type="submit" value="Add Record" id="submit_inventory" name="submit_inventory">
					</div>
				</div>
			</form>
		</div>
	</div>

	<script>
		$(".select2").select2({
			placeholder: "Select Any Option"
		})
	</script>

	<script src="js/select2/jquery.select2.js"></script>';
}

?>