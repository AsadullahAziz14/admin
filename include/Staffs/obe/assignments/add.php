<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'add' => '1'))) { 
	if(LMS_VIEW == 'add' && !isset($_GET['id'])) {
		$queryAssignment = $dblms->querylms("SELECT max(assignment_number) as assignment_number 
												FROM ".OBE_ASSIGNMENTS." 
												WHERE id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section	= '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
											");
		$valueAssignment = mysqli_fetch_array($queryAssignment);
		if($valueAssignment != "") {
			$assignmentNumber = $valueAssignment['assignment_number'] + 1;
		} else {
			$assignmentNumber = 0;
		}
		echo '
		<div class="row">
			<div class="modal-dialog" style="width:90%;">
				<form class="form-horizontal" action="obeassignments.php" method="POST" id="addNew" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" style="font-weight:700;"> Add Assignment asasAS</h4>
						</div>
						<div class="modal-body">
							<div class="form-group col-sm-61">
								<label class="control-label req col-lg-12" style="width:auto;"> <b>Assignment Number</b></label>
								<div class="col-lg-12">
									<select id="assignment_number" name="assignment_number" style="width:100%" autocomplete="off" required>
										<option value="">Select Option</option>';
										for($i = $assignmentNumber ; $i <= 50; $i++) { 
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
										echo '
									</select>
								</div>
							</div>
							<div class="form-group col-sm-61">
								<label class="control-label req col-lg-12" style="width:auto;"> <b>Assignment Date</b></label>
								<div class="col-lg-12">
									<input type="date" class="form-control" id="assignment_date" name="assignment_date" required></input>
								</div>
							</div>
							<div style="clear:both;"></div>
							<div class="form-group col-sm-61">
								<label class="control-label req col-lg-12" style="width:auto;"> <b>Assignment Marks</b></label>
								<div class="col-lg-12">
									<input type="number" class="form-control" id="marks" name="marks" value="0" readonly required>
								</div>
							</div>
							<div class="form-group col-sm-61">
								<label class="control-label req col-lg-12" style="width:auto;"><b>Status</b></label>
								<div class="col-lg-12">
									<select id="assignment_status" name="assignment_status" style="width:100%" autocomplete="off" required>
										<option value="">Select Option</option>';
									foreach($status as $assignment_status) { 
										echo '<option value="'.$assignment_status['id'].'">'.$assignment_status['name'].'</option>';
									}
									echo '
									</select>
								</div>
							</div>
							<div style="clear:both;"></div>
							<div id="questionContainer" style="margin-top:10px; margin-bottom: 10px;" class="col-sm-91">
								<!-- Question will be added here dynamicall through javascript -->
							</div>
							<div class="col-sm-91 item">
								<div class="form-sep" style="margin-top: 10px; width: 100%">
									<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
									<button type="button" class="btn btn-info" style="margin-right:15px" onclick="addQuestion()">Add Question</button> 
									</div>
								</div>
							</div>
							<div style="clear:both;"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal" onclick="location.href=\'obeassignments.php\'">Close</button>
							<input class="btn btn-primary" type="submit" value="Add Record" id="submit_assignment" name="submit_assignment">
						</div>
					</div>
				</form>
			</div>
		</div>
		<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
		<script src="js/add_question/add_question.js"></script>
		<script type="text/javascript">
			$(".select2").select2({
				placeholder: "Select Any Option"
			});
		</script>';
	}
}