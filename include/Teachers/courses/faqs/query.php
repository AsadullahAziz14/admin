<?php 

//--------------------------------------
if(isset($_POST['submit_faqs'])) { 
	$sqllmscheck  = $dblms->querylms("SELECT id  
										FROM ".COURSES_FAQS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND question = '".cleanvars($_POST['question'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' LIMIT 1");
if(mysqli_num_rows($sqllmscheck)>0) { 
	$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Notice: </span>Record already exists.</div>';
	header("Location:courses.php?id=".$_GET['id']."&view=FAQs", true, 301);
	exit();
} else { 
//------------------------------------------------
	$sqllms  = $dblms->querylms("INSERT INTO ".COURSES_FAQS." (
																status								, 
																question							, 
																answer								,
																id_curs								,
																id_teacher							,
																academic_session					,
																id_campus							,
																id_added							, 
																date_added 
															   )
	   													VALUES (
																'".cleanvars($_POST['status'])."'			,
																'".cleanvars($_POST['question'])."'			,
																'".cleanvars($_POST['answer'])."'			, 
																'".cleanvars($_POST['id_curs'])."'			, 
																'".cleanvars($rowsstd['emply_id'])."'		, 
																'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
																'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
																'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
																NOW() 
													 		 )"
							);
//--------------------------------------
		if($sqllms) { 
			$idfaq = $dblms->lastestid();
			$topicprograms = '';
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
	$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_FAQSPROGRAM." (
																		id_setup				, 
																		id_prg					, 
																		semester				,
																		section					,
																		timing							
																   )
	   														VALUES (
																		'".cleanvars($idfaq)."'		,
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
//--------------------------------------
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$idfaq.'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status'].'",'."\n";
			$requestedvars .= '"Question:"'.'=>'.'"'.$_POST['question'].'",'."\n";
			$requestedvars .= '"Answer:"'.'=>'.'"'.$_POST['answer'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'",'."\n";
			$requestedvars .= '"programs:"'.'=>'.'array('."\n";
			$requestedvars .= $topicprograms."\n";
			$requestedvars .= ")\n";
//--------------------------------------
		$logremarks = 'Add FAQs #: '.$idfaq.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGSTEACHER." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															details										,
															sess_id										,
															device_details								,
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

//--------------------------------------

//--------------------------------------	
	$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
	header("Location:courses.php?id=".$_GET['id']."&view=FAQs", true, 301);
	exit();
}
}
//--------------------------------------
}

//--------------------------------------
if(isset($_POST['changes_detailfaqs'])) { 
//------------------------------------------------
$sqllmsfaqs  = $dblms->querylms("UPDATE ".COURSES_FAQS." SET  status	= '".cleanvars($_POST['status'])."'
														, question		= '".cleanvars($_POST['question'])."' 
														, answer		= '".cleanvars($_POST['answer'])."' 
														, id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
														, id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														, date_modify	= NOW()
													WHERE id			= '".cleanvars($_POST['editid'])."'");
//--------------------------------------
		if($sqllmsfaqs) {
		$topicprograms = "";
//--------------------------------------
if(!empty(sizeof($_POST['idprg']))) {
//--------------------------------------
$sqllmsdelte  = $dblms->querylms("DELETE FROM ".COURSES_FAQSPROGRAM." WHERE id_setup = '".cleanvars($_POST['editid'])."'");
	for($ichk=0; $ichk<count($_POST['idprg']); $ichk++){
//--------------------------------------
	$arr 		= $_POST['idprg'][$ichk];
	$splitted 	= explode(",",trim($arr));  

	$idprg 		= $splitted[0];
	$semester 	= $splitted[1];
	$timing 	= $splitted[2];
	$section 	= $splitted[3];
//--------------------------------------
	$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_FAQSPROGRAM." (
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
			$requestedvars .= '"Question:"'.'=>'.'"'.$_POST['question'].'",'."\n";
			$requestedvars .= '"Answer:"'.'=>'.'"'.$_POST['answer'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'",'."\n";
			$requestedvars .= '"programs:"'.'=>'.'array('."\n";
			$requestedvars .= $topicprograms."\n";
			$requestedvars .= ")\n";
//--------------------------------------
			
	$logremarks = 'Update FAQs #:'.$_POST['editid'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGSTEACHER." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															details										,
															sess_id										,
															device_details								,
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
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=FAQs", true, 301);
		exit();
		}
//--------------------------------------
	}
//--------------------------------------
if(isset($_POST['changes_faqs'])) { 
//------------------------------------------------
$sqllmsfaqs  = $dblms->querylms("UPDATE ".COURSES_FAQS." SET  status	= '".cleanvars($_POST['status_edit'])."'
														, question		= '".cleanvars($_POST['question_edit'])."' 
														, answer		= '".cleanvars($_POST['answer_edit'])."' 
														, id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
														, id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														, date_modify	= NOW()
													WHERE id			= '".cleanvars($_POST['faqsid_edit'])."'");
//--------------------------------------
		if($sqllmsfaqs) {
//--------------------------------------
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$_POST['faqsid_edit'].'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status_edit'].'",'."\n";
			$requestedvars .= '"Question:"'.'=>'.'"'.$_POST['question_edit'].'",'."\n";
			$requestedvars .= '"Answer:"'.'=>'.'"'.$_POST['answer_edit'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'"';
//--------------------------------------
		$logremarks = 'Update FAQs #:'.$_POST['faqsid_edit'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGSTEACHER." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															details										,
															sess_id										,
															device_details								,
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
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=FAQs", true, 301);
		exit();
		}
//--------------------------------------
	}

//--------------------------------------
if(isset($_POST['import_faqs'])) { 
//------------------------------------------------
$checkbox = $_POST['faqsarchive'];
for($i=0;$i<count($_POST['faqsarchive']);$i++) {
	$del_id = $checkbox[$i];
	$sqllmschecker  = $dblms->querylms("SELECT *  
										FROM ".COURSES_FAQS." 
										WHERE id = '".cleanvars($del_id)."' LIMIT 1");
if(mysqli_num_rows($sqllmschecker)>0) { 
	$valuearachive = mysqli_fetch_array($sqllmschecker);
	$sqllmsfaqs  = $dblms->querylms("INSERT INTO ".COURSES_FAQS." (
																status								, 
																question							, 
																answer								,
																id_curs								,
																id_teacher							,
																academic_session					,
																id_campus							,
																id_added							, 
																date_added 
															   )
	   													VALUES (
																'".cleanvars($valuearachive['status'])."'		,
																'".cleanvars($valuearachive['question'])."'		,
																'".cleanvars($valuearachive['answer'])."'		, 
																'".cleanvars($_GET['id'])."'					, 
																'".cleanvars($rowsstd['emply_id'])."'			, 
																'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
																'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
																'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
																NOW() 
													 		 )"
							);
//--------------------------------------
		if($sqllmsfaqs) { 
		$lessonid = $dblms->lastestid();
//--------------------------------------
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$lessonid.'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$valuearachive['status'].'",'."\n";
			$requestedvars .= '"Question:"'.'=>'.'"'.$valuearachive['question'].'",'."\n";
			$requestedvars .= '"Answer:"'.'=>'.'"'.$valuearachive['answer'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'"';
//--------------------------------------
		$logremarks = 'Add FAQs #:: '.$lessonid.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGSTEACHER." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															details										,
															sess_id										,
															device_details								,
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
	if($sqllmsfaqs) { 
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record has been successfully Import.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=FAQs", true, 301);
		exit();	
	}
//--------------------------------------
}

