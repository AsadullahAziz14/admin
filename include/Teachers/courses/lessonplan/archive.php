<?php 
if(!isset($_GET['editid']) && !isset($_GET['add']) && isset($_GET['archive'])) {
	$sqllmslesson  = $dblms->querylms("SELECT id, status, id_curs, weekno, detail  
										FROM ".COURSES_LESSONS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session != '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										ORDER BY weekno ASC, id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmslesson) > 0) {
echo '
<div style="clear:both;"></div>

<div style="clear:both;"></div>
<form name="frmMain" id="frmMain" method="post" action="courses.php?id='.$_GET['id'].'&view=Lessonplan" OnSubmit="return CheckForm();">
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th><input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);" class="checkbox-inline"></th>
	<th style="font-weight:600;">Week #</th>
	<th style="font-weight:600;">Lesson Detail</th>
	<th style="font-weight:600; text-align:center;">Status</th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
while($rowlesson = mysqli_fetch_assoc($sqllmslesson)) { 
//------------------------------------------------
	$sqllmslessonchek  = $dblms->querylms("SELECT id, status, id_curs, weekno, detail  
										FROM ".COURSES_LESSONS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND weekno = '".cleanvars($rowlesson['weekno'])."'  
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' LIMIT 1");
if(mysqli_num_rows($sqllmslessonchek) == 0) {

$srbk++;
//------------------------------------------------
echo '
<tr>
	<td><input name="lessonarchive[]" type="checkbox" id="lessonarchive'.$srbk.'" value="'.$rowlesson['id'].'" class="checkbox-inline"></td>
	<td style="width:70px;">'.$rowlesson['weekno'].'</td>
	<td>'.$rowlesson['detail'].'</td>
	<td style="width:50px; text-align:center;">'.get_admstatus($rowlesson['status']).'</td>
</tr>';
//------------------------------------------------
}
}
if($srbk>0) {
//------------------------------------------------
echo '
<tr>
	<td colspan="15" style="text-align:right;">
<button class="btn btn-purple" name="import_lessonplan" id="import_lessonplan" type="submit" style="padding:5px 13px; font-size:12px; margin-top:5px;margin-left:5px;">Import</button> 
</tr>';
}
echo '
</tbody>
</table>
<input type="hidden" name="hdnCount" id="hdnCount" value="'.$srbk.'">
</form>
<script>
function CheckForm(){
	var checked=false;
	var elements = document.getElementsByName("lessonarchive[]");
	for(var i=0; i < elements.length; i++){
		if(elements[i].checked) {
			checked = true;
		}
	}
	if (!checked) {
		alert("at least one checkbox should be selected");
		return checked;
	} else if(confirm("Do you want to Import ?")==true)  {  
		return true;  
	}  else  {  
		return false;  
	}  
}

function ClickCheckAll(vol) {  
	var iji=1;  
	for(iji=1;iji<=document.frmMain.hdnCount.value;iji++)  {  
		if(vol.checked == true)  {  
			eval("document.frmMain.lessonarchive"+iji+".checked=true");  
		} else  {  
			eval("document.frmMain.lessonarchive"+iji+".checked=false");  
		}  
	}  
} 

</script>';
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}
} 