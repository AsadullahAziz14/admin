<?php 
//Require Vars, DB Connection and Function Files
require_once('../../../dbsetting/lms_vars_config.php');
require_once('../../../dbsetting/classdbconection.php');
$dblms = new dblms();
require_once('../../../functions/login_func.php');
require_once('../../../functions/functions.php');
require_once('../../../functions/studentservices.php');

//User Authentication
checkCpanelLMSALogin();

if(isset($_POST['status'])) {

	if(cleanvars($_POST['status']) == 2 || cleanvars($_POST['status']) == 3 ){

		echo '
		<div style="clear:both;padding-bottom:5px;"></div>
		<div class="col-sm-12">
			<div class="form_sep">
				<label class="req">Currently At</label>
				<select id="currectly_at" name="currectly_at" style="width:100%" autocomplete="off" required>
					<option value="">Select Option</option>';
					foreach($dsaApplicationCurrentLocation as $dsaCL){
						echo '<option value="'.$dsaCL['id'].'">'.$dsaCL['name'].'</option>';
					}
					echo'
			</select>
			</div> 
		</div>
		<script>
			$("#currectly_at").select2({
				allowClear: true
			});
		</script>';

	}

	if(cleanvars($_POST['status']) == 4){

		echo '
		<div style="clear:both;padding-bottom:5px;"></div>
		<div class="col-sm-61">
			<div class="form_sep">
				<label class="req">Date of Issuance</label>
				<input type="text" class="form-control pickadate" id="issuance_date" name="issuance_date" autocomplete="off" required>
			</div> 
		</div>

		<div class="col-sm-61">
			<div class="form_sep">
				<label class="req">Document Number</label>
				<input type="text" class="form-control" id="document_number" name="document_number" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" autocomplete="off" required>
			</div> 
		</div>';

	}
	
	if(cleanvars($_POST['status']) == 5){
		echo '
		<div style="clear:both;padding-bottom:5px;"></div>
		<div class="col-sm-61">
			<div class="form_sep">
				<label class="req">Recipient</label>
				<select id="recipient" name="recipient" onChange="get_recipient_relation(this.value)" style="width:100%" autocomplete="off" required>
					<option value="">Select Option</option>';
					foreach($dsaRecipientsArray as $dsaRecipient){
						echo '<option value="'.$dsaRecipient['id'].'">'.$dsaRecipient['name'].'</option>';
					}
					echo'
				</select>
			</div> 
		</div>
		<div class="col-sm-61">
			<div class="form_sep">
				<label class="req">Full Name</label>
				<input type="text" class="form-control" id="recipient_full_name" name="recipient_full_name" autocomplete="off" required>
			</div> 
		</div>
		<div style="clear:both;padding-bottom:5px;"></div>

		<div id="getdsarecipientrelation"></div>
		<div id="loading1"></div>

		<div class="col-sm-61">
			<div class="form_sep">
				<label class="req">Recipient CNIC</label>
				<input type="text" class="form-control" id="recipient_cnic" name="recipient_cnic" autocomplete="off" required>
			</div> 
		</div>
		<div class="col-sm-61">
			<div class="form_sep">
				<label class="req">Date of Delivery</label>
				<input type="text" class="form-control pickadate" id="delivered_date" name="delivered_date" autocomplete="off" required>
			</div> 
		</div>
		<script>
			$("#recipient").select2({
				allowClear: true
			});
		</script>
		<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
		<script>
			jQuery(function($) {
				$.mask.definitions["~"]="[+-]";
				$("#recipient_cnic").mask("99999-9999999-9");
			});
		</script>';
	}

	echo '
	<script>
		//USED BY: All date picking forms
		$(document).ready(function(){
			$(".pickadate").datepicker({
			format: "yyyy-mm-dd",
			language: "lang",
			autoclose: true,
			todayHighlight: true
			});	
		});
	</script>';
}
