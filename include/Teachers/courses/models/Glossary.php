<?php 


echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>

<div class="row">
<div id="cursEditGlosryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editGlosry" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Glossary Detail</h4>
</div>

<div class="modal-body">

		<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Caption</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="caption_edit" name="caption_edit" required autofocus autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Detail</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="detail_edit" name="detail_edit" style="height:50px !important;" required autocomplete="off"></textarea>
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
	<input type="hidden" id="glosryid_edit" name="glosryid_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_glossary" name="changes_glossary">
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
	$("#editGlosry").validate({
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
    $(".edit-glsry-modal").click(function(){
    

        var status_edit 		= $(this).attr("data-glsry-status");
		var detail_edit 		= $(this).attr("data-glsry-detail");
		var caption_edit 		= $(this).attr("data-glsry-caption");
		var glosryid_edit		= $(this).attr("data-glsryid");

		$("#caption_edit")		.val(caption_edit);
		$("#detail_edit")		.val(detail_edit);
		$("#glosryid_edit")		.val(glosryid_edit);
        $("#status_edit")		.select2().select2("val", status_edit); 
  });
    
});
</script>';
?>