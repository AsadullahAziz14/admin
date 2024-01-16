<?php
if (!LMS_VIEW && isset($_GET['id'])) {
   $queryIssuance = $dblms->querylms("SELECT issuance_id, issuance_remarks, issuance_status, issuance_to
   											FROM ".SMS_ISSUANCE." 
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

						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="issuance_to" class="req"><b>Issuance To</b></label>
								<select id="issuance_to" class="form-control" name="issuance_to" required>
									<option value="">Select</option>';
									$queryEmployees  = $dblms->querylms("SELECT emply_id, emply_name
																			FROM ".EMPLOYEES." 
																		");
               						while($valueEmployees = mysqli_fetch_array($queryEmployees)) {
										if($valueEmployees['emply_id'] == $valueIssuance['issuance_to']) {
											echo '<option value="'.$valueEmployees['emply_id'].'" selected>'.$valueEmployees['emply_name'].'</option>';
										} else {
											echo '<option value="'.$valueEmployees['emply_id'].'">'.$valueEmployees['emply_name'].'</option>';
										}
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

						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="issuance_remarks" class="req"><b>Remarks</b></label>
								<input type="text" class="form-control" id="issuance_remarks" name="issuance_remarks" value="'.$valueIssuance['issuance_remarks'].'" required>
							</div>
						</div>

						<div class="col-sm-91">';
							$queryPoDemand = $dblms->querylms("SELECT DISTINCT id_demand 
																FROM ".SMS_PO_DEMAND_ITEM_JUNCTION." 
																Where id_po = ".$valuePO['po_id']
															);
							$i = 0;
							while($valuePoDemand = mysqli_fetch_array($queryPoDemand)) {
								$i = $i + 1;
								echo '
								<div class="form-sep" style="margin-top: 10px; width: 100%; border: 1px solid rgb(231, 231, 231);">
									<div class="col-sm-92">
										<label for="id_demand" class="req">Demand</label>
										<select class="form-control" name="id_demand['.$i.']" id="id_demand'.$i.'">
											<option value=""></option>';
											$queryDemand = $dblms->querylms("SELECT demand_id, demand_code
																				FROM ".SMS_DEMAND);
											while($valueDemand = mysqli_fetch_array($queryDemand)) {
												if($valueDemand['demand_id'] == $valuePoDemand['id_demand']) {
													$selectedDemands[] = $valueDemand['demand_id'];
													echo '<option value="'.$valueDemand['demand_id'].'" selected>'.$valueDemand['demand_code'].'</option>';
												} else {
													echo '<option value="'.$valueDemand['demand_id'].'">'.$valueDemand['demand_code'].'</option>';
												}
											}
											echo '
										</select>
									</div>
									<div class="col-sm-21">
										<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
											<button class="btn btn-info" style="align-items: center;"><i class="icon-remove"></i></button>
										</div>
									</div>';
									$queryPoDemandJuntion = $dblms->querylms("SELECT id_item, quantity_ordered, unit_price 
																				FROM ".SMS_PO_DEMAND_ITEM_JUNCTION."
																				Where id_po = ".$valuePO['po_id']." && id_demand = ".$valuePoDemand['id_demand']);
									while($valuePoDemandJuntion = mysqli_fetch_array($queryPoDemandJuntion)) {
										$queryItem = $dblms->querylms("SELECT item_id, item_code, item_title
																		FROM ".SMS_ITEM." 
																		where item_id IN (".$valuePoDemandJuntion['id_item'].")");
										$valueItem = mysqli_fetch_array($queryItem);
										echo '
											<div class="item">
												<div class="col-sm-70">
														<label for="id_item" class="req"><b>Item Name</b></label>
														<input class="form-control" type="text" value="'.$valueItem['item_title'].'" name="id_item[u]['.$valuePoDemand['id_demand'].']['.$valueItem['item_id'].']" id="id_item'.$valuePoDemand['id_demand'].$valueItem['item_id'].'" required>
												</div>
												<div class="col-sm-21">
														<label for="quantity_ordered" class="req">Quantity</label>
														<input class="form-control" type="number"  value="'.$valuePoDemandJuntion['quantity_ordered'].'" name="quantity_ordered['.$valuePoDemand['id_demand'].']['.$valueItem['item_id'].']" id="quantity_ordered'.$valuePoDemand['id_demand'].$valueItem['item_id'].'" min="0" required>
												</div>
												<div class="col-sm-21">
														<label for="unit_price" class="req">Rate</label>
														<input class="form-control" type="number" value="'.$valuePoDemandJuntion['unit_price'].'" name="unit_price['.$valuePoDemand['id_demand'].']['.$valueItem['item_id'].']" id="unit_price'.$valuePoDemand['id_demand'].$valueItem['item_id'].'" min="0" required>
												</div>
												<!-- <div class="col-sm-21">
														<label for="amount" class="req">Amount</label>
														<input class="form-control" type="number" value="'.(($valuePO['po_tax_perc'] / 100) * ($valuePoDemandJuntion['unit_price'] * $valuePoDemandJuntion['quantity_ordered'])) + ($valuePoDemandJuntion['unit_price'] * $valuePoDemandJuntion['quantity_ordered']).'" name="amount['.$valuePoDemand['id_demand'].']['.$valueItem['item_id'].']" id="amount'.$valuePoDemand['id_demand'].$valueItem['item_id'].'" min="0" readonly required>
												</div> -->
												<div class="col-sm-21">
														<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
																<button type="button" class="btn btn-info" style="align-items: center;" onclick="removeItem(this)"><i class="icon-remove"></i></button>									
														</div>
												</div>
											</div>';
									}	
									echo '
								</div>';
							}
							echo '
						</div>

						<div class="col-sm-91"  id="itemContainer">
							<!-- Items will be added here dynamically... -->
						</div>

						<div class="col-sm-91 item">
							<div class="form-sep" style="margin-top: 10px; width: 100%">
								<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
									<button type="button" class="btn btn-info" onclick="addDemand()" style="width: 10%;  float: right"><i class="icon-plus">&nbsp&nbspAdd Item</i></button>
								</div>
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