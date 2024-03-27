<?php
session_start();
date_default_timezone_set('Asia/Karachi');
//**********Admin Area Login checking ***********************/
function checkCpanelLMSALogin() {
// if the session id is not set, redirect to login page
	if(!isset($_SESSION['userlogininfo']['LOGINIDA_SSS'])) {
		header("Location: login.php");
		exit;
	}
	// For admin logout
	if(isset($_GET['logout'])) {
		panelLMSALogout();
	}
}

//***************Function for admin login*********************
function cpanelLMSAuserLogin() {

	require_once ("dbsetting/lms_vars_config.php");
	require_once ("dbsetting/classdbconection.php");
	require_once ("functions/functions.php");
	$dblms = new dblms();
//******* if we found an error save the error message in this variable**********
	$errorMessage = '';
	$admin_user   = cleanvars($_POST['login_id']);
	$admin_pass1  = cleanvars($_POST['login_pass']);
	$admin_pass3  = md5($admin_pass1);

//*************** first, make sure the adminname & password are not empty******
	if($admin_user == '') {
		$errorMessage = 'You must enter your User Name';
	} else if ($admin_pass3 == '') {
		$errorMessage = 'You must enter the User Password';
	} else {
// **************Check the admin name and password exist*****************
		$sqllms	= $dblms->querylms("SELECT * FROM ".ADMINS."
											 WHERE adm_username = '".$admin_user."' 
											 -- AND adm_userpass = '".$admin_pass3."' 
											 AND adm_status = '1' LIMIT 1");
		

	//************** if the admin name and password exist then **************** 	
	if (mysqli_num_rows($sqllms) == 1) {
		$row = mysqli_fetch_array($sqllms); 

		$userlogininfo = [];
		
	//*********** Store admin id into session ************************
		$_SESSION['LOGINIDA_SSS']   			= $row['adm_id'];
		$_SESSION['LOGINUSERA_SSS'] 			= $row['adm_username'];
		$_SESSION['LOGINFNAMEA_SSS']  	 		= $row['adm_fullname'];
		$_SESSION['LOGINTYPE_SSS']  	 		= $row['adm_type']; //1,2,3... 8, 9
		$_SESSION['userlogininfo']['LOGINIDA'] 	= $row['adm_id'];
		$_SESSION['LOGINAFOR'] 		 			= 1;
		$_SESSION['LOGINTYPE'] 		 			= $row['adm_type'];
		// $_SESSION['LOGINTYPE'] 		 			= 8;
		$_SESSION['login_time'] 				= date('Y-m-d H:i:s'); // Store the current timestamp	
		
		
		$userlogininfo['LOGINTYPE']         = $row['adm_type'];

		$userlogininfo['LOGINIDA_SSS']   	= $row['adm_id'];
		$userlogininfo['LOGINUSERA_SSS'] 	= $row['adm_username'];
		$userlogininfo['LOGINFNAMEA_SSS']  	= $row['adm_fullname'];
		$userlogininfo['LOGINID_DT'] 		= $row['adm_id'];
		$userlogininfo['LOGINAFOR'] 		= 1;
		$userlogininfo['LOGINTYPE'] 		= $row['adm_type'];
		// $userlogininfo['LOGINTYPE'] 		= 8;
		$userlogininfo['LOGINIDA'] 		 	= $row['id_campus'];
		$userlogininfo['LOGINIDCOM'] 		= $row['id_campus'];
		$userlogininfo['login_time'] 		= date('Y-m-d H:i:s'); // Store the current timestamp

		$_SESSION['userlogininfo'] = $userlogininfo;

		$rightdata = array();
		// $sqllmsrights  	= $dblms->querylms("SELECT * FROM ".ADMIN_ROLES." 
		// 											WHERE id_adm = '".cleanvars($row['adm_id'])."' ORDER BY right_type ASC");
		// while($valueroles	= mysqli_fetch_array($sqllmsrights)) {
		// 	$rightdata[] = 	array (
		// 							'right_name' 	=> $valueroles['right_name'],
		// 							'add' 			=> $valueroles['added'],
		// 							'edit' 			=> $valueroles['updated'],
		// 							'delete' 		=> $valueroles['deleted'],
		// 							'view' 			=> $valueroles['view'],
		// 							'report' 		=> $valueroles['reporting'],
		// 							'type' 			=> $valueroles['right_type']
		// 						);
		// 	}
		
	$_SESSION['userroles'] = $rightdata;
		
	// ***************Login time when the admin login **************

	//**************Store into session url  Last page visit*******************  
		header("Location: dashboard.php");

		
	} else {

	//********** admin name and password dosn't much *******************
		$errorMessage = '<span style="color: red;"><p> Invalid User Name or Password.</p></span>';
	}		
}

return $errorMessage;
//mysql_close($link);
}

//****************Logout Function for admin site *******************************
function panelLMSALogout() {
	if (isset($_SESSION['userlogininfo']['LOGINIDA_SSS'])) {
		unset($_SESSION['userlogininfo']['LOGINIDA_SSS']);
		unset($_SESSION['LOGINUSERA_SSS']);
		unset($_SESSION['LOGINFNAMEA_SSS']);
		unset($_SESSION['userlogininfo']['LOGINAFOR']);
		unset($_SESSION['LOGINTYPE_SSS']);
		session_destroy();
	}
	header("Location: login.php");
	exit;
}
?>