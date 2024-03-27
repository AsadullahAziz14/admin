<?php 
//------------------------------------------------
if(isset($_GET['editid']) && !isset($_GET['add']) && !isset($_GET['archive'])) { 
//------------------------------------------------
	$sqllmslesson  = $dblms->querylms("SELECT *   
										FROM ".COURSES_BOOKS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND id = '".cleanvars($_GET['editid'])."' LIMIT 1");
	$rowlesson = mysqli_fetch_assoc($sqllmslesson);
//------------------------------------------------	
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
//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="courses.php?id='.$_GET['id'].'&view=Books" method="post" id="addLesson" enctype="multipart/form-data" OnSubmit="return CheckForm();">
<input type="hidden" name="editid" id="editid" value="'.cleanvars($_GET['editid']).'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=Books\'"><span>close</span></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Book Detaill</h4>
</div>

<div class="modal-body">

		<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Book Name </label>
			<input type="text" name="book_name" id="book_name" class="form-control" required autocomplete="off" value="'.$rowlesson['book_name'].'" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Author</label>
			<input type="text" name="author_name" id="author_name" class="form-control" required autocomplete="off" value="'.$rowlesson['author_name'].'" >
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Edition </label>
			<input type="text" name="edition" id="edition" class="form-control" required autocomplete="off" value="'.$rowlesson['edition'].'" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>ISBN</label>
			<input type="text" name="isbn" id="isbn" class="form-control" autocomplete="off" value="'.$rowlesson['isbn'].'" >
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Publisher </label>
			<input type="text" name="publisher" id="publisher" class="form-control" autocomplete="off" value="'.$rowlesson['publisher'].'" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>URL</label>
			<input type="text" name="url" id="url" class="form-control" autocomplete="off" value="'.$rowlesson['url'].'" >
		</div> 
	</div>
	<div style="clear:both;"></div>

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Status</b></label>
		<div class="col-lg-12">
			<select id="status" name="status" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
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
										FROM ".COURSES_BOOKSPROGRAM." clp 
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
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_detailbook" name="changes_detailbook">
	<button type="button" class="btn btn-default" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=Books\'" >Close</button>
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
	
	$("#weekno").select2({
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
</script>';
}
