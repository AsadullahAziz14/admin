<?php 

echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<div class="row">
<div id="cursEditDISsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editdicss" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Record</h4>
</div>

<div class="modal-body">


	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px;"><b> Student</b></label>
		<div class="col-lg-12">
			<input type="text" name="std_info_edit" id="std_info_edit" class="form-control" readonly autocomplete="off" >
		</div>
	</div>
	
	<div style="clear:both;"></div>

	<div class="col-sm-41">
		<div class="form_sep">
			<label class="req">Status </label>
			<select id="status_edit" name="status_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($onlinetatus as $itemonl) {
				echo '<option value="'.$itemonl['id'].'">'.$itemonl['name'].'</option>';
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
				echo '<option value="'.$ijr.'">'.$ijr.'</option>';
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
				echo '<option value="'.$itemyesno['id'].'">'.$itemyesno['name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px;"><b> Reply</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="reply_edit" name="reply_edit" style="height:100px !important;" autocomplete="off"></textarea>
		</div>
	</div>
	

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
	<input type="hidden" id="dscussid_edit" name="dscussid_edit" value="">
	<input type="hidden" id="noneditreply_edit" name="noneditreply_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_discussionreply" name="changes_discussionreply">
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
</script>
<script type="text/javascript">
$(document).ready(function(){
    $(".edit-discussion-modal").click(function(){
    

        var status_edit 		= $(this).attr("data-dscuss-status");
        var publish_edit 		= $(this).attr("data-dscuss-publish");
        var rating_edit 		= $(this).attr("data-dscuss-rating");
		var reply_edit 			= $(this).attr("data-dscuss-reply");
		var noneditreply_edit 	= $(this).attr("data-dscuss-noneditreply");
		var std_info_edit 		= $(this).attr("data-dscuss-stdinfo");
		var dscussid_edit		= $(this).attr("data-dscussid");

		$("#std_info_edit")		.val(std_info_edit);
		$("#reply_edit")		.val(reply_edit);
		$("#noneditreply_edit")	.val(noneditreply_edit);
		$("#dscussid_edit")		.val(dscussid_edit);
		
		
        $("#status_edit")		.select2().select2("val", status_edit);
        $("#publish_edit")		.select2().select2("val", publish_edit);
        $("#rating_edit")		.select2().select2("val", rating_edit);
  });
    
});
</script>';
?>