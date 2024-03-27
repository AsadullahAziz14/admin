<?php 

//------------------------------------------------
if(isset($_GET['editid']) && !isset($_GET['add']) && !isset($_GET['archive'])) { 
//------------------------------------------------
	$sqllmslesson  = $dblms->querylms("SELECT *   
										FROM ".COURSES_ASSIGNMENTS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND id = '".cleanvars($_GET['editid'])."' LIMIT 1");
	$rowlesson = mysqli_fetch_assoc($sqllmslesson);
	
if($rowlesson['is_midterm'] == 1) {
	
	echo "
<div class=\"col-lg-12\">
	<div class=\"widget-tabs-notification\">
	<div style=\"font-weight:700;margin-top:5px; font-size:16px; color:#f00; text-align:center;\">You have no rights to edit this assignment.</div>
	</div>
</div>";
	

	
} else {
	$sqllmscursrelated  = $dblms->querylms("SELECT DISTINCT(t.id_prg), d.id_curs, d.id_setup, 
										p.prg_id, p.prg_name, p.prg_code, t.section, t.timing , t.semester, c.is_obe 
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup  
										INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs   
										LEFT JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND d.id_curs = '".cleanvars($_GET['id'])."' AND t.status =  '1'");
	$countrelted = mysqli_num_rows($sqllmscursrelated);	
	$relsr =0 ;
	while($rowrelted = mysqli_fetch_array($sqllmscursrelated)){ 
		$relsr++;
		if($rowrelted['section']) { 
			$sectionrel 	= ' Section: '.$rowrelted['section'];
		} else  { 
			$sectionrel 	= '';
			$checkrel		= "";
		}
		
		if($rowrelted['prg_name']) {
			$prgname = $rowrelted['prg_name'].' ('.get_programtiming($rowrelted['timing']).')  Semester: '.addOrdinalNumberSuffix($rowrelted['semester']).' '.$sectionrel;
		} else {
			$prgname = 'LA: '.get_programtiming($rowrelted['timing']).$sectionrel;
		}


		$sqllmslessonprgs  = $dblms->querylms("SELECT clp.id, clp.id_prg, clp.id_setup, clp.semester, clp.section, clp.timing 
											FROM ".COURSES_ASSIGNMENTSPROGRAM." clp 
											WHERE clp.id_setup = '".cleanvars($rowlesson['id'])."' 
											AND clp.id_prg = '".cleanvars($rowrelted['id_prg'])."' 
											AND clp.semester = '".cleanvars($rowrelted['semester'])."'
											AND clp.timing = '".cleanvars($rowrelted['timing'])."'
											AND clp.section = '".cleanvars($rowrelted['section'])."' LIMIT 1 ");
		//-----------------------------------------------
		if(mysqli_num_rows($sqllmslessonprgs)>0) { 
			$prgchecked = " checked";
		} else { 
			$prgchecked = "";
		}
//------------------------------------------------	
	$sqllmscursobe  = $dblms->querylms("SELECT DISTINCT(d.id_curs), c.is_obe 
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup  
										INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs   
										LEFT JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND d.id_curs = '".cleanvars($_GET['id'])."' AND t.status =  '1'");	
//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="courses.php?id='.$_GET['id'].'&view=Assignments" method="post" id="addLesson" enctype="multipart/form-data" OnSubmit="return CheckForm();">
<input type="hidden" name="editid" id="editid" value="'.cleanvars($_GET['editid']).'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=Assignments\'"><span>close</span></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Assignment Detail</h4>
</div>

<div class="modal-body">

	
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Title </label>
			<input type="text" name="caption" id="caption" class="form-control" required autocomplete="off" value="'.$rowlesson['caption'].'" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Status</label>
			<select id="status" name="status" style="width:100%" autocomplete="off" required>';
			foreach($admstatus as $itemadm_status) { 
				if($rowlesson['status'] == $itemadm_status['status_id']) { 
					echo '<option value="'.$itemadm_status['status_id'].'" selected>'.$itemadm_status['status_name'].'</option>';
				} else { 
					echo '<option value="'.$itemadm_status['status_id'].'">'.$itemadm_status['status_name'].'</option>';
				}
			}
			echo'
			</select>
		</div> 
	</div>
	<div style="clear:both;"></div>
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Detail</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="detail" name="detail" required autocomplete="off" style="height:100px !important;">'.$rowlesson['detail'].'</textarea>
		</div>
	</div>
		
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Start Date </label>
			<input type="text" name="date_start" id="date_start" class="form-control pickadate" required autocomplete="off" value="'.$rowlesson['date_start'].'" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">End Date</label>
			<input type="text" name="date_end" id="date_end" class="form-control pickadate" required autocomplete="off" value="'.$rowlesson['date_end'].'" >
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Total Marks </label>
			<input type="text" name="total_marks" min="1" id="total_marks" required class="form-control" autocomplete="off" value="'.$rowlesson['total_marks'].'"  onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"  >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Passing Marks</label>
			<input type="text" name="passing_marks" id="passing_marks" class="form-control" autocomplete="off" value="'.$rowlesson['passing_marks'].'"  onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"  >
		</div> 
	</div>
	<div style="clear:both;"></div>
	';
	$sqllmscursobe  = $dblms->querylms("SELECT DISTINCT(d.id_curs), c.is_obe 
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup  
										INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs   
										LEFT JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND d.id_curs = '".cleanvars($_GET['id'])."' AND t.status =  '1'");	
	$rowcursobe = mysqli_fetch_array($sqllmscursobe);
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) == 1 && $rowcursobe['is_obe'] == 1) {
		echo '
		<input type="hidden" class="form-control" id="questionId" name="questionId">
		<div id="questionContainer" style="margin-top:10px; margin-bottom: 10px;" class="col-sm-91">';
			echo 'asad';
			if($rowlesson['id_ques']) {
				$questionIds = explode(',', $rowlesson['id_ques']);
				$i  =0;
				foreach ($questionIds as $key => $itemquestionIds) {
					$quessql = $dblms->querylms("SELECT ques_id, ques_number, ques_marks, ques_category, id_clo
													FROM ".OBE_QUESTIONS." 
													WHERE ques_id = (".$itemquestionIds.") ");
					$value_ques = mysqli_fetch_assoc($quessql);
					if($value_ques) {
						$quesClo = explode(',', $value_ques['id_clo']);
						$closql = $dblms->querylms("SELECT clo_id, clo_number
														FROM ".OBE_CLOS." as cl
														INNER JOIN ".OBE_CLOS_PROGRAMS." as cp ON cl.clo_id = cp.id_clo
														WHERE cl.id_teacher = ".cleanvars($rowsstd['emply_id'])." AND cl.id_course = ".cleanvars($_GET['id'])." AND cl.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' AND cl.id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])." AND cp.id_prg = ".cleanvars($rowrelted['id_prg'])." AND cp.semester = ".cleanvars($rowrelted['semester'])." AND cp.section = '".cleanvars($rowrelted['section'])."'
													");
						echo '
						<div class="form-sep" id="ques_Container['.$itemquestionIds.']" name="ques_Container" style="width: 100%; border: 1px solid rgb(231, 231, 231);">
							<div class="col-sm-31" style="margin-top: 5px;">
								<label class="req">Question Number:</label>
								<select class="form-control req" name="ques_number['.$key.']['.$itemquestionIds.']" style="width: 100%;" required>
									<option value="">Select Question No.</option>';
									for ($i = 1; $i <= 15; $i++) {
										if ($value_ques['ques_number'] == $i) {
											echo "<option value='$i' selected>$i</option>";
										} else {
											echo "<option value='$i'>$i</option>";
										}
									}
									echo '
								</select>
							</div>
							<div class="col-sm-31" style="margin-top: 5px;">
								<label class="req">Question Category:</label>                                 
								<select class="form-control req" name="ques_category['.$key.']['.$itemquestionIds.']" onchange="quesContianer(this,'.$itemquestionIds.')" style="width: 100%; margin-bottom: 10px;" required>
									<option value="">Select Question Cat.</option>';
									foreach ($ques_category as $cat) {
										if ($value_ques['ques_category'] == $cat['id']) {
											echo "<option value='$cat[id]' selected>$cat[name]</option>";
										} else {
											echo "<option value='$cat[id]' >$cat[name]</option>";
										}
									}
									echo '
								</select>
							</div>
				
							<div class="col-sm-31" style="margin-top: 5px;">
								<label class="req">Marks:</label>
								<select class="form-control req" id="ques_marks" name="ques_marks['.$key.']['.$itemquestionIds.']" style="width: 100%;"  required>
								<option value="">Select Marks</option>';
									for ($i = 1; $i <= 10; $i++) {
										if ($value_ques['ques_marks'] == $i) {
											echo "<option value='$i' selected>$i</option>";
										} else {
											echo "<option value='$i'>$i</option>";
										}
									}
									echo '
								</select>
							</div>
							<div class="col-sm-31" style="margin-top: 5px;">
								<label class="req">Mapped CLOs:</label>
								<select class="select2" name = "ques_clo['.$itemquestionIds.'][]" style="width: 100%;" multiple required>
									<option value="">Select CLOs</option>';
									while ($value_clo = mysqli_fetch_assoc($closql)) {
										if (in_array($value_clo['clo_id'], $quesClo)) {
											echo '<option value = "'.$value_clo['clo_id'].'" selected>'.$value_clo['clo_number'].'</option>';
										} else {
											echo '<option value = "'.$value_clo['clo_id'].'">'.$value_clo['clo_number'].'</option>';
										}
									}
									echo '
								</select>
							</div>
							<div class="col-sm-31" style="margin-top: 5px;">
								<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
									<button type="button" class="btn btn-danger" style="width: 50%; align-items: center;" onclick="remove('.$itemquestionIds.')"><i class="icon-trash"></i></button>
								</div>
							</div>
							<div style="clear: both;"></div>
							<div class="form_group questionStatementContainer" id="questionStatementContainer['.$itemquestionIds.']" style="margin-top: 5px;">
								<div style="margin-top: 5px;">';
									if($value_ques['ques_category'] == '1' || $value_ques['ques_category'] == 3 || $value_ques['ques_category'] == 4 || $value_ques['ques_category'] == 5) {
										echo '<textarea name="ques_statement['.$key.']['.$itemquestionIds.']" class="form-control"  placeholder="Question Statement" cols="20" rows="3" style="visibility:visible;">'.$value_ques['ques_statement'].'</textarea> ';
									} elseif ($value_ques['ques_category'] == '2') {
										echo '<input type="text" name="ques_statement['.$key.']['.$itemquestionIds.']" class="form-control" value="'.$value_ques['ques_statement'].'" style="margin-bottom: 10px;" placeholder="Question Statement">';
										$mcqoptionssql = $dblms->querylms("SELECT option1, option2, option3, option4, option5 
																				FROM ".OBE_MCQS." 
																				WHERE id_ques =  ".$itemquestionIds." ");
										$value_mcqoptionssql = mysqli_fetch_assoc($mcqoptionssql);
										if($value_mcqoptionssql) {
											echo '
											<div class="options" >
												<input type="text" name="option['.$key.']['.$itemquestionIds.'][1]" class="form-control" value="'.$value_mcqoptionssql['option1'].'" placeholder="option1" required>
												<input type="text" name="option['.$key.']['.$itemquestionIds.'][2]" class="form-control" value="'.$value_mcqoptionssql['option2'].'" placeholder="option2" required>
												<input type="text" name="option['.$key.']['.$itemquestionIds.'][3]" class="form-control" value="'.$value_mcqoptionssql['option3'].'" placeholder="option3" required>
												<input type="text" name="option['.$key.']['.$itemquestionIds.'][4]" class="form-control" value="'.$value_mcqoptionssql['option4'].'" placeholder="option4" required>
												<input type="text" name="option['.$key.']['.$itemquestionIds.'][5]" class="form-control" value="'.$value_mcqoptionssql['option5'].'" placeholder="option5" required>
											</div>';
										} else {
											echo '
											<div class="options">
												<input type="text" name="option['.$key.']['.$itemquestionIds.'][1]" class="form-control" value="" placeholder="option1" required>
												<input type="text" name="option['.$key.']['.$itemquestionIds.'][2]" class="form-control" value="" placeholder="option2" required>
												<input type="text" name="option['.$key.']['.$itemquestionIds.'][3]" class="form-control" value="" placeholder="option3" required>
												<input type="text" name="option['.$key.']['.$itemquestionIds.'][4]" class="form-control" value="" placeholder="option4" required>
												<input type="text" name="option['.$key.']['.$itemquestionIds.'][5]" class="form-control" value="" placeholder="option5" required>
											</div>';
										}
									}
									echo '                     
								</div>
							</div>
						</div>';
					}  
				}
			}
			echo '
		</div>
		<div class="col-sm-91 item">
			<div class="form-sep" style="margin-top: 10px; width: 100%">
				<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
				<button type="button" class="btn btn-info" style="margin-right:15px" onclick="addQuestion()">Add Question</button> 
				</div>
			</div>
		</div>
		';
	} else {
		echo '
		<div class="form-group">
			<label class="control-label col-lg-12" style="width:150px; margin-top:10px;"><b> Attach File</b></label>
			<div class="col-lg-12">
				<input id="assign_file" name="assign_file" class="btn btn-mid btn-primary clearfix" type="file"> 
				<div style="font-weight:700;margin-top:5px;">File extension must be: ( <span style="color:blue; font-weight:700;">jpg,jpeg, gif, png, pdf, docx, doc, xlsx, xls</span> )</div>
			</div>
		</div>';
	}
	echo'
	<div style="clear:both;"></div>';
	
	if($countrelted>0) { 
	echo '
		<div class="col-lg-12 heading-modal" style="margin-top:5px; margin-bottom:5px;"> You can add in all programs you are teaching.</div>
		<div style="clear:both;"></div>';
		echo '
			<div class="form-group">	
				<div class="col-lg-12" style="margin-left:20px;font-weight:normal; color:blue;"> 
					<input name="idprg[]" type="checkbox" id="idprg'.$relsr.'" value="'.$rowrelted['id_prg'].','.$rowrelted['semester'].','.$rowrelted['timing'].','.$rowrelted['section'].'" class="checkbox-inline" '.$prgchecked.'>  '.$prgname.'
				</div>
			</div>';
		}
	}
	echo '
	
</div>

<div class="modal-footer">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_detailassignment" name="changes_detailassignment">
	<button type="button" class="btn btn-default" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=Assignments\'" >Close</button>
</div>

</div>
</form>
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
function CheckForm(){
	var checked=false;
	var elements = document.getElementsByName("idprg[]");
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
<script>   
	window.addEventListener("DOMContentLoaded", function() {
		calculateTotalMarks();
	});

	// Calculate total marks
	function calculateTotalMarks() {
		var marksElements = document.querySelectorAll("#ques_marks");
		var totalMarks = 0;
		marksElements.forEach(function(element) {
			totalMarks += parseInt(element.value);
		});
		document.getElementById("marks").value = totalMarks;
	}

	// Update total marks when ques_marks is changed
	var quesMarksElements = document.querySelectorAll("#ques_marks");
	quesMarksElements.forEach(function(element) {
		element.addEventListener("change", function() {
			calculateTotalMarks();
		});
	});   

	$deleteid = [];
	function remove(questionId) {
		$deleteid.push(questionId);
		document.getElementById("ques_Container["+questionId+"]").remove();
		document.getElementById("questionId").value =  $deleteid;
		calculateTotalMarks();    
	}

	function quesContianer(selectValue,questionId) {
		questionContainer = document.getElementById("questionStatementContainer["+questionId+"]");
		showQuestionOptions(selectValue,questionContainer,questionId);          
	}
	
	$(".select2").select2({
		placeholder: "Select Any Option"
	})
</script>';
}
}