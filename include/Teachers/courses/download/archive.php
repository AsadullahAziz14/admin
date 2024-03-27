<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && isset($_GET['archive'])) { 
header("Location:courses.php?id=".$_GET['id']."&view=Downloads", true, 301);
exit();
//------------------------------------------------
	$sqllmsdwnladachi  = $dblms->querylms("SELECT id, status, id_curs, file_name, file_size, open_with, detail, file   
										FROM ".COURSES_DOWNLOADS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session != '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."'  
										ORDER BY id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsdwnladachi) > 0) {
echo '
<div style="clear:both;"></div>
<form name="frmMain" id="frmMain" method="post" action="courses.php?id='.$_GET['id'].'&view=Downloads" OnSubmit="return CheckForm();">
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;">
		<input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);" class="checkbox-inline">
	</th>
	<th style="font-weight:600;text-align:center;">Sr.#</th>
	<th style="font-weight:600;">File Name</th>
	<th style="font-weight:600;">Size</th>
	<th style="font-weight:600;">Open With</th>
	<th style="font-weight:600; text-align:center;">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srdn = 0;
//------------------------------------------------
while($rowdwnladachi = mysqli_fetch_assoc($sqllmsdwnladachi)) { 
//------------------------------------------------
$sqllmscheckdwn  = $dblms->querylms("SELECT id  
										FROM ".COURSES_DOWNLOADS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND file_name = '".cleanvars($rowdwnladachi['file_name'])."'  LIMIT 1");
if(mysqli_num_rows($sqllmscheckdwn) == 0) {
$srdn++;
if($rowdwnladachi['file']) { 
	$filedownload = '<a class="btn btn-xs btn-info" href="downloads/courses/'.$rowdwnladachi['file'].'" target="_blank"> <i class="icon-download"></i></a> ';
} else  { 
	$filedownload = ' &nbsp;&nbsp;&nbsp;&nbsp;';
}
//------------------------------------------------
echo '
<tr>
	<td style="width:40px;text-align:center;">
		<input name="downloadarchive[]" type="checkbox" id="downloadarchive'.$srdn.'" value="'.$rowdwnladachi['id'].'" class="checkbox-inline">
	</td>
	<td style="width:40px;text-align:center;">'.$srdn.'</td>
	<td>'.$rowdwnladachi['file_name'].'</td>
	<td>'.$rowdwnladachi['file_size'].'</td>
	<td>'.$rowdwnladachi['open_with'].'</td>
	<td style="width:60px; text-align:center;">'.get_admstatus($rowdwnladachi['status']).'</td>
	<td style="width:50px; text-align:center;">'.$filedownload.'</td>
</tr>';
}
//------------------------------------------------
}
if($srdn>0) {
//------------------------------------------------
echo '
<tr>
	<td colspan="15" style="text-align:right;">
<button class="btn btn-purple" name="import_downloads" id="import_downloads" type="submit" style="padding:5px 13px; font-size:12px; margin-top:5px;margin-left:5px;">Import</button> 
</tr>';
}
//------------------------------------------------
echo '
</tbody>
</table>
<input type="hidden" name="hdnCount" id="hdnCount" value="'.$srdn.'">
</form>
<script>
function CheckForm(){
	var checked=false;
	var elements = document.getElementsByName("downloadarchive[]");
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
			eval("document.frmMain.downloadarchive"+iji+".checked=true");  
		} else  {  
			eval("document.frmMain.downloadarchive"+iji+".checked=false");  
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