<?php 

echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">

<!--WI_MILESTONES_TABLE-->
<div class="row">
<div class="col-lg-12">
  
<div class="widget wtabs">
<div class="widget-content">';
//-----------------------------------------
echo '
<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th colspan="10">
		<h4 class="modal-title" style="font-weight:700;">Course Info</h4>
	</th>
</tr>
</thead>
<tbody>
<tr>
    <th width="13%"><strong>Course Code:</strong></th>
    <td idth="29%"><span class="label label-info" style="font-size:14px;">'.$rowsurs['curs_code'].'</span></td>
    <th width="18%"><strong>Credit Hours</strong></th>
    <td width="31%">'.$rowsurs['curs_credit_hours'].' (Theory: '.$rowsurs['cur_credithours_theory'].', Practical: '.$rowsurs['cur_credithours_practical'].')</td>
</tr>
<tr>
    <th><strong>Title</strong></th>
    <td colspan="3">'.$rowsurs['curs_name'].'</td>
</tr>

</tbody>
</table>

<h4 class="modal-title" style="font-weight:700; margin-top:15px;">Timetable</h4>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">Day</th>
	<th style="font-weight:600;">Period</th>
	<th style="font-weight:600;">Class Room</th>
</tr>
</thead>
<tbody>';
//----------------------------------------
	$sqllmstimetable  = $dblms->querylms("SELECT p.period_no, p.period_timestart, p.period_timeend, d.days, r.room_no     
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup  
										INNER JOIN ".TIMETABLE_ROOMS." r ON r.room_id = d.id_room   
										INNER JOIN ".TIMETABLE_PERIODS." p ON p.period_id = d.id_period  
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".ARCHIVE_SESS."'  
										AND d.id_curs = '".cleanvars($_GET['id'])."' AND t.timing =  '".cleanvars($_GET['timing'])."'
										AND t.status = '1' AND t.id_prg =  '".cleanvars($_GET['prgid'])."' $sqlsection 
										AND d.id_teacher = '".cleanvars($rowsurs['id_teacher'])."' 
										GROUP BY d.id_period ORDER BY d.id ASC");

$srtime = 0;
//------------------------------------------------
while($rowcurtime = mysqli_fetch_assoc($sqllmstimetable)) { 
//------------------------------------------------
$srtime++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px;">'.$srtime.'</td>
	<td>'.$rowcurtime['days'].'</td>
	<td>'.$rowcurtime['period_no'].' ('.$rowcurtime['period_timestart'].' - '.$rowcurtime['period_timeend'].')</td>
	<td>'.$rowcurtime['room_no'].'</td>
</tr>';
//------------------------------------------------
}
//------------------------------------------------
echo '
</tbody>
</table>



<h4 class="modal-title" style="font-weight:700; margin-top:15px; border-bottom: 1px dotted #999; padding-bottom: 5px;">Course Outline</h4>
<p>'.html_entity_decode ($rowsurs['curs_detail'], ENT_QUOTES).'</p>

</div>
</div>
</div>
</div>

<!--WI_MILESTONES_TABLE-->
<!--WI_TABS_NOTIFICATIONS-->

</div>
<div class="clearfix"></div>
</div>
</div>
</div>'; 


?>