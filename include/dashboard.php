<?php 
//----------------------------------------------------------------
$sqllmsadmin	= $dblms->querylms("SELECT adm_restpassdate FROM ".ADMINS."
										WHERE adm_status = '1' 
										AND adm_id = '".cleanvars($_SESSION['LOGINIDA_SSS'])."' LIMIT 1");
$value_admin = mysqli_fetch_array($sqllmsadmin);
//----------------------------------------------------------------
$last = strtotime($value_admin['adm_restpassdate']);
$current = strtotime(date('Y-m-d'));

$days = ceil(abs($current - $last) / 86400);

if($days >= 60 && cleanvars($_SESSION['LOGINIDCOM_SSS']) == 1){

	header("Location: changepassword.php");
	exit;

} else {


	if(isset($_GET['asession']) && cleanvars($_GET['asession']) != ''){

		$_SESSION['userlogininfo']['LOGINIDACADYEAR'] = cleanvars($_GET['asession']);
		header("Location: dashboard.php");
		exit();

	}

	echo '<title>'.TITLE_HEADER.' Dashboard</title>
	<!-- Matter -->
	<div class="matter">
	<!--WI_HEADING_BAR-->
	<div class="widget headerbar-widget">
		<div class="pull-left dashboard-user-picture"><img class="avatar-small" src="'.$_SESSION['userlogininfo']['LOGINIDAPIC'].'" alt="'.$_SESSION['userlogininfo']['LOGINFNAMEA'].'"/></div>
		<div class="headerbar-project-title pull-left">
			<h3 style="font-weight:600;">'.$_SESSION['userlogininfo']['LOGINFNAMEA'].'</h3>
		</div>
		<div class="dashboard-user-group pull-right">
			<label class="label label-default">'.($_SESSION['userlogininfo']['LOGINFNAMEA']).'</label>
		</div>
		<div class="clearfix"></div>
	</div>';

	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) == 1){

		echo '
		<div class="row">
			<div class="modal-dialog" style="width:95%;">
				<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
				<form class="form-horizontal" action="dashboard.php" method="GET" id="addSession">
					<div class="col-sm-12">
						<div class="form_sep" style="margin-top:5px;">
							<label>Academic Session</label>
							<select id="asession" name="asession" style="width:100%" autocomplete="off" onChange="this.form.submit()">
								<option value="Spring 2024"';if(cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR']) == 'Spring 2024'){ echo 'selected';} echo '>Spring 2024</option>
                                <option value="Fall 2023"';if(cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR']) == 'Fall 2023'){ echo 'selected';} echo '>Fall 2023</option>
							</select>
						</div> 
					</div>
				</form>
				<script>
					$("#asession").select2({
						allowClear: true
					});
				</script>
			</div>
		</div>';
	}

	echo '
	<div class="container">
	<!--WI_MY_TASKS_TABLE-->
	<div class="row fullscreen-mode">
	<div class="col-md-12">

	

	<div id="dasboard">
	<!-- Main Section -->
	<section class="main-section">
	<div class="main-content">
		<header><h2>Courses ('.cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR']).')</h2></header>
	<section class="container_9 clearfix">
	<div class="other-options grid_8">';

//--------------------------------------
$sqllmsflashmegs  = $dblms->querylms("SELECT detail   
										FROM ".MESSAGES."  
										WHERE id_campus = '".cleanvars($_SESSION['LOGINIDCOM_SSS'])."'  
										AND for_teachers = '1' AND status = '1' AND published = '1' 
										AND is_flashmessage = '1' 
										AND ('".date("Y-m-d")."' BETWEEN date_start  AND date_end) LIMIT 1");
if(mysqli_num_rows($sqllmsflashmegs)) { 

	$rowflashmsgs = mysqli_fetch_array($sqllmsflashmegs);
	echo '
	<style type="text/css">
		#project-brief ol li {
			list-style-type: inherit !important;
		}

		#project-brief ul li {
			list-style: circle !important;
		}
	</style>
	<div class="flashmsgs" style="margin-bottom:50px;  text-align:left !important;">
		<span class="nortification animateOpen">
			<div id="project-brief" style="color: #fff !important;">'.html_entity_decode($rowflashmsgs['detail'], ENT_QUOTES).'</div>
		</span>
	</div>
	<script>
		$("p").css("color", "#fff");
	</script>
	<div style="clear:both;"></div>';
}

