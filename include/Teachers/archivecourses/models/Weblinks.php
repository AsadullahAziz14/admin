<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="cursAddWeblinkModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="addWeblink" enctype="multipart/form-data">
<input type="hidden" name="id_curs" name="id_curs" value="'.$_GET['id'].'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Web Link</h4>
</div>

<div class="modal-body">

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> URL</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="url" name="url" required autofocus autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Detail</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="detail" name="detail" required autocomplete="off"></textarea>
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
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
		<input class="btn btn-primary" type="submit" value="Add Record" id="submit_weblink" name="submit_weblink">
	</button>
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
	$("#addWeblink").validate({
		rules: {
             status		: "required",
			 url		: "required",
			 detail		: "required"
		},
		messages: {
			status		: "This field is required",
			url			: "This field is required",
			detail		: "This field is required" 
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
<div id="cursEditWeblinkModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editWeblink" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Web Link</h4>
</div>

<div class="modal-body">

		<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> URL</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="url_edit" name="url_edit" required autofocus autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Detail</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="detail_edit" name="detail_edit" required autocomplete="off"></textarea>
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
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
	<input type="hidden" id="weblid_edit" name="weblid_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_weblink" name="changes_weblink">
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
	$("#editWeblink").validate({
		rules: {
             status_edit		: "required",
			 url_edit			: "required",
			 detail_edit		: "required",
			 institute_edit		: "required"
		},
		messages: {
			status_edit			: "This field is required",
			url_edit			: "This field is required",
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
    $(".edit-weblink-modal").click(function(){
    

        var status_edit 		= $(this).attr("data-weblink-status");
		var detail_edit 		= $(this).attr("data-weblink-detail");
		var url_edit 			= $(this).attr("data-weblink-url");
		var weblid_edit			= $(this).attr("data-weblid");

		$("#url_edit")			.val(url_edit);
		$("#detail_edit")		.val(detail_edit);
		$("#weblid_edit")		.val(weblid_edit);
        $("#status_edit")		.select2().select2("val", status_edit); 
  });
    
});
</script>';
?>