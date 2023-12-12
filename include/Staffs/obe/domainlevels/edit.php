<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'edit' => '1'))) 
{ 
	
	echo '
	<!--WI_EDIT_NEW_TASK_MODAL-->
	<div class="row">
	<div id="editDOMAINModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	<form class="form-horizontal" action="obedomainlevels.php" method="POST" id="editRecord">
	<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
		<h4 class="modal-title" style="font-weight:700;"> Edit DOMAIN LEVEL Details</h4>
	</div>

	<div class="modal-body">

		<div class="form-group">
			<label class="control-label req col-lg-12" style="width:auto;"> <b>Domain</b></label>
			<div class="col-lg-12">
				<select id="domain_name_code_edit" name="domain_name_code_edit" style="width:100%" autocomplete="off" required>
					<option value="">Select Domain</option>';
					foreach ($domain_name as $domain) {
					echo '<option value="'.$domain['id'].'">'.$domain['name'].'</option>';
					}
					echo'
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label req col-lg-12" style="width:auto;"> <b>Domain Level Name</b></label>
			<div class="col-lg-12">
				<input type="text" class="form-control" id="domain_level_name_edit" name="domain_level_name_edit" required></input>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label req col-lg-12" style="width:auto;"><b>Status</b></label>
			<div class="col-lg-12">
				<select id="domain_level_status_edit" name="domain_level_status_edit" style="width:100%" autocomplete="off" required>
					<option value="">Select Option</option>';
				foreach($status as $domain_level_status) { 
					echo '<option value="'.$domain_level_status['id'].'">'.$domain_level_status['name'].'</option>';
				}
				echo '
				</select>
			</div>
		</div>

	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
		<input type="hidden" id="domain_level_id_edit" name="domain_level_id_edit" value="">
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
					domain_name_code_edit					: "required",
					domain_level_name_edit		: "required",
					domain_level_status_edit	: "required"
					},
			messages: {
					domain_name_code_edit		: "This field is required",
					domain_level_name_edit		: "This field is required",
					domain_level_status_edit	: "This field is required"
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
         $(".edit-domain-level-modal").click(function(){

            // get variables from "edit link" ata attributes
            var domain_level_id                     = $(this).attr("data-domain-level-id");
            var domain_name_code                   	= $(this).attr("data-domain-name-code");
            var domain_level_name                	= $(this).attr("data-domain-level-name");
			var domain_level_status 				= $(this).attr("data-domain-level-status")

            // set modal input values dynamically
            $("#domain_level_id_edit")              .val(domain_level_id);
			$("#domain_name_code_edit")         	.val(domain_name_code);
            $("#domain_level_name_edit")         	.val(domain_level_name);
            
				//pre-select data in pull down lists
            $("#domain_level_status_edit")            .select2("val", domain_level_status);
         });

		});
	</script>';
}