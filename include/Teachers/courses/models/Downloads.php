<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>

<div class="row">
<div id="cursEditDwnldModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editDwld" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Course Resources Detail</h4>
</div>

<div class="modal-body">

		<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> File Name</b></label>
		<div class="col-lg-12">
			<input type="text" name="file_name_edit" id="file_name_edit" class="form-control" required autocomplete="off" >
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px;"><b> Attach File</b></label>
		<div class="col-lg-12">
			<input id="dwnl_file" name="dwnl_file" class="btn btn-mid btn-primary clearfix" type="file">
			<div style="color:blue;padding-top: 5px !important;">Upload valiid images. Only <span style="color:red; font-weight:600;">pdf, xlsx, xls, doc, docx, ppt, pptx, png, jpg, jpeg, rar, zip</span> are allowed.</div>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Detail</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="detail_edit" name="detail_edit" style="height:70px !important;" required autocomplete="off"></textarea>
		</div>
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Open With</label>
			<select id="open_with_edit" name="open_with_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
			foreach($fileopenwith as $fileopen) {
				echo '<option value="'.$fileopen.'">'.$fileopen.'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Lecture Slides</label>
			<select id="lecture_slides_edit" name="lecture_slides_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
			foreach($statusyesno as $itemyesno) { 
				echo '<option value="'.$itemyesno['id'].'">'.$itemyesno['name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep"  style="margin-top:5px;">
			<label class="req">Status </label>
			<select id="status_edit" name="status_edit" style="width:100%" autocomplete="off" required>';
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
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
	<input type="hidden" id="dwnldid_edit" name="dwnldid_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_dwnlad" name="changes_dwnlad">
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
	$("#open_with_edit").select2({
        allowClear: true
    });
	$("#lecture_slides_edit").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript">
$().ready(function() {
	$("#editDwld").validate({
		rules: {
             status_edit			: "required",
			 file_name_edit			: "required",
			 open_with_edit			: "required"
		},
		messages: {
			status_edit				: "This field is required",
			file_name_edit			: "This field is required",
			open_with_edit			: "This field is required"
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
    $(".edit-Dwnld-modal").click(function(){
    

        var status_edit 		= $(this).attr("data-Dwnldstatus");
		var file_name_edit 		= $(this).attr("data-Dwnldfilename");
		var open_with_edit 		= $(this).attr("data-Dwnldopenwith");
		var detail_edit 		= $(this).attr("data-Dwnlddetail");
		var lecture_slides_edit = $(this).attr("data-Dwnldslides");
		var dwnldid_edit		= $(this).attr("data-Dwnldid");

		$("#file_name_edit")	.val(file_name_edit);
		$("#detail_edit")		.val(detail_edit);
		$("#dwnldid_edit")		.val(dwnldid_edit);

        $("#status_edit")			.select2().select2("val", status_edit); 
		$("#open_with_edit")		.select2().select2("val", open_with_edit); 
		$("#lecture_slides_edit")	.select2().select2("val", lecture_slides_edit); 
  });
    
});
</script>';
?>