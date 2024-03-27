<?php 

//--------------------------------------
if(isset($_POST['submit_lesson'])) { 
//------------------------------------------------
	$sqllmschecker  = $dblms->querylms("SELECT id, status, id_curs, weekno, detail, section  
										FROM ".COURSES_LESSONS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND weekno = '".cleanvars($_POST['weekno'])."'  LIMIT 1");
	if(mysqli_num_rows($sqllmschecker)>0) { 
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>record already exists.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=Lessonplan", true, 301);
		exit();
	} else { 
	$sqllmslesson = $dblms->querylms("INSERT INTO ".COURSES_LESSONS." (
																		status								, 
																		weekno								, 
																		detail								,
																		id_curs								,
																		id_teacher							,
																		academic_session					,
																		id_campus							,
																		id_added							, 
																		date_added 
																   )
	   														VALUES (
																		'".cleanvars($_POST['status'])."'			,
																		'".cleanvars($_POST['weekno'])."'			,
																		'".cleanvars($_POST['detail'])."'			, 
																		'".cleanvars($_POST['id_curs'])."'			, 
																		'".cleanvars($rowsstd['emply_id'])."'		, 
																		'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
																		'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
																		NOW() 
													 			 )"
							);
//--------------------------------------
		if($sqllmslesson) { 
			$lessonid = $dblms->lastestid();
		
$topicprograms = '';
if(!empty(sizeof($_POST['idprg']))) {
//--------------------------------------
	for($ichk=0; $ichk<count($_POST['idprg']); $ichk++){
//--------------------------------------
	$arr 		= $_POST['idprg'][$ichk];
	$splitted 	= explode(",",trim($arr));  

	$idprg 		= $splitted[0];
	$semester 	= $splitted[1];
	$timing 	= $splitted[2];
	$section 	= $splitted[3];
//--------------------------------------

	$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_LESSONSPROGRAM." (
																		id_setup				, 
																		id_prg					, 
																		semester				,
																		section					,
																		timing							
																   )
	   														VALUES (
																		'".cleanvars($lessonid)."'	,
																		'".cleanvars($idprg)."'		,
																		'".cleanvars($semester)."'	, 
																		'".cleanvars($section)."'	, 
																		'".cleanvars($timing)."'		 
																		
													 			 )"
							);
		$topicprograms 	.= '"id_prg:"'.'=>'.'"'.($idprg).'",'."\n";
		$topicprograms 	.= '"semester:"'.'=>'.'"'.($semester).'",'."\n";
		$topicprograms 	.= '"section:"'.'=>'.'"'.($section).'",'."\n";
		$topicprograms 	.= '"timing:"'.'=>'.'"'.($timing).'"'."\n";
	}
//--------------------------------------
	}
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$lessonid.'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status'].'",'."\n";
			$requestedvars .= '"Weekno:"'.'=>'.'"'.$_POST['weekno'].'",'."\n";
			$requestedvars .= '"Details:"'.'=>'.'"'.$_POST['detail'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'",'."\n";
			$requestedvars .= '"programs:"'.'=>'.'array('."\n";
			$requestedvars .= $topicprograms."\n";
			$requestedvars .= ")\n";
//--------------------------------------
		$logremarks = 'Add Weekly Lesson Plan #: '.$lessonid.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGSTEACHER." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															details										,
															sess_id						,
															device_details				,
															id_campus				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'			,
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
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=Lessonplan", true, 301);
		exit();	
	}
}
//--------------------------------------
}

//--------------------------------------
if(isset($_POST['import_lessonplan'])) { 
//------------------------------------------------
$checkbox = $_POST['lessonarchive'];
for($i=0;$i<count($_POST['lessonarchive']);$i++) {
$del_id = $checkbox[$i];

	$sqllmschecker  = $dblms->querylms("SELECT *  
										FROM ".COURSES_LESSONS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND id = '".cleanvars($del_id)."' LIMIT 1");
if(mysqli_num_rows($sqllmschecker)>0) { 
	$valuearachive = mysqli_fetch_array($sqllmschecker);
	$sqllmslesson = $dblms->querylms("INSERT INTO ".COURSES_LESSONS." (
																		status								, 
																		weekno								, 
																		detail								,
																		id_curs								,
																		id_teacher							,
																		academic_session					,
																		id_campus							,
																		id_added							, 
																		date_added 
																   )
	   														VALUES (
																		'".cleanvars($valuearachive['status'])."'	,
																		'".cleanvars($valuearachive['weekno'])."'	,
																		'".cleanvars($valuearachive['detail'])."'	, 
																		'".cleanvars($_GET['id'])."'				, 
																		'".cleanvars($rowsstd['emply_id'])."'		, 
																		'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
																		'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
																		NOW() 
													 			 )"
							);
//--------------------------------------
		if($sqllmslesson) { 
		$lessonid = $dblms->lastestid();
//--------------------------------------
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$lessonid.'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$valuearachive['status'].'",'."\n";
			$requestedvars .= '"Weekno:"'.'=>'.'"'.$valuearachive['weekno'].'",'."\n";
			$requestedvars .= '"Details:"'.'=>'.'"'.$valuearachive['detail'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'"';
			
		$logremarks = 'Add Weekly Lesson Plan #: '.$lessonid.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGSTEACHER." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															details										,
															sess_id						,
															device_details				,
															id_campus				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		,
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
			

	}
}
}
	$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record has been successfully Import.</div>';
	header("Location:courses.php?id=".$_GET['id']."&view=Lessonplan", true, 301);
	exit();	
//--------------------------------------
}


