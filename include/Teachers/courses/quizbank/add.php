<?php
//------------------------------------------------
if(!isset($_GET['editid']) && isset($_GET['add'])) { 
	
	$sqllmscursrelated  = $dblms->querylms("SELECT d.id_curs, d.id_setup, c.curs_id, c.curs_code, c.curs_name, 
										p.prg_id, p.prg_name, p.prg_code, t.section, t.timing , t.semester, t.id_prg       
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs  
										LEFT JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg  
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.status = '1' AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND d.id_curs != '".cleanvars($_GET['id'])."'
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										GROUP BY d.id_curs ORDER BY t.section ASC, t.id ASC");
	$countrelted = mysqli_num_rows($sqllmscursrelated);
//------------------------------------------------
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="courses.php?id='.$_GET['id'].'&view=QuizBank" method="post" name="addquestion" id="addquestion" enctype="multipart/form-data">
<input type="hidden" name="id_curs" name="id_curs" value="'.$_GET['id'].'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=QuizBank\'"><span>close</span></button>
	<h4 class="modal-title" style="font-weight:700;">Add Question Detail</h4>
</div>

<div class="modal-body">

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Question</b></label>
		<div class="col-lg-12">
			<textarea  type="text" class="form-control ckeditor" id="question_title" name="question_title" required autofocus autocomplete="off"></textarea>
			
			
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-lg-12" style="width:250px; margin-top:10px;"><b> Attach File</b></label>
		<div class="col-lg-12">
			<input id="ques_file" name="ques_file" class="btn btn-mid btn-primary clearfix" type="file"> 
			<div style="font-weight:500; margin-top:5px;">File extension must be: (<span style="color:blue; font-weight:700;">jpg, jpeg, gif, png</span>)</div>
		</div>
	</div>

	<div style="clear:both;"></div>

	<div class="col-sm-32" style="margin-top:5px;">
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

	<div class="col-sm-32" style="margin-top:5px;">
		<div class="form_sep">
			<label class="req">Difficulty Level</label>
			<select id="question_level" name="question_level" style="width:100%" autocomplete="off" min="1" max="5" required>
			<option value="">Select</option>';
			foreach($difficultylevel as $itemlevel) {
				echo '<option value="'.$itemlevel['id'].'">'.$itemlevel['name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-32" style="margin-top:5px;">
		<div class="form_sep">
			<label class="req">Weeek # </label>
			<select id="question_weekno" name="question_weekno" style="width:100%" autocomplete="off" required>
				<option value="">Select Week</option>';
			for($iwk=1; $iwk <=50; $iwk++) { 
				$weekname = "Week: $iwk";
				echo '<option value="'.$weekname.'">'.$weekname.'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-32" style="margin-top:5px;">
		<div class="form_sep">
			<label class="req">Exam Term</label>
			<select id="question_term" name="question_term" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>
				<option value="1">Mid Term</option>
				<option value="2">Final Term</option>
			</select>
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="col-sm-61" style="margin-top:10px;">
		<div class="form_sep">
			<label class="req">Question Type</label>
			<select id="question_type" name="question_type" onchange="get_questionoption(this.value)" style="width:100%" autocomplete="off" required>
			<option value="">Select Type</option>';
			foreach($questiontype as $type) {
				if($type['id'] != '2') {
					echo "<option value='$type[id]'>$type[name]</option>";
				} 
			}
	echo'
			</select>
		</div> 
	</div>
	
<div id="getquestionoption">

	<div class="col-sm-61" style="margin-top:10px;">
		<div class="form_sep">
			<label class="req">Marks</label>
			<input type="number" class="form-control" value="" readonly id="question_marks" min="1" max="2" step="1" name="question_marks" required autocomplete="off">
		</div> 
	</div>
</div>
	
	
<div style="clear:both;"></div>';
if($countrelted>0) { 
echo '
	<div class="col-lg-12 heading-modal" style="margin-top:5px; margin-bottom:5px; font-size:13px;"> You can add the same question to the following courses.</div>
	<div style="clear:both;"></div>';
$relsr =0 ;
while($rowrelted = mysqli_fetch_array($sqllmscursrelated)){ 

$relsr++;

echo '
	<div class="form-group">	
		<div class="col-lg-12" style="margin-left:20px;font-weight:normal; color:blue;">
			<input name="idrelcurs[]" type="checkbox" id="idrelcurs'.$relsr.'" value="'.$rowrelted['id_curs'].'" class="checkbox-inline">  '.$rowrelted['curs_code'].' - '.$rowrelted['curs_name'].' 
		</div>
	</div>';
}
}
echo '

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=QuizBank\'" >Close</button>
	<input class="btn btn-primary" type="submit" value="Add Question" id="submit_question" name="submit_question">
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#question_level").select2({
        allowClear: true
	});
	$("#question_status").select2({
        allowClear: true
    });
	$("#question_type").select2({
        allowClear: true
	});
	$("#question_options").select2({
        allowClear: true
    });
	$("#question_term").select2({
        allowClear: true
    });
	
	$("#question_weekno").select2({
        allowClear: true
    });
	
	
	
</script>

<script type="text/javascript"> 

$("#ques_file").change(function () {
        var fileExtension = ["png", "jpg", "jpeg", "gif"];
        if ($.inArray($(this).val().split(\'.\').pop().toLowerCase(), fileExtension) == -1) {
            alert("Only formats are allowed : "+fileExtension.join(\', \'));
        }
    });
        $(\'#ques_file\').on(\'change\', function() { 
  
            const size = (this.files[0].size / 1024 / 1024).toFixed(2); 
  
            if (size > 2) { 
                alert("Try to upload file less than 2MB!"); 
            } else { 
                $("#output").html(\'<b>\' + \'This file size is: \' + size + " MB" + \'</b>\'); 
            } 
        }); 
    </script>

<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_ADD_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#addquestion").validate({
		rules: {
             question_status: "required",
			 question_title: "required",
			 question_type: "required",
			 question_marks: "required",
			 id_chapter: "required"
		},
		messages: {
			question_status: "This field is required",
			question_title: "This field is required",
			question_type: "This field is required",
			question_marks: "This field is required",
			id_chapter: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>
<!--WI_ADD_NEW_TASK_MODAL-->';
}
//------------------------------------------------