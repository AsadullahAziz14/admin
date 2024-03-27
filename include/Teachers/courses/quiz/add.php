<?php
//------------------------------------------------
if(!isset($_GET['editid']) && isset($_GET['add'])) { 
//------------------------------------------------	
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
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="" method="post" id="addLesson" enctype="multipart/form-data" OnSubmit="return CheckForm();">
<input type="hidden" name="id_curs" name="id_curs" value="'.$_GET['id'].'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=Quiz\'"><span>close</span></button>
	<h4 class="modal-title" style="font-weight:700;">Add Quiz Detail</h4>
</div>

<div class="modal-body">

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Title</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="quiz_title" name="quiz_title" required autofocus autocomplete="off">
		</div>
	</div>

	<div style="clear:both;"></div>

	<div class="col-sm-61" style="margin-top:10px;">
		<div class="form_sep">
			<label class="req">Status</label>
			<select id="quiz_status" name="quiz_status" style="width:100%" autocomplete="off" required>';
			foreach($status as $itemadm_status) {
				echo '<option value="'.$itemadm_status['id'].'">'.$itemadm_status['name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>

	<div class="col-sm-61" style="margin-top:10px;">
		<div class="form_sep">
			<label class="req">Exam Term</label>
			<select id="quiz_term" name="quiz_term" style="width:100%" autocomplete="off" required>
			<option value="">Choose</option>';
			foreach($examterm as $term) {
				echo "<option value='$term[id]'>$term[name]</option>";
			}
	echo'
			</select>
		</div> 
	</div>

	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:10px;">
			<label class="req">Total Marks </label>
			<input type="number" name="quiz_totalmarks" min="1" id="quiz_totalmarks" required class="form-control" autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:10px;">
			<label>Passing Marks</label>
			<input type="text" name="quiz_passingmarks" id="quiz_passingmarks" class="form-control" autocomplete="off" >
		</div> 
	</div>

	<div style="clear:both;"></div>

	<table class="footable table table-bordered  table-with-avatar invE_table" style="margin-top:10px;">
		<thead>
			<tr>
				<th></th>
				<th style="font-weight:600;">Difficulty Level</th>
				<th style="font-weight:600;">Questions</th>
				<th style="font-weight:600;">Type</th>
			</tr>
		</thead>
		<tbody>
			<tr class="inv_row">
				<td class="inv_clone_row" style="text-align:center; width:30px; vertical-align:middle;">
					<i class="icon-plus inv_clone_btn"></i>
				</td>
				<td style="width:100px;">
				
				<select name="difficulty_level[]" id="difficulty_level[]" required style="height:25px; width:100%;">
					<option value="">Choose</option>';
				foreach($difficultylevel as $itemlevel) {
				echo '<option value="'.$itemlevel['id'].'">'.$itemlevel['name'].'</option>';
			}
		echo '</select>
				
				</td>
				<td style="width:100px;"><input type="number" class="form-control col-lg-12" name="questions[]" id="questions[]" required /></td>
				<td style="width:100px;">
				<select name="id_type[]" id="id_type[]" required style="height:25px; width:100%;">
					<option value="">Choose</option>';
				foreach($questiontype as $type) {
					echo '<option value="'.$type['id'].'">'.$type['name'].'</option>';
				}
		echo '</select>
				</td>
			</tr>
			<tr class="last_row">
			</tr>
		</tbody>
	</table>

	<div style="clear:both;"></div>';
if($countrelted>0) { 
echo '
	<div class="col-lg-12 heading-modal" style="margin-top:5px; margin-bottom:5px;"> You can add in all programs you are teaching.</div>
	<div style="clear:both;"></div>';
$relsr =0 ;
while($rowrelted = mysqli_fetch_array($sqllmscursrelated)){ 
if($rowrelted['section']) { 
	$sectionrel 	= 'Section: '.$rowrelted['section'];
	$valuesection	= "";
} else  { 
	$sectionrel 	= '';
	$valuesection	= "";
}
$relsr++;

echo '
	<div class="form-group">	
		<div class="col-lg-12" style="margin-left:20px;font-weight:normal; color:blue;">
			<input name="idprg[]" type="checkbox" id="idprg'.$relsr.'" value="'.$rowrelted['id_prg'].','.$rowrelted['semester'].','.$rowrelted['timing'].','.$rowrelted['section'].'" class="checkbox-inline" checked>  '.$rowrelted['prg_name'].' ('.get_programtiming($rowrelted['timing']).')  Semester: '.addOrdinalNumberSuffix($rowrelted['semester']).' '.$sectionrel.'
		</div>
	</div>';
}
}

	echo '

</div>

<div class="modal-footer">
	<input class="btn btn-primary" type="submit" value="Save Quiz" id="submit_quiz" name="submit_quiz"> 
	<button type="button" class="btn btn-default" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=Quiz\'" >Close</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
	$("#quiz_status").select2({
        allowClear: true
    });
	$("#quiz_term").select2({
        allowClear: true
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
	
//------------------------------------------------
}
//------------------------------------------------