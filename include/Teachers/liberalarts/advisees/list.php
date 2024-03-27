<?php 
if(!LMS_VIEW && !isset($_GET['id']) && !isset($_GET['std_id'])) {  
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
$page = (int)$page;
//------------------------------------------------
	$sqllmsStudents  = $dblms->querylms("SELECT la.id
											FROM ".LA_ADVISOR_STUDENT." la
											INNER JOIN ".STUDENTS." std ON std.std_id = la.id_std
											INNER JOIN ".PROGRAMS." prg ON prg.prg_id = std.id_prg 
											INNER JOIN ".EMPLYS." emp ON emp.emply_id = la.id_advisor
											INNER JOIN ".DEPTS." dep ON dep.dept_id = emp.id_dept
											WHERE la.id_advisor = '".cleanvars($rowsstd['emply_id'])."'  
											AND la.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND la.is_deleted != '1' $sql2
											ORDER BY la.id DESC");
//--------------------------------------------------
	$count = mysqli_num_rows($sqllmsStudents);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
//--------------------------------------------------
	$sqllmsStudents  = $dblms->querylms("SELECT la.id, la.status, la.fromsemester, la.tosemester, std.std_id, std.std_regno, std.std_name, std.std_rollno, std.std_session, std.std_semester, std.std_section, std.std_mobile, std.std_email, std.std_photo,  
											std.std_timing, std.std_fathername, dep.dept_name, emp.emply_name 
											FROM ".LA_ADVISOR_STUDENT." la
											INNER JOIN ".STUDENTS." std ON std.std_id = la.id_std
											INNER JOIN ".EMPLYS." emp ON emp.emply_id = la.id_advisor
											INNER JOIN ".DEPTS." dep ON dep.dept_id = emp.id_dept
											WHERE la.id_advisor = '".cleanvars($rowsstd['emply_id'])."' 
											AND la.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND la.is_deleted != '1' $sql2 
											ORDER BY la.id DESC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsStudents) > 0) {
//--------------------------------------------------
echo '
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<div style=" float:right; text-align:right; font-weight:700; color:red; margin-right:10px;"> 
	<span class="navbar-form navbar-left form-small">
		Total Students: ('.number_format($count).')
	</span>
</div>
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style=" font-weight:600;text-align:center;">SR #</th>
	<th style="font-weight:700; text-align:center;" width="35px">Pic</th>
	<th style=" font-weight:600;"> Student</th>
	<th style="font-weight:700;text-align:center;"> From Semester </th>
	<th style="font-weight:700;text-align:center;"> To Semester </th>
	<th style="text-align:center;font-weight:600;"> Status</th>
	<th style=" width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
	
//------------------------------------------------
if($page ==1) { $srno = 0;} else { $srno = ($Limit * ($page-1));}
//------------------------------------------------
while($valueStudent = mysqli_fetch_array($sqllmsStudents)) { 
//------------------------------------------------
	$srno++;

	//$canEdit = '<a class="btn btn-xs btn-info" href="lateacherappointments.php?id='.$valueAppointment['id'].'"><i class="icon-pencil"></i></a>';
	
	if($valueStudent['std_photo']) { 
		$stdPhoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$valueStudent['std_photo'].'" alt="'.$valueStudent['std_name'].'"/>';
	} else {
		$stdPhoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$valueStudent['std_name'].'"/>';
	}
//------------------------------------------------
echo '
<tr>
	<td style="width:50px;text-align:center;vertical-align:middle;">'.$srno.'</td>
	<td style="vertical-align:middle;">'.$stdPhoto.'</td>
	<td style="vertical-align:middle;font-weight:600;">
		'.$valueStudent['std_regno'].'
		<div class="links-blue">'.$valueStudent['std_name'].' ('.addOrdinalNumberSuffix($valueStudent['std_semester']).')</div>
	</td>
	<td style="vertical-align:middle;text-align:center;width:120px;">'.addOrdinalNumberSuffix($valueStudent['fromsemester']).'</td>
	<td style="vertical-align:middle;text-align:center;width:100px;">'.addOrdinalNumberSuffix($valueStudent['tosemester']).'</td>
	<td style="width:55px; vertical-align:middle; text-align:center;">'.get_admstatus($valueStudent['status']).'</td>
	<td style="text-align:center;vertical-align: middle;">
		<a class="btn btn-xs btn-info iframeModal" data-height="400" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Student Profile of '.$valueStudent['std_name'].' ('.$valueStudent['std_session'].')</b>" data-src="laadviseesprofile.php?std_id='.$valueStudent['std_id'].'&ladvisor=1" href="#"><i class="icon-zoom-in"></i></a>';
		if($enableRegistrationEdit == 1){
			echo '<a class="btn btn-xs btn-info" href="?std_id='.$valueStudent['std_id'].'"><i class="icon-eye-open"></i></a>';
		} 
		echo '
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
	$pagination.= '<li><a href="laadvisees.php?page='.$prev.$sqlstring.'">Prev</a></li>';
}
//pages	
if ($lastpage < 7 + ($adjacents * 3)) {	//not enough pages to bother breaking it up
	for ($counter = 1; $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="laadvisees.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
		}
	}
} else if($lastpage > 5 + ($adjacents * 3))	{ //enough pages to hide some
//close to beginning; only hide later pages
	if($page < 1 + ($adjacents * 3)) {
		for ($counter = 1; $counter < 4 + ($adjacents * 3); $counter++)	{
			if ($counter == $page) {
				$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
			} else {
				$pagination.= '<li><a href="laadvisees.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
			}
		}
		$pagination.= '<li><a href="#"> ... </a></li>';
		$pagination.= '<li><a href="laadvisees.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
		$pagination.= '<li><a href="laadvisees.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
		$pagination.= '<li><a href="laadvisees.php?page=1'.$sqlstring.'">1</a></li>';
		$pagination.= '<li><a href="laadvisees.php?page=2'.$sqlstring.'">2</a></li>';
		$pagination.= '<li><a href="laadvisees.php?page=3'.$sqlstring.'">3</a></li>';
		$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="laadvisees.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
	$pagination.= '<li><a href="#"> ... </a></li>';
	$pagination.= '<li><a href="laadvisees.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
	$pagination.= '<li><a href="laadvisees.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else { //close to end; only hide early pages
	$pagination.= '<li><a href="laadvisees.php?page=1'.$sqlstring.'">1</a></li>';
	$pagination.= '<li><a href="laadvisees.php?page=2'.$sqlstring.'">2</a></li>';
	$pagination.= '<li><a href="laadvisees.php?page=3'.$sqlstring.'">3</a></li>';
	$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="laadvisees.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
}
}
//next button
if ($page < $counter - 1) {
	$pagination.= '<li><a href="laadvisees.php?page='.$next.$sqlstring.'">Next</a></li>';
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