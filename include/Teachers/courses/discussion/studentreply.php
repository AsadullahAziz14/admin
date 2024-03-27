<?php 
//-----------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && isset($_GET['replyid']) && !isset($_GET['topicid'])) { 
	$sqllmsdiss  = $dblms->querylms("SELECT ds.id, ds.status, ds.publish, ds.message, ds.reply, ds.rating, ds.id_topic, 
											ds.date_added, ds.reply_date, ds.reply_id, std.std_id, std.std_name, 
											std.std_semester, std.std_regno, std.std_photo,std.std_rollno, std.std_session   
											FROM ".COURSES_DISCUSSION." ds   
											INNER JOIN ".STUDENTS." std ON std.std_id = ds.id_std  
											WHERE ds.id = '".cleanvars($_GET['replyid'])."' ");
	$countdiss 	= mysqli_num_rows($sqllmsdiss);
	$itemstd 	= mysqli_fetch_array($sqllmsdiss);

echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<div class="row">
<div class="modal-dialog" style="width:80%;">
<form class="form-horizontal" action="courses.php?id='.$_GET['id'].'&view=Discussion&topicid='.$itemstd['id_topic'].'" method="post" id="editdicss" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=Discussion\'"><span>close</span></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Record</h4>
</div>

<div class="modal-body">


	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px;"><b> Student</b></label>
		<div class="col-lg-12">
			<input type="text" name="std_info_edit" id="std_info_edit" value="'.$itemstd['std_rollno'].' - '.$itemstd['std_name'].' ('.$itemstd['std_semester'].')" class="form-control" readonly autocomplete="off" >
		</div>
	</div>
	
	<div style="clear:both;"></div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Status </label>
			<select id="status_edit" name="status_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($discussionstatus as $itemd) { 
				if($itemstd['status'] == $itemd['id']) {
					echo '<option value="'.$itemd['id'].'" selected>'.$itemd['name'].'</option>';
				} else {
					echo '<option value="'.$itemd['id'].'">'.$itemd['name'].'</option>';
				}
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep">
			<label>Rating</label>
			<select id="rating_edit" name="rating_edit" style="width:100%" autocomplete="off">
				<option value="">Select Rating</option>';
			for($ijr=0; $ijr<=5; $ijr++) { 
				if($itemstd['rating'] == $ijr) {
					echo '<option value="'.$ijr.'" selected>'.$ijr.'</option>';
				} else {
					echo '<option value="'.$ijr.'">'.$ijr.'</option>';
				}
				
			}
	echo'
			</select>
		</div> 
	</div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label>Publish</label>
			<select id="publish_edit" name="publish_edit" style="width:100%" autocomplete="off">
				<option value="">Select Publish</option>';
			foreach($statusyesno as $itemyesno) { 
				if($itemstd['publish'] == $itemyesno['id']) {
					echo '<option value="'.$itemyesno['id'].'" selected>'.$itemyesno['name'].'</option>';
				} else {
					echo '<option value="'.$itemyesno['id'].'">'.$itemyesno['name'].'</option>';
				}
				
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px;"><b> Reply</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="reply_edit" name="reply_edit" style="height:100px !important;" autocomplete="off">'.$itemstd['reply'].'</textarea>
		</div>
	</div>
	

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=Discussion\'" >Close</button> 
	<input type="hidden" id="dscussid_edit" name="dscussid_edit" value="'.$itemstd['id'].'">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_discussionreply" name="changes_discussionreply">
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#status_edit").select2({
        allowClear: true
    });
	$("#publish_edit").select2({
        allowClear: true
    });
	$("#rating_edit").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#editdicss").validate({
		rules: {
             status_edit		: "required",
			 caption_edit		: "required",
			 detail_edit		: "required",
			 institute_edit		: "required"
		},
		messages: {
			status_edit			: "This field is required",
			caption_edit		: "This field is required",
			detail_edit			: "This field is required"
		},
		submitHandler: function(form) {
        //alert("form submitted");
		form.submit();
        }
	});
});
</script>';
}