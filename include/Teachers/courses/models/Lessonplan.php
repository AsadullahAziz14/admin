<?php 

echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<div class="row">
<div id="cursEditLessonModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editLesson" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Weekly Lesson Plan Detail</h4>
</div>

<div class="modal-body">

<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Weeek # </label>
			<select id="weekno_edit" name="weekno_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Week</option>';
			for($iwke=1; $iwke <=50; $iwke++) {
				echo '<option value="Week: '.$iwke.'">Week: '.$iwke.'</option>';
			}
	echo'
			</select>
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Status</label>
			<select id="status_edit" name="status_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
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
	<input type="hidden" id="lessonid_edit" name="lessonid_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_lesson" name="changes_lesson">
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
	$("#weekno_edit").select2({
        allowClear: true
    });
	
	
</script>
<script type="text/javascript">
$().ready(function() {
	$("#editLesson").validate({
		rules: {
             status_edit			: "required",
			 weekno_edit			: "required",
			 detail_edit			: "required"
			 
		},
		messages: {
			status_edit			: "This field is required",
			weekno_edit			: "This field is required",
			date_start_edit		: "This field is required",
			date_end_edit		: "This field is required",
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
    $(".edit-lesson-modal").click(function(){
    

        var status_edit 			= $(this).attr("data-lessonstatus");
		var weekno_edit 			= $(this).attr("data-lessonweekno");
		var detail_edit 			= $(this).attr("data-lessondetail");
		var lessonid_edit			= $(this).attr("data-lessonid");

		$("#detail_edit")			.val(detail_edit);
		$("#lessonid_edit")			.val(lessonid_edit);
        $("#status_edit")			.select2().select2("val", status_edit); 
		$("#weekno_edit")			.select2().select2("val", weekno_edit); 
  });
    
});
</script>';
?>