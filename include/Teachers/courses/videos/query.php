<?php 
//--------------------------------------
if(isset($_POST['submit_video'])) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT id  
										FROM ".COURSES_VIDEOLESSONS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND caption = '".cleanvars($_POST['caption'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' LIMIT 1");
if(mysqli_num_rows($sqllmscheck)>0) { 
	$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Notice: </span>Record already exists.</div>';
	header("Location:courses.php?id=".$_GET['id']."&view=Lessonvideo", true, 301);
	exit();
} else { 
	$sqllmsvideos  = $dblms->querylms("INSERT INTO ".COURSES_VIDEOLESSONS." (
																		status								, 
																		caption								, 
																		detail								,
																		embedcode							,
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
																		'".cleanvars($_POST['detail'])."'			, 
																		'".cleanvars($_POST['embedcode'])."'		, 
																		'".cleanvars($_POST['id_curs'])."'			, 
																		'".cleanvars($rowsstd['emply_id'])."'		, 
																		'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
																		'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
																		NOW() 
													 			 )"
							);
//--------------------------------------
		if($sqllmsvideos) {
		$idvideo = $dblms->lastestid();
//--------------------------------------
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
	$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_VIDEOLESSONSPROGRAM." (
																		id_setup				, 
																		id_prg					, 
																		semester				,
																		section					,
																		timing							
																   )
	   														VALUES (
																		'".cleanvars($idvideo)."'	,
																		'".cleanvars($idprg)."'		,
																		'".cleanvars($semester)."'	, 
																		'".cleanvars($section)."'	, 
																		'".cleanvars($timing)."'		 
																		
													 			 )"
							);
	}
//--------------------------------------
	}
//--------------------------------------
	$logremarks = 'Add Lesson Video #: '.$idvideo.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
		header("Location:courses.php?id=".$_GET['id']."&view=Lessonvideo", true, 301);
		exit();
//--------------------------------------

		} 
}
//--------------------------------------
}

//--------------------------------------
if(isset($_POST['changes_detailvideo'])) { 
//------------------------------------------------
$sqllmsvideo  = $dblms->querylms("UPDATE ".COURSES_VIDEOLESSONS." SET  status	= '".cleanvars($_POST['status'])."' 
														, caption			= '".cleanvars($_POST['caption'])."' 
														, detail			= '".cleanvars($_POST['detail'])."' 
														, embedcode			= '".cleanvars($_POST['embedcode'])."' 
														, id_campus			= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
														, id_modify			= '".$_SESSION['userlogininfo']['LOGINIDA']."' 
														, date_modify		= NOW()
													WHERE id				= '".cleanvars($_POST['editid'])."'");
//--------------------------------------
		if($sqllmsvideo) {
//--------------------------------------
if(!empty(sizeof($_POST['idprg']))) {
$sqllmsdelte  = $dblms->querylms("DELETE FROM ".COURSES_VIDEOLESSONSPROGRAM." WHERE id_setup = '".cleanvars($_POST['editid'])."'");
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
	$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_VIDEOLESSONSPROGRAM." (
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
	}
//--------------------------------------
	}
//--------------------------------------
	$logremarks = 'Update Lesson Video #:'.$_POST['editid'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			header("Location:courses.php?id=".$_GET['id']."&view=Lessonvideo", true, 301);
			exit();
		}
//--------------------------------------
	}
//--------------------------------------
if(isset($_POST['changes_video'])) { 
//------------------------------------------------
$sqllmsvideo  = $dblms->querylms("UPDATE ".COURSES_VIDEOLESSONS." SET  status	= '".cleanvars($_POST['status_edit'])."' 
														, caption			= '".cleanvars($_POST['caption_edit'])."' 
														, detail			= '".cleanvars($_POST['detail_edit'])."' 
														, embedcode			= '".cleanvars($_POST['embedcode_edit'])."' 
														, id_campus			= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
														, id_modify			= '".$_SESSION['userlogininfo']['LOGINIDA']."' 
														, date_modify		= NOW()
													WHERE id				= '".cleanvars($_POST['videoid_edit'])."'");
//--------------------------------------
		if($sqllmsvideo) {
//--------------------------------------
	$logremarks = 'Update Lesson Video #:'.$_POST['videoid_edit'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			header("Location:courses.php?id=".$_GET['id']."&view=Lessonvideo", true, 301);
			exit();
		}
//--------------------------------------
	}


//--------------------------------------
if(isset($_POST['import_videos'])) { 
//------------------------------------------------
$checkbox = $_POST['videoarchive'];
for($i=0;$i<count($_POST['videoarchive']);$i++) {
	$del_id = $checkbox[$i];
	$sqllmschecker  = $dblms->querylms("SELECT *  
										FROM ".COURSES_VIDEOLESSONS." 
										WHERE id = '".cleanvars($del_id)."' LIMIT 1");
if(mysqli_num_rows($sqllmschecker)>0) { 
	$valuearachive = mysqli_fetch_array($sqllmschecker);
	$sqllmsvideos  = $dblms->querylms("INSERT INTO ".COURSES_VIDEOLESSONS." (
																		status								, 
																		caption								, 
																		detail								,
																		embedcode							,
																		id_curs								,
																		id_teacher							,
																		academic_session					,
																		id_campus							,
																		id_added							, 
																		date_added 
																   )
	   														VALUES (
																		'".cleanvars($valuearachive['status'])."'			,
																		'".cleanvars($valuearachive['caption'])."'			,
																		'".cleanvars($valuearachive['detail'])."'			, 
																		'".cleanvars($valuearachive['embedcode'])."'		, 
																		'".cleanvars($_GET['id'])."'			, 
																		'".cleanvars($rowsstd['emply_id'])."'		, 
																		'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
																		'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
																		NOW() 
													 			 )"
							);
//--------------------------------------
		if($sqllmsvideos) { 
		$lessonid = $dblms->lastestid();
//--------------------------------------
	$logremarks = 'Add Video Lesson #: '.$lessonid.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			

	}
}
}
	if($sqllmsvideos) { 
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record has been successfully Import.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=Lessonvideo", true, 301);
		exit();	
	}
//--------------------------------------
}

