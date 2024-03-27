<?php
if(isset($_GET['editid']) && !isset($_GET['add']) && !isset($_GET['archive'])) {  

	$queryCLO = $dblms->querylms("SELECT *   
										FROM ".OBE_CLOS." 
										WHERE clo_id = '".cleanvars($_GET['editid'])."'
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND id_course = '".cleanvars($_GET['id'])."' 
										AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										LIMIT 1");
	$valueCLO = mysqli_fetch_assoc($queryCLO);

	$queryReleatedPrograms  = $dblms->querylms("SELECT DISTINCT(t.id_prg), d.id_setup, 
													p.prg_id, p.prg_name, p.prg_code, t.section, t.timing , t.semester  
													FROM ".TIMETABLE_DETAILS." d  
													INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
													LEFT JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg   
													WHERE t.status =  '1'
													AND t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
													AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
													AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
													AND d.id_curs = '".cleanvars($_GET['id'])."' AND p.prg_obe = '1'");
	$countRelatedPrograms = mysqli_num_rows($queryReleatedPrograms);
	$arrayRelatedPrograms = array();
	while($valueRelatedProgram = mysqli_fetch_array($queryReleatedPrograms)){ 
		$arrayRelatedPrograms[] = $valueRelatedProgram;
	}

	$arraySingleRecord = array_slice($arrayRelatedPrograms, 0, 1);
	foreach($arraySingleRecord as $time) {
		$timing = $time['timing'];
	}

	echo '
	<!--WI_ADD_NEW_TASK_MODAL-->
	<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
	<div class="row">
	<div class="modal-dialog" style="width:95%;">
	<form class="form-horizontal" action="courses.php?id='.$_GET['id'].'&view=CLOs" method="POST" id="addLesson" enctype="multipart/form-data" OnSubmit="return CheckForm();">
	<input type="hidden" name="editid" id="editid" value="'.cleanvars($_GET['editid']).'">
	<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=CLOs\'"><span>Close</span></button>
		<h4 class="modal-title" style="font-weight:700;"> Edit CLO Details</h4>
	</div>

	<div class="modal-body">
		
		<div class="col-sm-61">
			<div class="form_sep">
				<label class="req">CLO Number</label>
				<select id="clo_number" name="clo_number" style="width:100%" autocomplete="off" required>
					<option value="">Select Option</option>';
				for($i = 1; $i <= 50; $i++) { 
					echo '<option value="'.$i.'"'; if($i == $valueCLO['clo_number']){echo ' selected';} echo '>'.$i.'</option>';
				}
				echo '
				</select>
			</div> 
		</div>

		<div class="col-sm-61">
			<div class="form_sep">
				<label class="req">Status</label>
				<select id="clo_status" name="clo_status" style="width:100%" autocomplete="off" required>';
				foreach($status as $cloStatus) { 
					echo '<option value="'.$cloStatus['id'].'"'; if($cloStatus['id'] == $valueCLO['clo_status']){echo ' selected';} echo '>'.$cloStatus['name'].'</option>';
				}
				echo '
				</select>
			</div> 
		</div>

		<div style="clear:both;"></div>

		<div class="form-group">
			<label for="clo_statement" class="control-label req col-lg-12" style="width:250px;"> <b>CLO Statement</b></label>
			<div class="col-lg-12">
				<textarea class="form-control" name="clo_statement" id="clo_statement" style="height:100px!important;" required>'.$valueCLO['clo_statement'].'</textarea>
			</div>
		</div>

		<div style="clear:both;"></div>

		<div class="form-group">
			<label class="control-label req col-lg-12" style="width:250px;"><b>Mapped PLOs</b></label>
			<div class="col-lg-12">
				<select id="id_plo" class="select2" name="id_plo[]" style="width:100%" multiple>';
				$queryPLOs = $dblms->querylms("SELECT plo_id, plo_number 
													FROM ".OBE_PLOS." 
													WHERE plo_status = '1'
													AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'
													ORDER BY plo_number ASC");
				while($valuePLO = mysqli_fetch_array($queryPLOs)) {
					echo '<option value="'.$valuePLO['plo_id'].'"'; if(in_array($valuePLO['plo_id'], explode(',', $valueCLO['id_plo']))){echo ' selected';} echo '>PLO '.$valuePLO['plo_number'].'</option>';
				}
				echo '
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label req col-lg-12" style="width:250px;"><b>Mapped Domain Level</b></label>
			<div class="col-lg-12">
				<select id="id_domain_level" name="id_domain_level" style="width:100%" autocomplete="off" required>
					<option value="">Select Domain Level</option>';
					$queryDomainLevels = $dblms->querylms("SELECT level_id, level_code, level_name, id_domain
																FROM ".OBE_DOMAIN_LEVELS."
																WHERE level_status = '1'
																AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'
																ORDER BY level_code ASC");
					while($valueDomainLevel = mysqli_fetch_assoc($queryDomainLevels)) {
						echo '<option value="'.$valueDomainLevel['level_id'].'"'; if($valueDomainLevel['level_id'] == $valueCLO['id_domain_level']){echo ' selected';} echo '>'.$valueDomainLevel['level_code'].' - '.$valueDomainLevel['level_name'].'</option>';
					}
				echo '
				</select>
			</div>
		</div>

		<div style="clear:both;"></div>';

		if($countRelatedPrograms>0) { 
			
			echo '
			<div class="col-lg-12 heading-modal" style="margin-top:5px; margin-bottom:5px;"> You can add in all programs you are teaching.</div>
			<div style="clear:both;"></div>';
			$relsr =0 ;
			foreach($arrayRelatedPrograms as $valueRelatedProgram){ 

				$relsr++;
				if($valueRelatedProgram['section']) { 
					$sectionrel 	= ' Section: '.$valueRelatedProgram['section'];
				} else  { 
					$sectionrel 	= '';
					$checkrel		= "";
				}

				if($valueRelatedProgram['prg_name']) {
					$prgname = $valueRelatedProgram['prg_name'].' ('.get_programtiming($valueRelatedProgram['timing']).')  Semester: '.addOrdinalNumberSuffix($valueRelatedProgram['semester']).' '.$sectionrel;
				} else {
					$prgname = 'LA: '.get_programtiming($valueRelatedProgram['timing']).$sectionrel;
				}

				$queryCLOProgram = $dblms->querylms("SELECT clp.id, clp.id_prg, clp.id_clo, clp.semester, clp.section, clp.timing 
														FROM ".OBE_CLO_PROGRAMS." clp 
														WHERE clp.id_clo = '".cleanvars($valueCLO['clo_id'])."' 
														AND clp.id_prg = '".cleanvars($valueRelatedProgram['id_prg'])."' 
														AND clp.semester = '".cleanvars($valueRelatedProgram['semester'])."'
														AND clp.timing = '".cleanvars($valueRelatedProgram['timing'])."'
														AND clp.section = '".cleanvars($valueRelatedProgram['section'])."' LIMIT 1 ");
				if(mysqli_num_rows($queryCLOProgram) > 0) { 
					$programChecked = " checked";
				} else { 
					$programChecked = "";
				}

				echo '
				<div class="form-group">	
					<div class="col-lg-12" style="margin-left:20px;font-weight:normal; color:blue;">
						<input name="idprg[]" type="checkbox" id="idprg'.$relsr.'" value="'.$valueRelatedProgram['id_prg'].','.$valueRelatedProgram['semester'].','.$valueRelatedProgram['timing'].','.$valueRelatedProgram['section'].'" class="checkbox-inline" '.$programChecked.'>'.$prgname.'
					</div>
				</div>';
			}
		}
		echo '
	</div>

	<div class="modal-footer">
		<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_clo_changes" name="submit_clo_changes">
		<button type="button" class="btn btn-default" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=CLOs\'" >Close</button>
	</div>

	</div>
	</form>
	</div>
	</div>
	<!--WI_ADD_NEW_TASK_MODAL-->
	<script>
		$("#clo_number").select2({
			allowClear: true
		});
		$("#clo_status").select2({
			allowClear: true
		});
		$("#id_domain_level").select2({
			allowClear: true
		});
	</script>
	<script type="text/javascript">
		$(".select2").select2({
			placeholder: "Select Any Option"
		});
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
	</script>';
}