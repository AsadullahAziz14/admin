<?php
if(LMS_VIEW == 'add' && !isset($_GET['id'])) { 
	echo '
	<div class="row">
		<div class="modal-dialog" style="width:95%;">
			<form class="form-horizontal" action="inventory-purchase_order.php" method="POST" enctype="multipart/form-data" autocomplete="off">
				<div class="modal-content">
					<div class="modal-header"> 
						<h4 class="modal-title" style="font-weight:700;">Add PO</h4>
					</div>

					<div class="modal-body">
						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="id_vendor" class="req"><b>Vendor</b></label>
								<select name="id_vendor" class="form-control" id="id_vendor" required>
									<option value="">Select Vendor</option>';
									$queryVendor = $dblms->querylms("SELECT vendor_id, vendor_name 
																		FROM " .SMS_VENDORS);
									while($valueVendor = mysqli_fetch_array($queryVendor)) {
										echo '<option value="'.$valueVendor['vendor_id'].'">'.$valueVendor['vendor_name'].'</option>';
									}
									echo '
								</select>
							</div>
						</div>

						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="date_ordered" class="req"> Order Date </label>
								<input class="form-control" type="date" name="date_ordered" id="date_ordered" required>
							</div>
						</div>

						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="po_delivery_date" class="req">Delivery Date</label>
								<input class="form-control" type="date" name="po_delivery_date" id="po_delivery_date" required>
							</div>
						</div>

						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="po_delivery_address" class="req"><b>Delivery Adress</b></label>
								<select name="po_delivery_address" class="form-control" id="po_delivery_address" required>
									<option value="">Select Address</option>';
									$queryStores = $dblms->querylms("SELECT l.location_id, l.location_address
																	From ".SMS_LOCATIONS." l 
																");
									while($valueStore = mysqli_fetch_array($queryStores)) {
										echo '<option value="'.$valueStore['location_id'].'">'.$valueStore['location_address'].'</option>';
									}
									echo '
								</select>
							</div>
						</div>

						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="po_tax_perc" class="req">Tax %</label>
								<input class="form-control" type="text" name="po_tax_perc" id="po_tax_perc" required>
							</div>
						</div>

						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="po_payment_terms" class="req"><b>Payment Terms</b></label>
								<select id="po_payment_terms" class="form-control" name="po_payment_terms" required>
									<option value="">Select Payment Terms</option>';
									foreach (PAYMENT_TERMS as $key => $pt) {
										if($key === 'cr') {
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
										if($i == 15) {
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
							<label for="po_status" class="req"><b>Status</b></label>
								<select id="po_status" class="form-control" name="po_status" required>
									<option value="">Select Status</option>';
									foreach ($status as $adm_status) {
										echo '<option value="'. $adm_status['id'].'">'.$adm_status['name'].'</option>';
									}
									echo '
								</select>
							</div>
						</div>

						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="po_remarks" class="req">Remarks</label>
								<input class="form-control" type="text" name="po_remarks" id="po_remarks" required>
							</div>
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
						<input class="btn btn-primary" type="submit" value="Add Record" id="submit_po" name="submit_po">
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
		
		var selectedDemands = [];
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
			const demandSelectorContanier = document.createElement("div");
			demandSelectorContanier.className = "col-sm-92";

			const demandSelectorLabel = document.createElement("label");
			demandSelectorLabel.textContent = "Demand";
			demandSelectorLabel.className = "req";
			
			const demandSelector = document.createElement("select");
			demandSelector.className = "form-control";
			demandSelector.name = "id_demand["+i+"]";
			demandSelector.addEventListener("change", function () {
				// Fetch items based on the selected demand
				fetchItems(this.value, itemInputContainer);
			});
			demandSelector.required = true;

			var demandsString = selectedDemands.join(',');

			var xhr = new XMLHttpRequest();
			var method = "GET";
			var url = "include/ajax/getDemands.php?selectedDemands="+(demandsString);
			var asyncronous = true;

			xhr.open(method,url,asyncronous);
			xhr.send();

			xhr.onreadystatechange = function() {
				if(xhr.readyState === 4 && xhr.status === 200) {
					const options = xhr.responseText;
					demandSelector.innerHTML = options;
				}
			}

			demandSelectorContanier.appendChild(demandSelectorLabel);
			demandSelectorContanier.appendChild(demandSelector);
			container.appendChild(demandSelectorContanier);

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

?>