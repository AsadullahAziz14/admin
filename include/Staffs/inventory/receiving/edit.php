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

						<div class="col-sm-91">';
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
										<label for="id_po" class="req">PO</label>
										<select class="form-control" name="id_po['.$i.']" id="id_po'.$i.'">
											<option value=""></option>';
											$queryPO = $dblms->querylms("SELECT po_id, po_code
																				FROM ".SMS_PO);
											while($valuePO = mysqli_fetch_array($queryPO)) {
												if($valuePO['po_id'] == $valueReceivingPO['id_po']) {
													$selectedPOs[] = $valuePO['po_id'];
													echo '<option value="'.$valuePO['po_id'].'" selected>'.$valuePO['po_code'].'</option>';
												} else {
													echo '<option value="'.$valuePO['po_id'].'">'.$valuePO['po_code'].'</option>';
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
									$queryReceivingPOJuntion = $dblms->querylms("SELECT a.id_item, a.quantity_received, b.quantity_ordered
																					FROM ".SMS_RECEIVING_PO_ITEM_JUNCTION." as a , ".SMS_PO_DEMAND_ITEM_JUNCTION." as b
																					Where a.id_receiving = ".$valueReceiving['receiving_id']." AND a.id_po = ".$valueReceivingPO['id_po']." AND a.id_po = b.id_po AND a.id_item = b.id_item
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
		function removeItem(button) {
			var parentDiv = button.closest("[class*=item]");
			if (parentDiv) {
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
			const poSelectorContanier = document.createElement("div");
			poSelectorContanier.className = "col-sm-92";

			const poSelectorLabel = document.createElement("label");
			poSelectorLabel.textContent = "PO";
			poSelectorLabel.className = "req";
			
			const poSelector = document.createElement("select");
			poSelector.className = "form-control";
			poSelector.name = "id_po["+i+"]";
			poSelector.addEventListener("change", function () {
				// Fetch items based on the selected PO
				fetchItems(this.value, itemInputContainer);
			});
			poSelector.required = true;

			var poString = selectedPOs.join(',');

			var xhr = new XMLHttpRequest();
			var method = "GET";
			var url = "include/ajax/getDemandsPO.php?selectedPOs="+(poString);
			var asyncronous = true;

			xhr.open(method,url,asyncronous);
			xhr.send();

			xhr.onreadystatechange = function() {
				if(xhr.readyState === 4 && xhr.status === 200) {
					const options = xhr.responseText;
					poSelector.innerHTML = options;
				}
			}

			poSelectorContanier.appendChild(poSelectorLabel);
			poSelectorContanier.appendChild(poSelector);
			container.appendChild(poSelectorContanier);

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

			// Item Selector Start
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