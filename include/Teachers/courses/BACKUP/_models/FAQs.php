<?php 
	$sqllmscursrelated  = $dblms->querylms("SELECT DISTINCT(t.id_prg), d.id_setup, 
										p.prg_id, p.prg_name, p.prg_code, t.section, t.timing , t.semester  
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										INNER JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND d.id_curs = '".cleanvars($_GET['id'])."' AND t.status =  '1'");
	$countrelted = mysqli_num_rows($sqllmscursrelated);
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="cursAddFAQsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="addFaqs" enctype="multipart/form-data">
<input type="hidden" name="id_curs" name="id_curs" value="'.$_GET['id'].'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add FAQs</h4>
</div>

<div class="modal-body">

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> FAQs</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="question" name="question" required autofocus autocomplete="off" OnSubmit="return CheckForm();">
		</div>
	</div>

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Answer</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="answer" name="answer" required autocomplete="off"></textarea>
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
	<div style="clear:both;"></div>';
if($countrelted>0) { 
echo '
	<div class="col-lg-12 heading-modal" style="margin-top:5px; margin-bottom:5px;"> You can add in related program you are teaching.</div>
	<div style="clear:both;"></div>';
$relsr =0 ;
while($rowrelted = mysqli_fetch_array($sqllmscursrelated)){ 
if($rowrelted['section']) { 
	$sectionrel 	= 'Section: '.$rowrelted['section'];
} else  { 
	$sectionrel 	= '';
	$checkrel		= "";
}
$relsr++;


echo '
	<div class="form-group">	
		<div class="col-lg-12" style="margin-left:20px;font-weight:normal; color:blue;">
			<input name="relidprg[]" type="checkbox" id="relidprg'.$relsr.'" value="'.$rowrelted['id_prg'].'" class="checkbox-inline" checked>  '.$rowrelted['prg_name'].' ('.get_programtiming($rowrelted['timing']).')  Semester: '.addOrdinalNumberSuffix($rowrelted['semester']).' '.$sectionrel.'
		</div>
	</div>
	<input type="hidden" name="relsemester[]" id="relsemester['.$relsr.']" value="'.$rowrelted['semester'].'">
	<input type="hidden" name="reltiming[]" id="reltiming['.$relsr.']" value="'.$rowrelted['timing'].'">
	<input type="hidden" name="relsection[]" id="relsection['.$relsr.']" value="'.$rowrelted['section'].'">';
}
}
echo '

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
		<input class="btn btn-primary" type="submit" value="Add Record" id="submit_faqs" name="submit_faqs">
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
function CheckForm(){
	var checked=false;
	var elements = document.getElementsByName("relidprg[]");
	for(var i=0; i < elements.length; i++){
		if(elements[i].checked) {
			checked = true;
		}
	}
	if (!checked) {
		alert("at least one Program should be selected");
		return checked;
	} else  {  
		return true;  
	}  
}
</script>

<!--WI_ADD_NEW_TASK_MODAL-->

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
			<textarea class="form-control" id="answer_edit" name="answer_edit" required autocomplete="off"></textarea>
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