<?php 
//--------------------------------------------------	
$sqllmsstdcurs  = $dblms->querylms("SELECT DISTINCT(d.id_curs), t.section, t.id_prg, t.timing,  t.semester     
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs  
										INNER JOIN ".EMPLYS." e ON e.emply_id = d.id_teacher   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."'   
										AND t.status = '1' AND t.id_prg = '".cleanvars($_GET['prgid'])."' $sqlsection 
										AND d.id_curs = '".cleanvars($_GET['id'])."' ORDER BY t.session ASC");
$cursstudents = array();
$countstudents = 0;
//--------------------------------------------------
while($rowtsurs = mysqli_fetch_array($sqllmsstdcurs)) {
if($rowtsurs['section']) {
	$stdsection 	= " AND std.std_section =  '".cleanvars($rowtsurs['section'])."'"; 
} else { 
	$stdsection 	= " "; 
}
//--------------------------------------------------
	$sqllmsstds  = $dblms->querylms("SELECT *   
											FROM ".STUDENTS." std 
											INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
											WHERE (std.std_status = '2' OR std.std_status = '7')  
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prg = '".cleanvars($rowtsurs['id_prg'])."' 
											AND std.std_timing = '".cleanvars($rowtsurs['timing'])."'
											AND std.std_semester = '".cleanvars($rowtsurs['semester'])."' $stdsection 
											ORDER BY std.std_rollno ASC, std.std_regno ASC");
	while($rowcurstds = mysqli_fetch_assoc($sqllmsstds)) { 
		$cursstudents[] = $rowcurstds;
		$countstudents++;
	}
}
//--------------------------------------------------
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="cursAddAttendanceModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="addAssign" enctype="multipart/form-data">
<input type="hidden" name="id_curs" name="id_curs" value="'.$_GET['id'].'">
<input type="hidden" name="id_teacher" name="id_teacher" value="'.$rowsurs['id_teacher'].'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;">Add Student Attendance</h4>
</div>

<div class="modal-body">

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Lecture: #</label>
			<select id="lectureno" name="lectureno" style="width:100%" autocomplete="off" required>
				<option value="">Select Lecture</option>';
			for($isem = 1; $isem<=40; $isem ++) {
				echo '<option value="'.$isem.'">Lecture: '.$isem.'</option>';
			}
	echo'
			</select>
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Dated </label>
			<input type="text" name="dated" id="dated" class="form-control pickadate" value="'.date("Y-m-d").'" required autocomplete="off" >
		</div> 
	</div>

	<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	Total Students: ('.number_format($countstudents).')
</div>
<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr class="heading-modal">
	<th style="font-weight:600; vertical-align:middle; text-align:center;">Sr.#</th>
	<th style="font-weight:600; vertical-align:middle; text-align:center;">Roll No</th>
	<th style="font-weight:600; vertical-align:middle;">Reg #</th>
	<th width="35px" style="font-weight:600; vertical-align:middle;">Pic</th>
	<th style="font-weight:600; vertical-align:middle;">Student Name</th>
	<th style="font-weight:600; text-align:center;">Status<div style="color:red; font-size:10px;">Just Check Absant</div></th>
	<th style="font-weight:600; vertical-align:middle;">Remarks</th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
foreach($cursstudents as $rowcurstds) { 
 
$srbk++;
//------------------------------------------------
if($rowcurstds['std_photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$rowcurstds['std_photo'].'" alt="'.$rowcurstds['std_name'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$rowcurstds['std_name'].'"/>';
}
//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srbk.'</td>
	<td style="width:70px; text-align:center;">'.$rowcurstds['std_rollno'].'</td>
	<td style="width:150px;">'.$rowcurstds['std_regno'].'</td>
	<td>'.$stdphoto.'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowcurstds['std_name'].' ('.$rowcurstds['std_session'].')</b>" data-src="studentdetail.php?std_id='.$rowcurstds['std_id'].'" href="#">'.$rowcurstds['std_name'].'</a> </td>
	<td style="width:110px; text-align:center;"><input name="status['.$srbk.']" type="checkbox" id="status['.$srbk.']" value="1" class="checkbox-inline"></td>
	<td style="width:150px;"><input type="text" class="form-control col-lg-12" id="remarks['.$srbk.']" name="remarks['.$srbk.']" autocomplete="off"></td>
</tr>
<input type="hidden" name="id_std['.$srbk.']" id="id_std['.$srbk.']" value="'.$rowcurstds['std_id'].'">';
//------------------------------------------------
}
//------------------------------------------------
echo '
</tbody>
</table>
	<div style="clear:both;"></div>
	

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
	<input class="btn btn-primary" type="submit" value="Add Record" id="submit_attendance" name="submit_attendance">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#lectureno").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addAssign").validate({
		rules: {
             lectureno		: "required",
			 dated			: "required"
		},
		messages: {
			lectureno		: "This field is required",
			dated			: "This field is required"
		},
		submitHandler: function(form) {
        //alert("form submitted");
		form.submit();
        }
	});
});
</script>';
?>