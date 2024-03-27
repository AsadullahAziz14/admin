<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="empNewTrnModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="profile.php?view=training" method="post" id="addtrn" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Training Detail</h4>
</div>

<div class="modal-body">

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Job Field </label>
			<input type="text" name="jobfield" id="jobfield" class="form-control" required autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Course</label>
			<input type="text" name="course" id="course" class="form-control" required autocomplete="off">
		</div> 
	</div>

	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Start Date </label>
			<input type="text" name="date_start" id="date_start" class="form-control pickadate" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">End Date </label>
			<input type="text" name="date_end" id="date_end" required class="form-control pickadate" autocomplete="off" >
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Organization</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="organization" name="organization" required autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"><b> Address</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="address" name="address" autocomplete="off">
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
		<input class="btn btn-primary" type="submit" value="Add Record" id="submit_training" name="submit_training">
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
	$("#addtrn").validate({
		rules: {
             organization	: "required",
			 course			: "required",
			 jobfield		: "required",
			 date_start		: "required",
			 date_end		: "required"
		},
		messages: {
			organization	: "This field is required",
			course			: "This field is required",
			jobfield		: "This field is required",
			date_start		: "This field is required",
			date_end		: "This field is required"
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
<div id="empEditTrnModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="profile.php?view=training" method="post" id="editTrn" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Training Detail</h4>
</div>

<div class="modal-body">
		
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Job Field </label>
			<input type="text" name="jobfield_edit" id="jobfield_edit" class="form-control" required autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Course</label>
			<input type="text" name="course_edit" id="course_edit" class="form-control" required autocomplete="off">
		</div> 
	</div>

	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Start Date </label>
			<input type="text" name="date_start_edit" id="date_start_edit" class="form-control pickadate" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">End Date </label>
			<input type="text" name="date_end_edit" id="date_end_edit" required class="form-control pickadate" autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Organization</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="organization_edit" name="organization_edit"_edit required autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"><b> Address</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="address_edit" name="address_edit" autocomplete="off">
		</div>
	</div>
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
	<input type="hidden" id="trnid_edit" name="trnid_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_training" name="changes_training">
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
	$("#editTrn").validate({
		rules: {
             organization_edit	: "required",
			 course_edit		: "required",
			 jobfield_edit		: "required",
			 date_start_edit	: "required",
			 date_end_edit		: "required"
		},
		messages: {
			organization_edit	: "This field is required",
			course_edit			: "This field is required",
			jobfield_edit		: "This field is required",
			date_start_edit		: "This field is required",
			date_end_edit		: "This field is required"
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
    $(".edit-trn-modal").click(function(){
    

        var jobfield_edit 				= $(this).attr("data-trn-job");
		var address_edit 				= $(this).attr("data-trn-address");
		var course_edit 				= $(this).attr("data-trn-curs");
		var organization_edit 			= $(this).attr("data-trn-org");
		var date_start_edit 			= $(this).attr("data-trn-sdate");
		var date_end_edit 				= $(this).attr("data-trn-edate");
		var trnid_edit 					= $(this).attr("data-trnid");

		$("#jobfield_edit")				.val(jobfield_edit);
		$("#address_edit")				.val(address_edit);
		$("#course_edit")				.val(course_edit);
		$("#organization_edit")			.val(organization_edit);
		$("#date_start_edit")			.val(date_start_edit);
		$("#date_end_edit")				.val(date_end_edit);
		$("#trnid_edit")				.val(trnid_edit);
 
  });
    
});
</script>';