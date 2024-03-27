<?php 
//Dateheet
echo '<h4 class="modal-title" style="font-weight:700;">Date Sheet ('.$_SESSION['userlogininfo']['LOGINIDACADYEAR'].')</h4>';
$src = 0;
$sqllmsdetails  = $dblms->querylms("SELECT c.curs_code, c.curs_name, p.prg_name, t.semester, t.timing, t.section, 
										td.conifrm_date, eb.exam_timing   
										FROM ".TENTATIVE_DATESHEET_DETAIL." td  
										INNER JOIN ".TENTATIVE_DATESHEET." t ON t.id = td.id_setup   
										INNER JOIN ".COURSES." c ON c.curs_id = td.id_curs  
										INNER JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg   
										INNER JOIN ".EXAMS_BATCHES." eb ON eb.id = td.id_shift  
										WHERE td.id_teacher = '".cleanvars($rowstdpro['emply_id'])."' 
										AND t.status = '1' AND t.examterm = '1' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
										AND t.is_deleted != '1' AND t.is_liberalarts != '1'
										ORDER BY td.conifrm_date ASC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsdetails) > 0) {
//------------------------------------------------
echo '
<br>
<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th colspan="10">
		<h4 class="modal-title" style="font-weight:700;">Date Sheet ('.$_SESSION['userlogininfo']['LOGINIDACADYEAR'].')</h4>
	</th>
</tr>
<tr>
	<th style="font-weight:600;text-align:center;">Sr.#</th>
	<th style="font-weight:600;text-align:center;">Code</th>
	<th style="font-weight:600;">Course Name</th>
	<th style="font-weight:600;">Program Name</th>
	<th style="font-weight:600;text-align:center;">Semester</th>
	<th style="font-weight:600;text-align:center;">Section</th>
	<th style="font-weight:600;">Dated</th>
	<th style="font-weight:600;text-align:center;">Timing</th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
while($rowcurs = mysqli_fetch_array($sqllmsdetails)) { 
//--------------------------------------
$src++;

//------------------------------------------------
echo '
<tr>
	<td style="width:30px; text-align:center;vertical-align:middle;">'.$src.'</td>
	<td style="width:80px;vertical-align:middle;">'.$rowcurs['curs_code'].'</td>
	<td style="vertical-align:middle;text-align:left;">'.$rowcurs['curs_name'].'</td>
	<td style="vertical-align:middle;text-align:left;">'.$rowcurs['prg_name'].'</td>
	<td style="vertical-align:middle;text-align:center;width:80px;">'.addOrdinalNumberSuffix($rowcurs['semester']).'</td>
	<td style="vertical-align:middle;text-align:center;width:80px;">'.($rowcurs['section']).'</td>
	<td style="width:130px;text-align:left; vertical-align:middle;">'.date("D, j M Y", strtotime($rowcurs['conifrm_date'])).'</td>
	<td style="width:150px; vertical-align:middle;">
		'.$rowcurs['exam_timing'].'
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//------------------------------------------------
}

// Liberal Arts Date Sheet
$lasrc = 0;
$sqllmsladetails  = $dblms->querylms("SELECT c.curs_code, c.curs_name, t.semester, t.timing, td.lasection, 
										td.conifrm_date, eb.exam_timing   
										FROM ".TENTATIVE_DATESHEET_DETAIL." td  
										INNER JOIN ".TENTATIVE_DATESHEET." t ON t.id = td.id_setup   
										INNER JOIN ".COURSES." c ON c.curs_id = t.lacurs  										
										INNER JOIN ".EXAMS_BATCHES." eb ON eb.id = td.id_shift  
										WHERE td.id_teacher = '".cleanvars($rowstdpro['emply_id'])."' 
										AND t.status = '1' AND t.examterm = '1' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
										AND t.is_deleted != '1' AND t.is_liberalarts = '1'
										ORDER BY td.conifrm_date ASC, td.lasection ASC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsladetails) > 0) {
//------------------------------------------------
echo '
<br>
<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th colspan="10">
		<h4 class="modal-title" style="font-weight:700; color:#00f;">Liberal Arts</h4>
	</th>
</tr>
<tr>
	<th style="font-weight:600;text-align:center;">Sr.#</th>
	<th style="font-weight:600;text-align:center;">Code</th>
	<th style="font-weight:600;">Course Name</th>
	<th style="font-weight:600;text-align:center;">Semester</th>
	<th style="font-weight:600;text-align:center;">Section</th>
	<th style="font-weight:600;">Dated</th>
	<th style="font-weight:600;text-align:center;">Timing</th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
while($rowlacurs = mysqli_fetch_array($sqllmsladetails)) { 
//--------------------------------------
$lasrc++;

//------------------------------------------------
echo '
<tr>
	<td style="width:30px; text-align:center;vertical-align:middle;">'.$lasrc.'</td>
	<td style="width:80px;vertical-align:middle;">'.$rowlacurs['curs_code'].'</td>
	<td style="vertical-align:middle;text-align:left;">'.$rowlacurs['curs_name'].'</td>
	<td style="vertical-align:middle;text-align:center;width:80px;">'.addOrdinalNumberSuffix($rowlacurs['semester']).'</td>
	<td style="vertical-align:middle;text-align:center;width:80px;">'.($rowlacurs['lasection']).'</td>
	<td style="width:130px;text-align:left; vertical-align:middle;">'.date("D, j M Y", strtotime($rowlacurs['conifrm_date'])).'</td>
	<td style="width:150px; vertical-align:middle;">
		'.$rowlacurs['exam_timing'].'
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//------------------------------------------------
}
