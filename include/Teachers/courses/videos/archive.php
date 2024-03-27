<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && isset($_GET['archive'])) { 
	header("Location:courses.php?id=".$_GET['id']."&view=Lessonvideo", true, 301);
exit();
	
	$sqllmsvidesachi  = $dblms->querylms("SELECT * 
										FROM ".COURSES_VIDEOLESSONS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session != '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' ORDER BY id ASC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsvidesachi) > 0) {
echo '
<form name="frmMain" id="frmMain" method="post" action="courses.php?id='.$_GET['id'].'&view=Lessonvideo" OnSubmit="return CheckForm();">
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;">
		<input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);" class="checkbox-inline">
	</th>
	<th style="font-weight:600;text-align:center;">Sr.#</th>
	<th style="font-weight:600;">Title</th>
	<th style="font-weight:600;text-align:center;">Status</th>
</tr>
</thead>
<tbody>';
$svido = 0;
//------------------------------------------------
while($rowvideosachi = mysqli_fetch_assoc($sqllmsvidesachi)) { 
//------------------------------------------------
$sqllmschecker  = $dblms->querylms("SELECT *  
										FROM ".COURSES_VIDEOLESSONS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' 
										AND caption = '".cleanvars($rowvideosachi['caption'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										ORDER BY id DESC");
if(mysqli_num_rows($sqllmschecker) == 0) {
//------------------------------------------------
$svido++;
//------------------------------------------------
echo '
<tr>
	<td style="width:40px;text-align:center;">
		<input name="videoarchive[]" type="checkbox" id="videoarchive'.$svido.'" value="'.$rowvideosachi['id'].'" class="checkbox-inline">
	</td>
	<td style="width:50px; text-align:center;">'.$svido.'</td>
	<td>'.$rowvideosachi['caption'].'</td>
	<td style="width:50px; text-align:center;">'.get_admstatus($rowvideosachi['status']).'</td>
</tr>';
//------------------------------------------------
}
}
//------------------------------------------------
if($svido>0) {
//------------------------------------------------
echo '
<tr>
	<td colspan="15" style="text-align:right;">
<button class="btn btn-purple" name="import_videos" id="import_videos" type="submit" style="padding:5px 13px; font-size:12px; margin-top:5px;margin-left:5px;">Import</button> 
</tr>';
}
//------------------------------------------------
echo '
</tbody>
</table>
<input type="hidden" name="hdnCount" id="hdnCount" value="'.$svido.'">
</form>
<script>
function CheckForm(){
	var checked=false;
	var elements = document.getElementsByName("videoarchive[]");
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
			eval("document.frmMain.videoarchive"+iji+".checked=true");  
		} else  {  
			eval("document.frmMain.videoarchive"+iji+".checked=false");  
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