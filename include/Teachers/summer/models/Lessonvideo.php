<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="cursAddVideoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="addvideo" name="addvideo" enctype="multipart/form-data">
<input type="hidden" name="id_curs" name="id_curs" value="'.$_GET['id'].'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Video Lesson</h4>
</div>

<div class="modal-body">

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Title</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="caption" name="caption" required autofocus autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Embed Video</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="embedcode" name="embedcode" required autocomplete="off"></textarea>
		</div>
	</div>
	

	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px;"><b> Detail</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="detail" name="detail" autocomplete="off"></textarea>
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

</div>

<div class="modal-footer">
	<input class="btn btn-primary" type="submit" value="Add Record" id="submit_video" name="submit_video">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
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
	$("#addvideo").validate({
		rules: {
             status		: "required",
			 caption	: "required",
			 embedcode	: "required"
		},
		messages: {
			status		: "This field is required",
			caption		: "This field is required",
			embedcode	: "This field is required" 
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
<div id="cursEditVideoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editVideo" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Video Lesson</h4>
</div>

<div class="modal-body">

		<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Title</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="caption_edit" name="caption_edit" required autofocus autocomplete="off">
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Embed Video</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="embedcode_edit" name="embedcode_edit" required autocomplete="off"></textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px;"><b> Detail</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="detail_edit" name="detail_edit" autocomplete="off"></textarea>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Status</b></label>
		<div class="col-lg-12">
			<select id="status_edit" name="status_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadm_status) {
				echo "<option value='$itemadm_status[status_id]'>$itemadm_status[status_name]</option>";
			}
	echo'
			</select>
		</div>
	</div>

</div>

<div class="modal-footer">
	<input type="hidden" id="videoid_edit" name="videoid_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_video" name="changes_video">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button> 
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#status_edit").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#editVideo").validate({
		rules: {
             status_edit		: "required",
			 caption_edit		: "required",
			 embedcode_edit		: "required"
		},
		messages: {
			status_edit			: "This field is required",
			caption_edit		: "This field is required",
			embedcode_edit		: "This field is required"
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
    $(".edit-lessonvideo-modal").click(function(){
    

        var status_edit 		= $(this).attr("data-video-status");
		var detail_edit 		= $(this).attr("data-video-detail");
		var caption_edit 		= $(this).attr("data-video-caption");
		var embedcode_edit 		= $(this).attr("data-video-embed");
		var videoid_edit		= $(this).attr("data-videoid");

		$("#caption_edit")		.val(caption_edit);
		$("#detail_edit")		.val(detail_edit);
		$("#embedcode_edit")	.val(embedcode_edit);
		$("#videoid_edit")		.val(videoid_edit);
        $("#status_edit")		.select2().select2("val", status_edit); 
  });
    
});
</script>';
?>