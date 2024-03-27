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
										FROM ".SUMMER_COURSE_ALLOCATION." ca  
										INNER JOIN ".COURSES." c ON c.curs_id = ca.id_curs  
										INNER JOIN ".EMPLYS." e ON e.emply_id = ca.id_teacher 
										WHERE c.id_campus	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND ca.summer_year	= '".date("Y")."' 
										AND ca.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND ca.id_curs = '".cleanvars($_GET['id'])."'  LIMIT 1");
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
		<div class="headerbar-project-title pull-left"><h3 style="font-weight:600;"> '.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].' </h3></div>
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
						<li><a class="'.$curinfo.'" href="summer.php?id='.$_GET['id'].'" '.$style.'> Course Info</a></li>
						
						<li><a class="'.$students.'" href="summer.php?id='.$_GET['id'].'&view=Students" '.$style.'> Enrolled Students</a></li>';
				if($rowsurs['cur_credithours_theory']>0) {
					echo '<li><a href="summer.php?id='.$_GET['id'].'&view=Finaltermawrd" '.$style.'> Final Award List</a></li>';
				}
				if($rowsurs['cur_credithours_practical']>0) {
					echo '<li><a href="summer.php?id='.$_GET['id'].'&view=Practicalmarks" '.$style.'> Practicalm Award List</a></li>';
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
	include_once("summer/information.php");
}
//--------------- Language -------------
if(LMS_VIEW) {
	include_once("summer/".LMS_VIEW.".php");
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