//--------------------------------------
if(isset($_POST['changes_lesson'])) { 
//------------------------------------------------
$sqllmslesson  = $dblms->querylms("UPDATE ".COURSES_LESSONS." SET 
															status			= '".cleanvars($_POST['status_edit'])."'
														  , weekno			= '".cleanvars($_POST['weekno_edit'])."'
														  , id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
														  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														  , date_modify		= NOW()
													  WHERE id				= '".cleanvars($_POST['lessonid_edit'])."'");
//--------------------------------------
		if($sqllmslesson) {
//--------------------------------------
			
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$_POST['lessonid_edit'].'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status_edit'].'",'."\n";
			$requestedvars .= '"Weekno:"'.'=>'.'"'.$_POST['weekno_edit'].'",'."\n";
			$requestedvars .= '"Details:"'.'=>'.'"",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'"';
			
		$logremarks = 'Update Weekly Lesson Plan #:'.$_POST['lessonid_edit'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGSTEACHER." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															details										,
															sess_id						,
															device_details				,
															id_campus				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		,
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
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=Lessonplan", true, 301);
		exit();	
		}
//--------------------------------------
	}
//--------------------------------------
if(isset($_POST['changes_detaillesson'])) { 
//------------------------------------------------
$sqllmslesson  = $dblms->querylms("UPDATE ".COURSES_LESSONS." SET 
															status			= '".cleanvars($_POST['status'])."'
														  , detail			= '".cleanvars($_POST['detail'])."' 
														  , id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
														  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														  , date_modify		= NOW()
													  WHERE id				= '".cleanvars($_POST['editid'])."'");
//--------------------------------------
		if($sqllmslesson) {
			
		$topicprograms = '';
if(!empty(sizeof($_POST['idprg']))) {
	$sqllmsdelte  = $dblms->querylms("DELETE FROM ".COURSES_LESSONSPROGRAM." WHERE id_setup = '".cleanvars($_POST['editid'])."'");

//--------------------------------------
	for($ichk=0; $ichk<count($_POST['idprg']); $ichk++){
//--------------------------------------
	$arr 		= $_POST['idprg'][$ichk];
	$splitted 	= explode(",",trim($arr));  

	$idprg 		= $splitted[0];
	$semester 	= $splitted[1];
	$timing 	= $splitted[2];
	$section 	= $splitted[3];
//--------------------------------------
	$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_LESSONSPROGRAM." (
																		id_setup				, 
																		id_prg					, 
																		semester				,
																		section					,
																		timing							
																   )
	   														VALUES (
																		'".cleanvars($_POST['editid'])."'	,
																		'".cleanvars($idprg)."'				,
																		'".cleanvars($semester)."'			, 
																		'".cleanvars($section)."'			, 
																		'".cleanvars($timing)."'		 
																		
													 			 )"
							);
		$topicprograms 	.= '"id_prg:"'.'=>'.'"'.($idprg).'",'."\n";
		$topicprograms 	.= '"semester:"'.'=>'.'"'.($semester).'",'."\n";
		$topicprograms 	.= '"section:"'.'=>'.'"'.($section).'",'."\n";
		$topicprograms 	.= '"timing:"'.'=>'.'"'.($timing).'"'."\n";
	}
//--------------------------------------
	}

//--------------------------------------
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$_POST['editid'].'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status'].'",'."\n";
			$requestedvars .= '"Weekno:"'.'=>'.'"'.$_POST['weekno'].'",'."\n";
			$requestedvars .= '"Details:"'.'=>'.'"'.$_POST['detail'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'",'."\n";
			$requestedvars .= '"programs:"'.'=>'.'array('."\n";
			$requestedvars .= $topicprograms."\n";
			$requestedvars .= ")\n";
			
		$logremarks = 'Update Weekly Lesson Plan #:'.$_POST['lessonid'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGSTEACHER." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															details										,
															sess_id						,
															device_details				,
															id_campus				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		,
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
//--------------------------------------
			
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=Lessonplan", true, 301);
		exit();	
		}
//--------------------------------------
	}