//----------------------------------------------------------------
	$sqllmscrus  = $dblms->querylms("SELECT d.id_curs, d.id_setup, c.curs_id, c.curs_code, c.curs_name, 
										p.prg_id, p.prg_name, p.prg_code, t.section, t.timing , t.semester, t.id_prg       
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs  
										LEFT JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg  
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.status = '1' AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										GROUP BY d.id_curs ORDER BY t.section ASC, t.id ASC");
/*
	$sqllmscrus  = $dblms->querylms("SELECT DISTINCT(d.id_curs), d.id_setup, c.curs_id, c.curs_code, c.curs_name, 
										p.prg_id, p.prg_name, p.prg_code, t.section, t.timing , t.semester, t.id_prg       
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs  
										INNER JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg  
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.status = '1' AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										 ORDER BY t.section ASC, t.id ASC");

*/
//----------------------------------------------------------------
if(mysqli_num_rows($sqllmscrus)>0) { 
//----------------------------------------------------------------
while($rowscurs = mysqli_fetch_array($sqllmscrus)) {  

//----------------Assignments-----------------
	$sqllmsassign  = $dblms->querylms("SELECT COUNT(id) as Totalassignment
										FROM ".COURSES_ASSIGNMENTS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND id_curs = '".cleanvars($rowscurs['id_curs'])."'");
	$valueassigns = mysqli_fetch_array($sqllmsassign);
//----------------Announcements-----------------
	$sqllmsannouce  = $dblms->querylms("SELECT COUNT(id) as TotalAnnouc  
										FROM ".COURSES_ANNOUCEMENTS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND id_curs = '".cleanvars($rowscurs['id_curs'])."'");
	$valueannouce = mysqli_fetch_array($sqllmsannouce);
echo '
<div class="widget-grid widget-container" draggable="true">
<div class="widget has-details">
	<header >
		<ul class="ttw-notification-menu clearfix fr ">
			<li class="notification-menu-item first-item" id="assignments">
				<span class="text">Assignments</span><a href="courses.php?id='.$rowscurs['curs_id'].'&view=Assignments"><span title="New Assignments" class="notification-bubble redbubble">'.$valueassigns['Totalassignment'].'</span></a>
			</li>
			<li class="notification-menu-item" id="quizes">
				<span class="text">Quizzes</span> <span title="New Quizzes" class="notification-bubble bluebubble">0</span>
			</li>
			
			<li class="notification-menu-item  last-item" id="annoucements">
				<span class="text">Announcements</span><a href="courses.php?id='.$rowscurs['curs_id'].'&view=Annoucements"><span title="New Annoucement" class="notification-bubble yellowbubble">'.$valueannouce['TotalAnnouc'].'</span></a>
			</li>
		</ul>
		<h2><a href="courses.php?id='.$rowscurs['curs_id'].'">'.$rowscurs['curs_code'].' - '.$rowscurs['curs_name'].'</a></h2>
	</header>
	<section>
		<div class="report-preview">
			<ul class="dashboard-buttons">
				<li style="margin-left:30px;">
					<a href="courses.php?id='.$rowscurs['curs_id'].'" target="_self">
						<img src="images/icons/Courses.png" alt="Course Info" style="width:40px; height:40px;" />
						<p class="txtsmall" style="color:#222;">Course Info</p>
					</a>
				</li>
				
				<li>
					<a href="courses.php?id='.$rowscurs['curs_id'].'&view=Lessonplan" target="_self">
						<img src="images/icons/Lesson-Plan.png" alt="Lesson Plan" style="width:40px; height:40px;" />
						<p class="txtsmall" style="color:#222;">Lesson Plan</p>
					</a>
				</li>
				<li>
					<a href="courses.php?id='.$rowscurs['curs_id'].'&view=Resources" target="_self">
						<img src="images/icons/course-resources.png" alt="Lesson Video" style="width:40px; height:40px;" />
						<p class="txtsmall" style="color:#222;">Course Resources</p>
					</a>
				</li>
				
				<li>
					<a href="courses.php?id='.$rowscurs['curs_id'].'&view=Books" target="_self">
						<img src="images/icons/Books.png" alt="Books" style="width:40px; height:40px;" />
						<p class="txtsmall" style="color:#222;">Books</p>
					</a>
				</li>
				<li>
					<a href="courses.php?id='.$rowscurs['curs_id'].'&view=QuizBank" target="_self">
						<img src="images/icons/Quizes.png" alt="Questions Bank" style="width:40px; height:40px;" />
						<p class="txtsmall" style="color:#00f;font-weight:600;">Question Bank</p>
					</a>
				</li>
				
				<li>
					<a href="courses.php?id='.$rowscurs['curs_id'].'&view=Assignments" target="_self">
						<img src="images/icons/Assignments.png" alt="Assignments" style="width:40px; height:40px;" />
						<p class="txtsmall" style="color:#222;">Assignments</p>
					</a>
				</li>
				<li>
					<a href="courses.php?id='.$rowscurs['curs_id'].'&view=Discussion" target="_self">
						<img src="images/icons/Discussion-Board.png" alt="Discussion" style="width:40px; height:40px;" />
						<p class="txtsmall" style="color:#222;">Discussion Board</p>
					</a>
					
				</li>
				
				<li>
					<a href="courses.php?id='.$rowscurs['curs_id'].'&view=Annoucements" target="_self">
						<img src="images/icons/Announcement.png" alt="Discussion" style="width:40px; height:40px;" />
						<p class="txtsmall" style="color:#222;">Announcements</p>
					</a>
					
				</li>
				
				
			</ul>
		</div>
	</section>
	

</div>
</div>';
}
} else {
	echo '
	<div class="col-lg-12">
		<div class="widget-tabs-notification">No Result Found</div>
	</div>';
}
echo '
</div>
</section>

</div>
</section>
</div>';

//----------------------------------------------------------------
	$sqllmssummer  = $dblms->querylms("SELECT ca.id, ca.id_curs, ca.timing, ca.id_teacher, e.emply_name, c.curs_id, c.curs_code, c.curs_name     
										FROM ".SUMMER_COURSE_ALLOCATION." ca  
										INNER JOIN ".COURSES." c ON c.curs_id = ca.id_curs  
										INNER JOIN ".EMPLYS." e ON e.emply_id = ca.id_teacher   
										WHERE c.id_campus	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND ca.summer_year	= '".date("Y")."' AND  ca.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										GROUP BY ca.id_curs ORDER BY c.curs_code ASC");
//----------------------------------------------------------------
if(mysqli_num_rows($sqllmssummer)>0) { 
echo '<div id="dasboard">
<!-- Main Section -->
<section class="main-section">
<div class="main-content">
	<header><h2>Summer ('.ARCHIVE_SESS.')</h2></header>
	<section class="container_9 clearfix">
	<div class="other-options grid_8">';
//----------------------------------------------------------------
while($rowsummer = mysqli_fetch_array($sqllmssummer)) {  

echo '
<div class="widget-grid widget-container" draggable="true">
<div class="widget has-details">

	<header >
		<ul class="ttw-notification-menu clearfix fr ">
			<li class="notification-menu-item first-item" id="assignments">
				<span class="text">Assignments</span><a href="summer.php?id='.$rowsummer['curs_id'].'&view=Assignments"><span title="New Assignments" class="notification-bubble redbubble">0</span></a>
			</li>
			<li class="notification-menu-item" id="quizes">
				<span class="text">Quizzes</span> <span title="New Quizzes" class="notification-bubble bluebubble">0</span>
			</li>
			
			<li class="notification-menu-item  last-item" id="annoucements">
				<span class="text">Announcements</span><a href="summer.php?id='.$rowsummer['curs_id'].'&view=Annoucements"><span title="New Annoucement" class="notification-bubble yellowbubble">0</span></a>
			</li>
		</ul>
		<h2><a href="summer.php?id='.$rowsummer['curs_id'].'">'.$rowsummer['curs_code'].' - '.$rowsummer['curs_name'].'</a></h2>
	</header>
	<section>
		<div class="report-preview">
			<ul class="dashboard-buttons">
				<li style="margin-left:30px;">
					<a href="summer.php?id='.$rowsummer['curs_id'].'" target="_self">
						<img src="images/icons/Courses.png" alt="Course Info" style="width:40px; height:40px;" />
						<p class="txtsmall" style="color:#222;">Course Info</p>
					</a>
				</li>
				
				<li>
					<a href="summer.php?id='.$rowsummer['curs_id'].'" target="_self">
						<img src="images/icons/Lesson-Plan.png" alt="Lesson Plan" style="width:40px; height:40px;" />
						<p class="txtsmall" style="color:#222;">Lesson Plan</p>
					</a>
				</li>
				<li>
					<a href="summer.php?id='.$rowsummer['curs_id'].'" target="_self">
						<img src="images/icons/course-resources.png" alt="Lesson Video" style="width:40px; height:40px;" />
						<p class="txtsmall" style="color:#222;">Course Resources</p>
					</a>
				</li>
				
				<li>
					<a href="summer.php?id='.$rowsummer['curs_id'].'" target="_self">
						<img src="images/icons/Books.png" alt="Books" style="width:40px; height:40px;" />
						<p class="txtsmall" style="color:#222;">Books</p>
					</a>
				</li>
				
				<li>
					<a href="summer.php?id='.$rowsummer['curs_id'].'" target="_self">
						<img src="images/icons/Assignments.png" alt="Assignments" style="width:40px; height:40px;" />
						<p class="txtsmall" style="color:#222;">Assignments</p>
					</a>
				</li>
				
				<li>
					<a href="summer.php?id='.$rowsummer['curs_id'].'" target="_self">
						<img src="images/icons/Announcement.png" alt="Discussion" style="width:40px; height:40px;" />
						<p class="txtsmall" style="color:#222;">Announcements</p>
					</a>
					
				</li>
				
				
			</ul>
		</div>
	</section>
</div>
</div>';
//----------------------------------
}
//----------------------------------
echo '</div>
</section>

</div>
</section>';
} /*else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}*/

//----------------------------------
echo '

</div>


</div>
</div>
</div>

</div>
</div>
<!-- Matter ends -->
</div>
<!-- Mainbar ends -->
<div class="clearfix"></div>
<!-- Content ends -->
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
<!----------------------COMMON FOOTER--------------------------------->
<!-- Scroll to top -->
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>';
	include("messagepopup.php");
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


<!--------------------COMMON FOOTER JAVASCRIPT---------------------------->
<!-- REQUIRED - ALL VENDORS -->
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<!-- REQUIRED - ALL VENDORS -->

<!--REQUIRED js_ckeditor - CKeditor-->
<script type="text/javascript" src="js/ckeditor/ckeditor.js">
</script>

<!--REQUIRED js_ckeditor - CKeditor-->

<!-- CUSTOM - Datepicker (eternicode.github.io) -->
<script>
//USED BY: All date picking forms
$(document).ready(function(){
    $(".pickadate").datepicker({
       format: "yyyy-mm-dd",
       language: "lang",
       autoclose: true,
       todayHighlight: true
    });	
	
</script>
 <script>
    $(document).ready(function(){
        $("#bs-example2-modal-lg").modal(\'show\');
    });
</script>
<!-- CUSTOM - Datepicker (eternicode.github.io) -->

<!-- REQUIRED js_noty - Noty Notification -->
<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js">
</script>
<!-- REQUIRED js_noty - Noty Notification -->


<!--REQUIRED - footable.js (included in all-vendors.js)-->
<script type="text/javascript">
	$(function () {
		$(".footable").footable();
		
	});
</script>
<!--REQUIRED - footable.js -->


<!-- CUSTOM -->
<script type="text/javascript" src="js/custom/custom.js"></script>
<!-- CUSTOM -->


<!-- CUSTOM GENERAL -->
<script type="text/javascript" src="js/custom/custom.general.js"></script>
<!-- CUSTOM GENERAL -->


<!--------------------COMMON FOOTER JAVASCRIPT---------------------------->
</body>
</html>';
}
