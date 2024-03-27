<?php 
//--------------------------------------------
if(!LMS_VIEW) {
	$curinfo = 'side-menu-main-active';
	$style 	 = 'style="font-weight:600;"';
} else  { 
	$curinfo = '';
	$style 	 = '';
}
//--------------------------------------------
if(LMS_VIEW == 'FAQs') { 
	$faqds 	= 'side-menu-main-active';
	$style 	 = 'style="font-weight:600;"';
} else  { 
	$faqds 	= '';
	$style 	= '';
}

//--------------------------------------------
if(LMS_VIEW == 'Students') { 
	$students	= 'side-menu-main-active';
	$style 	 	= 'style="font-weight:600;"';
} else  { 
	$students 	= '';
	$style 	 	= '';
}
//--------------------------------------------
if(LMS_VIEW == 'Lessonplan') { 
	$lessons = 'side-menu-main-active';
	$style 	 = 'style="font-weight:600;"';
} else  { 
	$lessons = '';
	$style 	 = '';
}
//--------------------------------------------
if(LMS_VIEW == 'Assignments') { 
	$assigns = 'side-menu-main-active';
	$style 	 = 'style="font-weight:600;"';
} else  { 
	$assigns = '';
	$style 	 = '';
}
//--------------------------------------------
if(LMS_VIEW == 'StudentAssignments') { 
	$stdassigns = 'side-menu-main-active';
	$style 	 	= 'style="font-weight:600;"';
} else  { 
	$stdassigns = '';
	$style 	 	= '';
}
//--------------------------------------------
if(LMS_VIEW == 'Glossary') { 
	$glossary = 'side-menu-main-active';
} else  { 
	$glossary = '';
}
//--------------------------------------------
if(LMS_VIEW == 'Weblinks') { 
	$weblinks 	= 'side-menu-main-active';
	$style 	 	= 'style="font-weight:600;"';
} else  { 
	$weblinks 	= '';
	$style 	 	= '';
}
//--------------------------------------------
if(LMS_VIEW == 'Books') { 
	$bks 	= 'side-menu-main-active';
	$style 	= 'style="font-weight:600;"';
} else  { 
	$bks 	= '';
	$style 	= '';
}
//--------------------------------------------
if(LMS_VIEW == 'Downloads') { 
	$dows 	= 'side-menu-main-active';
	$style 	= 'style="font-weight:600;"';
} else  { 
	$dows 	= '';
	$style 	= '';
}
//--------------------------------------------
if(LMS_VIEW == 'Midtermawrd') { 
	$midaward = 'side-menu-main-active';
	$style 	  = 'style="font-weight:600;"';
} else  { 
	$midaward = '';
	$style 	  = '';
}
//--------------------------------------------
if(LMS_VIEW == 'Attendance') { 
	$attendace 	= 'side-menu-main-active';
	$style 	 	= '';
} else  { 
	$attendace 	= '';
	$style 	 	= '';
}
//--------------------------------------------
if(LMS_VIEW == 'Annoucements') { 
	$annoucement 	= 'side-menu-main-active';
	$style 	 		= '';
} else  { 
	$annoucement 	= '';
	$style 	 		= '';
}
//--------------------------------------------
if(LMS_VIEW == 'Lessonvideo') { 
	$vlesson 	= 'side-menu-main-active';
	$style 	 		= '';
} else  { 
	$vlesson 	= '';
	$style 	 		= '';
}

	$sqllms  = $dblms->querylms("SELECT emply_id 
										FROM ".EMPLYS."   										 
										WHERE id_campus 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND emply_loginid 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' LIMIT 1");
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

//--------------------------------------------

	$sqllmscurs  = $dblms->querylms("SELECT * 
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs  
										INNER JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg   
										INNER JOIN ".EMPLYS." e ON e.emply_id = d.id_teacher   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".ARCHIVE_SESS."' 
										AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND d.id_curs = '".cleanvars($_GET['id'])."' AND t.timing =  '".cleanvars($_GET['timing'])."'
										AND t.id_prg =  '".cleanvars($_GET['prgid'])."' 
										AND t.semester =  '".cleanvars($_GET['semester'])."' $sqlsection LIMIT 1");
	$rowsurs = mysqli_fetch_assoc($sqllmscurs);

if($rowsurs['cur_credithours_theory'] && $rowsurs['cur_credithours_practical']) { 
	$tcrdhours = $rowsurs['cur_credithours_theory'].' + '.$rowsurs['cur_credithours_practical'];
} else if($rowsurs['cur_credithours_theory'] && !$rowsurs['cur_credithours_practical']) { 
	$tcrdhours = $rowsurs['cur_credithours_theory']; 
} else if(!$rowsurs['cur_credithours_theory'] && $rowsurs['cur_credithours_practical']) { 
	$tcrdhours = $rowsurs['cur_credithours_practical']; 
}

//--------------------------------------------
echo '<title>'.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].' - '.TITLE_HEADER.'</title>
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<!----------------------COMMON PAGE HEADING--------------------------------->
<div class="matter">
<!----------------------COMMON PROJECT HEAD--------------------------------->
<!--WI_PROJECT_HEADER-->
<div class="headerbar">
	<div class="widget headerbar-widget">	
		<div class="headerbar-project-title pull-left"><h3 style="font-weight:600;"> Archive: '.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].' ('.$rowsurs['prg_name'].'- '.get_programtiming($rowsurs['timing']).')  Semester: '.addOrdinalNumberSuffix($rowsurs['semester']).' '.$sectcaption.'</h3></div>
	</div>
</div>
<!--WI_PROJECT_HEADER-->
<!----------------------COMMON PROJECT HEAD--------------------------------->
<div class="container">
<div class="row">';
if(LMS_VIEW != 'Finaltermawrd' && LMS_VIEW != 'Practicalmarks') { 
echo '
<!--WI_Menu-->
<div class="col-lg-3">
	<div class="row">
		<div class="col-lg-12 project-menu">
			<div class="box side-menu-main">
				<div class="box-head-dark"><b><i class="icon-foler-open"></i> Course Menu</b> </div>
				<div class="box-content">
					<ul>
						<li><a class="'.$curinfo.'" href="archive.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'" '.$style.'> Course Info</a></li>
						<li><a class="'.$lessons.'" href="archive.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Lessonplan" '.$style.'> Weekly Lesson Plan</a></li>
						<li><a class="'.$assigns.'" href="archive.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Assignments" '.$style.'> Assignments</a></li>
						
						<!--li><a class="" href="#" '.$style.'> Quizzes</a></li-->
						<!--li><a class="" href="#" '.$style.'> Question Bank</a></li-->
						<li><a class="'.$annoucement.'" href="archive.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Annoucements" '.$style.'> Announcements</a></li>
						<li><a class="'.$vlesson.'" href="archive.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Lessonvideo" '.$style.'> Lesson Video</a></li>
						<li><a class="'.$faqds.'" href="archive.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=FAQs" '.$style.'> FAQs</a></li>
						<li><a class="'.$glossary.'" href="archive.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Glossary" '.$style.'> Glossary</a></li>
						<li><a class="'.$weblinks.'" href="archive.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Weblinks" '.$style.'> Web Links</a></li>
						<li><a class="'.$bks.'" href="archive.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Books" '.$style.'> Books</a></li>
						<li><a class="'.$dows.'" href="archive.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Downloads" '.$style.'> Downloads</a></li>
						<li><a class="'.$students.'" href="archive.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Students" '.$style.'> Enrolled Students</a></li>
						<!--li><a class="'.$attendace.'" href="archive.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Attendance" '.$style.'> Attendance</a></li-->
						<li><a class="'.$midaward.'" href="archive.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Midtermawrd" '.$style.'> Mid Term Award List</a></li>';
				if($rowsurs['cur_credithours_theory']>0) {
					echo '<li><a href="archive.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Finaltermawrd" '.$style.'> Final Award List</a></li>';
				}
			if($rowsurs['cur_credithours_practical']>0) {
				echo '<li><a href="archive.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Practicalmarks" '.$style.'> Practicalm Award List</a></li>';
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
//-------------------------------------
if(!LMS_VIEW) {
	include_once("archivecourses/information.php");
}
//--------------- Language -------------
if(LMS_VIEW) {
	include_once("archivecourses/".LMS_VIEW.".php");
}
//-------------------------------------
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
	include_once("archivecourses/models/".LMS_VIEW.".php");
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
					<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
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
<script type="text/javascript" src="js/practicalaward.js"></script>
<script type="text/javascript" src="js/finaltermaward.js"></script>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
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