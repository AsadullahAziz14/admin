<?php 
//Delete Record
if(isset($_GET['delid'])) {
	$sqllms  	= $dblms->querylms("DELETE FROM ".ASSEMBLY_ATTENDANCE." WHERE id ='".$_GET['delid']."'");
	$sqllmsprt  = $dblms->querylms("DELETE FROM ".ASSEMBLY_ATTENDANCE_DETAIL." WHERE id_setup ='".$_GET['delid']."'");
	
	$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>Record deleted successfully.</div>';
	header('location:'.$_SERVER['HTTP_REFERER'].'');
	exit();
}

//Add Attendance
if(isset($_POST['submit_attendance'])) {  

	if(isset($_GET['section'])) {  
		$secthref		= "&section=".$_GET['section'];
		$section 		= $_GET['section'];
		$seccursquery 	= " AND at.section = '".$_GET['section']."'";
	} else { 
		$secthref		= '';
		$section 		= '';
		$seccursquery 	= " AND at.section = ''";
	}	

	$hrefredirect = 'assemblyattendance.php?prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'';


	if(isset($_GET['prgid']) && isset($_GET['semester']) && isset($_GET['timing']) && isset($_POST['id_teacher'])) { 

		$sqllmsCheck  = $dblms->querylms("SELECT at.id  
												FROM ".ASSEMBLY_ATTENDANCE."  at 
												WHERE at.id_campus 		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND at.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
												AND at.id_teacher 		= '".cleanvars($_POST['id_teacher'])."' 
												AND at.semester 		= '".cleanvars($_GET['semester'])."' 
												AND at.id_prg 			= '".cleanvars($_GET['prgid'])."' 
												AND at.timing 			= '".cleanvars($_GET['timing'])."'
												$seccursquery 
												AND at.dated 			= '".date('Y-m-d' , strtotime(cleanvars($_POST['dated'])))."'");
		
		if(mysqli_num_rows($sqllmschecklecture)>0) { 
			
			$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Notice: </span>Record already exists.</div>';
			header("Location:".$hrefredirect."", true, 301);
			exit();
			
		} else { 

			$sqllmsInsert  = $dblms->querylms("INSERT INTO ".ASSEMBLY_ATTENDANCE." (
																				id_prg 								,  
																				semester							,  
																				section								,  
																				timing								, 
																				id_teacher							,
																				dated								,
																				academic_session					,
																				id_campus							,
																				id_added							, 
																				date_added 
																		)
																	VALUES (
																				'".cleanvars($_GET['prgid'])."'				,
																				'".cleanvars($_GET['semester'])."'			,
																				'".cleanvars($section)."'					,
																				'".cleanvars($_GET['timing'])."'			,
																				'".cleanvars($_POST['id_teacher'])."'		, 
																				'".date('Y-m-d' , strtotime(cleanvars($_POST['dated'])))."'		, 
																				'".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 	, 
																				'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 					,
																				'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'			, 
																				NOW() 
																		)"
									);

			if($sqllmsInsert) {

				$idsetup = $dblms->lastestid();

				$attends = "\n";

				for($ichk=1; $ichk<=sizeof($_POST['id_std']); $ichk++){

					if(!empty($_POST['status'][$ichk])) { 
						$status = '1';
					} else { 
						$status = '2';
					}
	
					$sqllmInsertDetail = $dblms->querylms("INSERT INTO ".ASSEMBLY_ATTENDANCE_DETAIL."( 
																						id_setup									,
																						id_std										, 
																						status										, 
																						remarks										
																					)
																			VALUES (
																						'".$idsetup."'								, 
																						'".cleanvars($_POST['id_std'][$ichk])."'	, 
																						'".cleanvars($status)."'					, 
																						'".cleanvars($_POST['remarks'][$ichk])."'	
																					)
												");
				
					$attends .= '"id_std:"'.'=>'.'"'.cleanvars($_POST['id_std'][$ichk]).'",'."\n";
					$attends .= '"status:"'.'=>'.'"'.cleanvars($status).'",'."\n";
					$attends .= '"remarks:"'.'=>'.'"'.cleanvars($_POST['remarks'][$ichk]).'"'."\n";
				}
	
				$requestedvars = "\n";
				$requestedvars .= '"ID:"'.'=>'.'"'.$idsetup.'",'."\n";
				$requestedvars .= '"id_prg:"'.'=>'.'"'.$_GET['prgid'].'",'."\n";
				$requestedvars .= '"semester:"'.'=>'.'"'.$_GET['semester'].'",'."\n";
				$requestedvars .= '"section:"'.'=>'.'"'.$section.'",'."\n";
				$requestedvars .= '"timing:"'.'=>'.'"'.get_programtiming($_GET['timing']).'",'."\n";
				$requestedvars .= '"id_teacher:"'.'=>'.'"'.$_POST['id_teacher'].'",'."\n";
				$requestedvars .= '"dated:"'.'=>'.'"'.$_POST['dated'].'",'."\n";
				$requestedvars .= '"Students:"'.'=>'.'array('."\n";
				$requestedvars .= $attends."\n";
				$requestedvars .= ")\n";

				$logremarks = 'Add Student Assembly Attendance of Date: '.$_POST['dated'];
				$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGSTEACHER." (
																	id_user										, 
																	filename									, 
																	action										,
																	dated										,
																	ip											,
																	remarks										,
																	details							,
																	sess_id							,
																	device_details					,
																	id_campus				
																)
				
															VALUES(
																	'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	,
																	'".basename($_SERVER['REQUEST_URI'])."'		, 
																	'1'											, 
																	NOW()										,
																	'".cleanvars($ip)."'						,
																	'".cleanvars($logremarks)."'				,
																	'".cleanvars($requestedvars)."'				,
																	'".cleanvars(session_id())."'				,
																	'".cleanvars($devicedetails)."'				,
																	'".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'			
																)
											");

				$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record added successfully.</div>';
				header("Location:".$hrefredirect."", true, 301);
				exit();

			}

		}

	} else { 
	
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Notice: </span>Record could not be added due to missing some values.</div>';
		header("Location:".$hrefredirect."", true, 301);
		exit();

	}
}

