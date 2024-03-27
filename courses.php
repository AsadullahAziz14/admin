<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	// include "functions/liberalarts.php";
	// require_once 'functions/UserInfo.php';
	checkCpanelLMSALogin();
	include_once("include/header.php");
	// $devicedetails 	= UserInfo::get_device().' '.UserInfo::get_os().' '.UserInfo::get_browser() .'<br>'.htmlentities($_SERVER['HTTP_USER_AGENT']);
//---------------------------------
	include_once("include/".get_logintypes($_SESSION['userlogininfo']['LOGINAFOR'])."/courses.php");
//---------------------------------

