<?php 
if(isset($_GET['editid'])) {  
//------------------------------------------------
	$sqllmsAttendanceEdit  = $dblms->querylms("SELECT *   
													FROM ".ASSEMBLY_ATTENDANCE." 
													WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
													AND id = '".cleanvars($_GET['editid'])."' 
													LIMIT 1");
	$valueAttendanceEdit = mysqli_fetch_array($sqllmsAttendanceEdit);
//--------------------------------------------------
	if($valueAttendanceEdit['dated'] != date("Y-m-d")) { 
		echo '
		<div class="col-lg-12">
			<div class="widget-tabs-notification" style="font-size:16px; color:blue; font-weight:600;">Sorry, you do not have the right to edit attendance after lecture date.</div>
		</div>';
	} else { 
//--------------------------------------------------
		$cursstudents = array();
		$countstudents = 0;
		$lecurlimitv = 125;

		if(isset($_GET['section'])) {
			$stdsection 	= " AND std.std_section =  '".cleanvars($_GET['section'])."'"; 
			$sectionHref 		= '&section='.$_GET['section'];
		} else { 
			$stdsection 	= " AND std.std_section =  ''"; 
			$sectionHref		= '';
		}

		//--------------------------------------------------
		$sqllmsstds  = $dblms->querylms("SELECT std.std_id, std.std_photo, std.std_name, std.std_rollno, std.std_regno, std.std_session, 
											prg.prg_name  
											FROM ".STUDENTS." std 
											INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
											WHERE (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prg = '".cleanvars($_GET['prgid'])."' 
											AND std.std_timing = '".cleanvars($_GET['timing'])."' 
											AND std.std_semester = '".cleanvars($_GET['semester'])."' $stdsection 
											ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC");
		while($rowcurstds = mysqli_fetch_array($sqllmsstds)) { 
			$cursstudents[] = array (
										"std_id"		=> $rowcurstds['std_id'],
										"std_photo"		=> $rowcurstds['std_photo'],
										"std_name"		=> $rowcurstds['std_name'],
										"std_session"	=> $rowcurstds['std_session'],
										"std_rollno"	=> $rowcurstds['std_rollno'],
										"std_regno"		=> $rowcurstds['std_regno'],
										"prg_name"		=> $rowcurstds['prg_name']
									);
			$countstudents++;
		}
			
		$sqllmsstd2ndary  = $dblms->querylms("SELECT std.std_id, std.std_photo, std.std_name, std.std_rollno, std.std_regno,
												std.std_secondarysession, std.std_session, prg.prg_name  
												FROM ".STUDENTS." std 
												INNER JOIN ".PROGRAMS." prg ON std.id_prgsecondary = prg.prg_id 
												WHERE (std.std_status = '2' OR std.std_status = '7') 
												AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
												AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND std.id_prgsecondary = '".cleanvars($_GET['prgid'])."' 
												AND std.std_timing = '".cleanvars($_GET['timing'])."' 
												AND std.std_secondarysemester = '".cleanvars($_GET['semester'])."' $stdsection 
												ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC ");
		
		while($rowcur2ndary 	= mysqli_fetch_array($sqllmsstd2ndary)) {
			$cursstudents[] = array (
										"std_id"		=> $rowcur2ndary['std_id'],
										"std_photo"		=> $rowcur2ndary['std_photo'],
										"std_name"		=> $rowcur2ndary['std_name'],
										"std_session"	=> $rowcur2ndary['std_secondarysession'],
										"std_rollno"	=> $rowcur2ndary['std_rollno'],
										"std_regno"		=> $rowcur2ndary['std_regno'],
										"prg_name"		=> $rowcur2ndary['prg_name']
									);
			$countstudents++;
		}
//--------------------------------------------------
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<form class="form-horizontal" style="margin-left:1%;width:98%;" action="assemblyattendance.php?prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$sectionHref.'" method="post" id="editAssign" enctype="multipart/form-data">
<input type="hidden" name="id_teacher" name="id_teacher" value="'.$valueAttendanceEdit['id_teacher'].'">
<input type="hidden" name="id_setup" name="id_setup" value="'.$_GET['editid'].'">
<div class="modal-content">
<!--WI_MILESTONES_NAVIGATION-->
<div class="modal-header">	
	<button type="button" class="close" onclick="location.href=\'assemblyattendance.php?prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$sectionHref.'\'"><span>close</span></button>
	<h4 class="modal-title" style="font-weight:700;">Edit Student Attendance</h4>
</div>
<!--WI_MILESTONES_NAVIGATION-->

<div class="modal-body">

	<div class="form-group" style="margin-bottom:2px;">
		<label class="req col-lg-12" style="width:150px;"><b>Dated</b></label>
		<div class="col-lg-12">
			<input type="text" name="dated" id="dated" class="form-control pickadate" value="'.$valueAttendanceEdit['dated'].'" required autocomplete="off" >
		</div>
	</div>

	<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	Total Students: ('.($countstudents).')
</div>
<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th style="font-weight:600; vertical-align:middle; text-align:center;">Sr.#</th>
	<th style="font-weight:600; vertical-align:middle; text-align:center;">Roll #</th>
	<th style="font-weight:600; vertical-align:middle;">Reg #</th>
	<th width="35px" style="font-weight:600; vertical-align:middle;">Pic</th>
	<th style="font-weight:600; vertical-align:middle;">Student Name</th>
	<th style="font-weight:600; vertical-align:middle; text-align:center;">Session</th>
	<th style="font-weight:600; text-align:center;">Status<div style="color:red; font-size:10px;">Just Check Absent</div></th>
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
	$sqllmsattendance  = $dblms->querylms("SELECT id, id_std, status, remarks    
												FROM ".ASSEMBLY_ATTENDANCE_DETAIL." 
												WHERE id_setup = '".cleanvars($_GET['editid'])."' 
												AND id_std = '".cleanvars($rowcurstds['std_id'])."' LIMIT 1");
	$valueattendance 	= mysqli_fetch_array($sqllmsattendance);
//------------------------------------------------
if($valueattendance['id']) { 
	if($valueattendance['status'] == 1) { 
		$checked = 'checked="checked"';
	} else { 
		$checked = '';
	}
//------------------------------------------------
echo '
<tr>
	<td style="width:40px; text-align:center;">'.$srbk.'</td>
	<td style="width:60px; text-align:center;">'.$rowcurstds['std_rollno'].'</td>
	<td style="width:150px;">'.$rowcurstds['std_regno'].'</td>
	<td>'.$stdphoto.'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowcurstds['std_name'].' ('.$rowcurstds['std_session'].')</b>" data-src="studentdetail.php?std_id='.$rowcurstds['std_id'].'" href="#">'.$rowcurstds['std_name'].'</a> </td>
	<td style="width:80px; text-align:center;">'.$rowcurstds['std_session'].'</td>
	<td style="width:110px; text-align:center;"><input '.$checked.' name="status['.$srbk.']" type="checkbox" id="status['.$srbk.']" value="1" class="checkbox-inline"></td>
	<td style="width:150px;"><input type="text" value="'.$valueattendance['remarks'].'" class="form-control col-lg-12" id="remarks['.$srbk.']" name="remarks['.$srbk.']" autocomplete="off"></td>
</tr>
<input type="hidden" name="id_std['.$srbk.']" id="id_std['.$srbk.']" value="'.$rowcurstds['std_id'].'">
<input type="hidden" name="id_attendance['.$srbk.']" id="id_attendance['.$srbk.']" value="'.$valueattendance['id'].'">';
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<tr>
	<td style="width:40px; text-align:center;">'.$srbk.'</td>
	<td style="width:60px; text-align:center;">'.$rowcurstds['std_rollno'].'</td>
	<td style="width:150px;">'.$rowcurstds['std_regno'].'</td>
	<td>'.$stdphoto.'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowcurstds['std_name'].' ('.$rowcurstds['std_session'].')</b>" data-src="studentdetail.php?std_id='.$rowcurstds['std_id'].'" href="#">'.$rowcurstds['std_name'].'</a> </td>
	<td style="width:80px; text-align:center;">'.$rowcurstds['std_session'].'</td>
	<td style="width:110px; text-align:center;"><input  name="status['.$srbk.']" type="checkbox" id="status['.$srbk.']" value="1" class="checkbox-inline"></td>
	<td style="width:150px;"><input type="text" value="" class="form-control col-lg-12" id="remarks['.$srbk.']" name="remarks['.$srbk.']" autocomplete="off"></td>
</tr>
<input type="hidden" name="id_std['.$srbk.']" id="id_std['.$srbk.']" value="'.$rowcurstds['std_id'].'">
<input type="hidden" name="id_attendance['.$srbk.']" id="id_attendance['.$srbk.']" value="">';
}

}
//------------------------------------------------
echo '
</tbody>
</table>
	<div style="clear:both;"></div>
	

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'assemblyattendance.php?prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$sectionHref.'\'" >Close</button>
	<input class="btn btn-primary" type="submit" value="Change Record" id="changes_attendance" name="changes_attendance">
	</button>
</div>

</div>
</form>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#lecturenoid").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#editAssign").validate({
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
//------------------------------------------------
}
}