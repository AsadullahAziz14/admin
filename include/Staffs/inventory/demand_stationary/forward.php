<?php
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 8) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19'))) {
	echo '
   	<div class="row">
		<div id="viewDemandModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<form class="form-horizontal" action="inventory-demand_stationary.php" method="POST" id="viewRecord">
					<div class="modal-content">
						<div class="modal-header"> 
							<h4 class="modal-title" style="font-weight:700;">Demand Detail</h4>
						</div>

						<div class="modal-body">
							<div class="col-sm-61">
								<div style="margin-top:5px;">
									<label for="demand_code">Demand Code</label>
									<input class="form-control" type="text" name="demand_code" id="demand_code" readonly>
								</div>
							</div>
							<div class="col-sm-61">
								<div style="margin-top:5px;">
									<label for="demand_type"><b>Demand Type</b></label>
									<select id="demand_type" class="form-control" name="demand_type" readonly>
										<option value="">Select Type</option>';
										foreach (DEMAND_TYPES as $key => $dt) {
											echo '<option value="'.$key.'">'.$dt.'</option>';
										}
										echo '
									</select>
								</div>
							</div>
							<div class="col-sm-61">
								<div style="margin-top:5px;">
									<label for="demand_date">Demand Due Date </label>
									<input class="form-control" type="date" name="demand_date" id="demand_date" readonly>
								</div>
							</div>
							<div class="col-sm-61">
								<div style="margin-top:5px;">
									<label for="demand_due_date"> Demand Due Date </label>
									<input class="form-control" type="date" name="demand_due_date" id="demand_due_date" readonly>
								</div>
							</div>
							
							<div class="col-sm-61">
								<div style="margin-top:5px;">
									<label for="id_department"><b>Department</b></label>
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
							';
							if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2)){
								$queryAdmin = $dblms->querylms("SELECT adm_id,adm_fullname
																FROM ".ADMINS."
																Where stationary_approver = 1
															");
								$valueAdmin = mysqli_fetch_array($queryAdmin);
								echo '<input class="form-control" type="hidden" id="" name="forwarded_to" value="'.$valueAdmin['adm_id'].'" readonly>';
							}
							echo '	
							<div style="clear:both;"></div>
						</div>

						<div class="modal-footer">
							<input class="form-control" type="hidden" id="demand_id" name="demand_id" readonly>
							<button type="button" class="btn btn-default" onclick="location.href=\'inventory-demand_stationary.php\'">Close</button>
							';
							if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2)) {
								echo '<input class="btn btn-primary" type="submit" value="Forward to Dir. Admin" id="forward_demand" name="forward_demand">';
							}
							if($_SESSION['userlogininfo']['LOGINTYPE'] == 8) {
								echo '
									<input class="btn btn-primary" type="submit" value="Approve" id="approve_demand" name="approve_demand">
									<input class="btn btn-warning" type="submit" value="Reject" id="reject_demand" name="reject_demand">
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
			$(".view-demand-modal").click(function() {

				// get variables from "edit link" ata attributes
				var demand_id                   = $(this).attr("data-demand-id");
				var demand_code                 = $(this).attr("data-demand-code");
				var demand_status               = $(this).attr("data-demand-status");
				var demand_type             	= $(this).attr("data-demand-type");
				var demand_quantity             = $(this).attr("data-demand-quantity");
				var demand_date 				= $(this).attr("data-demand-date");
				var demand_due_date 			= $(this).attr("data-demand-due-date");
				var forwarded_to 				= $(this).attr("data-forwarded-to");
				var id_department 				= $(this).attr("data-id-department");
				var date_forwarded 				= $(this).attr("data-date-forwarded");
				if(forwarded_to !== "0") {
					$("#forward").remove();
					$("#forward_demand").hide();
				}

				// set modal input values dynamically
				$("#demand_id")              	.val(demand_id);
				$("#demand_code")         		.val(demand_code);
				$("#demand_type")         		.val(demand_type);
				$("#demand_quantity")         	.val(demand_quantity);
				$("#demand_date")				.val(convertDateToInputFormat(demand_date));
				$("#demand_due_date")   		.val(convertDateToInputFormat(demand_due_date));
				$("#forwarded_to")         		.val(forwarded_to);
				$("#id_department")         	.val(id_department);
				$("#date_forwarded")         	.val(convertDateToInputFormat(date_forwarded));

				//pre-select data in pull down lists
				$("#demand_status")            .select2("val", demand_status);
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