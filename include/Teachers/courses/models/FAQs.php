<?php 

echo '

<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<div class="row">
<div id="cursEditFAQsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editFaqs" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit FAQs Detail</h4>
</div>

<div class="modal-body">

		<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> FAQs</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="question_edit" name="question_edit" required autofocus autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Answer</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="answer_edit" name="answer_edit" style="height:70px !important;" required autocomplete="off"></textarea>
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
	<input type="hidden" id="faqsid_edit" name="faqsid_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_faqs" name="changes_faqs">
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#id_degree_edit").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#editFaqs").validate({
		rules: {
             status_edit		: "required",
			 question_edit		: "required",
			 answer_edit		: "required",
			 institute_edit		: "required"
		},
		messages: {
			status_edit			: "This field is required",
			question_edit		: "This field is required",
			answer_edit			: "This field is required"
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
    $(".edit-faqs-modal").click(function(){
    

        var status_edit 		= $(this).attr("data-faqs-status");
		var answer_edit 		= $(this).attr("data-faqs-answer");
		var question_edit 		= $(this).attr("data-faqs-question");
		var faqsid_edit			= $(this).attr("data-faqid");

		$("#question_edit")		.val(question_edit);
		$("#answer_edit")		.val(answer_edit);
		$("#faqsid_edit")		.val(faqsid_edit);
        $("#status_edit")		.select2().select2("val", status_edit); 
  });
    
});
</script>';
?>