<?php
if (!LMS_VIEW && isset($_GET['id'])) {
   $queryDemands = $dblms->querylms("SELECT demand_type, id_department, demand_status
   										FROM ".SMS_DEMAND." 
										WHERE demand_id =  ".cleanvars($_GET['id'])." ");
   $valueDemands = mysqli_fetch_array($queryDemands);
   echo '
		<div class="row">
			<div class="modal-dialog" style="width:95%;">
				<form class="form-horizontal" method="post" enctype="multipart/form-data">
					<input type="hidden" name="demand_id" value="'.$_GET['id'].'">
					<div class="modal-content">
						<div class="modal-header"> 
							<h4 class="modal-title" style="font-weight:700;">Edit Demand</h4>
						</div>

						<div class="modal-body">
							<input class="form-control deleted_item_ids" type="hidden" name="deleted_item_ids" id="deleted_item_ids">
							<div class="col-sm-61">
								<div style="margin-top:5px;">
									<label for="demand_type" class="req"><b>Demand Type</b></label>
									<select id="demand_type" class="form-control" name="demand_type" required>
										<option value="">Select Type</option>';
										foreach (DEMAND_TYPES as $key => $dt) {
											if($key == $valueDemands['demand_type']) {
												echo '<option value="'.$key.'" selected>'.$dt.'</option>';
											} else {
												echo '<option value="'.$key.'">'.$dt.'</option>';
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
																		FROM ".DEPTS);
										while($valueDepartments = mysqli_fetch_array($queryDepartments)) {
											if($valueDepartments['dept_id'] == $valueDemands['id_department']) {
												echo '<option value="'.$valueDepartments['dept_id'].'" selected>'.$valueDepartments['dept_name'].'</option>';
											} else {
												echo '<option value="'.$valueDepartments['dept_id'].'">'.$valueDepartments['dept_name'].'</option>';
											}
										}
										echo '
									</select>
								</div>
							</div>';
							$queryDemandItem = $dblms->querylms("SELECT distinct id_item, sum(quantity_demanded) as quantity_demanded, item_due_date 
																	FROM ".SMS_DEMAND_ITEM_JUNCTION."
																	WHERE id_demand =  ".cleanvars($_GET['id'])."
																	GROUP BY id_item
																");
							$i = 0;
							while($valueDemandItem = mysqli_fetch_array($queryDemandItem)) {
								$i++;
								echo '
								<div class="col-sm-91 item">
									<div class="form-sep" style="margin-top: 10px; width: 100%; border: 1px solid rgb(231, 231, 231);">
										<div class="col-sm-61">
											<label for="" class="req"><b>Item</b></label>
											<select class="form-control" name="item['.($i).'][u]" required>
												<option value="">Select Item</option>';
												$queryItems = $dblms->querylms("SELECT item_id,item_code,item_title 
																				FROM ".SMS_ITEM."
																				Where item_type = 1");
												while($valueItems = mysqli_fetch_array($queryItems)) {
													if($valueDemandItem['id_item'] == $valueItems['item_id']) {
														echo '<option value="'.$valueDemandItem['id_item'].'" selected>'.$valueItems['item_code'].'-'.$valueItems['item_title'].'</option>';
													} else {
														echo '<option value="'.$valueDemandItem['id_item'].'">'.$valueItems['item_code'].'-'.$valueItems['item_title'].'</option>';
													}
												}
												echo '
											</select>
										</div>
										<div class="col-sm-31">
											<label for="quantity_demanded" class="req">Quantity</label>
											<input class="form-control" type="number" name="quantity_demanded['.($i).'][u]" id="quantity_demanded" value="'.$valueDemandItem['quantity_demanded'].'" min="0" required>
										</div>
										<div class="col-sm-31">
											<label for="item_due_date" class="req">Due Date</label>
											<input class="form-control" type="date" name="item_due_date['.($i).'][u]" id="item_due_date" value="'.date('Y-m-d', strtotime($valueDemandItem['item_due_date'])).'" required>
										</div>
										<div class="col-sm-21">
											<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
												<button type="button" class="btn btn-info" style="align-items: center;" onclick="removeItem(this,'.$valueDemandItem['id_item'].')"><i class="icon-remove"></i></button>									
											</div>
										</div>
									</div>
								</div>';
							}
							echo '
							<div class="col-sm-91"  id="itemDetailContainer">
									<!-- Items will be added here dynamically... -->
							</div>

							<div class="col-sm-91 item">
								<div class="form-sep" style="margin-top: 10px; width: 100%">
									<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
										<button type="button" class="btn btn-info" style="width: 10%;  float: right" onclick="addItem()"><i class="icon-plus"></i></button>
									</div>
								</div>
							</div>
							<div style="clear:both;"></div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-default" onclick="location.href=\'inventory-demand_stationary.php\'">Close</button>
							<input class="btn btn-primary" type="submit" value="Save Changes" id="update_demand" name="update_demand">
						</div>
					</div>
				</form>
			</div>
		</div>

		<script>
			$(".select2").select2({
				placeholder: "Select Any Option"
			})

			$deleteid = [];
			function removeItem(button, delete_item_id) {
				var parentDiv = button.closest("[class*=item]");
				if (parentDiv) {
					$deleteid.push(delete_item_id);
					document.getElementById("deleted_item_ids").value =  $deleteid;
					parentDiv.parentNode.removeChild(parentDiv);
				}
			}
	
			var i = '.json_encode($i, JSON_NUMERIC_CHECK).'
			function addItem() {
				i = i + 1;
				
				const itemDetailContainer = document.getElementById("itemDetailContainer");
	
				const container = document.createElement("div");
				container.className = "form-sep";
				container.style.marginTop = "10px";
				container.style.width = "100%";
				container.style.border = "1px solid rgb(231, 231, 231)";
	
				itemDetailContainer.appendChild(container);
	
				const itemSelectorContanier = document.createElement("div");
				itemSelectorContanier.className = "col-sm-61";
	
				const itemSelectorLabel = document.createElement("label");
				itemSelectorLabel.className = "req";
				itemSelectorLabel.textContent = "Item Name";
	
				const itemSelector = document.createElement("select");
				itemSelector.className = "form-control";
				itemSelector.name = "item["+i+"][n]";
				itemSelector.required = true;
	
				var xhr = new XMLHttpRequest();
				var method = "GET";
				var url = "include/ajax/getItems.php?stationaryItems";
				var asyncronous = true;
	
				xhr.open(method,url,asyncronous);
				xhr.send();
	
				xhr.onreadystatechange = function() {
					if(xhr.readyState === 4 && xhr.status === 200) {
						const options = xhr.responseText;
						itemSelector.innerHTML = options;
					}
				}
	
				const itemSelectorOptions = document.createElement("option");
				itemSelectorOptions.value = "";
				itemSelectorOptions.textContent = "Select Item";
				
				itemSelector.appendChild(itemSelectorOptions);
	
				itemSelectorContanier.appendChild(itemSelectorLabel);
				itemSelectorContanier.appendChild(itemSelector);
				container.appendChild(itemSelectorContanier);
	
	
				const quantityContanier = document.createElement("div");
				quantityContanier.className = "col-sm-31";
	
				const quantityLabel = document.createElement("label");
				quantityLabel.className = "req";
				quantityLabel.textContent = "Quantity";
	
				const quantityInput = document.createElement("input");
				quantityInput.className = "form-control";
				quantityInput.type = "number";
				quantityInput.name = "quantity_demanded["+i+"][n]";
				quantityInput.id = "quantity_demanded";
				quantityInput.required = true;
	
				quantityContanier.appendChild(quantityLabel);
				quantityContanier.appendChild(quantityInput);
				container.appendChild(quantityContanier);
	
				const datecontainer = document.createElement("div");
				datecontainer.className = "col-sm-31";
	
				const dateLabel = document.createElement("label");
				dateLabel.className = "req";
				dateLabel.textContent = "Due Date";
	
				const dateInput = document.createElement("input");
				dateInput.className = "form-control";
				dateInput.type = "date";
				dateInput.name = "item_due_date["+i+"][n]";
				dateInput.required = true;
	
				datecontainer.appendChild(dateLabel);
				datecontainer.appendChild(dateInput);
				container.appendChild(datecontainer);
				
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
			}
		</script>
		<script src="js/select2/jquery.select2.js"></script>';
}