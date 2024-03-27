<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="empNewMemModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="profile.php?view=membership" method="post" id="addmem" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Membership Detail</h4>
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
			<label class="req">Designation</label>
			<input type="text" name="designation" id="designation" class="form-control" required >
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Membership #</label>
			<input type="text" name="memno" id="memno" class="form-control" required >
		</div> 
	</div>

	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Start Date </label>
			<input type="text" name="startdate" id="startdate" class="form-control pickadate" required >
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>End Date </label>
			<input type="text" name="enddate" id="enddate" class="form-control pickadate" >
		</div> 
	</div>

	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
		<input class="btn btn-primary" type="submit" value="Add Record" id="submit_mem" name="submit_mem">
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
	$("#addmem").validate({
		rules: {
             organization	: "required",
			 designation	: "required",
			 memno			: "required",
			 startdate		: "required"
		},
		messages: {
			organization	: "This field is required",
			designation		: "This field is required",
			memno			: "This field is required",
			startdate		: "This field is required"
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
<div id="empEditMemModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="profile.php?view=membership" method="post" id="editMem" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Membership Detail</h4>
</div>

<div class="modal-body">


	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Organization</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="organization_edit" name="organization_edit" required autofocus autocomplete="off">
		</div>
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Designation</label>
			<input type="text" name="designation_edit" id="designation_edit" class="form-control" required >
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Membership #</label>
			<input type="text" name="memno_edit" id="memno_edit" class="form-control" required >
		</div> 
	</div>

	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Start Date </label>
			<input type="text" name="startdate_edit" id="startdate_edit" class="form-control pickadate" required >
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>End Date </label>
			<input type="text" name="enddate_edit" id="enddate_edit" class="form-control pickadate" >
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
	<input type="hidden" id="memid_edit" name="memid_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_mem" name="changes_mem">
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
	$("#editMem").validate({
		rules: {
             organization_edit	: "required",
			 designation_edit	: "required",
			 memno_edit			: "required",
			 startdate_edit		: "required"
		},
		messages: {
			organization_edit	: "This field is required",
			designation_edit	: "This field is required",
			memno_edit			: "This field is required",
			startdate_edit		: "This field is required"
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
    $(".edit-mem-modal").click(function(){
    

        var memno_edit 				= $(this).attr("data-mem-no");
		var designation_edit 		= $(this).attr("data-mem-des");
		var organization_edit 		= $(this).attr("data-mem-org");
		var startdate_edit 			= $(this).attr("data-mem-sdate");
		var enddate_edit 			= $(this).attr("data-mem-edate");
		var memid_edit 				= $(this).attr("data-memid");

		$("#memno_edit")			.val(memno_edit);
		$("#designation_edit")		.val(designation_edit);
		$("#organization_edit")		.val(organization_edit);
		$("#startdate_edit")		.val(startdate_edit);
		$("#enddate_edit")			.val(enddate_edit);
		$("#memid_edit")			.val(memid_edit);
 
  });
    
});
</script>';