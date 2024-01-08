<?php
if (!LMS_VIEW && isset($_GET['id'])) {
   $queryIssuance = $dblms->querylms("SELECT issuance_id, issuance_remarks, issuance_status
   											FROM ".SMS_ITEM_ISSUANCES." 
											WHERE issuance_id =  ".cleanvars($_GET['id'])."
									");
   $valueIssuance = mysqli_fetch_array($queryIssuance);

   echo '
	<div class="row">
		<div class="modal-dialog" style="width:95%;">
			<form class="form-horizontal" action="inventory-issuance.php?id='.$_GET['id'].'" method="post" enctype="multipart/form-data">
				<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" style="font-weight:700;"> Edit Issuance</h4>
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
								<input type="text" class="form-control" id="issuance_remarks" name="issuance_remarks" value="'.$valueIssuance['issuance_remarks'].'" required>
							</div>
						</div>';
						$queryIssuanceItem = $dblms->querylms("SELECT GROUP_CONCAT(id_item) as id_item
													FROM ".SMS_ISSUANCE_ITEM_JUNCTION."  
													WHERE ".SMS_ISSUANCE_ITEM_JUNCTION.".id_issuance = ".$valueIssuance['issuance_id']."");
						$valueIssuanceItem = mysqli_fetch_array($queryIssuanceItem);
						$issuanceItemArray = explode(',',$valueIssuanceItem['id_item']);

						$queryItem = $dblms->querylms("SELECT item_id, item_title
													FROM ".SMS_ITEMS." 
													WHERE ".SMS_ITEMS.".item_status = '1'");
						echo '
						<div class="col-sm-61">
							<div style="margin-top:5px;">
							<label for="id_item" class="req"><b>Items</b></label>
								<select id="id_item" class="form-control" name="id_item" required>
								<option value="">Select Status</option>';
								while($valueItem = mysqli_fetch_array($queryItem)) {
									if(in_array($valueItem['item_id'],$issuanceItemArray)) {
										echo "<option value='".$valueItem['item_id']."' selected>".$valueItem['item_title']."</option>";
									} else {
										echo "<option value='".$valueItem['item_id']."'>".$valueItem['item_title']."</option>";
									}
								}
								echo'
								</select>
							</div>
						</div>

						<div class="col-sm-61">
							<div style="margin-top:5px;">
							<label for="issuance_status" class="req"><b>Status</b></label>
								<select id="issuance_status" class="form-control" name="issuance_status" required>
								<option value="">Select Status</option>';
								foreach($status as $issuance_status) {
									if($rowstd['issuance_status'] == $issuance_status['id']) {
										echo "<option value='$issuance_status[id]' selected>$issuance_status[name]</option>";
									} else {
										echo "<option value='$issuance_status[id]'>$issuance_status[name]</option>";
									}
								}
								echo'
								</select>
							</div>
						</div>
						<div style="clear:both;"></div>

					</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" onclick="location.href=\'inventory-issuance.php\'" >Close</button>
					<input class="btn btn-primary" type="submit" value="Save Changes" id="edit_issuance" name="edit_issuance">
				</div>
				</div>
			</form>
		</div>
	</div>
  
	<script type="text/javascript" src="assets/js/ckeditor/ckeditor.js"></script>
	<script>
	$(".select2").select2({
		placeholder: "Select Any Option"
	})
	</script>';
}