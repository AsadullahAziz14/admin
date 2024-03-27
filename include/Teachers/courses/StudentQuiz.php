<?php 
//--------------------------------------------
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">';
//--------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
}
//--------------------------------------
echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Quiz</h3></span>
			<a class="btn btn-mid btn-success pull-right" href="courses.php?id='.$_GET['id'].'&view=QuizBank"><i class="icon-list"></i> Quiz Bank</a> 
			<a class="btn btn-mid btn-info pull-right" href="courses.php?id='.$_GET['id'].'&view=Quiz&add"><i class="icon-plus"></i> Add Quiz </a> <a class="btn btn-mid btn-purple pull-right" href="courses.php?id='.$_GET['id'].'&view=Quiz"><i class="icon-list"></i> List</a> 
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<!--WI_MILESTONES_NAVIGATION-->

<!--WI_MILESTONES_TABLE-->
<div class="row">
<div class="col-lg-12">
  
<div class="widget wtabs">
<div class="widget-content">';
$sqllmsquiz  = $dblms->querylms("SELECT qstd.date_attempt, qstd.obtain_marks, q.quiz_title, q.quiz_enddate, std.std_id, std.std_name, 
                                    std.std_regno, std.std_photo, std.std_session    
                                    FROM ".QUIZ_STUDENT." qstd  
                                    INNER JOIN ".QUIZ." q ON q.quiz_id = qstd.id_quiz   
                                    INNER JOIN ".STUDENTS." std ON std.std_id = qstd.id_std    
                                    WHERE quiz_id = '".cleanvars($_GET['Quizid'])."' AND q.id_curs = '".cleanvars($_GET['id'])."' 
                                    AND q.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
                                    AND q.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
                                    AND q.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' ORDER BY qstd.id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsquiz) > 0) {
echo '
<table class="footable table table-bordered table-hover">
<thead>
<tr>
<th style="font-weight:600;text-align:center;vertical-align:middle; ">Sr.#</th>
<th width="50px" style="font-weight:600;vertical-align:middle;">Pic</th>
<th style="font-weight:600;vertical-align:middle;">Student</th>
<th style="font-weight:600;vertical-align:middle;">Reg. #</th>
<th style="font-weight:600;text-align:center;vertical-align:middle; ">Quiz</th>
<th style="font-weight:600;text-align:center; vertical-align:middle;">Due Date</th>
<th style="font-weight:600;text-align:center;vertical-align:middle; ">Submit Date</th>
<th style="font-weight:600;text-align:center;vertical-align:middle; ">Marks</th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
while($value_quiz = mysqli_fetch_assoc($sqllmsquiz)) { 
//------------------------------------------------
$srbk++;

if($value_quiz['std_photo']) { 
    $stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$value_quiz['std_photo'].'" alt="'.$value_quiz['std_name'].'"/>';
} else {
    $stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$value_quiz['std_name'].'"/>';
}
//------------------------------------------------
echo '
<tr>
<td style="width:40px; text-align:center; vertical-align:middle;">'.$srbk.'</td>
<td style="vertical-align:middle;">'.$stdphoto.'</td>
<td style="vertical-align:middle;"><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$value_quiz['std_name'].' ('.$value_quiz['std_session'].')</b>" data-src="studentdetail.php?std_id='.$value_quiz['std_id'].'" href="#">'.$value_quiz['std_name'].'</a></td>
<td style="vertical-align:middle;">'.$value_quiz['std_regno'].'</td>
<td style="vertical-align:middle;">'.$value_quiz['quiz_title'].'</td>
<td style="text-align:center; width:80px;vertical-align:middle;">'.date("d/m/Y", strtotime($value_quiz['quiz_enddate'])).'</td>
<td style="text-align:center; width:100px;vertical-align:middle;">'.date("d/m/Y", strtotime($value_quiz['date_attempt'])).'</td>
<td style="text-align:center; width:50px;vertical-align:middle;">'.$value_quiz['obtain_marks'].' </td>
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
}
//------------------------------------------------
echo '

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