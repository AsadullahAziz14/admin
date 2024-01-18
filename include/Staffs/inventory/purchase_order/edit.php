<?php
if (!LMS_VIEW && isset($_GET['id'])) {
	$queryPO = $dblms->querylms("SELECT po_id, po_status, po_remarks, po_tax_perc, po_payment_terms,
										po_credit_terms, po_lead_time, po_delivery_date, 
										po_delivery_address, date_ordered, id_vendor 
									FROM ".SMS_PO." WHERE po_id =  ".cleanvars($_GET['id'])." ");
	$valuePO = mysqli_fetch_array($queryPO);
	$selectedDemands = [];
	echo '
   	<div class="row">
		<div class="modal-dialog" style="width:95%;">
			<form class="form-horizontal" action="inventory-purchase_order.php?id='.$_GET['id'].'" method="POST" enctype="multipart/form-data" autocomplete="off">
				<div class="modal-content">
					<div class="modal-header"> 
						<h4 class="modal-title" style="font-weight:700;">Edit PO</h4>
					</div>

					<div class="modal-body">
						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="id_vendor" class="req"><b>Vendor</b></label>
								<select name="id_vendor" class="form-control" id="id_vendor" required>
									<option value="">Select Vendor</option>';
									$queryVendor = $dblms->querylms("SELECT vendor_id, vendor_name 
																		FROM ".SMS_VENDOR);
									while($valueVendor = mysqli_fetch_array($queryVendor)) {
										if($valueVendor['vendor_id'] == $valuePO['id_vendor']) {
											echo '<option value="'.$valueVendor['vendor_id'].'" selected>'.$valueVendor['vendor_name'].'</option>';
										} else {
											echo '<option value="'.$valueVendor['vendor_id'].'">'.$valueVendor['vendor_name'].'</option>';
										}
									}
									echo '
								</select>
							</div>
						</div>

						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="po_delivery_date" class="req">Delivery Date</label>
								<input class="form-control" type="date" name="po_delivery_date" id="po_delivery_date" value="'.date('Y-m-d', strtotime($valuePO['po_delivery_date'])).'" required>
							</div>
						</div>

						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="po_delivery_address" class="req"><b>Delivery Adress</b></label>
								<select name="po_delivery_address" class="form-control" id="po_delivery_address" required>
									<option value="">Select Address</option>';
										$queryLocation = $dblms->querylms("SELECT l.location_id, l.location_address
																		From ".SMS_LOCATION." l ");
										while($valueLocation = mysqli_fetch_array($queryLocation)) {
											if($valueLocation['location_id'] == $valuePO['po_delivery_address']){
												echo '<option value="'.$valueLocation['location_id'].'" selected>'.$valueLocation['location_address'].'</option>';
											} else {
												echo '<option value="'.$valueLocation['location_id'].'">'.$valueLocation['location_address'].'</option>';
											}
										}
									echo '
								</select>
							</div>
						</div>

						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="po_tax_perc" class="req">Tax %</label>
								<input class="form-control" type="text" name="po_tax_perc" id="po_tax_perc" value="'.$valuePO['po_tax_perc'].'" required>
							</div>
						</div>

						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="po_payment_terms" class="req"><b>Payment Terms</b></label>
								<select id="po_payment_terms" class="form-control" name="po_payment_terms" required>
									<option value="">Select Payment Terms</option>';
									foreach (PAYMENT_TERMS as $key => $pt) {
										if($key == $valuePO['po_payment_terms']) {
											echo '<option value="'.$key.'" selected>'.$pt.'</option>';
										} else {
											echo '<option value="'.$key.'">'.$pt.'</option>';
										}
									}
									echo '
								</select>
							</div>
						</div>

						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="po_lead_time" class="req"><b>Lead Time</b></label>
								<select id="po_lead_time" class="form-control" name="po_lead_time" required>
									<option value="">Select Lead Time</option>';
									for ($i=1; $i < 30; $i++) { 
										if($i == $valuePO['po_lead_time']) {
											echo '<option value="'.$i.'" selected>'.$i.' Days After PO Placed.</option>';
										} else {
											echo '<option value="'.$i.'">'.$i.' Days After PO Placed.</option>';
										}
									}
									echo '
								</select>
							</div>
						</div>

						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="date_ordered" class="req"> Ordered Date </label>
								<input class="form-control" type="date" name="date_ordered" id="date_ordered" value="'.date('Y-m-d', strtotime($valuePO['date_ordered'])).'" required>
							</div>
						</div>

						<div class="col-sm-61">
							<div style="margin-top:5px;">
							<label for="po_status" class="req"><b>Status</b></label>
								<select id="po_status" class="form-control" name="po_status" required>
									<option value="">Select Status</option>';
									foreach ($status as $poStatus) {
										if($valuePO['po_status'] == $poStatus['id']) {
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
							<div style="margin-top:5px;">
								<label for="po_remarks" class="req">Remarks</label>
								<input class="form-control" type="text" name="po_remarks" id="po_remarks" value="'.$valuePO['po_remarks'].'" required>
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
										<label for="id_demand" class="req">Demand</label>';									
										$queryDemand = $dblms->querylms("SELECT demand_id, demand_code
																			FROM ".SMS_DEMAND."
																			Where demand_id = ".$valuePoDemand['id_demand']."
																		");
										$valueDemand = mysqli_fetch_array($queryDemand);
										echo '
										<input type="text" class="form-control" value="'.$valueDemand['demand_code'].'" name="id_demand['.$i.']" id="id_demand'.$i.'">
									</div>
									<div class="col-sm-21">
										<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
											<button class="btn btn-info" style="align-items: center;"><i class="icon-remove"></i></button>
										</div>
									</div>';
									$queryPoDemandItem = $dblms->querylms("SELECT distinct id_item, sum(quantity_ordered) as quantity_ordered, unit_price 
																				FROM ".SMS_PO_DEMAND_ITEM_JUNCTION."
																				Where id_po = ".$valuePO['po_id']." AND id_demand = ".$valuePoDemand['id_demand']."
																				GROUP BY id_item
																				");
									while($valuePoDemandItem = mysqli_fetch_array($queryPoDemandItem)) {
										$queryItem = $dblms->querylms("SELECT item_id, item_code, item_title
																		FROM ".SMS_ITEM." 
																		where item_id IN (".$valuePoDemandItem['id_item'].")");
										$valueItem = mysqli_fetch_array($queryItem);
										echo '
											<div class="item">
												<div class="col-sm-61">
														<label for="id_item" class="req"><b>Item</b></label>
														<input class="form-control" type="text" value="'.$valueItem['item_title'].'" name="id_item[u]['.$valuePoDemand['id_demand'].']['.$valueItem['item_id'].']" id="id_item'.$valuePoDemand['id_demand'].$valueItem['item_id'].'" readonly required>
												</div>
												<div class="col-sm-31">
														<label for="quantity_ordered" class="req">Quantity</label>
														<input class="form-control" type="number"  value="'.$valuePoDemandItem['quantity_ordered'].'" name="quantity_ordered['.$valuePoDemand['id_demand'].']['.$valueItem['item_id'].']" id="quantity_ordered'.$valuePoDemand['id_demand'].$valueItem['item_id'].'" min="0" required>
												</div>
												<div class="col-sm-31">
														<label for="unit_price" class="req">Rate</label>
														<input class="form-control" type="number" value="'.$valuePoDemandItem['unit_price'].'" name="unit_price['.$valuePoDemand['id_demand'].']['.$valueItem['item_id'].']" id="unit_price'.$valuePoDemand['id_demand'].$valueItem['item_id'].'" min="0" required>
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
									<button type="button" class="btn btn-info" onclick="addDemand()" style="width: 10%;  float: right"><i class="icon-plus">&nbsp&nbspAdd Item</i></button>
								</div>
							</div>
						</div>
						
						<div style="clear:both;"></div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" onclick="location.href=\'inventory-purchase_order.php\'">Close</button>
						<input class="btn btn-primary" type="submit" value="Save changes" id="update_po" name="update_po">
					</div>
				</div>
				
			</form>
		</div>
	</div>
	
	<script>
	$(".select2").select2({
		placeholder: "Select Any Option"
	})

	function removeItem(button){
		var parentDiv = button.closest("[class*=item]");
		if (parentDiv) {
			parentDiv.parentNode.removeChild(parentDiv);
		}
	}
	
	var selectedDemands = '.json_encode($selectedDemands).'
	function addDemand() {
		var i = 0;
		i = i + 1;
		const itemContainer = document.getElementById("itemContainer");

		const container = document.createElement("div");
		container.className = "form-sep";
		container.style.marginTop = "10px";
		container.style.width = "100%";
		container.style.border = "1px solid rgb(231, 231, 231)";

		itemContainer.appendChild(container);

		// Demand Selector Start
		const demandInputContanier = document.createElement("div");
		demandInputContanier.className = "col-sm-70";

		const demandInputLabel = document.createElement("label");
		demandInputLabel.textContent = "Demand";
		demandInputLabel.className = "req";
		
		const demandInput = document.createElement("input");
		demandInput.className = "form-control";
		demandInput.name = "id_demand["+i+"]";
		demandInput.type = Text;
		demandInput.required = true;

		demandInputContanier.appendChild(demandInputLabel);
		demandInputContanier.appendChild(demandInput);
		container.appendChild(demandInputContanier);

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
			fetchItems(demandInput.value, itemInputContainer);
		});

		retrieveButtonDiv.appendChild(retrieveButton);
		retrieveButtonContainer.appendChild(retrieveButtonDiv);
		container.appendChild(retrieveButtonContainer);
		
		
		// Remove button Start
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

	function fetchItems(demandId, itemInputContainer) {
		selectedDemands.push(demandId);
		var xhr = new XMLHttpRequest();
		var method = "GET";
		var url = "include/ajax/getItems.php?selectedDemand=" + demandId;
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