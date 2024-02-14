<?php
if (!LMS_VIEW && isset($_GET['id'])) {
	$queryReceiving = $dblms->querylms("SELECT receiving_id, receiving_date, receiving_remarks,
												receiving_status, delivery_chalan_num, id_vendor 
										FROM ".SMS_RECEIVING." 
										WHERE receiving_id =  ".cleanvars($_GET['id'])." ");
	$valueReceiving = mysqli_fetch_array($queryReceiving);
	$selectedPOs = [];
	echo '
   	<div class="row">
		<div class="modal-dialog" style="width:95%;">
			<form class="form-horizontal" action="inventory-receiving.php?id='.$_GET['id'].'" method="POST" enctype="multipart/form-data" autocomplete="off">
				<div class="modal-content">
					<div class="modal-header"> 
						<h4 class="modal-title" style="font-weight:700;">Edit Receiving</h4>
					</div>
					<div class="modal-body">
						<div class="col-sm-61">
							<label for="delivery_chalan_num" class="req"><b>DC Num.</b></label>
							<input type="text" class="form-control" value="'.$valueReceiving['delivery_chalan_num'].'" id="delivery_chalan_num" name="delivery_chalan_num" required>
						</div>

						<div class="col-sm-61">
							<label for="id_vendor" class="req"><b>Select Vendor</b></label>
							<select name="id_vendor" class="form-control" id="id_vendor" required>
								<option value="">Select Vendor</option>';
								$queryVendor = $dblms->querylms("SELECT vendor_id, vendor_name 
																	FROM ".SMS_VENDOR);
								while($valueVendor = mysqli_fetch_array($queryVendor)) {
									if($valueVendor['vendor_id'] == $valueReceiving['id_vendor']) {
										echo '<option value="'.$valueVendor['vendor_id'].'" selected>'.$valueVendor['vendor_name'].'</option>';
									} else {
										echo '<option value="'.$valueVendor['vendor_id'].'">'.$valueVendor['vendor_name'].'</option>';
									}
								}
								echo '
							</select>
							
						</div>

						<div class="col-sm-61">
							<label for="receiving_remarks" class="req"><b>Remarks</b></label>
							<input type="text" class="form-control" value="'.$valueReceiving['receiving_remarks'].'" name="receiving_remarks" id="receiving_remarks" required>
						</div>

						<div class="col-sm-61">
							<div style="margin-top:5px;">
							<label for="receiving_status" class="req"><b>Status</b></label>
								<select id="receiving_status" class="form-control" name="receiving_status" required>
									<option value="">Select Status</option>';
									foreach ($status as $poStatus) {
										if($valueReceiving['receiving_status'] == $poStatus['id']) {
											echo '<option value="'. $poStatus['id'].'" selected>'.$poStatus['name'].'</option>';
										} else {
											echo '<option value="'. $poStatus['id'].'">'.$poStatus['name'].'</option>';
										}
									}
									echo '
								</select>
							</div>
						</div>

						<div class="col-sm-91">
							<input class="form-control deleted_item_ids" type="hidden" name="deleted_item_ids" id="deleted_item_ids">
							<input class="form-control deleted_po_ids" type="hidden" name="deleted_po_ids" id="deleted_po_ids">';
							$queryReceivingPO = $dblms->querylms("SELECT DISTINCT id_po 
																FROM ".SMS_RECEIVING_PO_ITEM_JUNCTION." 
																Where id_receiving= ".$valueReceiving['receiving_id']
															);
							$i = 0;
							while($valueReceivingPO = mysqli_fetch_array($queryReceivingPO)) {
								$i = $i + 1;
								echo '
								<div class="form-sep" style="margin-top: 10px; width: 100%; border: 1px solid rgb(231, 231, 231);">
									<div class="col-sm-92">
										<label for="id_po" class="req">PO</label>';
										$queryPO = $dblms->querylms("SELECT po_id, po_code
																		FROM ".SMS_PO."
																		where po_id = ".$valueReceivingPO['id_po']."
																	");
										$valuePO = mysqli_fetch_array($queryPO);
										echo '
										<input type="text" class="form-control" value="'.$valuePO['po_code'].'" name="id_po['.$i.']" id="id_po'.$i.'">
									</div>
									<div class="col-sm-21">
										<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
											<button class="btn btn-info" style="align-items: center;"><i class="icon-remove"></i></button>
										</div>
									</div>';
									$queryReceivingPOJuntion = $dblms->querylms("SELECT distinct a.id_item, sum(a.quantity_received) as quantity_received, b.quantity_ordered
																					FROM ".SMS_RECEIVING_PO_ITEM_JUNCTION." as a , ".SMS_PO_DEMAND_ITEM_JUNCTION." as b
																					Where a.id_receiving = ".$valueReceiving['receiving_id']." AND a.id_po = ".$valueReceivingPO['id_po']." AND a.id_po = b.id_po AND a.id_item = b.id_item
																					GROUP BY a.id_item
																				");
									while($valueReceivingPOJuntion = mysqli_fetch_array($queryReceivingPOJuntion)) {
										$queryItem = $dblms->querylms("SELECT item_id, item_code, item_title
																		FROM ".SMS_ITEM." 
																		where item_id IN (".$valueReceivingPOJuntion['id_item'].")");
										$valueItem = mysqli_fetch_array($queryItem);
										echo '
										<div class="item">
											<div class="col-sm-61">
												<label for="id_item" class="req"><b>Item Name</b></label>
												<input class="form-control" type="text" value="'.$valueItem['item_title'].'" name="id_item[u]['.$valueReceivingPO['id_po'].']['.$valueItem['item_id'].']" id="id_item'.$valueReceivingPO['id_po'].$valueItem['item_id'].'" readonly required>
											</div>
											<div class="col-sm-31">
												<label for="quantity_received" class="req">Quantity Ordered</label>
												<input class="form-control" type="number"  value="'.$valueReceivingPOJuntion['quantity_ordered'].'" name="quantity_received['.$valueReceivingPO['id_po'].']['.$valueItem['item_id'].']" id="quantity_received'.$valueReceivingPO['id_po'].$valueItem['item_id'].'" min="0" readonly required>
											</div>
											<div class="col-sm-31">
												<label for="quantity_received" class="req">Quantity Recieved</label>
												<input class="form-control" type="number"  value="'.$valueReceivingPOJuntion['quantity_received'].'" name="quantity_received['.$valueReceivingPO['id_po'].']['.$valueItem['item_id'].']" id="quantity_received'.$valueReceivingPO['id_po'].$valueItem['item_id'].'" min="0" required>
											</div>
											
											<div class="col-sm-21">
												<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
													<button type="button" class="btn btn-info" style="align-items: center;" onclick="removeItem(this,'.$valueReceivingPO['id_po'].','.$valueItem['item_id'].')"><i class="icon-remove"></i></button>									
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
									<button type="button" class="btn btn-info" onclick="addPo()" style="width: 10%;  float: right"><i class="icon-plus">&nbsp&nbspAdd Item</i></button>
								</div>
							</div>
						</div>
						<div style="clear:both;"></div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" onclick="location.href=\'inventory-receiving.php\'">Close</button>
						<input class="btn btn-primary" type="submit" value="Save changes" id="update_receiving" name="update_receiving">
					</div>
				</div>
				
			</form>
		</div>
	</div>
	
	<script>
		$(".select2").select2({
			placeholder: "Select Any Option"
		})

		$deleteItemId = [];
		$deletePOId = [];
		function removeItem(button,po_id, delete_item_id) {
			var parentDiv = button.closest("[class*=item]");
			if (parentDiv) {
				$deleteItemId.push(delete_item_id);
				$deletePOId.push(po_id);
				document.getElementById("deleted_item_ids").value =  $deleteItemId;
				document.getElementById("deleted_po_ids").value =  $deletePOId;
				parentDiv.parentNode.removeChild(parentDiv);
			}
		}	
		
		var selectedPOs = [];
		function addPo() {
			var i = 0;
			i = i + 1;
			const itemContainer = document.getElementById("itemContainer");

			const container = document.createElement("div");
			container.className = "form-sep";
			container.style.marginTop = "10px";
			container.style.width = "100%";
			container.style.border = "1px solid rgb(231, 231, 231)";

			itemContainer.appendChild(container);

			// PO Selector Start
			const poInputContanier = document.createElement("div");
			poInputContanier.className = "col-sm-70";

			const poInputLabel = document.createElement("label");
			poInputLabel.textContent = "PO";
			poInputLabel.className = "req";
			
			const poInput = document.createElement("input");
			poInput.className = "form-control";
			poInput.name = "id_po["+i+"]";
			poInput.type = Text;
			poInput.required = true;

			poInputContanier.appendChild(poInputLabel);
			poInputContanier.appendChild(poInput);
			container.appendChild(poInputContanier);

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
				fetchItems(poInput.value, itemInputContainer);
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

		function fetchItems(poId, itemInputContainer) {
			selectedPOs.push(poId);
			var xhr = new XMLHttpRequest();
			var method = "GET";
			var url = "include/ajax/getItems.php?selectedPO=" + poId;
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