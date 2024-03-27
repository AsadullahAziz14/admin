<?php 
//--------------------------------------------------
if(!isset($_GET['examid']) && isset($_GET['reattempt'])) { 
//--------------------------------------------------
    $cursstudents = array();
    $countstudents = 0;

    if(isset($_GET['section'])) {
        $stdsection 	= " AND std.std_section =  '".cleanvars($_GET['section'])."'"; 
        $addStdSection 	= cleanvars($_GET['section']); 
        $sectcaps 		= ' ('.$rowrelted['section'].')';
        $seccursquery 	= " AND at.section = '".$_GET['section']."'";
    } else { 
        $stdsection 	= " "; 
        $addStdSection 	= " "; 
        $seccursquery 	= "";
        $sectcaps 		= '';
    }
//--------------------------------------------------
	$sqllmsstds  = $dblms->querylms("SELECT std.std_id, std.std_photo, std.std_name, std.std_rollno, std.std_regno, std.std_session, 
                                        prg.prg_name  
                                        FROM ".STUDENTS." std 
                                        INNER JOIN ".REPEAT_REGISTRATION." rr ON rr.id_std = std.std_id
                                        INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
                                        WHERE (std.std_status = '2' OR std.std_status = '7') 
                                        AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
                                        AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                        AND std.id_prg = '".cleanvars($_GET['prgid'])."' 
                                        AND std.std_timing = '".cleanvars($_GET['timing'])."' 
                                        AND std.std_semester = '".cleanvars($_GET['semester'])."'
                                        AND std.std_section =  '".$addStdSection."'
                                        ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC");
	while($rowcurstds = mysqli_fetch_array($sqllmsstds)) { 
		$cursstudents[] = $rowcurstds;
		$countstudents++;
	}
//--------------------------------------------------
if ($countstudents > 0) { 
echo '
<h2 style="font-weight:600;text-align:left; color:#00f; margin-top:0px !important;padding-top: 0px;">
	'.get_examterm($_GET['term']).' Paper
</h2>

<div style="font-weight:700; text-align:right; color:blue; margin-right:10px; margin-top:0px;"> 
	Total Students: ('.number_format($countstudents).')
</div>
<div style="clear:both;"></div>

<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th style="font-weight:600; text-align:center;">Sr.#</th>
	<th style="font-weight:600; text-align:center;">Roll #</th>
	<th width="35px" style="font-weight:600;">Pic</th>
	<th style="font-weight:600;">Student Name</th>
	<th style="font-weight:600;">Session</th>
	<th style="font-weight:600;text-align:center;">Attempted Date</th>
	<th style="font-weight:600;text-align:center;">Questions</th>
	<th style="font-weight:600;text-align:center;">Answers</th>
	<th style="font-weight:600;text-align:center;">Marks</th>
	<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
foreach($cursstudents as $itemstd) { 
//------------------------------------------------
    $srbk++;
    
    if($itemstd['std_photo']) { 
        $stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$itemstd['std_photo'].'" alt="'.$itemstd['std_name'].'"/>';
    } else {
        $stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$itemstd['std_name'].'"/>';
    }
//--------------------Total Questions ----------------------------
	$sqllmstotalques  = $dblms->querylms("SELECT eq.id_exam, ex.date_attempt, ex.total_marks, ex.obtain_marks, ex.id_term, ex.published, ex.id_prg
										FROM ".REPEAT_EXAMSQUESTIONS." eq  
										INNER JOIN ".REPEAT_EXAM." ex ON ex.id = eq.id_exam 
										WHERE ex.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
                                        AND ex.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND ex.id_std = '".cleanvars($itemstd['std_id'])."' 
										AND ex.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND ex.id_prg = '".cleanvars($_GET['prgid'])."'
						                AND ex.semester = '".cleanvars($_GET['semester'])."'
										AND ex.id_curs = '".cleanvars($_GET['id'])."' 
										AND ex.id_term = '".cleanvars($_GET['term'])."' ");	
 	$countques = mysqli_num_rows($sqllmstotalques);
 	$valuesques = mysqli_fetch_array($sqllmstotalques);

    if($valuesques['id_exam']) {
        if($valuesques['date_attempt'] != '0000-00-00 00:00:00') {
            $dated 		= date('Y-m-d H:i', strtotime($valuesques['date_attempt']));
        } else {
            $dated 		= '';
        }
            if($valuesques['published'] == 1) {

                $linkview	 = '<a class="btn btn-xs btn-success" href="courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Assessments&reattempt=1&examid='.$valuesques['id_exam'].'"><i class="icon-eye-open"></i></a>  ';
            } else {
                
                $linkview	 = '<a class="btn btn-xs btn-success" href="courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Assessments&reattempt=1&examid='.$valuesques['id_exam'].'&term='.$_GET['term'].'"><i class="icon-eye-open"></i></a> 
                <a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Assessments&reattempt=1&examid='.$valuesques['id_exam'].'&term='.$_GET['term'].'&edit"><i class="icon-pencil"></i></a> ';

            }
    } else {
        $dated 		 = '';
        $linkview	 = '';
    }
//--------------------Total Answers ----------------------------
	$sqllmsanswers  = $dblms->querylms("SELECT eq.id  
										FROM ".REPEAT_EXAMSQUESTIONS." eq  
										INNER JOIN ".REPEAT_EXAM." ex ON ex.id = eq.id_exam 
										WHERE ex.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
                                        AND ex.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND ex.id_std = '".cleanvars($itemstd['std_id'])."' 
										AND ex.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND ex.id_prg = '".cleanvars($_GET['prgid'])."'
						                AND ex.semester = '".cleanvars($_GET['semester'])."'
										AND ex.id_curs = '".cleanvars($_GET['id'])."' 
										AND ex.id_term = '".cleanvars($_GET['term'])."'
										AND eq.is_answered = '1'");	
 	$countanswers = mysqli_num_rows($sqllmsanswers);
//-----------------------------------------------
echo '
<tr>
	<td style="width:30px; text-align:center;vertical-align:middle;">'.$srbk.'</td>
	<td style="width:50px;vertical-align:middle;text-align:center;">'.$itemstd['std_rollno'].'</td>
	<td style="vertical-align:middle;">'.$stdphoto.'</td>
	<td style="vertical-align:middle;"><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowcurstds['std_name'].' ('.$itemstd['std_session'].')</b>" data-src="studentdetail.php?std_id='.$itemstd['std_id'].'" href="#">'.$itemstd['std_name'].'</a> </td>
	<td style="vertical-align:middle;">'.$itemstd['std_session'].'</td>';
if($valuesques['id_exam']) { 

    if($valuesques['obtain_marks']) {

        if($valuesques['id_prg'] == 130 && $valuesques['id_term'] == 1) {
        
            $marks = $valuesques['obtain_marks'].'/35';

        } else if($valuesques['id_prg'] == 130 && $valuesques['id_term'] == 2) {
            
            $marks = $valuesques['obtain_marks'].'/40';

        }elseif($valuesques['id_term'] == 1) {
            
            $marks = $valuesques['obtain_marks'].'/25';

        }elseif($valuesques['id_term'] == 2) {
            
            $marks = $valuesques['obtain_marks'].'/50';

        }

    } else {
        $marks = '';
    }
echo '
	<td style="width:120px;vertical-align:middle;">'.$dated.'</td>
	<td style="text-align:center;vertical-align:middle;">'.$countques.'</td>
	<td style="text-align:center;vertical-align:middle;">'.$countanswers.'</td>
	<td style="text-align:center;vertical-align:middle;">'.$marks.'</td>
	<td style="text-align:center;vertical-align:middle;">'.$linkview.'</td>';
} else {
	echo '
	<td style="text-align:center;vertical-align:middle; color:#f00; font-weight:600;" colspan="5">
		Not appeared in the exam.
	</td>';
}
	
echo '
</tr>';
//------------------------------------------------
}
//------------------------------------------------
echo '
</tbody>
</table>';
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
} // end check record
	
} // end if exam id not 