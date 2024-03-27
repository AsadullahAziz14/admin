<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="empNewExpModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="profile.php?view=experience" method="post" id="addexp" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Experience Detail</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Organization</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="organization" name="organization" required autofocus autocomplete="off">
		</div>
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Job Field </label>
			<input type="text" name="jobfield" id="jobfield" class="form-control" required autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Designation</label>
			<input type="text" name="designation" id="designation" class="form-control" required >
		</div> 
	</div>

	<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"><b> Job Detail</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="jobdetail" name="jobdetail" autocomplete="off">
		</div>
	</div>

	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Start Date </label>
			<input type="text" name="date_start" id="date_start" class="form-control pickadate" required >
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>End Date </label>
			<input type="text" name="date_end" id="date_end" class="form-control pickadate" >
		</div> 
	</div>


	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Salary Start </label>
			<input type="number" name="salary_start" id="salary_start" class="form-control" >
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Salary End </label>
			<input type="number" name="salary_end" id="salary_end" class="form-control" >
		</div> 
	</div>

	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
		<input class="btn btn-primary" type="submit" value="Add Record" id="submit_exp" name="submit_exp">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->

<script type="text/javascript">
$().ready(function() {
	$("#addexp").validate({
		rules: {
             organization	: "required",
			 designation	: "required",
			 jobfield		: "required",
			 date_start		: "required"
		},
		messages: {
			organization	: "This field is required",
			designation		: "This field is required",
			jobfield		: "This field is required",
			date_start		: "This field is required"
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
<div id="empEditExpModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="profile.php?view=experience" method="post" id="editExp" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Experience Detail</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Organization</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="organization_edit" name="organization_edit" required autocomplete="off">
		</div>
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Job Field </label>
			<input type="text" name="jobfield_edit" id="jobfield_edit" class="form-control" required autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Designation</label>
			<input type="text" name="designation_edit" id="designation_edit" class="form-control" required >
		</div> 
	</div>

	<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"><b> Job Detail</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="jobdetail_edit" name="jobdetail_edit" autocomplete="off">
		</div>
	</div>

	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Start Date </label>
			<input type="text" name="date_start_edit" id="date_start_edit" class="form-control pickadate" required >
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>End Date </label>
			<input type="text" name="date_end_edit" id="date_end_edit" class="form-control pickadate" >
		</div> 
	</div>


	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Salary Start </label>
			<input type="number" name="salary_start_edit" id="salary_start_edit" class="form-control" >
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Salary End </label>
			<input type="number" name="salary_end_edit" id="salary_end_edit" class="form-control" >
		</div> 
	</div>

	<div style="clear:both;"></div>
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
	<input type="hidden" id="expid_edit" name="expid_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_exp" name="changes_exp">
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
	$("#editExp").validate({
		rules: {
             organization_edit	: "required",
			 designation_edit	: "required",
			 jobfield_edit		: "required",
			 date_start_edit	: "required"
		},
		messages: {
			organization_edit	: "This field is required",
			designation_edit	: "This field is required",
			jobfield_edit		: "This field is required",
			date_start_edit		: "This field is required"
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
    $(".edit-exp-modal").click(function(){
    

        var jobfield_edit 				= $(this).attr("data-exp-job");
		var jobdetail_edit 				= $(this).attr("data-exp-detail");
		var designation_edit 			= $(this).attr("data-exp-des");
		var organization_edit 			= $(this).attr("data-exp-org");
		var date_start_edit 			= $(this).attr("data-exp-sdate");
		var date_end_edit 				= $(this).attr("data-exp-edate");
		var salary_start_edit 			= $(this).attr("data-exp-ssalary");
		var salary_end_edit 			= $(this).attr("data-exp-esalary");
		var expid_edit 					= $(this).attr("data-expid");

		$("#jobfield_edit")				.val(jobfield_edit);
		$("#jobdetail_edit")			.val(jobdetail_edit);
		$("#designation_edit")			.val(designation_edit);
		$("#organization_edit")			.val(organization_edit);
		$("#date_start_edit")			.val(date_start_edit);
		$("#date_end_edit")				.val(date_end_edit);
		$("#salary_start_edit")			.val(salary_start_edit);
		$("#salary_end_edit")			.val(salary_end_edit);
		$("#expid_edit")				.val(expid_edit);
 
  });
    
});
</script>';