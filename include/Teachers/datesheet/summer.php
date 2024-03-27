<?php 
//Dateheet
$src = 0;
$sqllmsdetails  = $dblms->querylms("SELECT sd.timing, sd.confirm_date, c.curs_code, c.curs_name
										FROM ".SUMMER_DATESHEET." sd   
										INNER JOIN ".COURSES." c ON c.curs_id = sd.id_curs   
										WHERE sd.id_campus	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND sd.summer_year	= '".date("Y")."' AND sd.status = '1' 
										AND sd.id_teacher = '".cleanvars($rowstdpro['emply_id'])."' 
										ORDER BY sd.confirm_date ASC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsdetails) > 0) {
//------------------------------------------------
echo '
<br>
<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th colspan="10">
		<h4 class="modal-title" style="font-weight:700;">Summer Date Sheet ('.ARCHIVE_SESS.')</h4>
	</th>
</tr>
<tr>
	<th style="font-weight:600;text-align:center;">Sr.# </th>
	<th style="font-weight:600;text-align:center;">Code</th>
	<th style="font-weight:600;">Course Name</th>
	<th style="font-weight:600;text-align:center;">Timing</th>
	<th style="font-weight:600;">Dated</th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
while($rowcurs = mysqli_fetch_array($sqllmsdetails)) { 
//------------------------------------------------
	$src++;
	echo '
	<tr>
		<td style="width:30px; text-align:center;vertical-align:middle;">'.$src.'</td>
		<td style="width:90px;vertical-align:middle;">'.$rowcurs['curs_code'].'</td>
		<td style="vertical-align:middle;text-align:left;">'.$rowcurs['curs_name'].'</td>
		<td style="vertical-align:middle;text-align:center;width:120px;">'.(get_programtiming($rowcurs['timing'])).'</td>
		<td style="width:130px;text-align:left; vertical-align:middle;">'.date("D, j M Y", strtotime($rowcurs['confirm_date'])).'</td>
	</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//------------------------------------------------
}
?>