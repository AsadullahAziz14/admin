<?php
if(!isset($_GET['editid']) && isset($_GET['add'])) { 

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
	<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
	<!--WI_ADD_NEW_TASK_MODAL-->
	<div class="row">
	<div class="modal-dialog" style="width:95%;">
	<form id="addNew" class="form-horizontal" action="courses.php?id='.$_GET['id'].'&view=CLOs" method="POST" enctype="multipart/form-data" OnSubmit="return CheckForm();">
	<input type="hidden" name="id_curs" name="id_curs" value="'.$_GET['id'].'">
	<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=CLOs\'"><span>Close</span></button>
		<h4 class="modal-title" style="font-weight:700;">Add CLO Detail</h4>
	</div>

	<div class="modal-body">

		<div class="col-sm-61">
			<div class="form_sep">
				<label class="req">CLO Number</label>
				<select id="clo_number" name="clo_number" style="width:100%" autocomplete="off" required>
					<option value="">Select Option</option>';
				for($i = 1; $i <= 50; $i++) { 
					echo '<option value="'.$i.'">'.$i.'</option>';
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
					echo '<option value="'.$cloStatus['id'].'">'.$cloStatus['name'].'</option>';
				}
				echo '
				</select>
			</div> 
		</div>
		
		<div style="clear:both;"></div>

		<div class="form-group">
			<label for="clo_statement" class="control-label req col-lg-12" style="width:250px;"> <b>CLO Statement</b></label>
			<div class="col-lg-12">
				<textarea class="form-control" name="clo_statement" id="clo_statement" style="height:100px!important;" required></textarea>
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
					echo '<option value="'.$valuePLO['plo_id'].'">PLO '.$valuePLO['plo_number'].'</option>';
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
						echo '<option value="'.$valueDomainLevel['level_id'].'">'.$valueDomainLevel['level_code'].' - '.$valueDomainLevel['level_name'].'</option>';
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
				echo '
				<div class="form-group">	
					<div class="col-lg-12" style="margin-left:20px;font-weight:normal; color:blue;">
						<input name="idprg[]" type="checkbox" id="idprg'.$relsr.'" value="'.$valueRelatedProgram['id_prg'].','.$valueRelatedProgram['semester'].','.$valueRelatedProgram['timing'].','.$valueRelatedProgram['section'].'" class="checkbox-inline" checked> '.$prgname.'
					</div>
				</div>';
			}
		}
	echo '
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=CLOs\'" >Close</button>
		<input class="btn btn-primary" type="submit" value="Add Record" id="submit_clo" name="submit_clo">
	</div>

	</div>
	</form>
	</div>
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
		$().ready(function() {
			$("#addNew").validate({
				rules: {
					sections		: "required",
					clo_number	: "required",
					clo_statement : "required",
					id_plo: "required",
					id_domain_level: "required",
					clo_status: "required"
					},
			messages: {
					sections		: "This field is required",
					clo_number	: "This field is required",
					clo_statement : "This field is required",
					id_plo : "This field is required",
					id_domain_level: "This field is required",
					clo_status: "This field is required"
					},
				submitHandler: function(form) {
					form.submit();
				}
			});
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
	</script>
	<!--WI_ADD_NEW_TASK_MODAL-->';
}