<?php 
//--------------------------------------
if(isset($_POST['submit_resources'])) { 
// Lecture Slider or General Downloads
if($_POST['id_type'] == 1 || $_POST['id_type'] == 5) {
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT id  
										FROM ".COURSES_DOWNLOADS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND file_name = '".cleanvars($_POST['file_name'])."' 
										AND id_type = '".cleanvars($_POST['id_type'])."' LIMIT 1");
if(mysqli_num_rows($sqllmscheck)>0) { 
	$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Notice: </span>Record already exists.</div>';
	header("Location:courses.php?id=".$_GET['id']."&view=Resources", true, 301);
	exit();
} else { 
	$sqllmsbook  = $dblms->querylms("INSERT INTO ".COURSES_DOWNLOADS." (
														status								, 
														id_type								, 
														file_name							, 
														open_with							,
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
														'".cleanvars($_POST['id_type'])."'			,
														'".cleanvars($_POST['file_name'])."'		,
														'".cleanvars($_POST['open_with'])."'		, 
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
		if($sqllmsbook) {
	$fileid  = $dblms->lastestid();
		

//---------if file are attached-----------------------------
if(!empty($_FILES['dwnl_file']['name'])) { 
//--------------------------------------
	$img_dir		= "downloads/courses/";
	$filesize		= $_FILES['dwnl_file']['size'];
	$path_parts 	= pathinfo($_FILES["dwnl_file"]["name"]);
	$extension 		= strtolower($path_parts['extension']);
	
// check if ext
if(in_array($extension , array('pdf','xlsx', 'xls', 'doc', 'docx', 'ppt', 'pptx', 'png', 'jpg', 'jpeg', 'rar', 'zip'))) { 
//	$img 			= explode('.', $_FILES['dwnl_file']['name']);

// chcek file size  more the 5MB
if (($_FILES["dwnl_file"]["size"] > 5500000)) {
	$_SESSION['msg']['status'] .= '<div role="alert" class="alert alert-danger fade in"> <strong>Error!</strong> Only the file less than <b>"5 mb "</b> allowed to upload.</div>';
	$originalImage = '';
// if file size less than or equal to 5MB
} else {
	
	$originalImage	= $img_dir.to_seo_url($rowsurs['curs_code']).'-'.to_seo_url(cleanvars($_POST['file_name'])).'_'.$fileid.".".strtolower($extension);
	$img_fileName	= to_seo_url($rowsurs['curs_code']).'-'.to_seo_url(cleanvars($_POST['file_name'])).'_'.$fileid.".".strtolower($extension);

		$sqllmsupload  = $dblms->querylms("UPDATE ".COURSES_DOWNLOADS."
														SET file_size = '".formatSizeUnits($filesize)."'
														, file  = '".$img_fileName."'
												 WHERE  id		= '".cleanvars($fileid)."'");
		unset($sqllmsupload);
		$mode = '0644'; 
//--------------------------------------	
		move_uploaded_file($_FILES['dwnl_file']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
}
// end file sise check 
} else {
	$originalImage = '';
	$_SESSION['msg']['status'] .= '<div role="alert" class="alert alert-danger fade in"> <strong>Error!</strong> Upload valiid images. Only pdf, xlsx, xls, doc, docx, ppt, pptx, png, jpg, jpeg, rar, zip are allowed. </div>';
}
// end file ext check 
//--------------------------------------
} else {
	$originalImage = '';
}
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
	$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_DOWNLOADSPROGRAM." (
																		id_setup				, 
																		id_prg					, 
																		semester				,
																		section					,
																		timing							
																   )
	   														VALUES (
																		'".cleanvars($fileid)."'	,
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
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$fileid.'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status'].'",'."\n";
			$requestedvars .= '"Resource Type:"'.'=>'.'"'.get_CourseResources($_POST['id_type']).'",'."\n";
			$requestedvars .= '"Open With:"'.'=>'.'"'.$_POST['open_with'].'",'."\n";
			$requestedvars .= '"Detail:"'.'=>'.'"'.$_POST['detail'].'",'."\n";
			$requestedvars .= '"File Name:"'.'=>'.'"'.$_POST['file_name'].'",'."\n";
			$requestedvars .= '"File:"'.'=>'.'"'.$originalImage.'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'"';
//--------------------------------------	
	$logremarks = 'Add Download File: '.$fileid.'-'.$_POST['file_name'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGSTEACHER." (
													id_user							, 
													filename						, 
													action							,
													dated							,
													ip								,
													remarks							,
													details							,
													sess_id							,
													device_details					,
													id_campus				
												)
		
										VALUES (
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
//--------------------------------------
			$_SESSION['msg']['status'] .= '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."&view=Resources", true, 301);
			exit();
		}
}
//--------------------------------------
}
// end Lecture Slide and General Downloads
// video Lesson
	
if($_POST['id_type'] == 2) {
	
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT id  
										FROM ".COURSES_DOWNLOADS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' 
										AND file_name = '".cleanvars($_POST['caption'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."'  
										AND id_type = '".cleanvars($_POST['id_type'])."'  LIMIT 1");
if(mysqli_num_rows($sqllmscheck)>0) { 
	$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Notice: </span>Record already exists.</div>';
	header("Location:courses.php?id=".$_GET['id']."&view=Resources", true, 301);
	exit();
} else { 
	$sqllmsvideos  = $dblms->querylms("INSERT INTO ".COURSES_DOWNLOADS." (
														status								, 
														id_type								, 
														file_name							, 
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
														'".cleanvars($_POST['id_type'])."'			,
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
	$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_DOWNLOADSPROGRAM." (
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
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$idvideo.'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status'].'",'."\n";
			$requestedvars .= '"Resource Type:"'.'=>'.'"'.get_CourseResources($_POST['id_type']).'",'."\n";
			$requestedvars .= '"Caption:"'.'=>'.'"'.$_POST['caption'].'",'."\n";
			$requestedvars .= '"Detail:"'.'=>'.'"'.$_POST['detail'].'",'."\n";
			$requestedvars .= '"Embedcode:"'.'=>'.'"'.$_POST['embedcode'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'"';	
//--------------------------------------
		$logremarks = 'Add Lesson Video #: '.$idvideo.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=Resources", true, 301);
		exit();
//--------------------------------------

		} 
}
	

}
// end lesson video
// Web Links
if($_POST['id_type'] == 4) {
	
//--------------------------------------
	$sqllmscheckrel  = $dblms->querylms("SELECT id  
										FROM ".COURSES_DOWNLOADS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND url = '".cleanvars($_POST['url'])."' 
										AND id_type = '".cleanvars($_POST['id_type'])."' LIMIT 1");
if(mysqli_num_rows($sqllmschecker)>0) { 
	$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>record already exists.</div>';
	header("Location:courses.php?id=".$_GET['id']."&view=Resources", true, 301);
	exit();
} else { 

	$sqllmswebrel  = $dblms->querylms("INSERT INTO ".COURSES_DOWNLOADS." (
													status								, 
													id_type								, 
													file_name							, 
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
													'".cleanvars($_POST['id_type'])."'			,
													'".cleanvars($_POST['file_name'])."'		,
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
	$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_DOWNLOADSPROGRAM." (
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
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$idlink.'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status'].'",'."\n";
			$requestedvars .= '"Resource Type:"'.'=>'.'"'.get_CourseResources($_POST['id_type']).'",'."\n";
			$requestedvars .= '"File Name:"'.'=>'.'"'.$_POST['file_name'].'",'."\n";
			$requestedvars .= '"Url:"'.'=>'.'"'.$_POST['url'].'",'."\n";
			$requestedvars .= '"Detail:"'.'=>'.'"'.$_POST['detail'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'"';	
//--------------------------------------
		$logremarks = 'Add Web Link #: '.$idlink.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."&view=Resources", true, 301);
			exit();
		} 
//--------------------------------------
	}
	

}
// end Web Links
	
// Google Drive Link
if($_POST['id_type'] == 3) {
	
//--------------------------------------
	$sqllmscheckrel  = $dblms->querylms("SELECT id  
										FROM ".COURSES_DOWNLOADS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND url = '".cleanvars($_POST['drive_link'])."' LIMIT 1");
if(mysqli_num_rows($sqllmschecker)>0) { 
	$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>record already exists.</div>';
	header("Location:courses.php?id=".$_GET['id']."&view=Resources", true, 301);
	exit();
} else { 

	$sqllmswebrel  = $dblms->querylms("INSERT INTO ".COURSES_DOWNLOADS." (
													status								, 
													id_type								, 
													file_name							, 
													detail								, 
													url									,
													id_curs								,
													id_teacher							,
													academic_session					,
													id_campus							,
													id_added							, 
													date_added 
												)
	   									VALUES (
													'".cleanvars($_POST['status'])."'			,
													'".cleanvars($_POST['id_type'])."'			,
													'".cleanvars($_POST['caption'])."'			,
													'".cleanvars($_POST['detail'])."'			,
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
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$idlink.'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status'].'",'."\n";
			$requestedvars .= '"Resource Type:"'.'=>'.'"'.get_CourseResources($_POST['id_type']).'",'."\n";
			$requestedvars .= '"Caption:"'.'=>'.'"'.$_POST['caption'].'",'."\n";
			$requestedvars .= '"Url:"'.'=>'.'"'.$_POST['url'].'",'."\n";
			$requestedvars .= '"Detail:"'.'=>'.'"'.$_POST['detail'].'",'."\n";
			$requestedvars .= '"Drive Link:"'.'=>'.'"'.$_POST['drive_link'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'"';	
//--------------------------------------
//--------------------------------------
		$logremarks = 'Add Drive Link #: '.$idlink.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."&view=Resources", true, 301);
			exit();
		} 
//--------------------------------------
	}
}
// end Google Drive Link
}

//---------------------update record-----------------
if(isset($_POST['changes_detaildwnlad'])) { 
	
// Lecture Slider or General Downloads
if($_POST['id_type'] == 1 || $_POST['id_type'] == 5) {
//------------------------------------------------
$sqllmsdwnlad  = $dblms->querylms("UPDATE ".COURSES_DOWNLOADS." SET 
															status			= '".cleanvars($_POST['status'])."'
														  , lecture_slides	= '".cleanvars($_POST['lecture_slides'])."' 
														  , file_name		= '".cleanvars($_POST['file_name'])."' 
														  , open_with		= '".cleanvars($_POST['open_with'])."' 
														  , detail			= '".cleanvars($_POST['detail'])."' 
														  , id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
														  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														  , date_modify		= NOW()
													  WHERE id				= '".cleanvars($_POST['editid'])."'");
//--------------------------------------
		if($sqllmsdwnlad) {

//--------------------------------------
if(!empty(sizeof($_POST['idprg']))) { 
$sqllmsdelte  = $dblms->querylms("DELETE FROM ".COURSES_DOWNLOADSPROGRAM." WHERE id_setup = '".cleanvars($_POST['editid'])."'");
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
	$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_DOWNLOADSPROGRAM." (
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
if(!empty($_FILES['dwnl_file']['name'])) { 
//--------------------------------------
	$img_dir		= "downloads/courses/";
	$filesize		= $_FILES['dwnl_file']['size'];
	$path_parts 	= pathinfo($_FILES["dwnl_file"]["name"]);
		
	$extension 		= strtolower($path_parts['extension']);
	
// check if ext
if(in_array($extension , array('pdf','xlsx', 'xls', 'doc', 'docx', 'ppt', 'pptx', 'png', 'jpg', 'jpeg', 'rar', 'zip'))) { 
//	$img 			= explode('.', $_FILES['dwnl_file']['name']);

// chcek file size  more the 5MB
if (($_FILES["dwnl_file"]["size"] > 5500000)) {
	$_SESSION['msg']['status'] .= '<div role="alert" class="alert alert-danger fade in"> <strong>Error!</strong> Only the file less than <b>"5 mb "</b> allowed to upload.</div>';
	$originalImage = '';
// if file size less than or equal to 5MB
} else {
	$originalImage	= $img_dir.to_seo_url($rowsurs['curs_code']).'-'.to_seo_url(cleanvars($_POST['file_name'])).'_'.$_POST['editid'].".".strtolower($extension);
	$img_fileName	= to_seo_url($rowsurs['curs_code']).'-'.to_seo_url(cleanvars($_POST['file_name'])).'_'.$_POST['editid'].".".strtolower($extension);
//--------------------------------------
		$sqllmsupload  = $dblms->querylms("UPDATE ".COURSES_DOWNLOADS."
														SET file_size = '".formatSizeUnits($filesize)."'
														, file  = '".$img_fileName."'
												 WHERE  id		= '".cleanvars($_POST['editid'])."'");
		unset($sqllmsupload);
		$mode = '0644'; 
//--------------------------------------	
		move_uploaded_file($_FILES['dwnl_file']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
//--------------------------------------
}
// end file sise check 
} else {
	$originalImage = '';
	$_SESSION['msg']['status'] .= '<div role="alert" class="alert alert-danger fade in"> <strong>Error!</strong> Upload valiid images. Only pdf, xlsx, xls, doc, docx, ppt, pptx, png, jpg, jpeg, rar, zip are allowed. </div>';
}
// end file ext check 
} else {
	$originalImage = '';
}
//--------------------------------------
//--------------------------------------
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$_POST['editid'].'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status'].'",'."\n";
			$requestedvars .= '"Resource Type:"'.'=>'.'"'.get_CourseResources($_POST['id_type']).'",'."\n";
			$requestedvars .= '"Lecture Slides:"'.'=>'.'"'.$_POST['lecture_slides'].'",'."\n";
			$requestedvars .= '"File Name:"'.'=>'.'"'.$_POST['file_name'].'",'."\n";
			$requestedvars .= '"File:"'.'=>'.'"'.$originalImage.'",'."\n";
			$requestedvars .= '"Open With:"'.'=>'.'"'.$_POST['open_with'].'",'."\n";
			$requestedvars .= '"Detail:"'.'=>'.'"'.$_POST['detail'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'"';	
//--------------------------------------
	$logremarks = 'Update Download File:'.$_POST['editid'].'-'.$_POST['file_name'].'for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
//--------------------------------------
			$_SESSION['msg']['status'] .= '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."&view=Resources", true, 301);
			exit();
		}
//--------------------------------------
	}
// end Lecture Slides and Genernal Downloads
	
// Lesson Video
if($_POST['id_type'] == 2) {
	
//------------------------------------------------
$sqllmsvideo  = $dblms->querylms("UPDATE ".COURSES_DOWNLOADS." SET  status	= '".cleanvars($_POST['status'])."' 
														, file_name			= '".cleanvars($_POST['caption'])."' 
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
$sqllmsdelte  = $dblms->querylms("DELETE FROM ".COURSES_DOWNLOADSPROGRAM." WHERE id_setup = '".cleanvars($_POST['editid'])."'");
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
	$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_DOWNLOADSPROGRAM." (
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
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$_POST['editid'].'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status'].'",'."\n";
			$requestedvars .= '"Resource Type:"'.'=>'.'"'.get_CourseResources($_POST['id_type']).'",'."\n";
			$requestedvars .= '"Caption:"'.'=>'.'"'.$_POST['caption'].'",'."\n";
			$requestedvars .= '"Embedcode:"'.'=>'.'"'.$_POST['embedcode'].'",'."\n";
			$requestedvars .= '"Detail:"'.'=>'.'"'.$_POST['detail'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'"';	
//--------------------------------------
	$logremarks = 'Update Lesson Video #:'.$_POST['editid'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			
			$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."&view=Resources", true, 301);
			exit();
		}
//--------------------------------------
}
// end Lesson Video 
// Weblinks
if($_POST['id_type'] == 4) {
//------------------------------------------------
$sqllmsweblink  = $dblms->querylms("UPDATE ".COURSES_DOWNLOADS." SET  status	= '".cleanvars($_POST['status'])."'
														, file_name			= '".cleanvars($_POST['file_name'])."'
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
$sqllmsdelte  = $dblms->querylms("DELETE FROM ".COURSES_DOWNLOADSPROGRAM." WHERE id_setup = '".cleanvars($_POST['editid'])."'");
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
	$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_DOWNLOADSPROGRAM." (
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
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$_POST['editid'].'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status'].'",'."\n";
			$requestedvars .= '"Resource Type:"'.'=>'.'"'.get_CourseResources($_POST['id_type']).'",'."\n";
			$requestedvars .= '"Caption:"'.'=>'.'"'.$_POST['file_name'].'",'."\n";
			$requestedvars .= '"Url:"'.'=>'.'"'.$_POST['url'].'",'."\n";
			$requestedvars .= '"Detail:"'.'=>'.'"'.$_POST['detail'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'"';	
//--------------------------------------
		$logremarks = 'Update Web Link #:'.$_POST['editid'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."&view=Resources", true, 301);
			exit();
		}
//--------------------------------------	

}
// end web links
// Google Drive Link
if($_POST['id_type'] == 3) {
	//------------------------------------------------
$sqllmsweblink  = $dblms->querylms("UPDATE ".COURSES_DOWNLOADS." SET  status	= '".cleanvars($_POST['status'])."'
														, file_name			= '".cleanvars($_POST['caption'])."'
														, detail			= '".cleanvars($_POST['detail'])."'
														, url				= '".cleanvars($_POST['drive_link'])."'
														, id_campus			= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
														, id_modify			= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														, date_modify		= NOW()
													WHERE id				= '".cleanvars($_POST['editid'])."'");
//--------------------------------------
		if($sqllmsweblink) {

			//--------------------------------------
			if(!empty(sizeof($_POST['idprg']))) {
				$sqllmsdelte  = $dblms->querylms("DELETE FROM ".COURSES_DOWNLOADSPROGRAM." WHERE id_setup = '".cleanvars($_POST['editid'])."'");
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
					$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_DOWNLOADSPROGRAM." (
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
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$_POST['editid'].'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status'].'",'."\n";
			$requestedvars .= '"Resource Type:"'.'=>'.'"'.get_CourseResources($_POST['id_type']).'",'."\n";
			$requestedvars .= '"Caption:"'.'=>'.'"'.$_POST['caption'].'",'."\n";
			$requestedvars .= '"Url:"'.'=>'.'"'.$_POST['drive_link'].'",'."\n";
			$requestedvars .= '"Detail:"'.'=>'.'"'.$_POST['detail'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'"';	
//--------------------------------------
		$logremarks = 'Update Drive Link #:'.$_POST['editid'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."&view=Resources", true, 301);
			exit();
		}
//--------------------------------------
}
// end Google Drive Link
	
}


//--------------------------------------
if(isset($_POST['import_downloads'])) { 
//------------------------------------------------
$checkbox = $_POST['downloadarchive'];
for($i=0;$i<count($_POST['downloadarchive']);$i++) {
$del_id = $checkbox[$i];
	$sqllmschecker  = $dblms->querylms("SELECT d.status, d.id_type, d.file_name, d.file_size, d.open_with, d.detail, d.file 
										FROM ".COURSES_DOWNLOADS." d
										WHERE d.id = '".cleanvars($del_id)."' LIMIT 1");
if(mysqli_num_rows($sqllmschecker)>0) { 
	$valuearachive = mysqli_fetch_array($sqllmschecker);
	$sqllmsbook  = $dblms->querylms("INSERT INTO ".COURSES_DOWNLOADS." (
																		status								, 
																		id_type 							, 
																		file_name							, 
																		file_size							,
																		open_with							,
																		detail								,
																		file								,
																		id_curs								,
																		id_teacher							,
																		academic_session					,
																		id_campus							,
																		id_added							, 
																		date_added 
																   )
	   														VALUES (
																		'".cleanvars($valuearachive['status'])."'			,
																		'".cleanvars($valuearachive['id_type'])."'			,
																		'".cleanvars($valuearachive['file_name'])."'		,
																		'".cleanvars($valuearachive['file_size'])."'		,
																		'".cleanvars($valuearachive['open_with'])."'		, 
																		'".cleanvars($valuearachive['detail'])."'			, 
																		'".cleanvars($valuearachive['file'])."'				, 
																		'".cleanvars($_GET['id'])."'						,
																		'".cleanvars($rowsstd['emply_id'])."'		, 
																		'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
																		'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
																		NOW() 
													 			 )"
							);
//--------------------------------------
		if($sqllmsbook) { 
		$lessonid = $dblms->lastestid();
//--------------------------------------
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$lessonid.'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status'].'",'."\n";
			$requestedvars .= '"Resource Type:"'.'=>'.'"'.get_CourseResources($_POST['id_type']).'",'."\n";
			$requestedvars .= '"Caption:"'.'=>'.'"'.$_POST['file_name'].'",'."\n";
			$requestedvars .= '"file_size:"'.'=>'.'"'.$_POST['file_size'].'",'."\n";
			$requestedvars .= '"open_with:"'.'=>'.'"'.$_POST['open_with'].'",'."\n";
			$requestedvars .= '"Detail:"'.'=>'.'"'.$_POST['detail'].'",'."\n";
			$requestedvars .= '"file:"'.'=>'.'"'.$_POST['file'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'"';	
//--------------------------------------
	$logremarks = 'Add Download #: '.$lessonid.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			

	}
}
}
	if($sqllmsbook) { 
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record has been successfully Import.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=Resources", true, 301);
		exit();	
	}
//--------------------------------------
}
