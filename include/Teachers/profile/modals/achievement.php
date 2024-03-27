<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="empNewAchModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="profile.php?view=achievement" method="post" id="addach" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Achievement Detail</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Title</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="title" name="title" autocomplete="off" required>
		</div>
	</div>
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"><b> Dated</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control pickadate" id="dated" name="dated" autocomplete="off" required>
		</div>
	</div>
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"><b> Details</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="detail" name="detail" autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Organization</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="organization" name="organization" required autocomplete="off">
		</div>
	</div>
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
		<input class="btn btn-primary" type="submit" value="Add Record" id="submit_achi" name="submit_achi">
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
	$("#addach").validate({
		rules: {
             organization	: "required",
			 title			: "required",
			 dated			: "required"
		},
		messages: {
			organization	: "This field is required",
			title			: "This field is required",
			dated		: "This field is required"
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
<div id="empEditAchModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="profile.php?view=achievement" method="post" id="editAch" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Achievement Detail</h4>
</div>

<div class="modal-body">
		
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Title</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="title_edit" name="title_edit" autocomplete="off" required>
		</div>
	</div>
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"><b> Dated</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control pickadate" id="dated_edit" name="dated_edit" autocomplete="off" required>
		</div>
	</div>
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"><b> Details</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="detail_edit" name="detail_edit" autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Organization</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="organization_edit" name="organization_edit" required autocomplete="off">
		</div>
	</div>
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
	<input type="hidden" id="achid_edit" name="achid_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_achi" name="changes_achi">
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
	$("#editAch").validate({
		rules: {
            rules: {
             organization_edit	: "required",
			 title_edit			: "required",
			 dated_edit			: "required"
		},
		messages: {
			organization_edit	: "This field is required",
			title_edit			: "This field is required",
			dated_edit			: "This field is required"
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
    $(".edit-ach-modal").click(function(){
    

        var title_edit 					= $(this).attr("data-ach-title");
		var detail_edit 				= $(this).attr("data-ach-detail");
		var organization_edit 			= $(this).attr("data-ach-org");
		var dated_edit 					= $(this).attr("data-ach-dated");
		var achid_edit 					= $(this).attr("data-achid");

		$("#title_edit")				.val(title_edit);
		$("#detail_edit")				.val(detail_edit);
		$("#organization_edit")			.val(organization_edit);
		$("#dated_edit")				.val(dated_edit);
		$("#achid_edit")				.val(achid_edit);
 
  });
    
});
</script>';