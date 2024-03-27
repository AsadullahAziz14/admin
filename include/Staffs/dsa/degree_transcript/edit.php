<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '190')) { 

echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editBcatModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="dsadegreetranscript.php" method="post" id="editBcat">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Forwards Student Degree/Transcript Application</h4>
</div>

<div class="modal-body">

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Student Registration #</label>
			<input type="text" class="form-control" id="stdregno_edit" name="stdregno_edit" autocomplete="off" readonly>
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Student Name</label>
			<input type="text" class="form-control" id="stdname_edit" name="stdname_edit" autocomplete="off" readonly>
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Semester</label>
			<input type="text" class="form-control" id="semester_edit" name="semester_edit" autocomplete="off" readonly>
		</div> 
	</div>
	
	<div style="clear:both;padding-top:10px !important;"></div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Application For</label>
			<select id="degree_transcript_edit" name="degree_transcript_edit" style="width:100%" required disabled>
				<option></option>';
				$i = 0;
				foreach($stdaffairstypes as $degreeTranscript){
					echo '<option value="'.$degreeTranscript['id'].'">'.$degreeTranscript['name'].'</option>';
					$i++;
					if($i == 2) break;
				}
			echo '	
			</select>
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Normal/Urgent</label>
			<select id="normal_urgent_edit" name="normal_urgent_edit" style="width:100%" autocomplete="off" required disabled>
				<option value="">Select Option</option>';
				foreach($regular_urgent as $regularUrgent){
					echo '<option value="'.$regularUrgent['id'].'">'.$regularUrgent['name'].'</option>';
				}
			echo'
			</select>
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Original/Duplicate</label>
			<select id="original_duplicate_edit" name="original_duplicate_edit" style="width:100%" autocomplete="off" required disabled>
				<option value="">Select Option</option>';
				foreach ($original_duplicate as $originalDuplicate)  {
					echo '<option value="'.$originalDuplicate['id'].'">'.$originalDuplicate['name'].'</option>';
				}
			echo'
			</select>
		</div> 
	</div>

	<div style="clear:both;padding-top:10px !important;"></div>
	
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"> <b>Remarks</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="remarks_edit" name="remarks_edit" style="height:70px!important;" required autocomplete="off"></textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-lg-12 req" style="width:450px;"> <b>Forward To</b></label>
		<div class="col-lg-12">
			<select id="cclist" name="cclist[]" multiple required style="width:100%; height:auto!important;">';
				$sqllmsAdmins  = $dblms->querylms("SELECT adm.adm_id, adm.adm_username, adm.adm_fullname, dept.dept_name
														FROM ".ADMINS." adm 
														LEFT JOIN ".DEPTS." dept ON dept.dept_id = adm.id_dept 
														WHERE adm.adm_status = '1' AND adm.adm_logintype = '1'
														AND adm.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
														ORDER BY adm.adm_username ASC");
				while($valueAdmin = mysqli_fetch_array($sqllmsAdmins)){

					$departmentName = '';
					if($valueAdmin['dept_name']){
						$departmentName = ' ('.$valueAdmin['dept_name'].')';
					}

					echo '<option value="'.$valueAdmin['adm_id'].'">'.$valueAdmin['adm_fullname'].' - '.$valueAdmin['adm_username'].''.$departmentName.'</option>';
				}
				echo '
			</select>
		</div>
	</div>

</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
	<input type="hidden" id="id_edit" name="id_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="forward_application" name="forward_application">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->

<!--JS_EDIT_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_EDIT_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#editBcat").validate({
		rules: {
			remarks_edit	: "required"
		},
		messages: {
			remarks_edit	: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		//USED BY: WI_EDIT_TASK_MODAL
		//ACTIONS: dynamically add data into modal form
		//REQUIRES: jquery.js
		//ACTIONS-2: creates a pull down/select for each specified field (with preselected values)
		//REQUIRES-2: select2.js
			
		//---edit item link clicked-------
		$(".edit-bcat-modal").click(function(){
		
			//get variables from "edit link" data attributes
			var stdregno_edit 			= $(this).attr("data-cat-stdregno");
			var stdname_edit 			= $(this).attr("data-cat-stdname");
			var semester_edit 			= $(this).attr("data-cat-semester");
			var degree_transcript_edit 	= $(this).attr("data-cat-for");
			var normal_urgent_edit 		= $(this).attr("data-cat-normal-urgent");
			var original_duplicate_edit = $(this).attr("data-cat-original-duplicate");
			var id_edit 				= $(this).attr("data-cat-id");

			//set modal input values dynamically
			$("#stdregno_edit")				.val(stdregno_edit);
			$("#stdname_edit")				.val(stdname_edit);
			$("#semester_edit")				.val(semester_edit);
			$("#id_edit")					.val(id_edit);

			//pre-select data in pull down lists
			$("#degree_transcript_edit")	.select2().select2("val", degree_transcript_edit); 
			$("#normal_urgent_edit")		.select2().select2("val", normal_urgent_edit); 
			$("#original_duplicate_edit")	.select2().select2("val", original_duplicate_edit); 
		});
		
	});
</script>
<script>
	$("#cclist").select2({
		allowClear: true
	});
</script';
}