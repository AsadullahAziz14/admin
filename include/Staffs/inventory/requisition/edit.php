<?php
if (!LMS_VIEW && isset($_GET['id'])) {
	$queryRequisition = $dblms->querylms("SELECT requisition_id, requisition_status, requisition_remarks, 
													requisition_purpose, requisition_type, id_department, id_location  
											FROM ".SMS_REQUISITION." 
											WHERE requisition_id =  ".cleanvars($_GET['id'])." ");
	$valueRequisition = mysqli_fetch_array($queryRequisition);
	$selectedDemandRequisition = [];
	echo '
   	<div class="row">
		<div class="modal-dialog" style="width:95%;">
			<form class="form-horizontal" action="inventory-requisition.php?id='.$_GET['id'].'" method="POST" enctype="multipart/form-data" autocomplete="off">
				<div class="modal-content">
					<div class="modal-header"> 
						<h4 class="modal-title" style="font-weight:700;">Edit Requisition</h4>
					</div>
					<div class="modal-body">
						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="requisition_type" class="req"><b>Requistion Type</b></label>
								<select name="requisition_type" class="form-control" id="requisition_type" required>
									<option value="">Select Type</option>';
									foreach (REQUISITION_TYPES as $id => $rt) {
										if($id == $valueRequisition['requisition_type']) {
											echo '<option value="'.$id.'" selected>'.$rt.'</option>';
										} else {
											echo '<option value="'.$id.'">'.$rt.'</option>';
										}
									}
									echo '
								</select>
							</div>
						</div>
						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="id_department" class="req"><b>Department</b></label>
								<select name="id_department" class="form-control" id="id_department" required>
									<option value="">Select Department</option>';
									$queryDepartments = $dblms->querylms("SELECT dept_id, dept_name 
																			FROM ".DEPTS."
																			Where dept_id = ".$valueRequisition['id_department']."
																		");
									while($valueDepartments = mysqli_fetch_array($queryDepartments)) {
										if($valueDepartments['dept_id'] == $valueRequisition['id_department']){
											echo '<option value="'.$valueDepartments['dept_id'].'" selected>'.$valueDepartments['dept_name'].'</option>';
										} else {
											echo '<option value="'.$valueDepartments['dept_id'].'">'.$valueDepartments['dept_name'].'</option>';
										}
									}
									echo '
								</select>
							</div>
						</div>
						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="id_location" class="req"><b>Store</b></label>
								<select name="id_location" class="form-control" id="id_location" required>
									<option value="">Select Address</option>';
										$queryLocation = $dblms->querylms("SELECT l.location_id, l.location_address
																			From ".SMS_LOCATION." l 
																			where l.location_id = ".$valueRequisition['id_location']."
																		");
										while($valueLocation = mysqli_fetch_array($queryLocation)) {
											if($valueLocation['location_id'] == $valueRequisition['id_location']){
												echo '<option value="'.$valueLocation['location_id'].'" selected>'.$valueLocation['location_address'].'</option>';
											} else {
												echo '<option value="'.$valueLocation['location_id'].'">'.$valueLocation['location_address'].'</option>';
											}
										}
									echo '
								</select>
							</div>
						</div>

						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="requisition_purpose" class="req">Requisition Purpose</label>
								<input class="form-control" type="text" name="requisition_purpose" id="requisition_purpose" value="'.$valueRequisition['requisition_purpose'].'" required>
							</div>
						</div>

						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="requisition_remarks" class="req">Remarks</label>
								<input class="form-control" type="text" name="requisition_remarks" id="requisition_remarks" value="'.$valueRequisition['requisition_remarks'].'" required>
							</div>
						</div>
						
						<div class="col-sm-91">
							<input class="form-control deleted_item_ids" type="hidden" name="deleted_item_ids" id="deleted_item_ids">
							<input class="form-control deleted_demand_ids" type="hidden" name="deleted_demand_ids" id="deleted_demand_ids">
							<input class="form-control deleted_demand" type="hidden" name="deleted_demand" id="deleted_demand">';';
							$queryRequisitionDemand = $dblms->querylms("SELECT DISTINCT id_demand
																FROM ".SMS_REQUISITION_DEMAND_ITEM_JUNCTION." 
																Where id_requisition = ".$valueRequisition['requisition_id']
															);
							$i = 0;
							while($valueRequisitionDemand = mysqli_fetch_array($queryRequisitionDemand)) {
								$i = $i + 1;
								echo '
								<div class="form-sep" style="margin-top: 10px; width: 100%; border: 1px solid rgb(231, 231, 231);">
									<div class="col-sm-92">
										<label for="id_demand" class="req">Demand</label>';									
										$queryDemand = $dblms->querylms("SELECT demand_id, demand_code
																			FROM ".SMS_DEMAND."
																			Where demand_id = ".$valueRequisitionDemand['id_demand']."
																		");
										$valueDemand = mysqli_fetch_array($queryDemand);
										echo '
										<input type="text" class="form-control" value="'.$valueDemand['demand_code'].'" name="id_demand['.$i.']" id="id_demand'.$i.'">										
									</div>
									<div class="col-sm-21">
										<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
											<button type="button" class="btn btn-info" style="align-items: center;" onclick="removeDemand(this,'.$valueRequisitionDemand['id_demand'].')"><i class="icon-remove"></i></button>
										</div>
									</div>';
									$queryRequisitionDemandJuntion = $dblms->querylms("SELECT distinct id_item, sum(quantity_requested) as quantity_requested 
																						FROM ".SMS_REQUISITION_DEMAND_ITEM_JUNCTION."
																						Where id_requisition = ".$valueRequisition['requisition_id']." AND id_demand = ".$valueRequisitionDemand['id_demand']."
																						GROUP BY id_item
																					");
									while($valueRequisitionDemandJuntion = mysqli_fetch_array($queryRequisitionDemandJuntion)) {
										$queryItem = $dblms->querylms("SELECT item_id, item_code, item_title
																		FROM ".SMS_ITEM." 
																		where item_id IN (".$valueRequisitionDemandJuntion['id_item'].")");
										$valueItem = mysqli_fetch_array($queryItem);
										echo '
										<div class="item">
											<div class="col-sm-61">
													<label for="id_item" class="req"><b>Item</b></label>
													<input class="form-control" type="text" value="'.$valueItem['item_title'].'" name="id_item[u]['.$valueRequisitionDemand['id_demand'].']['.$valueItem['item_id'].']" id="id_item'.$valueRequisitionDemand['id_demand'].$valueItem['item_id'].'" readonly required>
											</div>
											';
											$queryDemad = $dblms->querylms("SELECT id_item, sum(quantity_demanded) as quantity_demanded
																				FROM ".SMS_DEMAND_ITEM_JUNCTION." 
																				where id_item =  ".$valueRequisitionDemandJuntion['id_item']." AND id_demand = ".$valueRequisitionDemand['id_demand']."
																				Group by id_item
																			");
											$valueDemand = mysqli_fetch_array($queryDemad);
											echo '
											<div class="col-sm-31">
												<label for="quantity_demanded" class="req">Demand Quantity</label>
												<input class="form-control" type="number" value="'.$valueDemand['quantity_demanded'].'" name="quantity_demanded['.$valueRequisitionDemand['id_demand'].']['.$valueItem['item_id'].']" id="quantity_demanded'.$valueRequisitionDemand['id_demand'].$valueItem['item_id'].'" min="0" readonly required>
											</div>
											<div class="col-sm-31">
													<label for="quantity_requested" class="req">Quantity Requested</label>
													<input class="form-control" type="number"  value="'.$valueRequisitionDemandJuntion['quantity_requested'].'" name="quantity_requested['.$valueRequisitionDemand['id_demand'].']['.$valueItem['item_id'].']" id="quantity_requested'.$valueRequisitionDemand['id_demand'].$valueItem['item_id'].'" min="0" required>
											</div>
											<div class="col-sm-21">
												<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
													<button type="button" class="btn btn-info" style="align-items: center;" onclick="removeItem(this,'.$valueRequisitionDemand['id_demand'].','.$valueItem['item_id'].')"><i class="icon-remove"></i></button>									
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
						<button type="button" class="btn btn-default" onclick="location.href=\'inventory-requisition.php\'">Close</button>
						<input class="btn btn-primary" type="submit" value="Save changes" id="update_requisition" name="update_requisition">
					</div>
				</div>
				
			</form>
		</div>
	</div>
	
	<script>
	$(".select2").select2({
		placeholder: "Select Any Option"
	})

	deleteDemand = [];
	function removeDemand(button,demand_id) {
		console.log(demand_id);
		deleteDemand.push(demand_id);
		document.getElementById("deleted_demand").value =  deleteDemand;
		document.getElementById(demand_id).remove();
	}

	$deleteItemId = [];
	$deleteDemandId = [];
	function removeItem(button,demand_id, delete_item_id) {
		var parentDiv = button.closest("[class*=item]");
		if (parentDiv) {
			$deleteItemId.push(delete_item_id);
			$deleteDemandId.push(demand_id);
			document.getElementById("deleted_item_ids").value =  $deleteItemId;
			document.getElementById("deleted_demand_ids").value =  $deleteDemandId;
			parentDiv.parentNode.removeChild(parentDiv);
		}
	}
	
	var selectedDemandRequisition = '.json_encode($selectedDemandRequisition).'
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

	function fetchItems(demandId, itemInputContainer) {
		selectedDemandRequisition.push(demandId);
		var xhr = new XMLHttpRequest();
		var method = "GET";
		var url = "include/ajax/getItems.php?selectedDemandRequisition=" + demandId;
		var asyncronous = true;

		xhr.open(method, url, asyncronous);
		xhr.send();

		xhr.onreadystatechange = function () {
			if (xhr.readyState === 4 && xhr.status === 200) {
				const options = xhr.responseText;
				itemInputContainer.innerHTML = options;
			}
		};
	}

	</script>

	<script src="js/select2/jquery.select2.js"></script>';
}