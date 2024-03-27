<?php 
if(!LMS_VIEW && !isset($_GET['id'])) {  
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	} 
$page = (int)$page;
//------------------------------------------------
	$sqllmsAppointments = $dblms->querylms("SELECT ag.group_id
													FROM ".LA_ADVISORAPPOINTMENTS_GROUP." ag
                                                    WHERE ag.id_advisor = '".cleanvars($rowsstd['emply_id'])."' $sql2
													AND ag.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
                                                    AND ag.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
                                                    ORDER BY ag.group_id DESC");
//--------------------------------------------------
	$count = mysqli_num_rows($sqllmsAppointments);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
//--------------------------------------------------
	$sqllmsAppointments  = $dblms->querylms("SELECT ag.*
													FROM ".LA_ADVISORAPPOINTMENTS_GROUP." ag
													WHERE ag.id_advisor = '".cleanvars($rowsstd['emply_id'])."' $sql2
                                                    AND ag.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
                                                    AND ag.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
                                                    ORDER BY ag.group_id DESC LIMIT ".($page-1)*$Limit .",$Limit");
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
	<th style=" font-weight:600;"> Group Name</th>
	<th style=" font-weight:600;"> Date</th>
	<th style=" font-weight:600;text-align:center;"> Duration</th>
	<th style=" font-weight:600;text-align:center;"> Students</th>
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
	$addAttendance = '<a class="btn btn-xs btn-success" href="lateacherappointmentsgroup.php?view=addAttendance&id='.$valueAppointment['group_id'].'">Mark Attendance</a>';
	$canEdit = '<a class="btn btn-xs btn-info" href="lateacherappointmentsgroup.php?id='.$valueAppointment['group_id'].'"><i class="icon-pencil"></i></a>';

	$sqllmsStudent = $dblms->querylms("SELECT COUNT(id_std) as totalStudent
													FROM ".LA_ADVISORAPPOINTMENTS_GROUP_DETAIL."
													WHERE id_group = '".cleanvars($valueAppointment['group_id'])."'");
	$valueStudent = mysqli_fetch_array($sqllmsStudent);

	echo '
	<tr>
		<td style="width:50px;text-align:center;vertical-align:middle;">'.$srno.'</td>
		<td  style="vertical-align:middle;"><a class="links-blue" href="#">'.$valueAppointment['group_name'].'</a> </td>
		<td  style="vertical-align:middle;">'.date('d-m-Y', strtotime($valueAppointment['group_date'])).'</td>
		<td style="vertical-align:middle;text-align:center;width:100px;">'.$valueAppointment['group_timeduration'].'</td>
		<td style="vertical-align:middle;text-align:center;width:70px;">'.$valueStudent['totalStudent'].'</td>
		<td style="width:55px; vertical-align:middle; text-align:center;">'.get_appointstatus($valueAppointment['group_status']).'</td>
		<td style="text-align:center; vertical-align:middle;">
			'.$addAttendance.$canEdit.'
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
	$pagination.= '<li><a href="lateacherappointmentsgroup?page='.$prev.$sqlstring.'">Prev</a></li>';
}
//pages	
if ($lastpage < 7 + ($adjacents * 3)) {	//not enough pages to bother breaking it up
	for ($counter = 1; $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="lateacherappointmentsgroup?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
		}
	}
} else if($lastpage > 5 + ($adjacents * 3))	{ //enough pages to hide some
//close to beginning; only hide later pages
	if($page < 1 + ($adjacents * 3)) {
		for ($counter = 1; $counter < 4 + ($adjacents * 3); $counter++)	{
			if ($counter == $page) {
				$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
			} else {
				$pagination.= '<li><a href="lateacherappointmentsgroup?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
			}
		}
		$pagination.= '<li><a href="#"> ... </a></li>';
		$pagination.= '<li><a href="lateacherappointmentsgroup?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
		$pagination.= '<li><a href="lateacherappointmentsgroup?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
		$pagination.= '<li><a href="lateacherappointmentsgroup?page=1'.$sqlstring.'">1</a></li>';
		$pagination.= '<li><a href="lateacherappointmentsgroup?page=2'.$sqlstring.'">2</a></li>';
		$pagination.= '<li><a href="lateacherappointmentsgroup?page=3'.$sqlstring.'">3</a></li>';
		$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="lateacherappointmentsgroup?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
	$pagination.= '<li><a href="#"> ... </a></li>';
	$pagination.= '<li><a href="lateacherappointmentsgroup?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
	$pagination.= '<li><a href="lateacherappointmentsgroup?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else { //close to end; only hide early pages
	$pagination.= '<li><a href="lateacherappointmentsgroup?page=1'.$sqlstring.'">1</a></li>';
	$pagination.= '<li><a href="lateacherappointmentsgroup?page=2'.$sqlstring.'">2</a></li>';
	$pagination.= '<li><a href="lateacherappointmentsgroup?page=3'.$sqlstring.'">3</a></li>';
	$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="lateacherappointmentsgroup?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
}
}
//next button
if ($page < $counter - 1) {
	$pagination.= '<li><a href="lateacherappointmentsgroup?page='.$next.$sqlstring.'">Next</a></li>';
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