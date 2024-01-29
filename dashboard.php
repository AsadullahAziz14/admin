<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
	require_once("include/header.php");
	echo $_SESSION['userlogininfo']['LOGINAFOR'];
	
	
echo '<title>'.TITLE_HEADER.' Dashboard</title>
<!-- Matter -->
<div class="matter">
<!--WI_HEADING_BAR-->
<div class="widget headerbar-widget">
	<div class="pull-left dashboard-user-picture"><img class="avatar-small" src="images/default.png" alt=""/></div>
	<div class="headerbar-project-title pull-left">
		<h3>'.$_SESSION['userlogininfo']['LOGINFNAMEA_SSS'].'</h3>
	</div>
	<div class="dashboard-user-group pull-right">
		<label class="label label-default">'.$_SESSION['userlogininfo']['LOGINFNAMEA_SSS'].'</label>
	</div>
	<div class="clearfix"></div>
</div>
<div class="container">
<!--WI_MY_TASKS_TABLE-->
<div class="row fullscreen-mode">
<div class="col-md-12">
<div class="widget">
<div class="widget-content">
	<h1 style="font-weight:700;padding:150px; text-align:center;">Welcome to Minhaj University Lahore</h1>
</div>
</div>
</div>
</div>
<img src="" alt="">
</div>
';


echo '
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
<!-- Footer ends -->';
?>
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
    $('.pickadate').datepicker({
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
		$('.footable').footable();
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
</html>