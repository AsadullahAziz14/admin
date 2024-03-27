<?php 
//--------------------------------------
if(isset($_POST['submit_question'])) { 
//------------------------------------------------
	$sqllmsselect  = $dblms->querylms("SELECT question_id   
											FROM ".QUIZ_QUESTION." 
											WHERE question_title = '".cleanvars($_POST['question_title'])."'
											AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'  
											AND id_curs = '".cleanvars($_GET['id'])."' LIMIT 1");
//------------------------------------------------
	if(mysqli_num_rows($sqllmsselect)>0) { 
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>Record already exists.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=QuizBank", true, 301);
		exit();
	} else { 
		
// check question 
		if(cleanvars(removeWhiteSpace($_POST['question_title'])) == '') {
			$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>Question field is required</div>';
			header("Location:".$_SERVER['HTTP_REFERER'], true, 301);
			exit();
			
		} else {
		
		$sqllmsquestion  = $dblms->querylms("INSERT INTO ".QUIZ_QUESTION." (
																question_status					, 
																question_title					,
																question_type					,
																question_term					,
																question_weekno					,
																question_marks					,
																question_level					,
																id_curs							,
																id_teacher						,
																academic_session				,
																id_campus						,
																id_added						, 
																date_added 
															)
													VALUES (
															'".cleanvars($_POST['question_status'])."'		,
															'".cleanvars(removeWhiteSpace($_POST['question_title']))."'	,
															'".cleanvars($_POST['question_type'])."'		,
															'".cleanvars($_POST['question_term'])."'		,
															'".cleanvars($_POST['question_weekno'])."'		,
															'".cleanvars($_POST['question_marks'])."'		, 
															'".cleanvars($_POST['question_level'])."'		, 
															'".cleanvars($_POST['id_curs'])."'				,
															'".cleanvars($rowsstd['emply_id'])."'			,
															'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."'		,
															'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 			,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	, 
															NOW() 
														)"
								);
		$id_question = $dblms->lastestid();
		
		$img_fileName = '';	
		$originalImage = '';	
	

			
//--------------------------------------
if(!empty($_FILES['ques_file']['name'])) { 
//--------------------------------------
	$img_dir		= "downloads/exams/questions/";
	$filesize		= $_FILES['ques_file']['size'];
	$path_parts 	= pathinfo($_FILES["ques_file"]["name"]);
	$extension 		= $path_parts['extension'];
	$originalImage	= $img_dir.time().'_'.$id_question.".".strtolower($extension);
	$img_fileName	= time().'_'.$id_question.".".strtolower($extension);
//	$extension 		= strtolower($img[1]);
	
	if(in_array($extension , array('jpg', 'jpeg', 'gif', 'png'))) { 
//--------------------------------------
			$sqllmsupload  = $dblms->querylms("UPDATE ".QUIZ_QUESTION."
															SET question_file = '".$img_fileName."'
													 WHERE  question_id	= '".cleanvars($id_question)."'");
			unset($sqllmsupload);
			$mode = '0644'; 
//--------------------------------------	
			move_uploaded_file($_FILES['ques_file']['tmp_name'],$originalImage);
			chmod ($originalImage, octdec($mode));
	}
//--------------------------------------
}
//------------------------------------------------
		$questionoptions = "\n";
		if(!empty($_POST['answer_option'])) { 
			
			
			$arraychecked = $_POST['answer_option'];
			
			//echo sizeof($arraychecked).'<br><br>';
			
			for($ijq=1; $ijq<=sizeof($arraychecked); $ijq++){  
				
				if($_POST['answer_correct'] == $ijq) {$status = '1';} else { $status = '0';}
				//echo $_POST['answer_option'][$ijq].' - '.$status.'<br>';
				
				$sqllmsoption  = $dblms->querylms("INSERT INTO ".QUIZ_QUESTION_OPTION."( 
																id_question									,
																answer_option								, 
																answer_correct									
														)
												VALUES (
															'".$id_question."'								, 
															'".(removeWhiteSpace($_POST['answer_option'][$ijq]))."'	, 
															'".cleanvars($status)."'	
														)
											");
				
				//unset($ansstatus);
			$questionoptions .= '"answer_option:"'.'=>'.'"'.(removeWhiteSpace($_POST['answer_option'][$ijq])).'",'."\n";
			$questionoptions .= '"answer_correct:"'.'=>'.'"'.cleanvars($status).'"'."\n";
				
			}
		}
//--------------------------------------
			
//--------------------------------------
if(!empty(sizeof($_POST['idrelcurs']))) {
	for($icrel=0; $icrel<count($_POST['idrelcurs']); $icrel++){ 
//--------------------------------------
	$sqllmsrels  = $dblms->querylms("INSERT INTO ".QUIZ_QUESTION." (
																question_status					, 
																question_title					,
																question_type					,
																question_term					,
																question_weekno					,
																question_marks					,
																question_level					,
																id_curs							,
																id_teacher						,
																academic_session				,
																id_campus						,
																id_added						, 
																date_added 
															)
													VALUES (
															'".cleanvars($_POST['question_status'])."'		,
															'".cleanvars(removeWhiteSpace($_POST['question_title']))."'	,
															'".cleanvars($_POST['question_type'])."'		,
															'".cleanvars($_POST['question_term'])."'		,
															'".cleanvars($_POST['question_weekno'])."'		,
															'".cleanvars($_POST['question_marks'])."'		, 
															'".cleanvars($_POST['question_level'])."'		, 
															'".cleanvars($_POST['idrelcurs'][$icrel])."'	,
															'".cleanvars($rowsstd['emply_id'])."'			,
															'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."'		,
															'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 			,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	, 
															NOW() 
														)"
								);
		
	//--------------------------------------
		$idrelque = $dblms->lastestid();

		$sqllmsupload2  = $dblms->querylms("UPDATE ".QUIZ_QUESTION."
														SET question_file = '".$img_fileName."'
													WHERE  question_id	= '".cleanvars($idrelque)."'");
		unset($sqllmsupload2);
		
//------------------------------------------------
		if(!empty($_POST['answer_option'])) { 
			
			$arraycheckedrel = $_POST['answer_option'];
			
			
			for($ijrel=1; $ijrel<=sizeof($arraycheckedrel); $ijrel++){  
				
				if($_POST['answer_correct'] == $ijrel) {$statusrel = '1';} else { $statusrel = '0';}
				//echo $_POST['answer_option'][$ijq].' - '.$status.'<br>';
				
				$sqllmsoption  = $dblms->querylms("INSERT INTO ".QUIZ_QUESTION_OPTION."( 
																id_question									,
																answer_option								, 
																answer_correct									
														)
												VALUES (
															'".$idrelque."'												, 
															'".(removeWhiteSpace($_POST['answer_option'][$ijrel]))."'	, 
															'".cleanvars($statusrel)."'	
														)
											");
				
				
			}
		}
//--------------------------------------
//--------------------------------------
	} // end for loop
	
	
	} // end check array	
			
			if($sqllmsquestion) {
				
//--------------------------------------
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$id_question.'",'."\n";
			$requestedvars .= '"question_status:"'.'=>'.'"'.$_POST['question_status'].'",'."\n";
			$requestedvars .= '"question_title:"'.'=>'.'"'.$_POST['question_title'].'",'."\n";
			$requestedvars .= '"question_type:"'.'=>'.'"'.get_questiontype($_POST['question_type']).'",'."\n";
			$requestedvars .= '"question_term:"'.'=>'.'"'.get_examterm($_POST['question_term']).'",'."\n";
			$requestedvars .= '"question_weekno:"'.'=>'.'"'.$_POST['question_weekno'].'",'."\n";
			$requestedvars .= '"question_marks:"'.'=>'.'"'.$_POST['question_marks'].'",'."\n";
			$requestedvars .= '"question_level:"'.'=>'.'"'.get_difficultylevel1($_POST['question_level']).'",'."\n";
			$requestedvars .= '"question_file:"'.'=>'.'"'.$originalImage.'",'."\n";
			$requestedvars .= '"id_teacher:"'.'=>'.'"'.$rowsstd['emply_id'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"question_options:"'.'=>'.'array('."\n";
			$requestedvars .= $questionoptions."\n";
			$requestedvars .= ")\n";
//--------------------------------------
		$logremarks = 'Add Quiz Bank  for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
				header("Location:courses.php?id=".$_GET['id']."&view=QuizBank", true, 301);
				exit();
			}
			
			
			
		} // end question title checked
	}
//--------------------------------------
}
//--------------------------------------

//--------------------------------------
if(isset($_POST['changes_question'])) { 
	//echo ($_POST['question_title_edit']);
// check question 
		if(cleanvars(removeWhiteSpace($_POST['question_title'])) == '') {
			$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>Question field is required</div>';
			header("Location:".$_SERVER['HTTP_REFERER'], true, 301);
			exit();
			
		} else {
		
//------------------------------------------------
$sqllmsquestion  = $dblms->querylms("UPDATE ".QUIZ_QUESTION." SET 
												   question_status	= '".cleanvars($_POST['question_status'])."'
												 , question_title	= '".cleanvars(removeWhiteSpace($_POST['question_title']))."' 
												 , question_weekno	= '".(cleanvars($_POST['question_weekno']))."'
												 , question_marks	= '".(cleanvars($_POST['question_marks']))."'
												 , question_level	= '".(cleanvars($_POST['question_level']))."'
												 , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
												 , date_modify		= NOW()
											 WHERE question_id		= '".cleanvars($_POST['editid'])."'");
//------------------------------------------------
	$originalImage = '';
//--------------------------------------
if(!empty($_FILES['ques_file']['name'])) { 
//--------------------------------------
	$img_dir		= "downloads/exams/questions/";
	$filesize		= $_FILES['ques_file']['size'];
	$path_parts 	= pathinfo($_FILES["ques_file"]["name"]);
	$extension 		= $path_parts['extension'];
	$originalImage	= $img_dir.time().'_'.$_POST['editid'].".".strtolower($extension);
	$img_fileName	= time().'_'.$_POST['editid'].".".strtolower($extension);
//	$extension 		= strtolower($img[1]);
	
	if(in_array($extension , array('jpg', 'jpeg', 'gif', 'png'))) { 
//--------------------------------------
			$sqllmsupload2  = $dblms->querylms("UPDATE ".QUIZ_QUESTION."
															SET question_file = '".$img_fileName."'
													 WHERE  question_id	= '".cleanvars($_POST['editid'])."'");
			unset($sqllmsupload2);
			$mode = '0644'; 
//--------------------------------------	
			move_uploaded_file($_FILES['ques_file']['tmp_name'],$originalImage);
			chmod ($originalImage, octdec($mode));
	}
//--------------------------------------
}
	$questionoptions = "\n";
	if(!empty($_POST['answer_option'])) { 
		
		
		
		for($i=1; $i<=sizeof($_POST['answer_option']); $i++){
			
			if($_POST['answer_correct'] == $i) {$status = '1';} else { $status = '0';}
			
			if($_POST['id_edit'][$i]){

				$sqllmsoption  = $dblms->querylms("UPDATE ".QUIZ_QUESTION_OPTION." SET 
													answer_option	= '".cleanvars(removeWhiteSpace($_POST['answer_option'][$i]))."'
												  , answer_correct	= '".cleanvars($status)."' 
											  WHERE id				= '".cleanvars($_POST['id_edit'][$i])."'");

			}
			else{

				$sqllmsoption  = $dblms->querylms("INSERT INTO ".QUIZ_QUESTION_OPTION."( 
																	id_question									,
																	answer_option								, 
																	answer_correct									
															)
													VALUES (
																'".cleanvars($_POST['editid'])."'				, 
																'".(removeWhiteSpace($_POST['answer_option'][$i]))."', 
																'".cleanvars($status)."'	
															)
												");

			}


			unset($sqllmsoption);
			$questionoptions .= '"answer_option:"'.'=>'.'"'.removeWhiteSpace($_POST['answer_option'][$i]).'",'."\n";
			$questionoptions .= '"answer_correct:"'.'=>'.'"'.($status).'"'."\n";
				
			
		}
	}
			


	//------------------------------------------------
	if($sqllmsquestion) {
		
		//--------------------------------------
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$_POST['editid'].'",'."\n";
			$requestedvars .= '"question_status:"'.'=>'.'"'.$_POST['question_status'].'",'."\n";
			$requestedvars .= '"question_title:"'.'=>'.'"'.$_POST['question_title'].'",'."\n";
			$requestedvars .= '"question_type:"'.'=>'.'"'.get_questiontype($_POST['questiontype']).'",'."\n";
			$requestedvars .= '"question_term:"'.'=>'.'"'.get_examterm($_POST['question_term']).'",'."\n";
			$requestedvars .= '"question_weekno:"'.'=>'.'"'.$_POST['question_weekno'].'",'."\n";
			$requestedvars .= '"question_marks:"'.'=>'.'"'.$_POST['question_marks'].'",'."\n";
			$requestedvars .= '"question_level:"'.'=>'.'"'.get_difficultylevel1($_POST['question_level']).'",'."\n";
			$requestedvars .= '"question_file:"'.'=>'.'"'.$originalImage.'",'."\n";
			$requestedvars .= '"id_teacher:"'.'=>'.'"'.$rowsstd['emply_id'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"question_options:"'.'=>'.'array('."\n";
			$requestedvars .= $questionoptions."\n";
			$requestedvars .= ")\n";
//--------------------------------------
		$logremarks = 'Update Quiz Bank ID: '.$_POST['editid'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record Updated successfully.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=QuizBank", true, 301);
		exit();
	}
		} // end question title checker
//--------------------------------------
}
//--------------------------------------