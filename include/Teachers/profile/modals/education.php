<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="empNewEduModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="profile.php?view=education" method="post" id="addeduskill" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Education History</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Degree Level</b></label>
		<div class="col-lg-12">
			<select id="id_degree" name="id_degree" style="width:100%" autocomplete="off" required>
				<option value="">Select Degree Level</option>';
			$sqllmslang		= $dblms->querylms("SELECT degree_id, degree_name 
													FROM ".HRM_DEGREES." 
													WHERE degree_status = '1' 
													ORDER BY degree_name ASC");
			while($rowlang 	= mysqli_fetch_array($sqllmslang)) {
				echo '<option value="'.$rowlang['degree_id'].'">'.$rowlang['degree_name'].'</option>';
			}
	echo'
			</select>
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Program Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="program" name="program" required autofocus autocomplete="off">
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Major Subjects</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="subjects" name="subjects" required autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Institute/Board</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="institute" name="institute" required autocomplete="off">
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Grade/GPA</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="grade" name="grade" required autocomplete="off">
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Year</b></label>
		<div class="col-lg-12">
			<input type="number" class="form-control" id="year" name="year" required autocomplete="off">
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"><b> Result Card</b></label>
		<div class="col-lg-12">
			<input id="resultcard" name="resultcard" class="btn btn-mid btn-primary clearfix" type="file"> 
			<span style="color:#f00;">size should be less then 300KB</span>
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
		<input class="btn btn-primary" type="submit" value="Add Record" id="submit_education" name="submit_education">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#id_degree").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addeduskill").validate({
		rules: {
             id_degree		: "required",
			 program		: "required",
			 subjects		: "required",
			 institute		: "required"
		},
		messages: {
			id_degree		: "This field is required",
			program			: "This field is required",
			subjects		: "This field is required",
			institute		: "This field is required"
		},
		submitHandler: function(form) {
        //alert("form submitted");
		form.submit();
        }
	});
});
</script>
<!--WI_ADD_NEW_TASK_MODAL-->

<div class="row">
<div id="empEditEduModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="profile.php?view=education" method="post" id="editEdukill" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Education History</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Degree Level</b></label>
		<div class="col-lg-12">
			<select id="id_degree_edit" name="id_degree_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Degree Level</option>';
			$sqllmslang		= $dblms->querylms("SELECT degree_id, degree_name 
													FROM ".HRM_DEGREES." 
													WHERE degree_status = '1' 
													ORDER BY degree_name ASC");
			while($rowlang 	= mysqli_fetch_array($sqllmslang)) {
				echo '<option value="'.$rowlang['degree_id'].'">'.$rowlang['degree_name'].'</option>';
			}
	echo'
			</select>
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Program Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="program_edit" name="program_edit" required autofocus autocomplete="off">
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Major Subjects</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="subjects_edit" name="subjects_edit" required autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Institute/Board</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="institute_edit" name="institute_edit" required autocomplete="off">
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Grade/GPA</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="grade_edit" name="grade_edit" required autocomplete="off">
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Year</b></label>
		<div class="col-lg-12">
			<input type="number" class="form-control" id="year_edit" name="year_edit" required autocomplete="off">
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"><b> Result Card</b></label>
		<div class="col-lg-12">
			<input id="resultcard" name="resultcard" class="btn btn-mid btn-primary clearfix" type="file"> 
			<span style="color:#f00;">size should be less then 300KB</span>
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
	<input type="hidden" id="eduid_edit" name="eduid_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_education" name="changes_education">
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#id_degree_edit").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#editEdukill").validate({
		rules: {
             id_degree_edit		: "required",
			 program_edit		: "required",
			 subjects_edit		: "required",
			 institute_edit		: "required"
		},
		messages: {
			id_degree_edit		: "This field is required",
			program_edit		: "This field is required",
			subjects_edit		: "This field is required",
			institute_edit		: "This field is required"
		},
		submitHandler: function(form) {
        //alert("form submitted");
		form.submit();
        }
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
    $(".edit-edu-modal").click(function(){
    

        var id_degree_edit 		= $(this).attr("data-edu-degree");
		var program_edit 		= $(this).attr("data-edu-prg");
		var subjects_edit 		= $(this).attr("data-edu-subjs");
		var institute_edit 		= $(this).attr("data-edu-inst");
		var grade_edit 			= $(this).attr("data-edu-grade");
		var year_edit 			= $(this).attr("data-edu-year");
		var eduid_edit 			= $(this).attr("data-eduid");

		$("#program_edit")		.val(program_edit);
		$("#subjects_edit")		.val(subjects_edit);
		$("#institute_edit")	.val(institute_edit);
		$("#grade_edit")		.val(grade_edit);
		$("#year_edit")			.val(year_edit);
		$("#eduid_edit")		.val(eduid_edit);

        $("#id_degree_edit")	.select2().select2("val", id_degree_edit); 
  });
    
});
</script>';