<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && isset($_GET['archive'])) { 
//------------------------------------------------
	$sqllmsassign  = $dblms->querylms("SELECT id, status, id_curs, caption, detail, date_start, date_end, 
										total_marks, passing_marks, fileattach, timing    
										FROM ".COURSES_ASSIGNMENTS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session != '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' ORDER BY id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsassign) > 0) {
echo '
<form name="frmMain" id="frmMain" method="post" action="courses.php?id='.$_GET['id'].'&view=Assignments" OnSubmit="return CheckForm();">
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th><input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);" class="checkbox-inline"></th>
	<th style="font-weight:600;text-align:center; ">Sr.#</th>
	<th style="font-weight:600;">Title</th>
	<th style="font-weight:600;text-align:center; ">Total Marks</th>
	<th style="font-weight:600;text-align:center; ">Start Date</th>
	<th style="font-weight:600;text-align:center; ">End Date</th>
	<th style="font-weight:600;text-align:center; ">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
while($rowassign = mysqli_fetch_assoc($sqllmsassign)) { 
//------------------------------------------------
	$sqllmslessonchek  = $dblms->querylms("SELECT  id, status, id_curs, caption, detail, date_start, date_end, 
										total_marks, passing_marks, fileattach, timing 
										FROM ".COURSES_ASSIGNMENTS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND date_end = '".date("Y-m-d", strtotime(cleanvars($rowassign['date_end'])))."' 
										AND date_start = '".date("Y-m-d", strtotime(cleanvars($rowassign['date_start'])))."'
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' LIMIT 1");
if(mysqli_num_rows($sqllmslessonchek) == 0) {

$srbk++;
if($rowassign['fileattach']) { 
	$filedownload = '<a class="btn btn-xs btn-success" href="downloads/assignments/teachers/'.$rowassign['fileattach'].'" target="_blank"> <i class="icon-download"></i></a> ';
} else  { 
	$filedownload = ' &nbsp;&nbsp;&nbsp;&nbsp;';
}

//------------------------------------------------
echo '
<tr>
	<td><input name="assignarchive[]" type="checkbox" id="assignarchive'.$srbk.'" value="'.$rowassign['id'].'" class="checkbox-inline"></td>
	<td style="width:40px;text-align:center;">'.$srbk.'</td>
	<td>'.$rowassign['caption'].'</td>
	<td style="text-align:center; width:90px;">'.$rowassign['total_marks'].'</td>
	<td style="text-align:center; width:100px;">'.date("d/m/Y", strtotime($rowassign['date_start'])).'</td>
	<td style="text-align:center; width:100px;">'.date("d/m/Y", strtotime($rowassign['date_end'])).'</td>
	<td style="width:60px; text-align:center;">'.get_admstatus($rowassign['status']).'</td>
	<td style="width:40px; text-align:center;">'.$filedownload.' </td>
</tr>';
//------------------------------------------------
}
}
if($srbk>0) {
//------------------------------------------------
echo '
<tr>
	<td colspan="15" style="text-align:right;">
<button class="btn btn-purple" name="import_assignments" id="import_assignments" type="submit" style="padding:5px 13px; font-size:12px; margin-top:5px;margin-left:5px;">Import</button> 
</tr>';
}
//------------------------------------------------
echo '
</tbody>
</table>
</table>
<input type="hidden" name="hdnCount" id="hdnCount" value="'.$srbk.'">
</form>
<script>
function CheckForm(){
	var checked=false;
	var elements = document.getElementsByName("assignarchive[]");
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
			eval("document.frmMain.assignarchive"+iji+".checked=true");  
		} else  {  
			eval("document.frmMain.assignarchive"+iji+".checked=false");  
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