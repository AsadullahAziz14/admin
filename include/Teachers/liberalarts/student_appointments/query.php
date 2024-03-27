<?php 
//Update Student Appointment Request
if(isset($_POST['appointment_changes'])) { 

	$data = array(
		'status'	        		=> cleanvars($_POST['status'])								, 
		'appointment_date'	       	=> date('Y-m-d', strtotime(cleanvars($_POST['appointment_date'])))	, 
		'time_duration'	       		=> cleanvars($_POST['time_duration'])						, 
		'issues'	       			=> cleanvars($_POST['issues'])								, 
		'way_forward'	       		=> cleanvars($_POST['way_forward'])							, 
		'wayforward_date'	       	=> date('Y-m-d', strtotime(cleanvars($_POST['wayforward_date'])))	, 
		'id_modify'	        		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])		, 
		'date_modify'		        => date("Y-m-d H:i:s")		            					, 
	);

	$sqllmsUpdate = $dblms->Update(LA_ADVISORAPPOINTMENTS, $data, "WHERE id = '".cleanvars($_GET['id'])."'");

	if($sqllmsUpdate) { 

		//Set Success MSG in Session & Exit
		$_SESSION['msg']['status']  = '<div id="infoupdated" class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
		header("Location: lateacherappointments.php", true, 301);
		exit();

	}
}