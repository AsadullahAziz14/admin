<?php  
if(LMS_VIEW == 'add' && !isset($_GET['id'])) { 
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '16', 'add' => '1'))) { 
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="#" method="post" id="addNew">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'ladepartmentcoursesoffered.php\'"><span>close</span></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Offered Courses</h4>
</div>

<div class="modal-body">

	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Status</label>
			<select id="status" name="status" required style="width:100%;">';
				foreach($status as $liststatus) {
					echo '<option value="'.$liststatus['id'].'">'.$liststatus['name'].'</option>';
				}
				echo '
			</select>
		</div> 
	</div>

	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Liberal Arts</label>
			<select id="liberal_arts" name="liberal_arts" required style="width:100%;" onchange="get_statusliberalarts(this.value)">
				<option value="">Select Option</option>';
				foreach($yesno as $yn) {
					echo '<option value="'.$yn['id'].'">'.$yn['name'].'</option>';
				}
				echo '
			</select>
		</div> 
	</div>
	
<div id="getstatusliberalarts">

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Department</label>
			<select id="id_dept" name="id_dept" required style="width:100%;">
				<option value="">Select Department</option> 
			</select>
		</div> 
	</div>
	
	<div style="clear:both;padding-top:10px !important;"></div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Sequencing Category</label>
			<select id="sequencing_category" name="sequencing_category" required style="width:100%;">
				<option value="">Select Sequencing</option> 
			</select>
		</div> 
	</div>
	
	
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Semester</label>
			<select id="semester" name="semester" required style="width:100%;">
				<option value="">Select Semester</option> 
			</select>
		</div> 
	</div>
	
</div>


<div style="clear:both;padding-top:5px !important;"></div>


</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'ladepartmentcoursesoffered.php\'">Close</button>
		<input class="btn btn-primary" type="submit" value="Add Offered Course" id="add_offered_course" name="add_offered_course">
	</button>
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<!--JS_ADD_NEW_TASK_MODAL-->
<script>
	$("#id_dept").select2({
		allowClear: true
	});
</script>
<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_ADD_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#addNew").validate({
		rules: {
			dept_domain				: "required",
			sequencing_category		: "required",
			liberal_arts			: "required",
			status					: "required",
			id_prg					: "required",
			semester				: "required"
		},
		messages: {
			dept_domain			: "This field is required",
			sequencing_category	: "This field is required",
			liberal_arts		: "This field is required",
			status				: "This field is required",
			id_prg				: "This field is required",
			semester			: "This field is required"
		},
		submitHandler: function(form) {
        //alert("form submitted");
		form.submit();
        }
	});
});
</script>
<!--JS_ADD_NEW_TASK_MODAL-->';
}
}