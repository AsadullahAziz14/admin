<?php
if (!isset ($_GET['editid']) && isset ($_GET['add']) && !isset ($_GET['archive'])) {
	$sqllmscursrelated = $dblms->querylms("SELECT DISTINCT(t.id_prg), d.id_curs, d.id_setup, 
										p.prg_id, p.prg_name, p.prg_code, t.section, t.timing , t.semester, c.is_obe  
										FROM " . TIMETABLE_DETAILS . " d 
										INNER JOIN " . TIMETABLE . " t ON t.id = d.id_setup
										INNER JOIN " . COURSES . " c ON c.curs_id = d.id_curs   
										LEFT JOIN " . PROGRAMS . " p ON p.prg_id = t.id_prg   
										WHERE t.id_campus = '" . cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) . "' 
										AND t.academic_session = '" . cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR']) . "' 
										AND d.id_teacher = '" . cleanvars($rowsstd['emply_id']) . "' 
										AND d.id_curs = '" . cleanvars($_GET['id']) . "' AND t.status =  '1'");
	$countrelted = mysqli_num_rows($sqllmscursrelated);
	$arryreltedprgs = array();
	while ($rowrelted = mysqli_fetch_array($sqllmscursrelated)) {
		$arryreltedprgs[] = $rowrelted;
	}

	$arraySingleRecord = array_slice($arryreltedprgs, 0, 1);
	foreach ($arraySingleRecord as $time) {
		$timing = $time['timing'];
	}

	echo $arryreltedprgs[0]['id_prg'];
	echo '
		<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
		<!--WI_ADD_NEW_TASK_MODAL-->
		<div class="row">
			<div class="modal-dialog" style="width:95%;">
				<form class="form-horizontal" action="courses.php?id='.$_GET['id'].'&view=Assignments" method="post" id="addLesson" enctype="multipart/form-data" OnSubmit="return CheckForm();">
					<input type="hidden" name="id_curs" name="id_curs" value="' . $_GET['id'] . '">
					<input type="hidden" name="id_prg" name="id_prg" value="' . $_GET['prg_id'] . '">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" onclick="location.href=\'courses.php?id=' . $_GET['id'] . '&view=Assignments\'"><span>close</span></button>
							<h4 class="modal-title" style="font-weight:700;">Add Assignment Detail</h4>
						</div>
						<div class="modal-body">
							<div class="col-sm-61">
								<div class="form_sep">
									<label class="req">Title </label>
									<input type="text" name="caption" id="caption" class="form-control" required autocomplete="off" >
								</div> 
							</div>
							<div class="col-sm-61">
								<div class="form_sep">
									<label class="req">Status</label>
									<select id="status" name="status" style="width:100%" autocomplete="off" required>';
									foreach ($admstatus as $itemadm_status) {
										echo "<option value='$itemadm_status[status_id]'>$itemadm_status[status_name]</option>";
									}
									echo '
									</select>
								</div> 
							</div>
							
							<div style="clear:both;"></div>

							<div class="form-group">
								<label class="control-label req col-lg-12" style="width:150px;"><b> Detail</b></label>
								<div class="col-lg-12">
									<textarea class="form-control" id="detail" name="detail" required autocomplete="off" style="height:100px !important;"></textarea>
								</div>
							</div>

							<div style="clear:both;"></div>

							<div class="col-sm-41">
								<div class="form_sep" style="margin-top:5px;">
									<label>Midterm Examination Assignment? </label>
									<select id="is_midterm" name="is_midterm" style="width:100%" autocomplete="off" onchange="get_assignmentmidtermmarks(this.value, ' . $timing . ')" >';
									foreach ($yesno as $itemyesno) {
										if ($itemyesno['id'] != 0) {
											echo '<option value="' . $itemyesno['id'] . '" selected>' . $itemyesno['name'] . '</option>';
										}
									}
									echo '
									</select>
								</div> 
							</div>
							
							<div id="getassignmentmidtermmarks">
								<div class="col-sm-41">
									<div class="form_sep" style="margin-top:5px;">
										<label class="req">Total Marks </label>
										<input type="number" name="total_marks" min="0" id="total_marks" readonly required class="form-control" autocomplete="off"  onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"  >
									</div> 
								</div>
								<div class="col-sm-41">
									<div class="form_sep" style="margin-top:5px;">
										<label>Passing Marks</label>
										<input type="text" name="passing_marks" id="passing_marks" class="form-control" autocomplete="off"  onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"  >
									</div> 
								</div>

								<div style="clear:both;"></div>
								
								<div class="col-sm-61">
									<div class="form_sep" style="margin-top:5px;">
										<label class="req">Start Date </label>
										<input type="text" name="date_start" id="date_start" class="form-control pickadate" required autocomplete="off" >
									</div> 
								</div>

								<div class="col-sm-61">
									<div class="form_sep" style="margin-top:5px;">
										<label class="req">End Date</label>
										<input type="text" name="date_end" id="date_end" class="form-control pickadate" required autocomplete="off" >
									</div> 
								</div>

							</div>	
							
							<div style="clear:both;"></div>
							';
							if (cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) == 1 && $arryreltedprgs[0]['is_obe'] == 1) {
								echo '
									<div id="questionContainer" style="margin-top:10px; margin-bottom: 10px;" class="col-sm-91">
										<!-- Question will be added here dynamicall through javascript -->
									</div>
									<div class="col-sm-91 item">
										<div class="form-sep" style="margin-top: 10px; width: 100%">
											<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
											<button type="button" class="btn btn-info" style="margin-right:15px" onclick="addQuestion('.$_GET['id'].','.$_GET['prg_id'].')">Add Question</button> 
											</div>
										</div>
									</div>';
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
							echo '
							<div style="clear:both;"></div>';
							if ($countrelted > 0) {
								echo '
							<div class="col-lg-12 heading-modal" style="margin-top:5px; margin-bottom:5px;"> You can add in all programs you are teaching.</div>
							<div style="clear:both;"></div>';
							$relsr = 0;
							foreach ($arryreltedprgs as $rowrelted) {
								$relsr++;
								if ($rowrelted['section']) {
									$sectionrel = ' Section: ' . $rowrelted['section'];
								} else {
									$sectionrel = '';
									$checkrel = "";
								}


								if ($rowrelted['prg_name']) {
									$prgname = $rowrelted['prg_name'] . ' (' . get_programtiming($rowrelted['timing']) . ')  Semester: ' . addOrdinalNumberSuffix($rowrelted['semester']) . ' ' . $sectionrel;
								} else {
									$prgname = 'LA: ' . get_programtiming($rowrelted['timing']) . $sectionrel;
								}


								echo '
								<div class="form-group">	
									<div class="col-lg-12" style="margin-left:20px;font-weight:normal; color:blue;">
										<input name="idprg[]" type="checkbox" id="idprg' . $relsr . '" value="' . $rowrelted['id_prg'] . ',' . $rowrelted['semester'] . ',' . $rowrelted['timing'] . ',' . $rowrelted['section'] . '" class="checkbox-inline" checked>  ' . $prgname . '
									</div>
								</div>';
								}
							}
							echo '

						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-default" onclick="location.href=\'courses.php?id=' . $_GET['id'] . '&prg_id='.$arryreltedprgs[0]['id_prg'].'&view=Assignments\'" >Close</button>
							<input class="btn btn-primary" type="submit" value="Add Record" id="submit_assignment" name="submit_assignment">
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

		$("#is_midterm").select2({
			allowClear: true
		});

	</script>
	<script type="text/javascript">
		function CheckForm() {
			var checked = false;
			var elements = document.getElementsByName("idprg[]");
			for (var i = 0; i < elements.length; i++) {
				if (elements[i].checked) {
					checked = true;
				}
			}
			if (!checked) {
				alert("at least one Program should be selected");
				return checked;
			} else {
				return true;
			}
		}
	</script>
	<!--WI_ADD_NEW_TASK_MODAL-->

	<script src="js/add_question/add_question.js"></script>';
}
//------------------------------------------------