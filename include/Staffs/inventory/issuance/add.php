<?php

if(LMS_VIEW == 'add' && !isset($_GET['id'])) { 
	echo '
	<div class="row">
		<div class="modal-dialog" style="width:95%;">
			<form class="form-horizontal" action="inventory-issuance.php" method="POST" enctype="multipart/form-data" autocomplete="off">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" style="font-weight:700;">Add Issuance</h4>
					</div>

					<div class="modal-body">
						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="issuance_to" class="req"><b>Issuance To</b></label>
								<select id="issuance_to" class="form-control" name="issuance_to" required>
									<option value="">Select</option>';
									$queryEmployees  = $dblms->querylms("SELECT emply_id, emply_name
																			FROM ".EMPLYS." 
																		");
               						while($valueEmployees = mysqli_fetch_array($queryEmployees)) {
										echo '<option value="'.$valueEmployees['emply_id'].'">'.$valueEmployees['emply_name'].'</option>';
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
									foreach ($status as $adm_status) {
										echo '<option value="'.$adm_status['id'].'">'.$adm_status['name'].'</option>';
									}
									echo '
								</select>
							</div>
						</div>

						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="issuance_remarks" class="req"><b>Remarks</b></label>
								<input type="text" class="form-control" id="issuance_remarks" name="issuance_remarks" required>
							</div>
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
						<button type="button" class="btn btn-default" onclick="location.href=\'inventory-issuance.php\'">Close</button>
						<input class="btn btn-primary" type="submit" id="submit_issuance" name="submit_issuance" value="Add Record">
					</div>
				</div>
			</form>
		</div>
	</div>

	<script src="js/select2/jquery.select2.js"></script>

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