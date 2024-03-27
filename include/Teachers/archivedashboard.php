<?php 
echo '<title>'.TITLE_HEADER.' Archive Dashboard</title>
<!-- Matter -->
<div class="matter">
<!--WI_HEADING_BAR-->
<div class="widget headerbar-widget">
	<div class="pull-left dashboard-user-picture"><img class="avatar-small" src="'.$_SESSION['userlogininfo']['LOGINIDAPIC'].'" alt="'.$_SESSION['userlogininfo']['LOGINFNAMEA'].'"/></div>
	<div class="headerbar-project-title pull-left">
		<h3>'.$_SESSION['userlogininfo']['LOGINFNAMEA'].'</h3>
	</div>
	<div class="dashboard-user-group pull-right">
		<label class="label label-default">'.$_SESSION['userlogininfo']['LOGINFNAMEA'].'</label>
	</div>
	<div class="clearfix"></div>
</div>
<div class="container">
<!--WI_MY_TASKS_TABLE-->
<div class="row fullscreen-mode">
<div class="col-md-12">

<div id="dasboard">
<!-- Main Section -->
<section class="main-section">
<div class="main-content">
	<header><h2>Archive Courses ('.ARCHIVE_SESS.') </h2></header>
<section class="container_8 clearfix">
<div class="other-options grid_7">';
//----------------------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT emply_id 
										FROM ".EMPLYS."   										 
										WHERE id_campus 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND emply_loginid 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' LIMIT 1");
	$rowsstd = mysqli_fetch_array($sqllms);
//----------------------------------------------------------------
	$sqllmscrus  = $dblms->querylms("SELECT DISTINCT(d.id_curs), d.id_setup, c.curs_id, c.curs_code, c.curs_name, 
										p.prg_id, p.prg_name, p.prg_code, t.section, t.timing , t.semester      
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs  
										INNER JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg  
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.status = '1' AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND t.academic_session = '".ARCHIVE_SESS."'  
										 ORDER BY t.section ASC, t.id ASC");
//----------------------------------------------------------------
if(mysqli_num_rows($sqllmscrus)>0) { 
//----------------------------------------------------------------
while($rowscurs = mysqli_fetch_array($sqllmscrus)) {  
 if($rowscurs['section']) { 
	$sectcaption = 'Section: '.$rowscurs['section'];
	$secthref 	 = '&section='.$rowscurs['section'];
 } else { 
 	$sectcaption = '';
	$secthref 	 = '';
 }

echo '
<div class="widget-grid widget-container" draggable="true">
<div class="widget has-details">
	<header>
		<ul class="ttw-notification-menu clearfix fr ">
			<li class="notification-menu-item first-item" id="assignments">
				<span class="text">Assignments</span><span title="New Assignments" class="notification-bubble redbubble">0</span>
			</li>
			<li class="notification-menu-item" id="quizes">
				<span class="text">Quizzes</span> <span title="New Quizzes" class="notification-bubble bluebubble">0</span>
			</li>
			<li class="notification-menu-item " id="messages">
				<span class="text">GDB</span><span title="New GDB" class="notification-bubble yellowbubble">0</span>
			</li>
			<li class="notification-menu-item  last-item" id="annoucements">
				<span class="text">Announcements</span><span title="New Annoucement" class="notification-bubble greenbuble">0</span>
			</li>
		</ul>
		<h2><a title="View Course Information and related contents" href="archive.php?id='.$rowscurs['curs_id'].'&prgid='.$rowscurs['prg_id'].'&timing='.$rowscurs['timing'].'&semester='.$rowscurs['semester'].$secthref.'">'.$rowscurs['curs_code'].' - '.$rowscurs['curs_name'].' ('.$rowscurs['prg_code'].'- '.get_programtiming($rowscurs['timing']).') '.$sectcaption.' Semester: '.addOrdinalNumberSuffix($rowscurs['semester']).'</a></h2>
	</header>

	<section>
		<div class="report-preview">
			<ul class="dashboard-buttons">
				<li>
					<a title="View Course Information and related contents" class="coursewebsite" href="archive.php?id='.$rowscurs['curs_id'].'&prgid='.$rowscurs['prg_id'].'&timing='.$rowscurs['timing'].'&semester='.$rowscurs['semester'].$secthref.'" style="display:inline-block;width:34px;"></a>
				</li>
				<li>
					<a title="Lessons" class="lessons" href="archive.php?id='.$rowscurs['curs_id'].'&prgid='.$rowscurs['prg_id'].'&timing='.$rowscurs['timing'].'&semester='.$rowscurs['semester'].$secthref.'&view=Lessonplan" style="display:inline-block;width:34px;"></a>
				</li>
				<li>
					<a title="Video Lessons" class="videos"href="archive.php?id='.$rowscurs['curs_id'].'&prgid='.$rowscurs['prg_id'].'&timing='.$rowscurs['timing'].'&semester='.$rowscurs['semester'].$secthref.'&view=Lessonvideo" style="display:inline-block;width:34px;"></a>
				</li>
				<li>
					<a title="New and past Quizzes details" class="quizes" href="#" style="display:inline-block;width:34px;"></a>
				</li>
				<li>
					<a  title="Manage your Assignments" class="assignments" href="archive.php?id='.$rowscurs['curs_id'].'&prgid='.$rowscurs['prg_id'].'&timing='.$rowscurs['timing'].'&semester='.$rowscurs['semester'].$secthref.'&view=Assignments" style="display:inline-block;width:34px;"></a>
				</li>
				<li>
					<a title="Participate in Graded Discussion" class="GDB" href="#" style="display:inline-block;width:34px;"></a>
				</li>
				<li>
					<a title="Participate in Moderated Discussion" class="MDB" href="#"></a>
				</li>
				<li>
					<a title="View new course Announcements" class="annoucements" href="archive.php?id='.$rowscurs['curs_id'].'&prgid='.$rowscurs['prg_id'].'&timing='.$rowscurs['timing'].'&semester='.$rowscurs['semester'].$secthref.'&view=Annoucements" style="display:inline-block;width:34px;"></a>
				</li>
				<li>
					<a title="Attend Live Session" class="livesession" href="#" style="display:inline-block;width:34px;"></a>
				</li>
			</ul>
		</div>
	</section>
</div>
</div>';
//----------------------------------
}
//----------------------------------
}
//----------------------------------
echo '
</div>
</section>

</div>
</section>
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
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>
<!--------------------COMMON FOOTER JAVASCRIPT---------------------------->
<!-- REQUIRED - ALL VENDORS -->
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<!-- REQUIRED - ALL VENDORS -->
<!--REQUIRED js_ckeditor - CKeditor-->
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
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
});
</script>
<!-- CUSTOM - Datepicker (eternicode.github.io) -->
<!-- REQUIRED js_noty - Noty Notification -->
<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
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
?>