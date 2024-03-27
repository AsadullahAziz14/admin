<?php 
//--------------------------------------
if(isset($_POST['submit_drivelinks'])) { 
//--------------------------------------
	$sqllmscheckrel  = $dblms->querylms("SELECT id  
										FROM ".COURSES_DRIVELINKS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND drive_link = '".cleanvars($_POST['drive_link'])."' LIMIT 1");
if(mysqli_num_rows($sqllmschecker)>0) { 
	$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>record already exists.</div>';
	header("Location:courses.php?id=".$_GET['id']."&view=Drivelinks", true, 301);
	exit();
} else { 

	$sqllmswebrel  = $dblms->querylms("INSERT INTO ".COURSES_DRIVELINKS." (
																		status								, 
																		caption								, 
																		drive_link							,
																		id_curs								,
																		id_teacher							,
																		academic_session					,
																		id_campus							,
																		id_added							, 
																		date_added 
																   )
	   														VALUES (
																		'".cleanvars($_POST['status'])."'			,
																		'".cleanvars($_POST['caption'])."'			,
																		'".cleanvars($_POST['drive_link'])."'		, 
																		'".cleanvars($_POST['id_curs'])."'			, 
																		'".cleanvars($rowsstd['emply_id'])."'			, 
																		'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
																		'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
																		NOW() 
													 			 )"
							);
	if($sqllmswebrel) { 
	$idlink = $dblms->lastestid();
//--------------------------------------
	$logremarks = 'Add Drive Link #: '.$idlink.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGS." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															id_campus				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'				,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."'			, 
															'1'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($logremarks)."'						,
															'".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'			
														  )
									");
			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."&view=Drivelinks", true, 301);
			exit();
		} 
//--------------------------------------
	}
}


//------------update--------------------------
if(isset($_POST['changes_detaildrive'])) { 
//------------------------------------------------
$sqllmsweblink  = $dblms->querylms("UPDATE ".COURSES_DRIVELINKS." SET  status	= '".cleanvars($_POST['status'])."'
														, caption			= '".cleanvars($_POST['caption'])."'
														, drive_link		= '".cleanvars($_POST['drive_link'])."'
														, id_campus			= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
														, id_modify			= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														, date_modify		= NOW()
													WHERE id				= '".cleanvars($_POST['editid'])."'");
//--------------------------------------
		if($sqllmsweblink) {

//--------------------------------------
	$logremarks = 'Update Drive Link #:'.$_POST['editid'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGS." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															id_campus				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'				,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."'			, 
															'2'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($logremarks)."'						,
															'".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'			
														  )
									");
			$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."&view=Drivelinks", true, 301);
			exit();
		}
//--------------------------------------
	}
