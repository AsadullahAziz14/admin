<?php 
echo '<title>Manage Courses - '.TITLE_HEADER.'</title>
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
<style type="text/css">
.tabs a	{ 
	width: 80px !important;
	padding: 0px !important;
}
.courseoutline  ul {
	list-style-type:disc !important; 
	margin-left:5px 
}
.courseoutline  table td {
	border: 0 none fff !important;   
}
.courseoutline  table.datatable tbody td:last-child {
	border-bottom: 1px solid #ffffff !important;
}
</style>
	
<div id="dasboard">

<!-- Main Section -->
<section class="main-section grid_8">
<div class="main-content">
<header><h2>Course Information</h2></header>
<section class="container_8 clearfix">

<div class="widget-grid widget-container" draggable="true">
<div class="widget has-details">
	<header>
		<ul class="ttw-notification-menu clearfix fr ">
			<li class="notification-menu-item first-item" id="assignments">
				<span class="text">Assignments</span><span title="New Assignments" class="notification-bubble redbubble">1</span>
			</li>
			<li class="notification-menu-item" id="quizes">
				<span class="text">Quizzes</span> <span title="New Quizzes" class="notification-bubble bluebubble">1</span>
			</li>
			<li class="notification-menu-item " id="messages">
				<span class="text">GDB</span><span title="New GDB" class="notification-bubble yellowbubble">2</span>
			</li>
			<li class="notification-menu-item  last-item" id="annoucements">
				<span class="text">Announcements</span><span title="New Annoucement" class="notification-bubble greenbuble">5</span>
			</li>
		</ul>
		<h2><a title="Course Information and related contents" href="#">CS103 - Programming Fundamentals</a></h2>
	</header>
	<section>
		<div class="report-preview">
			<ul class="dashboard-buttons">
				<li>
					<a title="Course Information and related contents" class="coursewebsite" href="#" style="display:inline-block;width:34px;"></a>
				</li>
				<li>
					<a title="Lessons" class="lessons" href="" style="display:inline-block;width:34px;"></a>
				</li>
				<li>
					<a title="Video Lessons" class="videos" href="" style="display:inline-block;width:34px;"></a>
				</li>
				<li>
					<a title="Quizzes details" class="quizes" href="#" style="display:inline-block;width:34px;"></a>
				</li>
				<li>
					<a title="Assignments" class="assignments" href="" style="display:inline-block;width:34px;"></a>
				</li>
				<li>
					<a title="Graded Discussions" class="GDB" href="" style="display:inline-block;width:34px;"></a>
				</li>
				<li>
					<a title="Moderated Discussions" class="MDB" href="" style="display:inline-block;width:34px;"></a>
				</li>
				<li>
					<a title="Course Announcements" class="annoucements" href="" style="display:inline-block;width:34px;"></a>
				</li>
				<li>
					<a title="Attend Live Session" class="livesession" href="" style="display:inline-block;width:34px;"></a>
				</li>
			</ul>
		</div>
	</section>
</div>
</div>

<div style="clear:both;"></div>
<table id="MainContent_dlCourses" cellspacing="0" style="border-collapse:collapse;">
<tr>
	<td></td>
</tr>
<tr>
<td>
<div class="grid_8">
<!-- the tabs -->
<div class="tabbed-pane">
	<ul class="tabs">
		<li><a href="#">Course Info</a></li>
		<li><a href="#">Overview</a></li>
		<li><a href="#">Contents</a></li>
		<li><a href="#">FAQs</a></li>
		<li><a href="#">Glossary</a></li>
		<li><a href="#">Web Links</a></li>
		<li><a href="#">Books</a></li>
		<li><a href="#">Downloads</a></li>
		<li><a href="#">Grading</a></li>
	</ul>
<!-- tab "panes" -->
<div class="panes clearfix">';
	include_once("course/information.php");
	include_once("course/overview.php");
	include_once("course/contents.php");
	include_once("course/FAQs.php");
	include_once("course/glossary.php");
	include_once("course/weblinks.php");
	include_once("course/books.php");
	include_once("course/downloads.php");
	include_once("course/grading.php");
echo '

</div>
</div>
</div>
</td>
	</tr>
</table>

</div>
</section>
</div>
</section>
<!-- Main Section End -->
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