<?php
include_once("query.php");

$id 		= (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';
$prgid 		= (isset($_GET['prgid']) && $_GET['prgid'] != '') ? $_GET['prgid'] : '';
$semester 	= (isset($_GET['semester']) && $_GET['semester'] != '') ? $_GET['semester'] : '';
$section 	= (isset($_GET['section']) && $_GET['section'] != '') ? $_GET['section'] : '';
$timing 	= (isset($_GET['timing']) && $_GET['timing'] != '') ? $_GET['timing'] : '';
$tpl 		= (isset($_GET['tpl']) && $_GET['tpl'] != '') ? $_GET['tpl'] : '';

if(!LMS_VIEW) {
	$curinfo 		= 'side-menu-main-active';
	$stylecurinfo 	= 'style="font-weight:600;"';
} else  { 
	$curinfo 		= '';
	$stylecurinfo 	= '';
}

if(LMS_VIEW == 'CLOs') {
	$courseCLOs 		= 'side-menu-main-active';
	$styleCourseCLOs 	= 'style="font-weight:600;"';
} else  { 
	$courseCLOs 		= '';
	$styleCourseCLOs 	= '';
}

if(LMS_VIEW == 'FAQs') { 
	$faqds 			= 'side-menu-main-active';
	$stylefaqds 	= 'style="font-weight:600;"';
} else  { 
	$faqds 			= '';
	$stylefaqds 	= '';
}

if(LMS_VIEW == 'Students') { 
	$students		= 'side-menu-main-active';
	$stylestudents 	= 'style="font-weight:600;"';
} else  { 
	$students 		= '';
	$stylestudents 	= '';
}

if(LMS_VIEW == 'Lessonplan') { 
	$lessons 		= 'side-menu-main-active';
	$stylelessons 	= 'style="font-weight:600;"';
} else  { 
	$lessons 		= '';
	$stylelessons 	= '';
}

if(LMS_VIEW == 'Discussion') { 
	$discussion 		= 'side-menu-main-active';
	$stylediscussion 	= 'style="font-weight:600;"';
} else  { 
	$discussion 		= '';
	$stylediscussion 	= '';
}

if(LMS_VIEW == 'Assignments') { 
	$assigns 		= 'side-menu-main-active';
	$styleassigns 	= 'style="font-weight:600;"';
} else  { 
	$assigns 		= '';
	$styleassigns 	= '';
}

if(LMS_VIEW== 'QuizBank') { 
	$quiz 		= 'side-menu-main-active';
	$stylequiz 	= 'style="font-weight:600;"';
} else  { 
	$quiz 		= '';
	$stylequiz 	= '';
}

if(LMS_VIEW == 'StudentAssignments') { 
	$stdassigns 		= 'side-menu-main-active';
	$stylestdassigns 	= 'style="font-weight:600;"';
} else  { 
	$stdassigns 		= '';
	$stylestdassigns 	= '';
}

if(LMS_VIEW == 'Glossary') { 
	$glossary 		= 'side-menu-main-active';
	$styleglossary 	= 'style="font-weight:600;"';
} else  { 
	$glossary 		= '';
	$styleglossary 	= '';
}

if(LMS_VIEW == 'Weblinks') { 
	$weblinks 		= 'side-menu-main-active';
	$styleweblinks 	= 'style="font-weight:600;"';
} else  { 
	$weblinks 		= '';
	$styleweblinks 	= '';
}

if(LMS_VIEW == 'Books') { 
	$bks 			= 'side-menu-main-active';
	$stylebks 		= 'style="font-weight:600;"';
} else  { 
	$bks 			= '';
	$stylebks 		= '';
}

if(LMS_VIEW == 'Downloads') { 
	$dows 			= 'side-menu-main-active';
	$styledows 		= 'style="font-weight:600;"';
} else  { 
	$dows 			= '';
	$styledows 		= '';
}

if(LMS_VIEW == 'Resources') { 
	$resour 		= 'side-menu-main-active';
	$styleresour 	= 'style="font-weight:600;"';
} else  { 
	$resour 		= '';
	$styleresour 	= '';
}

if(LMS_VIEW == 'Midtermawrd') { 
	$midaward 		= 'side-menu-main-active';
	$stylemidaward 	= 'style="font-weight:600;"';
} else  { 
	$midaward 		= '';
	$stylemidaward 	= '';
}

if(LMS_VIEW == 'Attendance') { 
	$attendace 		= 'side-menu-main-active';
	$styleattendace = 'style="font-weight:600;"';
} else  { 
	$attendace 		= '';
	$styleattendace = '';
}

if(LMS_VIEW == 'Annoucements') { 
	$annoucement 		= 'side-menu-main-active';
	$styleannoucement 	= 'style="font-weight:600;"';
} else  { 
	$annoucement 		= '';
	$styleannoucement 	= '';
}

if(LMS_VIEW == 'Lessonvideo') { 
	$vlesson 		= 'side-menu-main-active';
	$stylevlesson 	= 'style="font-weight:600;"';
} else  { 
	$vlesson 		= '';
	$stylevlesson 	= '';
}

if(LMS_VIEW == 'Assessments') { 
	$asses 			= 'side-menu-main-active';
	$styleasses 	= 'style="font-weight:600;"';
} else  { 
	$asses 			= '';
	$styleasses 	= '';
}

if(LMS_VIEW == 'Drivelinks') { 
	$Drivelinks 		= 'side-menu-main-active';
	$styleDrivelinks 	= 'style="font-weight:600;"';
} else  { 
	$Drivelinks			= '';
	$styleDrivelinks 	= '';
}

$sqllms = $dblms->querylms("SELECT em.emply_id, em.emply_name, de.designation_name, dp.dept_name
								FROM ".EMPLYS." em 
								LEFT JOIN ".DESIGNATIONS." de ON de.designation_id = em.id_designation
								LEFT JOIN ".DEPTS." dp ON dp.dept_id = em.id_dept					 
								WHERE em.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
								AND em.emply_loginid = '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' LIMIT 1");
$rowsstd = mysqli_fetch_array($sqllms);

if(isset($_GET['section'])) { 
	$sqlsection 	= " AND t.section =  '".cleanvars($_GET['section'])."'"; 
	
	$sectcaption 	= 'Section: '.$_GET['section'];
	$secthref 	 	= '&section='.$_GET['section'];
} else  { 
	$sqlsection 	= " "; 
	$sectcaption 	= '';
	$secthref 	 	= '';
}

$sqllmssetting = $dblms->querylms("SELECT exam_datesheet, midterm_mattendance, finalterm_mattendance, course_evaluation, teacher_evaluation,  
											graduating_survey, midterm_eattendance, finalterm_eattendance, exclude_attendance, teacher_attendance,
											teacher_marks   
											FROM ".SETTINGS." 
											WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											LIMIT 1");
$rowsetting = mysqli_fetch_array($sqllmssetting);

$sqllmscurs = $dblms->querylms("SELECT d.id_curs, t.is_liberalarts, d.id_courseallocate, c.is_obe, c.curs_pre_requisite, 
									c.cur_credithours_theory, c.cur_credithours_practical, c.curs_name, 
									c.curs_code, c.curs_credit_hours, c.curs_detail, c.curs_references, 
									d.id_teacher, t.section, t.semester, p.prg_id, p.prg_obe   
									FROM ".TIMETABLE_DETAILS." d  
									INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
									INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs  
									INNER JOIN ".EMPLYS." e ON e.emply_id = d.id_teacher   
									LEFT JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg   
									WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
									AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
									AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
									AND d.id_curs = '".cleanvars($_GET['id'])."'  LIMIT 1");
if(mysqli_num_rows($sqllmscurs) == 0) {

	echo '
	<script type="text/javascript" src="js/jquery/jquery.js"></script>
	<!----------------------COMMON PAGE HEADING--------------------------------->
	<div class="matter">
	<!----------------------COMMON PROJECT HEAD--------------------------------->
	<!--WI_PROJECT_HEADER-->
	<div class="headerbar">
		<div class="widget headerbar-widget">	
			<div class="headerbar-project-title pull-left"><h3 style="font-weight:600;"> </h3></div>
		</div>
	</div>
	<!--WI_PROJECT_HEADER-->
	<!----------------------COMMON PROJECT HEAD--------------------------------->
	<div class="container">
	<div class="row">

	<div class="col-lg-12">
		<div class="widget-tabs-notification" style="font-size:16px; color:blue; font-weight:600;">No Result Found</div>
	</div>
	</div>
	</div>
	</div>';

} else {

	$rowsurs = mysqli_fetch_assoc($sqllmscurs);

	if($rowsurs['cur_credithours_theory'] && $rowsurs['cur_credithours_practical']) { 
		$tcrdhours = $rowsurs['cur_credithours_theory'].' + '.$rowsurs['cur_credithours_practical'];
	} else if($rowsurs['cur_credithours_theory'] && !$rowsurs['cur_credithours_practical']) { 
		$tcrdhours = $rowsurs['cur_credithours_theory']; 
	} else if(!$rowsurs['cur_credithours_theory'] && $rowsurs['cur_credithours_practical']) { 
		$tcrdhours = $rowsurs['cur_credithours_practical']; 
	}
	
	if(!empty($rowsurs['curs_pre_requisite'])) { $prerequisite = get_yesno1(1); } else { $prerequisite = get_yesno1(2); }

	echo '
	<title>'.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].' - '.TITLE_HEADER.'</title>
	<script type="text/javascript" src="js/jquery/jquery.js"></script>
	<!----------------------COMMON PAGE HEADING--------------------------------->
	<div class="matter">
	<!----------------------COMMON PROJECT HEAD--------------------------------->
	<!--WI_PROJECT_HEADER-->
	<div class="headerbar">
		<div class="widget headerbar-widget">	
			<div class="headerbar-project-title pull-left"><h3 style="font-weight:600;"> '.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].'</h3></div>
		</div>
	</div>
	<!--WI_PROJECT_HEADER-->
	<!----------------------COMMON PROJECT HEAD--------------------------------->
	<div class="container">
	<div class="row">';
	if(LMS_VIEW != 'Finaltermawrd' && LMS_VIEW != 'Practicalmarks') { 
		
		//if($timing != '2') { 
			$attndlink = '<li><a class="'.$attendace.'" href="courses.php?id='.$_GET['id'].'&view=Attendance" '.$styleattendace.'> Attendance</a></li>';
		//} else { 
		//	$attndlink = '';
		//}

		echo '
		<!--WI_Menu-->
		<div class="col-lg-3">
			<div class="row">
				<div class="col-lg-12 project-menu">
					<div class="box side-menu-main">
						<div class="box-head-dark"><b><i class="icon-foler-open"></i> Course Menu</b> </div>
						<div class="box-content">
							<ul>
								<li><a class="'.$curinfo.'" href="courses.php?id='.$_GET['id'].'" '.$stylecurinfo.'> Course Info</a></li>';
								if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) == 1 && $rowsurs['is_obe'] == 1) {
									echo '<li><a class="'.$courseCLOs.'" href="courses.php?id='.$_GET['id'].'&view=CLOs" '.$styleCourseCLOs.'> CLOs</a></li>';
								}
								echo '
								<li><a class="'.$lessons.'" href="courses.php?id='.$_GET['id'].'&view=Lessonplan" '.$stylelessons.'> Weekly Lesson Plan</a></li>
								<li><a class="'.$discussion.'" href="courses.php?id='.$_GET['id'].'&view=Discussion" '.$stylediscussion.'> Weekly Discussion Board</a></li>
								<li><a class="'.$assigns.'" href="courses.php?id='.$_GET['id'].'&view=Assignments" '.$styleassigns.'> Assignments</a></li>
								<li><a class="'.$stdassigns.'" href="courses.php?id='.$_GET['id'].'&view=StudentAssignments" '.$stylestdassigns.'> Student Assignments</a></li>
								<li><a class="'.$quiz.'" href="courses.php?id='.$_GET['id'].'&view=QuizBank" '.$stylequiz.'> Question Bank</a></li>
								
								<li><a class="'.$annoucement.'" href="courses.php?id='.$_GET['id'].'&view=Annoucements" '.$styleannoucement.'> Announcements</a></li>
								<li><a class="'.$resour.'" href="courses.php?id='.$_GET['id'].'&view=Resources" '.$styleresour.'> Course Resources</a></li>
								
								<li><a class="'.$faqds.'" href="courses.php?id='.$_GET['id'].'&view=FAQs" '.$stylefaqds.'> FAQs</a></li>
								<li><a class="'.$glossary.'" href="courses.php?id='.$_GET['id'].'&view=Glossary" '.$styleglossary.'> Glossary</a></li>
								
								<li><a class="'.$bks.'" href="courses.php?id='.$_GET['id'].'&view=Books" '.$stylebks.'> Books</a></li>
								
								<li><a class="'.$students.'" href="courses.php?id='.$_GET['id'].'&view=Students" '.$stylestudents.'> Enrolled Students</a></li>
								'.$attndlink.'
								<!--li><a class="'.$asses.'" href="courses.php?id='.$_GET['id'].'&view=Assessments" '.$styleasses.'> Semester Assessments</a></li-->
								<li><a class="'.$midaward.'" href="courses.php?id='.$_GET['id'].'&view=Midtermawrd" '.$stylemidaward.'> Mid Term Award List</a></li>';
						if($rowsurs['cur_credithours_theory']>0) {
							echo '<li><a href="courses.php?id='.$_GET['id'].'&view=Finaltermawrd"> Final Award List</a></li>';
						}
					if($rowsurs['cur_credithours_practical']>0) {
						echo '<li><a href="courses.php?id='.$_GET['id'].'&view=Practicalmarks"> Practical Award List</a></li>';
					}
					echo '
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- WI_Menu -->';
	}

	if(!LMS_VIEW) {
		include_once("courses/information.php");
	}
	if(LMS_VIEW) {
		include_once("courses/".LMS_VIEW.".php");
	}
}

echo '
</div>
<!--WI_NOTIFICATION-->

<!--WI_NOTIFICATION-->
</div>
</div>
</div>
<div class="clearfix"></div>
</div>
<!----------------------COMMON FOOTER--------------------------------->

<!-- Footer starts -->
<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<p class="copy">Powered by: | <a href="'.COPY_RIGHTS_URL.'" target="_blank">'.COPY_RIGHTS.'</a> </p>
			</div>
		</div>
	</div>
</footer>
<!-- Footer ends -->

<!-- Scroll to top -->
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>';
//-------------------------------------
if(LMS_VIEW) {
	include_once("courses/models/".LMS_VIEW.".php");
} 
echo '

<!--WI_IFRAME_MODAL-->
<div class="row">
	<div id="modalIframe" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
					<h4 class="modal-title" id="modal-iframe-title"> Edit</h4>
					<div class="clearfix"></div>
				</div>
				<div class="modal-body">
					<iframe frameborder="0" class="slimScrollBarModal----"></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--WI_IFRAME_MODAL-->
<!--JS_SELECT_LISTS-->
<script type="text/javascript">
// close the div in 5 secs
window.setTimeout("closeHelpDiv();", 5000, 2500);

function closeHelpDiv(){
	document.getElementById("infoupdated").style.display=" none";
}
</script>
<script type="text/javascript" src="js/courses.js"></script>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script src="js/ckeditor/samples/js/sample.js"></script>
<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
<script>
jQuery(function($) {
      $.mask.definitions["~"]="[+-]";
      $("#emply_cnic").mask("99999-9999999-9");
	  $("#emply_cnic_edit").mask("99999-9999999-9");
	  $("#emply_mobile").mask("9999-9999999");
	  $("#emply_mobile_edit").mask("9999-9999999");
        });
</script>
<script type="text/javascript">
	$(function () {
		$(".footable").footable();
	});
</script>
<script>
//USED BY: All date picking forms
$(document).ready(function(){
$(".pickadate").datepicker({
   format: "yyyy-mm-dd",
   language: "lang",
   autoclose: true,
   todayHighlight: true
});	
});
</script>
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>';
?>