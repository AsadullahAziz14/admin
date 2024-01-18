<?php
if(LMS_VIEW == 'add' && !isset($_GET['id'])) { 
	echo '
	<!--WI_ADD_NEW_TASK_MODAL-->
	<div class="row">
		<div class="modal-dialog" style="width:95%;">
			<form class="form-horizontal" action="#" method="post" id="addNewBcat" enctype="multipart/form-data">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" style="font-weight:700;">Add Receiving</h4>
					</div>
					<div class="modal-body">

						<div class="col-sm-61">
							<label for="delivery_chalan_num" class="req"><b>DC Num.</b></label>
							<input type="text" class="form-control" id="delivery_chalan_num" name="delivery_chalan_num" required>
						</div>

						<div class="col-sm-61">
							<label for="id_vendor" class="req"><b>Vendor</b></label>
							<select name="id_vendor" class="form-control" id="id_vendor" required>
								<option value="">Select Vendor</option>';
								$queryVendor = $dblms->querylms("SELECT vendor_id, vendor_name 
																	FROM ".SMS_VENDOR);
								while($valueVendor = mysqli_fetch_array($queryVendor)) {
									echo '<option value="'.$valueVendor['vendor_id'].'">'.$valueVendor['vendor_name'].'</option>';
								}
								echo '
							</select>
						</div>

						<div class="col-sm-61">
							<label for="receiving_remarks" class="req"><b>Remarks</b></label>
							<input type="text" class="form-control" name="receiving_remarks" id="receiving_remarks" required>
						</div>

						<div class="col-sm-61">
							<label for="receiving_status" class="req"><b>Status</b></label>
							<select id="receiving_status" class="form-control" name="receiving_status" required>
								<option value="">Select Status</option>';
								foreach ($status as $receivingStatus) {
									echo '<option value="'.$receivingStatus['id'].'">'.$receivingStatus['name'].'</option>';
								}
								echo '
							</select>
						</div>

						<div class="col-sm-91" id="itemContainer">
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
						<input class="btn btn-primary" type="submit" value="Add Record" id="submit_receiving" name="submit_receiving">
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
	</script>';
}

?>