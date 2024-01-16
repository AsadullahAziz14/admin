<?php
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'edit' => '1'))) {
	echo '
   	<div class="row">
		<div id="viewPOModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<form class="form-horizontal" action="inventory-purchase_order.php" method="POST" id="editRecord">
					<div class="modal-content">
						<div class="modal-header"> 
							<h4 class="modal-title" style="font-weight:700;">Edit PO</h4>
						</div>

						<div class="modal-body">
							<div class="col-sm-61">
								<div style="margin-top:5px;">
									<label for="id_vendor"><b>Select Vendor</b></label>
									<select name="id_vendor" class="form-control" id="id_vendor" readonly required>
										<option value="">Select Vendor</option>';
										$queryVendor = $dblms->querylms("SELECT vendor_id, vendor_name 
																			FROM ".SMS_VENDOR."
																			");
										while($valueVendor = mysqli_fetch_array($queryVendor)) {
											if($valueVendor['vendor_id']) {
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
									<label for="po_delivery_date">Delivery Date</label>
									<input class="form-control" type="date" name="po_delivery_date" id="po_delivery_date" readonly>
								</div>
							</div>

							<div class="col-sm-61">
								<div style="margin-top:5px;">
									<label for="po_delivery_address"><b>Delivery Adress</b></label>
									<select name="po_delivery_address" class="form-control" id="po_delivery_address" readonly>
										<option value="">Select Address</option>';
											$queryLocation = $dblms->querylms("SELECT l.location_id, l.location_address
																			From ".SMS_LOCATION." l ");
											while($valueLocation = mysqli_fetch_array($queryLocation)) {
												if($valueLocation['location_id']){
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
									<label for="po_tax_perc">Tax %</label>
									<input class="form-control" type="text" name="po_tax_perc" id="po_tax_perc" readonly>
								</div>
							</div>

							<div class="col-sm-61">
								<div style="margin-top:5px;">
									<label for="po_payment_terms"><b>Payment Terms</b></label>
									<select id="po_payment_terms" class="form-control" name="po_payment_terms" readonly>
										<option value="">Select Payment Terms</option>';
										foreach (PAYMENT_TERMS as $key => $pt) {
											if($key) {
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
									<label for="po_lead_time"><b>Lead Time</b></label>
									<select id="po_lead_time" class="form-control" name="po_lead_time" readonly>
										<option value="">Select Lead Time</option>';
										for ($i=1; $i < 30; $i++) { 
											if($i) {
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
									<label for="date_ordered"> Ordered Date </label>
									<input class="form-control" type="date" name="date_ordered" id="date_ordered" readonly>
								</div>
							</div>

							<div class="col-sm-61">
								<div style="margin-top:5px;">
									<label><b>Status</b></label>
									<select class="form-control" name="po_status" id="po_status" readonly>
										<option value="">Select Status</option>';
										foreach ($status as $poStatus) {
											echo '<option value="'.$poStatus['id'].'">'.$poStatus['name'].'</option>';
										}
										echo '
									</select>
								</div>
							</div>

							<div class="col-sm-91">
								<div style="margin-top:5px;">
									<label for="po_remarks">Remarks</label>
									<input class="form-control" type="text" name="po_remarks" id="po_remarks" readonly>
								</div>
							</div>

							<div class="col-sm-91">
								<div style="margin-top:5px;">
									<label><b>Forward to:</b></label>
									<input class="form-control" type="hidden" id="po_id" name="po_id" readonly>
									<select class="form-control col-sm-91" name="forwarded_to" id="forwarded_to">
										<option value="">Select</option>';
										$queryAdmin = $dblms->querylms("SELECT adm_id,adm_fullname
																		FROM ".ADMINS."
																		WHERE adm_id IN (1,2,3,4,5)
																		$sql2
																	");
										while($valueAdmin = mysqli_fetch_array($queryAdmin)) {
											echo '<option value="'.$valueAdmin['adm_id'].'">'.$valueAdmin['adm_fullname'].'</option> ';
										}
										echo '
									</select>
								</div>
							</div>
							
							<div style="clear:both;"></div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-default" onclick="location.href=\'inventory-purchase_order.php\'">Close</button>
							<input class="btn btn-primary" type="submit" value="Forward" id="forward_po" name="forward_po">
						</div>
					</div>
					
				</form>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
		$(".select2").select2({
			placeholder: "Select Any Option"
		})
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			//---edit item link clicked-------
			$(".view-po-modal").click(function(){

				// get variables from "edit link" ata attributes
				var po_id                   = $(this).attr("data-po-id");
				var po_code                 = $(this).attr("data-po-code");
				var po_status 				= $(this).attr("data-po-status");
				var po_delivery_date 		= $(this).attr("data-po-delivery-date");
				var po_delivery_address 	= $(this).attr("data-po-delivery-address");
				var po_tax_perc 			= $(this).attr("data-po-tax-perc");
				var po_payment_terms 		= $(this).attr("data-po-payment-terms");
				var po_lead_time 			= $(this).attr("data-po-lead-time");
				var po_remarks				= $(this).attr("data-po-remarks");
				var date_ordered 			= $(this).attr("data-date-ordered");
				var forwarded_by 			= $(this).attr("data-forwarded-by");
				var forwarded_to 			= $(this).attr("data-forwarded-by");
				var date_forwarded 			= $(this).attr("data-date-forwarded");
				var id_vendor 				= $(this).attr("data-id-vendor");

				console.log(date_ordered);
				// set modal input values dynamically
				$("#po_id")              	.val(po_id);
				$("#po_code")         		.val(po_code);
				$("#po_delivery_date")		.val(convertDateToInputFormat(po_delivery_date));
				$("#po_delivery_address")   .val(po_delivery_address);
				$("#po_tax_perc")         	.val(po_tax_perc);
				$("#po_payment_terms")      .val(po_payment_terms);
				$("#po_lead_time")         	.val(po_lead_time);
				$("#po_remarks")         	.val(po_remarks);
				$("#date_ordered")         	.val(convertDateToInputFormat(date_ordered));
				$("#forwarded_to")         	.val(forwarded_to);
				$("#id_vendor")         	.val(id_vendor);

				//pre-select data in pull down lists
				$("#po_status")            .select2("val", po_status);
			});
		});
		<!--JS_EDIT_NEW_TASK_MODAL-->

		// Function to convert date to "YYYY-MM-DD" format
		function convertDateToInputFormat(inputDate) {
			var options = { year: "numeric", month: "numeric", day: "numeric" };
			return new Date(inputDate).toLocaleDateString("en-CA", options);
		}
	</script>
	<script src="js/select2/jquery.select2.js"></script>';
}