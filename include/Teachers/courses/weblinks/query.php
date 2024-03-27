<?php 
//--------------------------------------
if(isset($_POST['submit_weblink'])) { 
//--------------------------------------
	$sqllmscheckrel  = $dblms->querylms("SELECT id  
										FROM ".COURSES_LINKS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND url = '".cleanvars($_POST['url'])."' LIMIT 1");
if(mysqli_num_rows($sqllmschecker)>0) { 
	$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>record already exists.</div>';
	header("Location:courses.php?id=".$_GET['id']."&view=Weblinks", true, 301);
	exit();
} else { 

	$sqllmswebrel  = $dblms->querylms("INSERT INTO ".COURSES_LINKS." (
																		status								, 
																		url									, 
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
																		'".cleanvars($_POST['url'])."'				,
																		'".cleanvars($_POST['detail'])."'			, 
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
	$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_LINKSPROGRAM." (
																		id_setup				, 
																		id_prg					, 
																		semester				,
																		section					,
																		timing							
																   )
	   														VALUES (
																		'".cleanvars($idlink)."'	,
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
	$logremarks = 'Add Web Link #: '.$idlink.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			header("Location:courses.php?id=".$_GET['id']."&view=Weblinks", true, 301);
			exit();
		} 
//--------------------------------------
	}
}
//--------------------------------------
if(isset($_POST['changes_detailweblink'])) { 
//------------------------------------------------
$sqllmsweblink  = $dblms->querylms("UPDATE ".COURSES_LINKS." SET  status	= '".cleanvars($_POST['status'])."'
														, url				= '".cleanvars($_POST['url'])."'
														, detail			= '".cleanvars($_POST['detail'])."'
														, id_campus			= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
														, id_modify			= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														, date_modify		= NOW()
													WHERE id				= '".cleanvars($_POST['editid'])."'");
//--------------------------------------
		if($sqllmsweblink) {
//--------------------------------------
if(!empty(sizeof($_POST['idprg']))) {
$sqllmsdelte  = $dblms->querylms("DELETE FROM ".COURSES_LINKSPROGRAM." WHERE id_setup = '".cleanvars($_POST['editid'])."'");
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
	$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_LINKSPROGRAM." (
																		id_setup				, 
																		id_prg					, 
																		semester				,
																		section					,
																		timing							
																   )
	   														VALUES (
																		'".cleanvars($_POST['editid'])."'	,
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
	$logremarks = 'Update Web Link #:'.$_POST['editid'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			header("Location:courses.php?id=".$_GET['id']."&view=Weblinks", true, 301);
			exit();
		}
//--------------------------------------
	}
//--------------------------------------
if(isset($_POST['changes_weblink'])) { 
//------------------------------------------------
$sqllmsweblink  = $dblms->querylms("UPDATE ".COURSES_LINKS." SET  status	= '".cleanvars($_POST['status_edit'])."'
														, url				= '".cleanvars($_POST['url_edit'])."'
														, detail			= '".cleanvars($_POST['detail_edit'])."'
														, id_campus			= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
														, id_modify			= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														, date_modify		= NOW()
													WHERE id				= '".cleanvars($_POST['weblid_edit'])."'");
//--------------------------------------
		if($sqllmsweblink) {
//--------------------------------------
	$logremarks = 'Update Web Link #:'.$_POST['weblid_edit'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			header("Location:courses.php?id=".$_GET['id']."&view=Weblinks", true, 301);
			exit();
		}
//--------------------------------------
	}


//--------------------------------------
if(isset($_POST['import_weblink'])) { 
//------------------------------------------------
$checkbox = $_POST['weblinkarchive'];
for($i=0;$i<count($_POST['weblinkarchive']);$i++) {
$del_id = $checkbox[$i];
		$sqllmscheckrel  = $dblms->querylms("SELECT *   
										FROM ".COURSES_LINKS." 
										WHERE  id = '".cleanvars($del_id )."' LIMIT 1");
if(mysqli_num_rows($sqllmscheckrel)>0) { 
	$valuearachive = mysqli_fetch_array($sqllmscheckrel);
	$sqllmswebrel  = $dblms->querylms("INSERT INTO ".COURSES_LINKS." (
																		status								, 
																		url									, 
																		detail								,
																		id_curs								,
																		id_teacher							,
																		academic_session					,
																		id_campus							,
																		id_added							, 
																		date_added 
																   )
	   														VALUES (
																		'".cleanvars($valuearachive['status'])."'			,
																		'".cleanvars($valuearachive['url'])."'				,
																		'".cleanvars($valuearachive['detail'])."'			, 
																		'".cleanvars($_GET['id'])."'						, 
																		'".cleanvars($rowsstd['emply_id'])."'				, 
																		'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
																		'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
																		NOW() 
													 			 )"
							);
//--------------------------------------
		if($sqllmswebrel) { 
		$lessonid = $dblms->lastestid();
//--------------------------------------
	$logremarks = 'Add Download #: '.$lessonid.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
	if($sqllmswebrel) { 
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record has been successfully Import.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=Weblinks", true, 301);
		exit();	
	}
//--------------------------------------
}
