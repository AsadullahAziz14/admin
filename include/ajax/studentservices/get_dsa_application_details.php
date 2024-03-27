<?php
require_once('../../../dbsetting/lms_vars_config.php');
require_once('../../../dbsetting/classdbconection.php');
$dblms = new dblms();
require_once('../../../functions/login_func.php');
require_once('../../../functions/functions.php');
require_once('../../../functions/studentservices.php');

//User Authentication
checkCpanelLMSALogin();

if(isset($_POST['id'])){

	$queryApplication = $dblms->querylms("SELECT sa.*, std.std_id, std.std_name, std.std_regno, std.std_photo, std.std_session, std.std_semester, std.std_timing, prg.prg_name, prg.id_cat
											FROM ".DSA_APPLICATIONS." sa
											INNER JOIN ".STUDENTS." std ON std.std_id = sa.id_std
											INNER JOIN ".PROGRAMS." prg ON prg.prg_id = std.id_prg
											WHERE sa.id = '".cleanvars($_POST['id'])."'
											AND sa.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND sa.is_deleted != '1'
											LIMIT 1");
	$valueApplication = mysqli_fetch_array($queryApplication);

	if($valueApplication['photo']){

		$studentPhoto = '<img class="avatar-smallest image-boardered" style="width:50px; height:50px; float:right;" src="downloads/dsa/pictures/'.$valueApplication['photo'].'" alt="'.$valueApplication['std_name'].'"/>';

	} else{

		if($valueApplication['std_photo']) { 
			$studentPhoto = '<img class="avatar-smallest image-boardered" style="width:50px; height:50px; float:right;" src="images/students/'.$valueApplication['std_photo'].'" alt="'.$valueApplication['std_name'].'"/>';
		} else {
			$studentPhoto = '<img class="avatar-smallest image-boardered" style="width:50px; height:50px; float:right;" src="images/students/default.png" alt="'.$valueApplication['std_name'].'"/>';
		}

	}

    $dateApplied 	= '';
    $dateDue 		= '';
	$dateofBirth 	= '';

    if($valueApplication['date_added'] != '0000-00-00'){
        $dateApplied = date('d-m-Y', strtotime($valueApplication['date_added']));
    }

	if($valueApplication['due_date'] != '0000-00-00'){
        $dateDue = date('d-m-Y', strtotime($valueApplication['due_date']));
    }

    if($valueApplication['dob'] != '0000-00-00'){
        $dateofBirth = date('d-m-Y', strtotime($valueApplication['dob']));
    }
    
    echo '
    <table class="table table-bordered">
        <tr>
            <th class="p-2" nowrap="nowrap">Reference #</th>
            <td nowrap="nowrap" colspan="2" class="p-2"><span class="blog-post-info-tag btn btn-info">'.$valueApplication['reference_no'].'</span></td>
			<th class="p-2" nowrap="nowrap">Status</th>
            <td nowrap="nowrap" colspan="2" class="p-2">'.get_dsa_status_student($valueApplication['status']).'</td>
        </tr>
		<tr>
			<th class="p-2">Apply Date</th>
			<td class="p-2" colspan="2">'.$dateApplied.'</td>
			<th class="p-2">Due Date</th>
			<td class="p-2" colspan="2">'.$dateDue.'</td>
		</tr>
		<tr>
			<th class="p-2">Application For</th>
			<td class="p-2" colspan="2">'.get_dsa_degree_transcript($valueApplication['degree_transcript']).'</td>
			<th class="p-2">Normal/Urgent</th>
			<td class="p-2" colspan="2">'.get_dsa_regular_urgent1($valueApplication['normal_urgent']).'</td>
		</tr>
        <tr>
            <th class="p-2">Student Name</th>
            <td class="p-2" colspan="2">'.$valueApplication['full_name'].'</td>
			<th class="p-2">Student CNIC</th>
            <td class="p-2" colspan="2">'.$valueApplication['cnic'].'</td>
        </tr>
		<tr>
            <th class="p-2">Date of Birth</th>
            <td class="p-2" colspan="2">'.$dateofBirth.'</td>
			<th class="p-2">Timing</th>
            <td class="p-2" colspan="2">'.get_programtiming($valueApplication['std_timing']).'</td>
        </tr>
		<tr>
			<th class="p-2" style="vertical-align:middle;">Program Name</th>
			<td class="p-2" style="vertical-align:middle;" colspan="5">'.$valueApplication['prg_name'].$studentPhoto.'</td>
		</tr>
		<tr>
            <th class="p-2">Mobile</th>
            <td class="p-2" colspan="2">'.$valueApplication['mobile'].'</td>
			<th class="p-2">Email</th>
            <td class="p-2" colspan="2">'.$valueApplication['email'].'</td>
        </tr>
        <tr>
            <th class="p-2" nowrap="nowrap">Postal Address</th>
            <td colspan="5" class="p-2">'.$valueApplication['postal_address'].'</td>
        </tr>
    </table>';

	echo '
	<div class="tsf-nav-step col-md-12">
		<!-- BEGIN STEP INDICATOR-->
		<ul class="gsi-step-indicator triangle gsi-style-3 gsi-transition" style="line-height:1.3;" >';
			$srno = 0;
			foreach($dsaStatus as $status) {

				if($status['id'] != 3 || ($status['id'] == 3 && $valueApplication['status'] == 3)){

					$srno++;

					$applicationStatus = '';
					if($status['id'] <= $valueApplication['status']){
						$applicationStatus = 'completed';
					}
					if($valueApplication['status'] == 3 && $status['id'] == 3){
						$applicationStatus = 'current';
					}

					echo '
					<li data-target="step-'.$srno.'" class="'.$applicationStatus.'">
						<a href="">
							<span class="number">'.$srno.'</span>
							<span class="desc">
								<label>'.$status['name'].'</label>
							</span>
						</a>
					</li>';

				}
			}
			echo '
		</ul>
		<!-- END STEP INDICATOR--->
	</div>';

	$queryRepeatCourses = $dblms->querylms("SELECT rc.offered_semester, rc.repeat_semester, cr.curs_code, cr.curs_name
												FROM ".DSA_APPLICATIONS_REPEAT_COURSES." rc
												INNER JOIN ".COURSES." cr ON cr.curs_id = rc.id_course
												WHERE rc.id_setup = '".$valueApplication['id']."'
												ORDER BY rc.id ASC");
	if(mysqli_num_rows($queryRepeatCourses)>0) {

		echo '
		<h4>Repeat Courses</h4>
		<table class="table table-bordered">
			<tr>
				<th class="p-2" nowrap="nowrap">Sr. #</th>
				<th nowrap="nowrap" class="p-2">Course</th>
				<th class="p-2" nowrap="nowrap">Semester Offered In</th>
				<th nowrap="nowrap" class="p-2">Semester Repeat In</th>
			</tr>';
			$sr = 0;
	
			while($valueRepeatCourse = mysqli_fetch_array($queryRepeatCourses)) {
	
				$sr++;
	
				echo '
				<tr>
					<td class="p-2" align="center">'.$sr.'</td>
					<td class="p-2">'.$valueRepeatCourse['curs_code'].' - '.$valueRepeatCourse['curs_name'].'</td>
					<td class="p-2">'.$valueRepeatCourse['offered_semester'].'</td>
					<td class="p-2">'.$valueRepeatCourse['repeat_semester'].'</td>
				</tr>';
			}
			echo '
		</table>';
	}

}
?>