<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/vars_setting.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
	include_once("include/header.php");
	include_once("include/Staffs/dashboard.php");
?>