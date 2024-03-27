<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>

<div class="row">
<div id="cursEditQuizModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editAssign" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Question Detail</h4>
</div>

<div class="modal-body">

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Title</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="question_title_edit" name="question_title_edit" required autofocus autocomplete="off">
		</div>
	</div>

	<div style="clear:both;"></div>

	<div class="col-sm-61" style="margin-top:5px;">
		<div class="form_sep">
			<label class="req">Status</label>
			<select id="question_status" name="question_status" style="width:100%" autocomplete="off" required>';
			foreach($admstatus as $itemadm_status) {
				echo "<option value='$itemadm_status[status_id]'>$itemadm_status[status_name]</option>";
			}
		echo'
			</select>
		</div> 
	</div>

	<div class="col-sm-61" style="margin-top:5px;">
		<div class="form_sep">
			<label class="req">Chapter</label>
			<select id="id_chapter" name="id_chapter" style="width:100%" autocomplete="off" required>';
			for($i=1; $i<=20; $i++) {
				echo '<option value="'.$i.'">Chapter '.$i.'</option>';
			}
		echo'
			</select>
		</div> 
	</div>

	<div style="clear:both;"></div>

	<div class="col-sm-61" style="margin-top:5px;">
		<div class="form_sep">
			<label class="req">Type</label>
			<select id="question_type" name="question_type" style="width:100%" autocomplete="off" required>';
			foreach($questiontype as $type) {
				echo "<option value='$type[id]'>$type[name]</option>";
			}
		echo'
			</select>
		</div> 
	</div>

	<div class="col-sm-61" style="margin-top:5px;">
		<div class="form_sep">
			<label class="req">Options</label>
			<select id="question_options" name="question_options" style="width:100%" autocomplete="off" required>
			<option value="">Select</option>';
			for($i=1; $i<=4; $i++) {
				echo '<option value="'.$i.'">'.$i.'</option>';
			}
		echo'
			</select>
		</div> 
	</div>

	<div style="clear:both;"></div>
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
	<input type="hidden" id="questionid_edit" name="questionid_edit" value="">changes_question
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_question" name="changes_question">
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
	$("#editAssign").validate({
		rules: {
             status_edit			: "required",
			 caption_edit			: "required",
			 date_start_edit		: "required",
			 date_end_edit			: "required",
			 detail_edit			: "required" ,
			 total_marks_edit: {
                required: true,
                number: true
            },
			passing_marks_edit: {
                required: true,
                number: true
            }
		},
		messages: {
			status_edit			: "This field is required",
			caption_edit		: "This field is required",
			date_start_edit		: "This field is required",
			date_end_edit		: "This field is required",
			detail_edit			: "This field is required" ,
			total_marks_edit: {
                required: "Please enter Total Marks",
                number: "Please enter only numeric value"
            },
			passing_marks_edit: {
                required: "Please enter Passing Marks",
                number: "Please enter only numeric value"
            }
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
    $(".edit-assignment-modal").click(function(){

        var quiz_status_edit 		= $(this).attr("data-status");
		var quiz_title_edit 		= $(this).attr("data-title");
		var quiz_startdate_edit 	= $(this).attr("data-start");
		var quiz_enddate_edit 		= $(this).attr("data-end");
		var quiz_term_edit 			= $(this).attr("data-term");
		var quiz_questions_edit 	= $(this).attr("data-question");
		var quiz_time_edit 			= $(this).attr("data-time");
		var quiz_totalmarks_edit 	= $(this).attr("data-totalmarks");
		var quiz_passingmarks_edit 	= $(this).attr("data-passingmarks");
		var quizid_edit				= $(this).attr("data-quizid");

		$("#quiz_title_edit")			.val(quiz_title_edit);
		$("#quiz_startdate_edit")		.val(quiz_startdate_edit);
		$("#quiz_enddate_edit")			.val(quiz_enddate_edit);
		$("#quiz_questions_edit")		.val(quiz_questions_edit);
		$("#quiz_time_edit")			.val(quiz_time_edit);
		$("#quiz_totalmarks_edit")		.val(quiz_totalmarks_edit);
		$("#quiz_passingmarks_edit")	.val(quiz_passingmarks_edit);
		$("#quizid_edit")				.val(quizid_edit);
        $("#quiz_status_edit")			.select2().select2("val", quiz_status_edit);
        $("#quiz_term_edit")			.select2().select2("val", quiz_term_edit);
  });
});
</script>';
?>