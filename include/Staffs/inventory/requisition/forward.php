<?php
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 8) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 9) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19'))) {
	echo '
   	<div class="row">
		<div id="viewRequisitionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<form class="form-horizontal" action="inventory-requisition.php" method="POST" id="viewRecord">
					<div class="modal-content">
						<div class="modal-header"> 
							<h4 class="modal-title" style="font-weight:700;">Requisition Detail</h4>
						</div>
						<div class="modal-body">
							<div class="col-sm-61">
								<div style="margin-top:5px;">
									<label for="requisition_code">Requisition Code</label>
									<input class="form-control" type="text" name="requisition_code" id="requisition_code" readonly>
								</div>
							</div>
							<div class="col-sm-61">
								<div style="margin-top:5px;">
									<label for="requisition_date">Requisition Date </label>
									<input class="form-control" type="date" name="requisition_date" id="requisition_date" readonly>
								</div>
							</div>
							<div class="col-sm-61">
								<div style="margin-top:5px;">
									<label for="requisition_type"><b>Requisition Type</b></label>
									<select id="requisition_type" class="form-control" name="requisition_type" readonly>
										<option value="">Select Type</option>';
										foreach (REQUISITION_TYPES as $key => $dt) {
											echo '<option value="'.$key.'">'.$dt.'</option>';
										}
										echo '
									</select>
								</div>
							</div>
							<div class="col-sm-61">
								<div style="margin-top:5px;">
									<label for="id_department"><b> Department</b></label>
									<select class="form-control" id="id_department" name="id_department" readonly>
										<option value="">Select Department</option>';
										$queryDepartment = $dblms->querylms("SELECT dept_id, dept_name 
																				FROM ".DEPTS."
																			");
										while($valueDepartment = mysqli_fetch_array($queryDepartment)) {
											echo '<option value="'.$valueDepartment['dept_id'].'">'.$valueDepartment['dept_name'].'</option> ';
										}
										echo '
									</select>
								</div>
							</div>
							<div class="col-sm-61">
								<div style="margin-top:5px;">
									<label for="id_requester"><b> Requester</b></label>
									<select class="form-control" id="id_requester" name="id_requester" readonly>
										<option value="">Select</option>';
										$queryEmployee = $dblms->querylms("SELECT emply_id, emply_name 
																				FROM ".EMPLYS."
																			");
										while($valueEmployee = mysqli_fetch_array($queryEmployee)) {
											echo '<option value="'.$valueEmployee['emply_id'].'">'.$valueEmployee['emply_name'].'</option> ';
										}
										echo '
									</select>
								</div>
							</div>
							<div class="col-sm-61">
								<div style="margin-top:5px;">
									<label for="requisition_purpose"> Purpose </label>
									<input class="form-control" type="text" name="requisition_purpose" id="requisition_purpose" readonly>
								</div>
							</div>
							<div class="col-sm-61">
								<div style="margin-top:5px;">
									<label for="requisition_remarks">Remarks </label>
									<input class="form-control" type="text" name="requisition_remarks" id="requisition_remarks" readonly>
								</div>
							</div>
							<div class="col-sm-91" id="forward">
								<div style="margin-top:5px;">
									<label><b>Forward to:</b></label>
									<select class="form-control col-sm-91" name="forwarded_to" id="forwarded_to">
										<option value="">Select</option>';
										$queryAdmin = $dblms->querylms("SELECT adm_id,adm_fullname
																			FROM ".ADMINS."
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
							<input class="form-control" type="hidden" id="requisition_id" name="requisition_id" readonly>
							<button type="button" class="btn btn-default" onclick="location.href=\'inventory-requisition.php\'">Close</button>
							';
							if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2)) {
								echo '<input class="btn btn-primary" type="submit" value="Forward" id="forward_requisition" name="forward_requisition">';
							}
							if(($_SESSION['userlogininfo']['LOGINTYPE'] == 8) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 9)) {
								echo '
									<input class="btn btn-primary" type="submit" value="Approve" id="approve_requisition" name="approve_requisition">
									<input class="btn btn-warning" type="submit" value="Reject" id="reject_requisition" name="reject_requisition">
								';
							}
							echo '
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
			$(".view-requisition-modal").click(function() {

				// get variables from "edit link" ata attributes
				var requisition_id               	= $(this).attr("data-requisition-id");
				var requisition_code                = $(this).attr("data-requisition-code");
				var requisition_date 				= $(this).attr("data-requisition-date");
				var requisition_type             	= $(this).attr("data-requisition-type");
				var requisition_purpose             = $(this).attr("data-requisition-purpose");
				var requisition_remarks             = $(this).attr("data-requisition-remarks");
				var id_department 					= $(this).attr("data-id-department");
				var id_requester 					= $(this).attr("data-id-requester");
				var forwarded_to 					= $(this).attr("data-forwarded-to");
				var date_forwarded 					= $(this).attr("data-date-forwarded");
				if(forwarded_to !== "0") {
					$("#forward").remove();
					$("#forward_requisition").hide();
				}
				
				// set modal input values dynamically
				$("#requisition_id")            .val(requisition_id);
				$("#requisition_code")         	.val(requisition_code);
				$("#requisition_date")			.val(convertDateToInputFormat(requisition_date));
				$("#requisition_type")         	.val(requisition_type);
				$("#requisition_purpose")       .val(requisition_purpose);
				$("#requisition_remarks")       .val(requisition_remarks);
				$("#id_department")         	.val(id_department);
				$("#id_requester")         		.val(id_requester);
				$("#forwarded_to")         		.val(forwarded_to);
				$("#date_forwarded")         	.val(convertDateToInputFormat(date_forwarded));

				//pre-select data in pull down lists
				$("#requisition_status")            .select2("val", requisition_status);
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