<?php 

//------------------------------------------------
if(!isset($_GET['editid']) && isset($_GET['add']) && !isset($_GET['archive'])) { 
	
header("Location:courses.php?id=".$_GET['id']."&view=Drivelinks", true, 301);
exit();
//------------------------------------------------
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="courses.php?id='.$_GET['id'].'&view=Drivelinks" method="post" id="Drivelinks" enctype="multipart/form-data">
<input type="hidden" name="id_curs" name="id_curs" value="'.$_GET['id'].'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=Weblinks\'"><span>close</span></button>
	<h4 class="modal-title" style="font-weight:700;">Add Drive Link Detail</h4>
</div>

<div class="modal-body">
	
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Title</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="caption" name="caption" required autofocus autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Drive Link</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="drive_link" name="drive_link" required autocomplete="off" style="height:70px !important;"></textarea>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Status</b></label>
		<div class="col-lg-12">
			<select id="status" name="status" style="width:100%" autocomplete="off" required>';
			foreach($admstatus as $itemadm_status) {
				echo "<option value='$itemadm_status[status_id]'>$itemadm_status[status_name]</option>";
			}
	echo'
			</select>
		</div>
	</div>
	<div style="clear:both;"></div>


</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=Drivelinks\'" >Close</button>
	<input class="btn btn-primary" type="submit" value="Add Record" id="submit_drivelinks" name="submit_drivelinks">
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#status").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_ADD_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#Drivelinks").validate({
		rules: {
             caption			: "required",
			 drive_link			: "required"
		},
		messages: {
			caption				: "This field is required",
			drive_link			: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
} 
//------------------------------------------------