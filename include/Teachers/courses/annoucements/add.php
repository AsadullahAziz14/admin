<?php 
//---------------------Add Course Announcement--------------------------
if(!isset($_GET['editid']) && isset($_GET['add'])) { 
	$sqllmscursrelated  = $dblms->querylms("SELECT DISTINCT(t.id_prg), d.id_setup, 
										p.prg_id, p.prg_name, p.prg_code, t.section, t.timing , t.semester  
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										LEFT JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg   
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
<form class="form-horizontal" action="courses.php?id='.$_GET['id'].'&view=Annoucements" method="post" id="addLesson" enctype="multipart/form-data" OnSubmit="return CheckForm();">
<input type="hidden" name="id_curs" name="id_curs" value="'.$_GET['id'].'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=Annoucements\'"><span>close</span></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Course Announcement</h4>
</div>

<div class="modal-body">
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Title</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="caption" name="caption" required autofocus autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Detail</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="detail" name="detail" style="height:100px !important;" required autocomplete="off"></textarea>
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
	<div class="col-lg-12 heading-modal" style="margin-top:5px; margin-bottom:5px;"> You can add in all programs you are teaching.</div>
	<div style="clear:both;"></div>';
$relsr =0 ;
while($rowrelted = mysqli_fetch_array($sqllmscursrelated)){ 
	$relsr++;
	if($rowrelted['section']) { 
		$sectionrel 	= ' Section: '.$rowrelted['section'];
		$valuesection	= "";
	} else  { 
		$sectionrel 	= '';
		$valuesection	= "";
	}
	if($rowrelted['prg_name']) {
		$prgname = $rowrelted['prg_name'].' ('.get_programtiming($rowrelted['timing']).')  Semester: '.addOrdinalNumberSuffix($rowrelted['semester']).' '.$sectionrel;
	} else {
		$prgname = 'LA: '.get_programtiming($rowrelted['timing']).$sectionrel;
	}


echo '
	<div class="form-group">	
		<div class="col-lg-12" style="margin-left:20px;font-weight:normal; color:blue;">
			<input name="idprg[]" type="checkbox" id="idprg'.$relsr.'" value="'.$rowrelted['id_prg'].','.$rowrelted['semester'].','.$rowrelted['timing'].','.$rowrelted['section'].'" class="checkbox-inline" checked>  '.$prgname.'
		</div>
	</div>';
}
}
echo '


</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=Annoucements\'" >Close</button>
	<input class="btn btn-primary" type="submit" value="Add Record" id="submit_annoucements" name="submit_annoucements">
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