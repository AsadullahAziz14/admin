<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && isset($_GET['archive'])) { 
//------------------------------------------------
	$sqllmsfaqsachive  = $dblms->querylms("SELECT id, status, id_curs, question, answer 
										FROM ".COURSES_FAQS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session != '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										ORDER BY id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsfaqsachive) > 0) {
echo '
<div style="clear:both;"></div>
<form name="frmMain" id="frmMain" method="post" action="courses.php?id='.$_GET['id'].'&view=FAQs" OnSubmit="return CheckForm();">
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;">
		<input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);" class="checkbox-inline">
	</th>
	<th style="font-weight:600;text-align:center;">Sr.#</th>
	<th style="font-weight:600;">FAQs</th>
	<th style="font-weight:600;">Answer</th>
	<th style="font-weight:600;text-align:center;">Status</th>
</tr>
</thead>
<tbody>';
$srf = 0;
//------------------------------------------------
while($rowfaqsachi = mysqli_fetch_assoc($sqllmsfaqsachive)) { 
//------------------------------------------------
//------------------------------------------------
$sqllmschecker  = $dblms->querylms("SELECT id, status, id_curs, question, answer 
										FROM ".COURSES_FAQS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND question = '".cleanvars($rowfaqsachi['question'])."'
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										ORDER BY id DESC");
if(mysqli_num_rows($sqllmschecker) == 0) {
$srf++;
//------------------------------------------------
echo '
<tr>
	<td style="width:40px;text-align:center;">
		<input name="faqsarchive[]" type="checkbox" id="faqsarchive'.$srf.'" value="'.$rowfaqsachi['id'].'" class="checkbox-inline">
	</td>
	<td style="width:40px;text-align:center">'.$srf.'</td>
	<td style="width:200px;">'.$rowfaqsachi['question'].'</td>
	<td>'.$rowfaqsachi['answer'].'</td>
	<td style="width:50px; text-align:center;">'.get_admstatus($rowfaqsachi['status']).'</td>
</tr>';
//------------------------------------------------
}
}
//------------------------------------------------
if($srf>0) {
//------------------------------------------------
echo '
<tr>
	<td colspan="15" style="text-align:right;">
<button class="btn btn-purple" name="import_faqs" id="import_faqs" type="submit" style="padding:5px 13px; font-size:12px; margin-top:5px;margin-left:5px;">Import</button> 
</tr>';
}
//------------------------------------------------
echo '
</tbody>
</table>
<input type="hidden" name="hdnCount" id="hdnCount" value="'.$srf.'">
</form>
<script>
function CheckForm(){
	var checked=false;
	var elements = document.getElementsByName("faqsarchive[]");
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
			eval("document.frmMain.faqsarchive"+iji+".checked=true");  
		} else  {  
			eval("document.frmMain.faqsarchive"+iji+".checked=false");  
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