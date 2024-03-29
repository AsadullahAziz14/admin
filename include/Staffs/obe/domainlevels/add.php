<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'add' => '1'))) {	
	echo '
	<!--WI_ADD_NEW_TASK_MODAL-->
	<div class="row">
		<div id="addNewDOMAINLEVELModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<form class="form-horizontal" action="obedomainlevels.php" method="POST" id="addNew" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
							<h4 class="modal-title" style="font-weight:700;"> Add Domain Level Details</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label class="control-label req col-lg-12" style="width:auto;"> <b>Domain</b></label>
								<div class="col-lg-12">
									<select id="domain_name_code" name="domain_name_code" style="width:100%" autocomplete="off" required>
										<option value="">Select Domain</option>';
										foreach ($domain_name as $domain) {
										echo '<option value="'.$domain['id'].'">'.$domain['name'].'</option>';
										}
										echo'
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="domain_level_name" class="control-label req col-lg-12" style="width:auto;"> <b>Domain Level Name</b></label>
								<div class="col-lg-12">
									<input type="text" class="form-control" id="domain_level_name" name="domain_level_name" required></input>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label req col-lg-12" style="width:auto;"><b>Status</b></label>
								<div class="col-lg-12">
									<select id="domain_level_status" name="domain_level_status" style="width:100%" autocomplete="off" required>
										<option value="">Select Option</option>';
									foreach($status as $domainLevelStatus) { 
										echo '<option value="'.$domainLevelStatus['id'].'">'.$domainLevelStatus['name'].'</option>';
									}
									echo '
									</select>
								</div>
							</div>
							<div style="clear:both;"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
								<input class="btn btn-primary" type="submit" value="Add Record" id="submit_domain_level" name="submit_domain_level">
							</button>
						</div>

					</div>
				</form>
			</div>
		</div>
	</div>
	<!--WI_ADD_NEW_TASK_MODAL-->
	<!--JS_ADD_NEW_TASK_MODAL-->
	<script type="text/javascript">
		$(".select2").select2({
			placeholder: "Select Any Option"
		});

		$().ready(function() {
			$("#addNew").validate({
				rules: {
					domain_name_code	: "required",
					domain_level_name	: "required",
					domain_level_status	: "required"
					},
			messages: {
					domain_name_code	: "This field is required",
					domain_level_name	: "This field is required",
					domain_level_status	: "This field is required"
					},
				submitHandler: function(form) {
					form.submit();
				}
			});
		});
	</script>
	<!--JS_ADD_NEW_TASK_MODAL-->';
}