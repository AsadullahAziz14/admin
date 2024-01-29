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
									if($valueIssuance['issuance_status'] == $issuance_status['id']) {
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
						<div style="clear:both;"></div>


						<div class="col-sm-91">';
							$queryIssuanceRequisition = $dblms->querylms("SELECT DISTINCT id_requisition
																FROM ".SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION." 
																Where id_issuance = ".$valueIssuance['issuance_id']
															);
							$i = 0;
							while($valueIssuanceRequisition = mysqli_fetch_array($queryIssuanceRequisition)) {
								$i = $i + 1;
								echo '
								<div class="form-sep" style="margin-top: 10px; width: 100%; border: 1px solid rgb(231, 231, 231);">
									<div class="col-sm-92">
										<label for="id_requisition" class="req">Requisition</label>';
										$queryRequisition = $dblms->querylms("SELECT requisition_id, requisition_code
																				FROM ".SMS_REQUISITION."
																				Where requisition_id = ".$valueIssuanceRequisition['id_requisition']."
																			");
										$valueRequisition = mysqli_fetch_array($queryRequisition);
										echo '
										<input type="text" class="form-control" value="'.$valueRequisition['requisition_code'].'" name="id_requisition['.$i.']" id="id_requisition'.$i.'">
									</div>
									<div class="col-sm-21">
										<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
											<button class="btn btn-info" style="align-items: center;"><i class="icon-remove"></i></button>
										</div>
									</div>';
									$queryIssuanceRequisitionItem = $dblms->querylms("SELECT id_item, quantity_issued, id_requisition
																						FROM ".SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION."
																						Where id_issuance = ".$valueIssuance['issuance_id']." AND id_requisition = ".$valueIssuanceRequisition['id_requisition']."
																					");
									while($valueIssuanceRequisitionItem = mysqli_fetch_array($queryIssuanceRequisitionItem)) {
										$queryItem = $dblms->querylms("SELECT item_id, item_code, item_title
																		FROM ".SMS_ITEM." 
																		where item_id IN (".$valueIssuanceRequisitionItem['id_item'].")");
										$valueItem = mysqli_fetch_array($queryItem);
										echo '
											<div class="item">
												<div class="col-sm-42">
														<label for="id_item" class="req"><b>Item</b></label>
														<input class="form-control" type="text" value="'.$valueItem['item_title'].'" name="id_item[u]['.$valueIssuanceRequisition['id_requisition'].']['.$valueItem['item_id'].']" id="id_item'.$valueIssuanceRequisition['id_requisition'].$valueItem['item_id'].'" readonly required>
												</div>';
												$queryRequisitionDemandItem = $dblms->querylms("SELECT distinct id_item, sum(quantity_requested) as quantity_requested
																								FROM ".SMS_REQUISITION_DEMAND_ITEM_JUNCTION."
																								Where id_requisition = ".$valueIssuanceRequisitionItem['id_requisition']." AND id_item = ".$valueIssuanceRequisitionItem['id_item']."
																								Group By id_item
																							");
												$valueRequisitionDemandItem = mysqli_fetch_array($queryRequisitionDemandItem);
												echo '
												<div class="col-sm-31">
													<label for="quantity_requested" class="req">Quantity Requested</label>
													<input class="form-control" type="number"  value="'.$valueRequisitionDemandItem['quantity_requested'].'" name="quantity_requested['.$valueIssuanceRequisitionItem['id_requisition'].']['.$valueItem['item_id'].']" id="quantity_requested'.$valueIssuanceRequisitionItem['id_requisition'].$valueItem['item_id'].'" min="0" readonly required>
												</div>
												';
												$queryInventory = $dblms->querylms("SELECT distinct id_item, sum(quantity_added) as quantity_instock
																					FROM ".SMS_INVENTORY_RECEIVING_ITEM_JUNCTION."
																					Where id_item = ".$valueIssuanceRequisitionItem['id_item']."
																				");
												$valueInventory = mysqli_fetch_array($queryInventory);
												echo '
												<div class="col-sm-31">
													<label for="quantity_instock" class="req">Quantity In-Stock</label>
													<input class="form-control" type="number"  value="'.$valueInventory['quantity_instock'].'" name="quantity_instock['.$valueIssuanceRequisitionItem['id_requisition'].']['.$valueItem['item_id'].']" id="quantity_instock'.$valueIssuanceRequisitionItem['id_requisition'].$valueItem['item_id'].'" min="0" readonly required>
												</div>
												<div class="col-sm-31">
													<label for="quantity_issued" class="req">Quantity Issued</label>
													<input class="form-control" type="number"  value="'.$valueIssuanceRequisitionItem['quantity_issued'].'" name="quantity_issued['.$valueIssuanceRequisitionItem['id_requisition'].']['.$valueItem['item_id'].']" id="quantity_issued'.$valueIssuanceRequisitionItem['id_requisition'].$valueItem['item_id'].'" min="0" required>
												</div>
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
									<button type="button" class="btn btn-info" onclick="addRequisition()" style="width: 10%;  float: right"><i class="icon-plus">&nbsp&nbspAdd Item</i></button>
								</div>
							</div>
						</div>
						<div style="clear:both;"></div>
					</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" onclick="location.href=\'inventory-issuance.php\'" >Close</button>
					<input class="btn btn-primary" type="submit" value="Save Changes" id="update_issuance" name="update_issuance">
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


		function removeItem(button) {
			var parentDiv = button.closest("[class*=item]");
			if (parentDiv) {
				parentDiv.parentNode.removeChild(parentDiv);
			}
		}	
		
		var selectedRequisitions = [];
		function addRequisition() {
			var i = 0;
			i = i + 1;
			const itemContainer = document.getElementById("itemContainer");

			const container = document.createElement("div");
			container.className = "form-sep";
			container.style.marginTop = "10px";
			container.style.width = "100%";
			container.style.border = "1px solid rgb(231, 231, 231)";

			itemContainer.appendChild(container);

			// Requisition Selector Start
			const requisitionInputContanier = document.createElement("div");
			requisitionInputContanier.className = "col-sm-70";

			const requisitionInputLabel = document.createElement("label");
			requisitionInputLabel.textContent = "Requisition";
			requisitionInputLabel.className = "req";
			
			const requisitionInput = document.createElement("input");
			requisitionInput.className = "form-control";
			requisitionInput.name = "id_requisition["+i+"]";
			requisitionInput.type = Text;
			requisitionInput.required = true;

			requisitionInputContanier.appendChild(requisitionInputLabel);
			requisitionInputContanier.appendChild(requisitionInput);
			container.appendChild(requisitionInputContanier);

			// Retrieve Button Start
			const retrieveButtonContainer = document.createElement("div");
			retrieveButtonContainer.className = "col-sm-31";
			const retrieveButtonDiv = document.createElement("div");
			retrieveButtonDiv.style = "display: flex; justify-content: left; align-items: left; margin: 15px;"

			const retrieveButton = document.createElement("button");
			retrieveButton.className = "btn btn-info";
			retrieveButton.style.alignItems = "center";
			retrieveButton.innerHTML = "Retrieve";

			
			retrieveButton.addEventListener("click", function (event) {
				event.preventDefault();  // Prevent the default form submission behavior
				fetchItems(requisitionInput.value, itemInputContainer);
			});

			retrieveButtonDiv.appendChild(retrieveButton);
			retrieveButtonContainer.appendChild(retrieveButtonDiv);
			container.appendChild(retrieveButtonContainer);

			// Remove Button Start
			const removeButtonContainer = document.createElement("div");
			removeButtonContainer.className = "col-sm-21";

			const removeButtonDiv = document.createElement("div");
			removeButtonDiv.style = "display: flex; justify-content: center; align-items: center; margin: 15px;"

			const removeButton = document.createElement("button");
			removeButton.className = "btn btn-info";
			removeButton.style.alignItems = "center";
			removeButton.onclick = "removeItem(this)";
			removeButton.innerHTML = "<i class=\"icon-remove\"></i>";

			removeButton.addEventListener("click", function () {
				container.remove();
			});

			removeButtonDiv.appendChild(removeButton);
			removeButtonContainer.appendChild(removeButtonDiv);
			container.appendChild(removeButtonContainer);

			// Item Input Start
			const itemInputContainer = document.createElement("div");
			itemInputContainer.className = "col-sm-91";
			
			container.appendChild(itemInputContainer);
		}

		function fetchItems(requisitionId, itemInputContainer) {
			selectedRequisitions.push(requisitionId);
			var xhr = new XMLHttpRequest();
			var method = "GET";
			var url = "include/ajax/getItems.php?selectedRequisition=" + requisitionId;
			var asyncronous = true;

			xhr.open(method, url, asyncronous);
			xhr.send();

			xhr.onreadystatechange = function () {
				if (xhr.readyState === 4 && xhr.status === 200) {
					const options = xhr.responseText;
					itemInputContainer.innerHTML = options;
					// itemInputContainer.appendChild(options)
				}
			};
		}
	</script>
	<script src="js/select2/jquery.select2.js"></script>';
}