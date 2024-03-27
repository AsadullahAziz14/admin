<?php 
//--------------------------------------
if(isset($_POST['submit_quiz'])) { 
//------------------------------------------------
	$sqllmsselect  = $dblms->querylms("SELECT quiz_id   
										FROM ".QUIZ." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' 
										AND quiz_title = '".cleanvars($_POST['quiz_title'])."' 
										AND quiz_term = '".cleanvars($_POST['quiz_term'])."' LIMIT 1");
//------------------------------------------------
	if(mysqli_num_rows($sqllmsselect)>0) { 
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>Record already exists.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=Quiz", true, 301);
		exit();
	} else {
		$sqllmsquiz  = $dblms->querylms("INSERT INTO ".QUIZ." (
																quiz_status					, 
																quiz_title					,
																quiz_term					,
																quiz_totalmarks				,
																quiz_passingmarks			,
																id_curs						,
																id_teacher					,
																academic_session			,
																id_campus					,
																id_added					, 
																date_added 
															)
													VALUES (
															'".cleanvars($_POST['quiz_status'])."'		,
															'".cleanvars($_POST['quiz_title'])."'		,
															'".cleanvars($_POST['quiz_term'])."'		, 
															'".cleanvars($_POST['quiz_totalmarks'])."'	,
															'".cleanvars($_POST['quiz_passingmarks'])."',
															'".cleanvars($_POST['id_curs'])."'			,
															'".cleanvars($rowsstd['emply_id'])."'		, 
															'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
															'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
															NOW() 
														)"
								);

		//--------------------------------------
		if($sqllmsquiz) {

			$id_quiz  = $dblms->lastestid();

			$count_question = 0;
			//--------------------------------------
			for($i=0; $i<=count($_POST['difficulty_level']); $i++){
				//--------------------------------------
				if(!empty($_POST['difficulty_level'][$i]) && !empty($_POST['questions'][$i]) && !empty($_POST['id_type'][$i])) {
				//--------------------------------------
					$count_question = ($count_question + $_POST['questions'][$i]);

					$sqllmsquizdetail  = $dblms->querylms("INSERT INTO ".QUIZ_DETAIL." (
																id_quiz						,
																difficulty_level			,
																questions					,
																question_type			
															)
													VALUES (
																'".cleanvars($id_quiz)."'						,
																'".cleanvars($_POST['difficulty_level'][$i])."'	,
																'".cleanvars($_POST['questions'][$i])."' 		,
																'".cleanvars($_POST['id_type'][$i])."'	
															)"
														);
				}
			}

			$sqllmsquiz  = $dblms->querylms("UPDATE ".QUIZ." SET 
												  quiz_questions	= '".cleanvars($count_question)."' 
											 WHERE quiz_id			= '".cleanvars($id_quiz)."'");

		$arraychecked = $_POST['idprg'];
//--------------------------------------
if(!empty(sizeof($_POST['idprg']))) {
	for($ichkj=0; $ichkj<count($_POST['idprg']); $ichkj++){ 

	$arr 		= $_POST['idprg'][$ichkj];

	$splitted 	= explode(",",trim($arr));  
	$idprg 		= $splitted[0];
	$semester 	= $splitted[1];
	$timing 	= $splitted[2];
	$section 	= $splitted[3];
//--------------------------------------
		$sqllmsrel = $dblms->querylms("INSERT INTO ".QUIZ_PROGRAM." (
																		id_setup				, 
																		id_prg					, 
																		semester				,
																		section					,
																		timing							
																   )
	   														VALUES (
																		'".cleanvars($id_quiz)."'	,
																		'".cleanvars($idprg)."'		,
																		'".cleanvars($semester)."'	, 
																		'".cleanvars($section)."'	, 
																		'".cleanvars($timing)."'		 
																		
													 			 )"
							);
//--------------------------------------
	}
}
//---------------------------------------

			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."&view=Quiz", true, 301);
			exit();
		}
		//--------------------------------------
	}
//--------------------------------------
}
//--------------------------------------

//--------------------------------------
if(isset($_POST['changes_quiz'])) { 
//------------------------------------------------
$sqllmsquiz  = $dblms->querylms("UPDATE ".QUIZ." SET 
													quiz_status			= '".cleanvars($_POST['quiz_status'])."'
												 , quiz_title			= '".cleanvars($_POST['quiz_title'])."'
												 , quiz_term			= '".cleanvars($_POST['quiz_term'])."'  
												 , quiz_totalmarks		= '".cleanvars($_POST['quiz_totalmarks'])."' 
												 , quiz_passingmarks	= '".cleanvars($_POST['quiz_passingmarks'])."' 
												 , id_campus			= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
												 , id_modify			= '".$_SESSION['userlogininfo']['LOGINIDA']."'
												 , date_modify			= NOW()
											 WHERE quiz_id				= '".cleanvars($_POST['quizid_edit'])."'");
//--------------------------------------
	if($sqllmsquiz) {

		$sqllmsqize  = $dblms->querylms("DELETE FROM ".QUIZ_DETAIL." WHERE id_quiz = '".cleanvars($_POST['quizid_edit'])."'");
		$count_question = 0;
			//--------------------------------------
			for($i=0; $i<=count($_POST['difficulty_level']); $i++){
				//--------------------------------------
				if(!empty($_POST['difficulty_level'][$i]) && !empty($_POST['questions'][$i]) && !empty($_POST['id_type'][$i])) {
				//--------------------------------------
					$count_question = ($count_question + $_POST['questions'][$i]);

					$sqllmsquizdetail  = $dblms->querylms("INSERT INTO ".QUIZ_DETAIL." (
																id_quiz						,
																difficulty_level			,
																questions					,
																question_type			
															)
													VALUES (
																'".cleanvars($_POST['quizid_edit'])."'			,
																'".cleanvars($_POST['difficulty_level'][$i])."'	,
																'".cleanvars($_POST['questions'][$i])."' 		,
																'".cleanvars($_POST['id_type'][$i])."'	
															)"
														);
				}
			}

			$sqllmsquiz  = $dblms->querylms("UPDATE ".QUIZ." SET 
												  quiz_questions	= '".cleanvars($count_question)."' 
											 WHERE quiz_id			= '".cleanvars($_POST['quizid_edit'])."'");
		//--------------------------------------
		if(!empty(sizeof($_POST['idprg']))) {

		$sqllmsdelte  = $dblms->querylms("DELETE FROM ".QUIZ_PROGRAM." WHERE id_setup = '".cleanvars($_POST['quizid_edit'])."'");
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
				$sqllmsrel = $dblms->querylms("INSERT INTO ".QUIZ_PROGRAM." (
																					id_setup				, 
																					id_prg					, 
																					semester				,
																					section					,
																					timing							
																			)
																		VALUES (
																					'".cleanvars($_POST['quizid_edit'])."'	,
																					'".cleanvars($idprg)."'		,
																					'".cleanvars($semester)."'	, 
																					'".cleanvars($section)."'	, 
																					'".cleanvars($timing)."'		 
																					
																			)"
										);
			}
		//--------------------------------------
		}
		//---------------------------------------
			
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record Updated successfully.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=Quiz", true, 301);
		exit();
	}
//--------------------------------------
}
//--------------------------------------