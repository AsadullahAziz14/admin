<?php 
//--------------------------------------
if(isset($_POST['submit_dwnlad'])) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT id  
										FROM ".COURSES_DOWNLOADS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND file_name = '".cleanvars($_POST['file_name'])."'  LIMIT 1");
if(mysqli_num_rows($sqllmscheck)>0) { 
	$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Notice: </span>Record already exists.</div>';
	header("Location:courses.php?id=".$_GET['id']."&view=Downloads", true, 301);
	exit();
} else { 
	$sqllmsbook  = $dblms->querylms("INSERT INTO ".COURSES_DOWNLOADS." (
																		status								, 
																		lecture_slides						, 
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
																		'".cleanvars($_POST['lecture_slides'])."'	,
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
	
	$_SESSION['msg']['status'] .= '<div role="alert" class="alert alert-danger fade in"> <strong>Error!</strong> Upload valiid images. Only pdf, xlsx, xls, doc, docx, ppt, pptx, png, jpg, jpeg, rar, zip are allowed. </div>';
}
// end file ext check 
//--------------------------------------
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
	$logremarks = 'Add Download File: '.$fileid.'-'.$_POST['file_name'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
//--------------------------------------
			$_SESSION['msg']['status'] .= '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."&view=Downloads", true, 301);
			exit();
		}
}
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['changes_detaildwnlad'])) { 
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
	
	$_SESSION['msg']['status'] .= '<div role="alert" class="alert alert-danger fade in"> <strong>Error!</strong> Upload valiid images. Only pdf, xlsx, xls, doc, docx, ppt, pptx, png, jpg, jpeg, rar, zip are allowed. </div>';
}
// end file ext check 
}
//--------------------------------------
	$logremarks = 'Update Download File:'.$_POST['editid'].'-'.$_POST['file_name'].'for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'					,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."'			, 
															'2'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($logremarks)."'				,
															'".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'			
														  )
									");
//--------------------------------------
			$_SESSION['msg']['status'] .= '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."&view=Downloads", true, 301);
			exit();
		}
//--------------------------------------
	}

//--------------------------------------
if(isset($_POST['changes_dwnlad'])) { 
//------------------------------------------------
$sqllmsdwnlad  = $dblms->querylms("UPDATE ".COURSES_DOWNLOADS." SET 
															status			= '".cleanvars($_POST['status_edit'])."'
														  , lecture_slides	= '".cleanvars($_POST['lecture_slides_edit'])."' 
														  , file_name		= '".cleanvars($_POST['file_name_edit'])."' 
														  , open_with		= '".cleanvars($_POST['open_with_edit'])."' 
														  , detail			= '".cleanvars($_POST['detail_edit'])."' 
														  , id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
														  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														  , date_modify		= NOW()
													  WHERE id				= '".cleanvars($_POST['dwnldid_edit'])."'");
//--------------------------------------
		if($sqllmsdwnlad) {
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
// if file size less than or equal to 5MB
} else {
	//$img 			= explode('.', $_FILES['dwnl_file']['name']);
	$originalImage	= $img_dir.to_seo_url($rowsurs['curs_code']).'-'.to_seo_url(cleanvars($_POST['file_name_edit'])).'_'.$_POST['dwnldid_edit'].".".strtolower($extension);
	$img_fileName	= to_seo_url($rowsurs['curs_code']).'-'.to_seo_url(cleanvars($_POST['file_name_edit'])).'_'.$_POST['dwnldid_edit'].".".strtolower($extension);
	//$extension 		= strtolower($img[1]);
//--------------------------------------
		$sqllmsupload  = $dblms->querylms("UPDATE ".COURSES_DOWNLOADS."
														SET file_size = '".formatSizeUnits($filesize)."'
														, file  = '".$img_fileName."'
												 WHERE  id		= '".cleanvars($_POST['dwnldid_edit'])."'");
		unset($sqllmsupload);
		$mode = '0644'; 
//--------------------------------------	
		move_uploaded_file($_FILES['dwnl_file']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
//--------------------------------------
}
// end file sise check 
} else {
	
	$_SESSION['msg']['status'] .= '<div role="alert" class="alert alert-danger fade in"> <strong>Error!</strong> Upload valiid images. Only pdf, xlsx, xls, doc, docx, ppt, pptx, png, jpg, jpeg, rar, zip are allowed. </div>';
}
// end file ext check 
}
//--------------------------------------
	$logremarks = 'Update Download File:'.$_POST['dwnldid_edit'].'-'.$_POST['file_name_edit'].'for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'					,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."'			, 
															'2'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($logremarks)."'				,
															'".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'			
														  )
									");
//--------------------------------------
			$_SESSION['msg']['status'] .= '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."&view=Downloads", true, 301);
			exit();
		}
//--------------------------------------
	}

//--------------------------------------
if(isset($_POST['import_downloads'])) { 
//------------------------------------------------
$checkbox = $_POST['downloadarchive'];
for($i=0;$i<count($_POST['downloadarchive']);$i++) {
$del_id = $checkbox[$i];
	$sqllmschecker  = $dblms->querylms("SELECT *  
										FROM ".COURSES_DOWNLOADS." 
										WHERE id = '".cleanvars($del_id)."' LIMIT 1");
if(mysqli_num_rows($sqllmschecker)>0) { 
	$valuearachive = mysqli_fetch_array($sqllmschecker);
	$sqllmsbook  = $dblms->querylms("INSERT INTO ".COURSES_DOWNLOADS." (
																		status								, 
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
	if($sqllmsbook) { 
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record has been successfully Import.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=Downloads", true, 301);
		exit();	
	}
//--------------------------------------
}
