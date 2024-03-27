<?php 
if(!LMS_VIEW && !isset($_GET['id'])) {  
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	} 
//------------------------------------------------
	$sqllmsAppointments = $dblms->querylms("SELECT ap.id
													FROM ".LA_ADVISORAPPOINTMENTS." ap
													INNER JOIN ".STUDENTS." std ON std.std_id = ap.id_std 
													LEFT JOIN ".COURSES." cr ON cr.curs_id = ap.id_curs
                                                    WHERE ap.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
                                                    AND ap.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
													AND ap.id_advisor = '".cleanvars($rowsstd['emply_id'])."'  
                                                    ORDER BY ap.id DESC");
//--------------------------------------------------
	$count = mysqli_num_rows($sqllmsAppointments);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
//--------------------------------------------------
	$sqllmsAppointments  = $dblms->querylms("SELECT ap.*, cr.curs_code, cr.curs_name, cr.cur_credithours_theory, cr.cur_credithours_practical, std.std_id, std.std_name, std.std_regno, std.std_photo, std.std_session 
													FROM ".LA_ADVISORAPPOINTMENTS." ap
													INNER JOIN ".STUDENTS." std ON std.std_id = ap.id_std 
													LEFT JOIN ".COURSES." cr ON cr.curs_id = ap.id_curs
                                                    WHERE ap.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
													AND ap.id_advisor = '".cleanvars($rowsstd['emply_id'])."'  
                                                    AND ap.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                                    ORDER BY ap.id DESC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsAppointments) > 0) {
//--------------------------------------------------
echo '
<div style=" float:right; text-align:right; font-weight:700; color:red; margin-right:10px;"> 
	<span class="navbar-form navbar-left form-small">
		Total Records: ('.number_format($count).') 
	</span>
</div>
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style=" font-weight:600;text-align:center;">SR # </th>
	<th style="font-weight:700; text-align:center;" width="35px">Pic</th>
	<th style=" font-weight:600;"> Student Name</th>
	<th style=" font-weight:600;"> Course Name</th>
	<th style=" font-weight:600;text-align:center;"> Semester</th>
	<th style=" font-weight:600;text-align:center;"> Section</th>
	<th style=" font-weight:600;text-align:center;"> Request Date</th>
	<th style=" font-weight:600;text-align:center;"> Appointment Date</th>
	<th style="text-align:center;font-weight:600;"> Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
if($page ==1) { $srno = 0;} else { $srno = ($Limit * ($page-1));}
//------------------------------------------------
while($valueAppointment = mysqli_fetch_array($sqllmsAppointments)) { 
//------------------------------------------------
	$srno++;

	$canEdit = '<a class="btn btn-xs btn-info" href="lateacherappointments.php?id='.$valueAppointment['id'].'"><i class="icon-pencil"></i></a>';
	
	if($valueAppointment['std_photo']) { 
		$stdPhoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$valueAppointment['std_photo'].'" alt="'.$valueAppointment['std_name'].'"/>';
	} else {
		$stdPhoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$valueAppointment['std_name'].'"/>';
	}
	
	if($valueAppointment['id_curs']) {
		$cursname = $valueAppointment['curs_code'].' - '.$valueAppointment['curs_name'].' <br>(<span style="color:#00f; font-size:11px;">Theory: '.$valueAppointment['cur_credithours_theory'].'</span>, <span style="color:darkorange; font-size:11px;">Practical: '.$valueAppointment['cur_credithours_practical'].'</span>)';
	} else {
		$cursname = '';
	}
//------------------------------------------------
echo '
<tr>
	<td style="width:50px;text-align:center;vertical-align:middle;">'.$srno.'</td>
	<td style="vertical-align:middle;">'.$stdPhoto.'</td>
	<td  style="vertical-align:middle; font-weight:600;"><div>'.$valueAppointment['std_regno'].'</div><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$valueAppointment['std_name'].' ('.$valueAppointment['std_session'].')</b>" data-src="studentdetail.php?std_id='.$valueAppointment['std_id'].'" href="#"> '.$valueAppointment['std_name'].'</a> </td>
	<td  style="vertical-align:middle;">'.$cursname.'</td>
	<td style="vertical-align:middle;text-align:center;width:70px;">'.addOrdinalNumberSuffix($valueAppointment['semester']).'</td>
	<td  style="vertical-align:middle;width:100px;text-align:center;">'.$valueAppointment['section'].'</td>
	<td  style="vertical-align:middle;width:120px;text-align:center;">'.date('d-m-Y', strtotime($valueAppointment['request_date'])).'</td>
	<td  style="vertical-align:middle;width:150px;text-align:center;">'.date('d-m-Y', strtotime($valueAppointment['appointment_date'])).'</td>
	<td style="width:55px; vertical-align:middle; text-align:center;">'.get_appointstatus($valueAppointment['status']).'</td>
	<td style="text-align:center; vertical-align:middle;"><a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe" data-modal-window-title="<b>Appointment Detail </b>" data-src="laappointmentsview.php?id='.$valueAppointment['id'].'" href="#"><i class="icon-zoom-in"></i></a>  '.$canEdit.'
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
if($count>$Limit) {
echo '
<div class="widget-foot">
<!--WI_PAGINATION-->
<ul class="pagination pull-right">';
//--------------------------------------------------
$pagination = "";

if($lastpage > 1) {	
//previous button
if ($page > 1) {
	$pagination.= '<li><a href="lateacherappointments.php?page='.$prev.$sqlstring.'">Prev</a></li>';
}
//pages	
if ($lastpage < 7 + ($adjacents * 3)) {	//not enough pages to bother breaking it up
	for ($counter = 1; $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="lateacherappointments.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
		}
	}
} else if($lastpage > 5 + ($adjacents * 3))	{ //enough pages to hide some
//close to beginning; only hide later pages
	if($page < 1 + ($adjacents * 3)) {
		for ($counter = 1; $counter < 4 + ($adjacents * 3); $counter++)	{
			if ($counter == $page) {
				$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
			} else {
				$pagination.= '<li><a href="lateacherappointments.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
			}
		}
		$pagination.= '<li><a href="#"> ... </a></li>';
		$pagination.= '<li><a href="lateacherappointments.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
		$pagination.= '<li><a href="lateacherappointments.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
		$pagination.= '<li><a href="lateacherappointments.php?page=1'.$sqlstring.'">1</a></li>';
		$pagination.= '<li><a href="lateacherappointments.php?page=2'.$sqlstring.'">2</a></li>';
		$pagination.= '<li><a href="lateacherappointments.php?page=3'.$sqlstring.'">3</a></li>';
		$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="lateacherappointments.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
	$pagination.= '<li><a href="#"> ... </a></li>';
	$pagination.= '<li><a href="lateacherappointments.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
	$pagination.= '<li><a href="lateacherappointments.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else { //close to end; only hide early pages
	$pagination.= '<li><a href="lateacherappointments.php?page=1'.$sqlstring.'">1</a></li>';
	$pagination.= '<li><a href="lateacherappointments.php?page=2'.$sqlstring.'">2</a></li>';
	$pagination.= '<li><a href="lateacherappointments.php?page=3'.$sqlstring.'">3</a></li>';
	$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="lateacherappointments.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
}
}
//next button
if ($page < $counter - 1) {
	$pagination.= '<li><a href="lateacherappointments.php?page='.$next.$sqlstring.'">Next</a></li>';
} else {
	$pagination.= "";
}
	echo $pagination;
}

echo '
</ul>
<!--WI_PAGINATION-->
	<div class="clearfix"></div>
</div>';
}
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