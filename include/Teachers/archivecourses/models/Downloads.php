<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="cursAddDwnldModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="addDwld" enctype="multipart/form-data">
<input type="hidden" name="id_curs" name="id_curs" value="'.$_GET['id'].'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Download Detail</h4>
</div>

<div class="modal-body">

		
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> File Name</b></label>
		<div class="col-lg-12">
			<input type="text" name="file_name" id="file_name" class="form-control" required autocomplete="off" >
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Attach File</b></label>
		<div class="col-lg-12">
			<input id="dwnl_file" name="dwnl_file" class="btn btn-mid btn-primary clearfix" required type="file"> 
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Detail</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="detail" name="detail" required autocomplete="off"></textarea>
		</div>
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Open With</label>
			<select id="open_with" name="open_with" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
			foreach($fileopenwith as $fileopen) {
				echo '<option value="'.$fileopen.'">'.$fileopen.'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep"  style="margin-top:5px;">
			<label class="req">Status </label>
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
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
		<input class="btn btn-primary" type="submit" value="Add Record" id="submit_dwnlad" name="submit_dwnlad">
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
	$("#open_with").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addDwld").validate({
		rules: {
             status			: "required",
			 file_name		: "required",
			 dwnl_file	: "required"
		},
		messages: {
			status			: "This field is required",
			file_name		: "This field is required",
			dwnl_file		: "This field is required" 
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
<div id="cursEditDwnldModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editDwld" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Download Detail</h4>
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
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Detail</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="detail_edit" name="detail_edit" required autocomplete="off"></textarea>
		</div>
	</div>
	
	<div class="col-sm-61">
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
	
	<div class="col-sm-61">
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
		var dwnldid_edit		= $(this).attr("data-Dwnldid");

		$("#file_name_edit")	.val(file_name_edit);
		$("#detail_edit")		.val(detail_edit);
		$("#dwnldid_edit")		.val(dwnldid_edit);

        $("#status_edit")		.select2().select2("val", status_edit); 
		$("#open_with_edit")	.select2().select2("val", open_with_edit); 
  });
    
});
</script>';
?>