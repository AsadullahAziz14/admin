<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'edit' => '1'))) {
	echo '
	<!--WI_EDIT_NEW_TASK_MODAL-->
	<div class="row">
		<div id="editCLOModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<form class="form-horizontal" action="obeclos.php" method="POST" id="editRecord">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
							<h4 class="modal-title" style="font-weight:700;"> Edit CLO Details</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label class="control-label col-lg-12 req" style="width:150px;"> <b>CLO Number</b></label>
								<div class="col-lg-12">
									<select id="clo_number_edit" name="clo_number_edit" style="width:100%" autocomplete="off" required>
										<option value="">Select CLO Number</option>';
									for($i = 1; $i <= 50; $i++) { 
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
									echo '
									</select>
								</div>
							</div>

							<div style="clear:both;"></div>

							<div class="form-group">
								<label class="control-label req col-lg-12" style="width:150px;"> <b>CLO Statement</b></label>
								<div class="col-lg-12">
									<textarea class="form-control" name="clo_statement_edit" id="clo_statement_edit" style="height:100px!important;" required></textarea>
								</div>
							</div>';

							$queryPLO = $dblms->querylms("SELECT plo_id, plo_statement 
															FROM ".OBE_PLOS." 
															WHERE id_prg = 1
														");
							$options = '';
							while ($valuePlo = mysqli_fetch_array($queryPLO)) {
								$options .= '<option value="'.$valuePlo['plo_id'].'">'.$valuePlo['plo_statement'].'</option>';
							}
								
							echo '
							<div class="form-group">
								<label class="control-label req col-lg-12" style="width:150px;"><b>Mapped PLOs</b></label>
								<div class="col-lg-12">
									<select id="id_plo_edit" class="select2" name="id_plo_edit[]" style="width:100%" multiple>
										'.$options.'
									</select>
								</div>
							</div>';

							$queryDomains = $dblms->querylms("SELECT domain_level_id, domain_level_code, domain_level_name
																FROM ".OBE_DOMAIN_LEVELS."
															");
							$options = '';
							while ($valueDomain = mysqli_fetch_assoc($queryDomains)) {
								$options .= '<option value="'.$valueDomain['domain_level_id'].'">'.$valueDomain['domain_level_code'].' - '.$valueDomain['domain_level_name'].'</option>';
							}
							
							echo '
							<div class="form-group">
								<label class="control-label req col-lg-12" style="width:150px;"><b>Mapped Domain</b></label>
								<div class="col-lg-12">
									<select id="id_domain_level_edit" name="id_domain_level_edit" style="width:100%" autocomplete="off" required>
										<option value="">Select Domain Level</option>
										'.$options.'
									</select>
								</div>
							</div>

							<div style="clear:both;"></div>

							<div class="form-group">
								<label class="control-label req col-lg-12" style="width:150px;"><b>Status</b></label>
								<div class="col-lg-12">
									<select id="clo_status_edit" name="clo_status_edit" style="width:100%" autocomplete="off" required>
										<option value="">Select Option</option>';
									foreach($status as $cloStatus) { 
										echo '<option value="'.$cloStatus['id'].'">'.$cloStatus['name'].'</option>';
									}
									echo '
									</select>
								</div>
							</div>
							
							<div style="clear:both;"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
							<input type="hidden" id="clo_id_edit" name="clo_id_edit" value="">
							<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--WI_EDIT_NEW_TASK_MODAL-->
   <script type="text/javascript">
		$(".select2").select2({
			placeholder : "Select Any Option"
		});

	<!--JS_EDIT_NEW_TASK_MODAL-->
		$().ready(function() {
			$("#editRecord").validate({
				rules: {
						sections		: "required",
						clo_number	: "required",
						clo_statement : "required",
						id_plo: "required",
						id_domain_level: "required",
						clo_status: "required"
					},
				messages: {
						sections		: "This field is required",
						clo_number	: "This field is required",
						clo_statement : "This field is required",
						id_plo : "This field is required",
						id_domain_level: "This field is required",
						clo_status: "This field is required"
					},
				submitHandler: function(form) {
					form.submit();
				}
			});
		});
	</script>
   <script type="text/javascript">
		$(document).ready(function(){
			//---edit item link clicked-------
         $(".edit-clo-modal").click(function(){

            // get variables from "edit link" ata attributes
            var clo_id                       = $(this).attr("data-clo-id");
            var clo_number                   = $(this).attr("data-clo-number");
            var clo_statement                = $(this).attr("data-clo-statement");
            var id_plo                       = $(this).attr("data-id-plo");
            var id_domain_level              = $(this).attr("data-id-domain-level");
            var clo_status                   = $(this).attr("data-clo-status");

            // set modal input values dynamically
            $("#clo_statement_edit")         .val(clo_statement);
            $("#clo_id_edit")                .val(clo_id);
            
				//pre-select data in pull down lists
            $("#clo_number_edit")            .select2("val", clo_number);
            $("#id_plo_edit")                .select2().select2("val", id_plo);
            $("#id_domain_level_edit")       .select2("val", id_domain_level);
            $("#clo_status_edit")            .select2("val", clo_status);
         });

		});
	</script>';
}