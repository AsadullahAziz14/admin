<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && isset($_GET['archive'])) { 
//------------------------------------------------
	$sqllmsweblinkachi  = $dblms->querylms("SELECT * 
										FROM ".COURSES_LINKS." cl 
										WHERE cl.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND cl.academic_session != '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND cl.id_curs = '".cleanvars($_GET['id'])."' 
										AND cl.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										ORDER BY cl.id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsweblinkachi) > 0) {
echo '
<div style="clear:both;"></div>

<div style="clear:both;"></div>
<form name="frmMain" id="frmMain" method="post" action="courses.php?id='.$_GET['id'].'&view=Weblinks" OnSubmit="return CheckForm();">
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;">
		<input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);" class="checkbox-inline">
	</th>
	<th style="font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">URL</th>
	<th style="font-weight:600;">Detail</th>
	<th style="font-weight:600;text-align:center">Status</th>
</tr>
</thead>
<tbody>';
$srwl = 0;
//------------------------------------------------
while($rowweblinkachi = mysqli_fetch_assoc($sqllmsweblinkachi)) { 
//------------------------------------------------
	$sqllmscheckre  = $dblms->querylms("SELECT id  
										FROM ".COURSES_LINKS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND url = '".cleanvars($rowweblinkachi['url'])."' LIMIT 1");
if(mysqli_num_rows($sqllmscheckre) == 0) { 

$srwl++;
//------------------------------------------------
echo '
<tr>
	<td style="width:40px;text-align:center;">
		<input name="weblinkarchive[]" type="checkbox" id="weblinkarchive'.$srwl.'" value="'.$rowweblinkachi['id'].'" class="checkbox-inline">
	</td>
	<td style="width:40px;text-align:center;">'.$srwl.'</td>
	<td style="width:200px;"><a href="'.$rowweblinkachi['url'].'" target="_blank" class="links-blue">'.$rowweblinkachi['url'].'</a></td>
	<td>'.$rowweblinkachi['detail'].'</td> 
	<td style="width:50px; text-align:center;">'.get_admstatus($rowweblinkachi['status']).'</td>
</tr>';
//------------------------------------------------
}
}
if($srwl>0) {
//------------------------------------------------
echo '
<tr>
	<td colspan="15" style="text-align:right;">
<button class="btn btn-purple" name="import_weblink" id="import_weblink" type="submit" style="padding:5px 13px; font-size:12px; margin-top:5px;margin-left:5px;">Import</button> 
</tr>';
}
//------------------------------------------------
echo '
</tbody>
</table>
<input type="hidden" name="hdnCount" id="hdnCount" value="'.$srwl.'">
</form>
<script>
function CheckForm(){
	var checked=false;
	var elements = document.getElementsByName("weblinkarchive[]");
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
			eval("document.frmMain.weblinkarchive"+iji+".checked=true");  
		} else  {  
			eval("document.frmMain.weblinkarchive"+iji+".checked=false");  
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