<?php

if(LMS_VIEW == 'add' && !isset($_GET['id'])) { 
	echo '
	<div class="row">
		<div class="modal-dialog" style="width:95%;">
			<form class="form-horizontal" action="inventory-vendors.php" method="POST" enctype="multipart/form-data" autocomplete="off">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" style="font-weight:700;">Add Vendor Details</h4>
					</div>

					<div class="modal-body">

						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="vendor_name" class="req"><b>Vendor Name</b></label>
								<input type="text" class="form-control" id="vendor_name" name="vendor_name" required>	
							</div>
						</div>

						<div class="col-sm-61">
							<div style="margin-top:5px;">
								<label for="vendor_address" class="req"><b>Vendor Address</b></label>
								<input type="text" class="form-control" id="vendor_address" name="vendor_address" required>
							</div>
						</div>

						<div class="col-sm-31">
							<div style="margin-top:5px;">
								<label for="vendor_contact_name" class="req"><b>Contact Person</b></label>
								<input type="text" class="form-control" id="vendor_contact_name" name="vendor_contact_name">
							</div>
						</div>

						<div class="col-sm-31">
							<div style="margin-top:5px;">
								<label for="vendor_contact_email" class="req"><b>Email</b></label>
								<input type="email" class="form-control" id="vendor_contact_email" name="vendor_contact_email">
							</div>
						</div>

						<div class="col-sm-31">
							<div style="margin-top:5px;">
								<label for="vendor_contact_phone1" class="req"><b>Phone Num. 1</b></label>
								<input type="text" class="form-control" id="vendor_contact_phone1" name="vendor_contact_phone1">
							</div>
						</div>

						<div class="col-sm-31">
							<div style="margin-top:5px;">
								<label for="vendor_contact_phone2" class="req"><b>Phone Num. 2</b></label>
								<input type="text" class="form-control" id="vendor_contact_phone2" name="vendor_contact_phone2">
							</div>
						</div>

						<div class="col-sm-31">
							<div style="margin-top:5px;">
								<label for="vendor_status" class="req"><b>Status</b></label>
								<select id="vendor_status" class="form-control" name="vendor_status" required>
									<option value="">Select Status</option>';
									foreach ($status as $adm_status) {
										echo '<option value="'.$adm_status['id'].'">'.$adm_status['name'].'</option>';
									}
									echo '
								</select>
							</div>
						</div>

						<div style="clear:both;"></div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" onclick="location.href=\'inventory-vendors.php\'">Close</button>
						<input class="btn btn-primary" type="submit" value="Add Record" id="submit_vendor" name="submit_vendor">
					</div>
				</div>
				
			</form>
		</div>
	</div>

	<script>
		function updateSecondSelector() {
			var selectedValue = document.getElementById("id_category").value;

			var ajaxReq = new XMLHttpRequest();
			var method = "GET";
			var url = "include/ajax/get_Options.php?selectedValue=" + selectedValue;
			var asynchronous = true;

			ajaxReq.open(method, url,asynchronous);
			ajaxReq.send();

			ajaxReq.onreadystatechange = function() {
				if (ajaxReq.readyState === 4 && ajaxReq.status === 200) {
					const options = ajaxReq.responseText;
					var id_sub_category = document.getElementById("id_sub_category");
					
					id_sub_category.innerHTML = options;
					console.log(options);
				}
			};
		}
	</script>
	<script src="js/select2/jquery.select2.js"></script>
	<script>
		$(".select2").select2({
			placeholder: "Select Any Option"
		})
	</script>
	';
}
?>