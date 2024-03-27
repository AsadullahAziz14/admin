<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && isset($_GET['archive'])) { 
//------------------------------------------------
	$sqllmsbookachive  = $dblms->querylms("SELECT id, status, id_curs, url, book_name, author_name, edition, isbn, publisher  
										FROM ".COURSES_BOOKS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session != '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."'   
										ORDER BY id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsbookachive) > 0) {
echo '
<div style="clear:both;"></div>
<form name="frmMain" id="frmMain" method="post" action="courses.php?id='.$_GET['id'].'&view=Books" OnSubmit="return CheckForm();">
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;">
		<input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);" class="checkbox-inline">
	</th>
	<th style="font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">Book Name</th>
	<th style="font-weight:600;">Author</th>
	<th style="font-weight:600;">Edition</th>
	<th style="font-weight:600;text-align:center">Status</th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
while($rowbookachi = mysqli_fetch_assoc($sqllmsbookachive)) { 
//------------------------------------------------
$sqllmschecker  = $dblms->querylms("SELECT *   
										FROM ".COURSES_BOOKS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND book_name = '".cleanvars($rowbookachi['book_name'])."'
										AND author_name = '".cleanvars($rowbookachi['author_name'])."'  LIMIT 1");
if(mysqli_num_rows($sqllmschecker) == 0) {
$srbk++;
//------------------------------------------------
echo '
<tr>
	<td style="width:40px;text-align:center;">
		<input name="bookarchive[]" type="checkbox" id="bookarchive'.$srbk.'" value="'.$rowbookachi['id'].'" class="checkbox-inline">
	</td>
	<td style="width:40px;text-align:center;">'.$srbk.'</td>
	<td>'.$rowbookachi['book_name'].'</td>
	<td>'.$rowbookachi['author_name'].'</td>
	<td>'.$rowbookachi['edition'].'</td>
	<td style="width:60px; text-align:center;">'.get_admstatus($rowbookachi['status']).'</td>
</tr>';
//------------------------------------------------
}
}
if($srbk>0) {
//------------------------------------------------
echo '
<tr>
	<td colspan="15" style="text-align:right;">
<button class="btn btn-purple" name="import_books" id="import_books" type="submit" style="padding:5px 13px; font-size:12px; margin-top:5px;margin-left:5px;">Import</button> 
</tr>';
}
//------------------------------------------------
echo '
</tbody>
</table>
<input type="hidden" name="hdnCount" id="hdnCount" value="'.$srbk.'">
</form>
<script>
function CheckForm(){
	var checked=false;
	var elements = document.getElementsByName("bookarchive[]");
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
			eval("document.frmMain.bookarchive"+iji+".checked=true");  
		} else  {  
			eval("document.frmMain.bookarchive"+iji+".checked=false");  
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

