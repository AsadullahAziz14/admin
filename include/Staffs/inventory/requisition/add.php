<?php
if(LMS_VIEW == 'add' && !isset($_GET['id'])) { 
	echo '
	<div class="row">
		<div class="modal-dialog" style="width:95%;">
			<form class="form-horizontal" action="inventory-requisition.php" method="POST" enctype="multipart/form-data" autocomplete="off">
				<div class="modal-content">
					<div class="modal-header"> 
						<h4 class="modal-title" style="font-weight:700;">Add Requisition</h4>
					</div>

					<div class="modal-body">
						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="requisition_type" class="req"><b>Requistion Type</b></label>
								<select name="requisition_type" class="form-control" id="requisition_type" required>
									<option value="">Select Type</option>
									<option value="1">Tengible</option>
									<option value="2">Non-Tengible</option>
								</select>
							</div>
						</div>
						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="id_department" class="req"><b>Department</b></label>
								<select name="id_department" class="form-control" id="id_department" required>
									<option value="">Select Department</option>';
									$queryDepartments = $dblms->querylms("SELECT dept_id, dept_name 
															FROM ".DEPARTMENTS);
									while($valueDepartments = mysqli_fetch_array($queryDepartments)) {
										echo '<option value="'.$valueDepartments['dept_id'].'">'.$valueDepartments['dept_name'].'</option>';
									}
									echo '
								</select>
							</div>
						</div>
						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="id_location" class="req"><b>Store</b></label>
								<select name="id_location" class="form-control" id="id_location" required>
									<option value="">Select Store</option>';
									$queryStores = $dblms->querylms("SELECT l.location_id, l.location_address
																	From ".SMS_LOCATION." l 
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
							<label for="requistion_status" class="req"><b>Status</b></label>
								<select id="requistion_status" class="form-control" name="requistion_status" required>
									<option value="">Select Status</option>';
									foreach ($status as $requisitionStatus) {
										echo '<option value="'. $requisitionStatus['id'].'">'.$requisitionStatus['name'].'</option>';
									}
									echo '
								</select>
							</div>
						</div>
						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="requisition_purpose" class="req"><b>Requistion Purpose</b></label>
								<input class="form-control" type="text" name="requisition_purpose" id="requisition_purpose" required>
							</div>
						</div>
						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="requisition_remarks" class="req">Remarks</label>
								<input class="form-control" type="text" name="requisition_remarks" id="requisition_remarks" required>
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
						<button type="button" class="btn btn-default" onclick="location.href=\'inventory-requisition.php\'">Close</button>
						<input class="btn btn-primary" type="submit" value="Add Record" id="submit_requisition" name="submit_requisition">
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
			demandSelector.required = true;

			var demandsString = selectedDemands.join(',');
			var xhr = new XMLHttpRequest();
			var method = "GET";
			var url = "include/ajax/getDemandsPO.php?selectedDemands="+(demandsString);
			var asyncronous = true;

			xhr.open(method,url,asyncronous);
			xhr.send();

			xhr.onreadystatechange = function() {
				if(xhr.readyState === 4 && xhr.status === 200) {
					const options = xhr.responseText;
					demandSelector.innerHTML = options;
				}
			}

			demandSelector.addEventListener("change", function () {
				// Fetch items based on the selected demand
				fetchItems(this.value, itemInputContainer);
			});

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