//Update Attendance Record
if(isset($_POST['changes_attendance'])) { 

	if(isset($_GET['section'])) {  
		$secthref		= "&section=".$_GET['section'];
		$section 		= $_GET['section'];
		$seccursquery 	= " AND at.section = '".$_GET['section']."'";
	} else { 
		$secthref		= '';
		$section 		= '';
		$seccursquery 	= " AND at.section = ''";
	}	

	$hrefredirect = 'assemblyattendance.php?prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref;	


	if(date('Y-m-d' , strtotime(cleanvars($_POST['dated']))) != date("Y-m-d")) { 
		
		$_SESSION['msg']['status'] = '<div class="alert-box warning" style="width:85%;"><span>Notice: </span>You cannot update attendance because current date and your lecture date difference. </div>';
		header("Location:".$hrefredirect."", true, 301);
		exit();

	} else {

		$sqllmsInsert  = $dblms->querylms("UPDATE ".ASSEMBLY_ATTENDANCE." SET 
																lectureno	= '".cleanvars($_POST['lectureno'])."'
															, semester		= '".cleanvars($_GET['semester'])."'
															, section		= '".cleanvars($section)."'
															, timing		= '".cleanvars($_GET['timing'])."'
															, id_prg		= '".cleanvars($_GET['prgid'])."'
															, id_teacher	= '".cleanvars($_POST['id_teacher'])."'
															, dated			= '".date('Y-m-d' , strtotime(cleanvars($_POST['dated'])))."' 
															, id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
															, id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
															, date_modify	= NOW()
														WHERE id			= '".cleanvars($_POST['id_setup'])."'");

		if($sqllmsInsert) {

			$arraychecked = $_POST['id_std'];
			$attends = "\n";

			for($ichk=1; $ichk<=sizeof($_POST['id_std']); $ichk++){

				if(!empty($_POST['status'][$ichk])) { 
					$status = '1';
				} else { 
					$status = '2';
				}

				if(!empty($_POST['id_attendance'][$ichk])) { 
				//------------------------------------------------
					$sqllmsUpdateDetail  = $dblms->querylms("UPDATE ".ASSEMBLY_ATTENDANCE_DETAIL." SET 
																			id_std		= '".cleanvars($_POST['id_std'][$ichk])."'
																		, status		= '".cleanvars($status)."'
																		, remarks		= '".cleanvars($_POST['remarks'][$ichk])."' 
																	WHERE id_setup	= '".cleanvars($_POST['id_setup'])."' 
																	AND id	= '".cleanvars($_POST['id_attendance'][$ichk])."' ");
				} else { 
				//------------------------------------------------
					$sqllmsUpdateDetail  = $dblms->querylms("INSERT INTO ".ASSEMBLY_ATTENDANCE_DETAIL."( 
																						id_setup									,
																						id_std										, 
																						status										, 
																						remarks										
																					)
																			VALUES (
																						'".cleanvars($_POST['id_setup'])."'			, 
																						'".cleanvars($_POST['id_std'][$ichk])."'	, 
																						'".cleanvars($status)."'					, 
																						'".cleanvars($_POST['remarks'][$ichk])."'	
																					)
												");

				}

				$attends .= '"id_std:"'.'=>'.'"'.cleanvars($_POST['id_std'][$ichk]).'",'."\n";
				$attends .= '"status:"'.'=>'.'"'.cleanvars($status).'",'."\n";
				$attends .= '"remarks:"'.'=>'.'"'.cleanvars($_POST['remarks'][$ichk]).'"'."\n";

			}

			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$_POST['id_setup'].'",'."\n";
			$requestedvars .= '"semester:"'.'=>'.'"'.$_GET['semester'].'",'."\n";
			$requestedvars .= '"section:"'.'=>'.'"'.$section.'",'."\n";
			$requestedvars .= '"timing:"'.'=>'.'"'.get_programtiming($_GET['timing']).'",'."\n";
			$requestedvars .= '"id_prg:"'.'=>'.'"'.$_GET['prgid'].'",'."\n";
			$requestedvars .= '"id_teacher:"'.'=>'.'"'.$_POST['id_teacher'].'",'."\n";
			$requestedvars .= '"dated:"'.'=>'.'"'.$_POST['dated'].'",'."\n";
			$requestedvars .= '"Students:"'.'=>'.'array('."\n";
			$requestedvars .= $attends."\n";
			$requestedvars .= ")\n";

			$logremarks = 'Update Student Assembly Attendance of Date: '.$_POST['dated'];
			$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGSTEACHER." (
																id_user										, 
																filename									, 
																action										,
																dated										,
																ip											,
																remarks										,
																details							,
																sess_id							,
																device_details					,
																id_campus				
															)
			
														VALUES(
																'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	,
																'".basename($_SERVER['REQUEST_URI'])."'		, 
																'2'											, 
																NOW()										,
																'".cleanvars($ip)."'						,
																'".cleanvars($logremarks)."'				,
																'".cleanvars($requestedvars)."'				,
																'".cleanvars(session_id())."'				,
																'".cleanvars($devicedetails)."'				,
																'".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'			
															)
										");

			$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
			header("Location:".$hrefredirect."", true, 301);
			exit();
	
		}

	}

}