<?php 
//---------------Add and update Liberal Arts midterm award list-----------------------
if(isset($_POST['submit_lamarks'])) { 
	
	if($_POST['submit_lamarks'] == 'saveonly') { 
		$forwardto  = $_POST['forward_to']; 	
	} else if($_POST['submit_lamarks'] == 'saveforward') { 
		$forwardto = "4"; 
	}
//------------------------------------------------
if(empty(removeWhiteSpace($_GET['section'])) || empty(removeWhiteSpace($_POST['id_curs'])) || empty(removeWhiteSpace($_GET['timing'])) || removeWhiteSpace($_GET['semester']) == '' || empty(removeWhiteSpace($_POST['id_teacher'])) || (count( array_filter($_POST['marks'])) < 1)) {
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div  class="alert-box error"><span>Oop: </span>Record can not added due to some missing fields.</b></div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
} else {
//------------------------------------------------
if(empty($_POST['id_setup'])) { 
	$sqllmschecker  = $dblms->querylms("SELECT * 
												FROM ".MIDTERM." m 
												WHERE m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										  		AND m.section 	= '".cleanvars($_GET['section'])."' 
												AND m.timing 	= '".cleanvars($_GET['timing'])."' 
											  	AND m.semester 	= '".cleanvars($_GET['semester'])."' 
												AND m.id_teacher = '".cleanvars($_POST['id_teacher'])."'
												AND m.is_liberalarts = '1'
												AND m.section 	= '".cleanvars($section)."'
												AND m.id_curs 	= '".cleanvars($_POST['id_curs'])."' LIMIT 1");
	$valuemarks 		= mysqli_fetch_array($sqllmschecker);
if($valuemarks['id']) { 
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>warning: </span>Record already added.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//------------------------------------------------
} else { 
//------------------------------------------------

//------------------------------------------------
	$sqllms = $dblms->querylms("INSERT INTO ".MIDTERM." (
															status										,
															forward_to									,
															is_liberalarts								,
															id_curs										,
															section										, 
															semester									, 
															timing										, 
															id_prg										, 
															id_teacher									, 
															dated										, 
															exam_date									,
															academic_session							, 
															id_campus									,
															id_added									,
															date_added
														)
												VALUES (
															'2'											, 
															'".cleanvars($forwardto)."'					, 
															'1'											, 
															'".cleanvars($_POST['id_curs'])."'			, 
															'".cleanvars($_POST['stdsection'])."'			, 
															'".cleanvars($_POST['stdsemester'])."'			, 
															'".cleanvars($_POST['stdtiming'])."'			, 
															'0'												, 
															'".cleanvars($_POST['id_teacher'])."'				, 
															'".date('Y-m-d')."'								, 
															'".date('Y-m-d', strtotime($_POST['exam_date']))."'				, 
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'		,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'			, 
															NOW()			
														)
							");
//--------------------------------------
if($sqllms) {
$idsetup = $dblms->lastestid();
//--------------------------------------
		$logremarks = 'Add Student Mid Term Award List #: '.$idsetup.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
	$arraychecked = $_POST['id_std'];
//--------------------------------------
	for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
		if($_POST['attendance'][$ichk] == 1) { 
				if($_POST['marks'][$ichk]<=$_POST['maxmarks']) { 
					$marks = $_POST['marks'][$ichk];
				} else { 
					$marks = 0;
				}
			} else { 
				$marks = 0;
			}
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".MIDTERM_DETAILS."( 
																				id_midterm						,
																				id_std							, 
																				marks							,
																				attendance						,
																				remarks								
																			)
	   																VALUES (
																				'".$idsetup."'									, 
																				'".cleanvars($_POST['id_std'][$ichk])."'		, 
																				'".cleanvars($marks)."'							,
																				'".cleanvars($_POST['attendance'][$ichk])."'	,
																				'".cleanvars($_POST['remarks'][$ichk])."'	
																			)
										");
		}
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//------------------------------------------------
}
}
//--------------------------------------
} else if($_POST['id_setup']) { 
//--------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".MIDTERM." SET forward_to	= '".cleanvars($forwardto)."' 
													, dated			= '".date("Y-m-d")."' 
													, exam_date		= '".date('Y-m-d', strtotime($_POST['exam_date']))."' 
													, id_modify		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
													, date_modify	= NOW() 
												WHERE id			= '".cleanvars($_POST['id_setup'])."'");

//--------------------------------------
if($sqllms) {
//--------------------------------------
	$logremarks = 'Update Student Mid Term Award List #: '.$_POST['id_setup'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'			,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."'	, 
															'2'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($logremarks)."'						,
															'".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'			
														  )
									");

//--------------------------------------
//	$sqllmsdelte  = $dblms->querylms("DELETE FROM ".FINALTERM_DETAILS." WHERE id_finalterm = '".$_POST['id_setup']."'");
//--------------------------------------
	$arraychecked = $_POST['id_std'];
//--------------------------------------
	for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
	if($_POST['attendance'][$ichk] == 1) { 
		if($_POST['marks'][$ichk]<=$_POST['maxmarks']) { 
			$marks = $_POST['marks'][$ichk];
		} else { 
			$marks = 0;
		}
	} else { 
		$marks = 0;
	}

if(!empty($_POST['id_edited'][$ichk])) { 
//------------------------------------------------
	$sqllmsmulti  = $dblms->querylms("UPDATE ".MIDTERM_DETAILS." SET 
															marks		= '".cleanvars($marks)."'
														  , attendance	= '".cleanvars($_POST['attendance'][$ichk])."'
														  , remarks		= '".cleanvars($_POST['remarks'][$ichk])."'
													  WHERE  id	= '".cleanvars($_POST['id_edited'][$ichk])."' ");
} else { 
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".MIDTERM_DETAILS."( 
																				id_midterm					,
																				id_std						, 
																				marks						,
																				attendance					,
																				remarks 				
																			)
	   																VALUES (
																				'".$_POST['id_setup']."'					, 
																				'".cleanvars($_POST['id_std'][$ichk])."'	, 
																				'".cleanvars($marks)."'						,
																				'".cleanvars($_POST['attendance'][$ichk])."'	,
																				'".cleanvars($_POST['remarks'][$ichk])."'	
																			)
										");
}
		}
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record Update successfully.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//------------------------------------------------
}
//--------------------------------------
}
//--------------------------------------
}
}


//Add and Update Midterm Award List
if(isset($_POST['submit_marks'])) { 

	if($_POST['submit_marks'] == 'saveonly') { 
		$forwardto  = $_POST['forward_to']; 	
	} else if($_POST['submit_marks'] == 'saveforward') { 
		$forwardto = "4"; 
	}

	if(empty(removeWhiteSpace($_GET['prgid'])) || empty(removeWhiteSpace($_POST['id_curs'])) || empty(removeWhiteSpace($_GET['timing'])) || removeWhiteSpace($_GET['semester']) == '' || empty(removeWhiteSpace($_POST['id_teacher'])) || (count( array_filter($_POST['marks'])) < 0)) {

		$_SESSION['msg']['status'] = '<div  class="alert-box error"><span>Oop: </span>Record can not added due to some missing fields.</b></div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	} else {

		if(empty($_POST['id_setup'])) { 

			$sqllmschecker  = $dblms->querylms("SELECT * 
														FROM ".MIDTERM." m 
														WHERE m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
														AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
														AND m.id_prg 	= '".cleanvars($_GET['prgid'])."' 
														AND m.timing 	= '".cleanvars($_GET['timing'])."' 
														AND m.semester 	= '".cleanvars($_GET['semester'])."' 
														AND m.id_teacher = '".cleanvars($_POST['id_teacher'])."'
														AND m.is_liberalarts != '1'
														AND m.section 	= '".cleanvars($section)."'
														AND m.id_curs 	= '".cleanvars($_POST['id_curs'])."' LIMIT 1");
			$valuemarks 		= mysqli_fetch_array($sqllmschecker);

			if($valuemarks['id']) { 

				$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>warning: </span>Record already added.</div>';
				header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
				exit();

			} else { 

				$sqllms = $dblms->querylms("INSERT INTO ".MIDTERM." (
																		status										,
																		forward_to									,
																		is_liberalarts								,
																		id_curs										,
																		section										, 
																		semester									, 
																		timing										, 
																		id_prg										, 
																		id_teacher									, 
																		dated										, 
																		exam_date									,
																		academic_session							, 
																		id_campus									,
																		id_added									,
																		date_added
																	)
															VALUES (
																		'2'											, 
																		'".cleanvars($forwardto)."'					, 
																		'2'											, 
																		'".cleanvars($_POST['id_curs'])."'			, 
																		'".cleanvars($_POST['stdsection'])."'			, 
																		'".cleanvars($_POST['stdsemester'])."'			, 
																		'".cleanvars($_POST['stdtiming'])."'			, 
																		'".cleanvars($_POST['prgid'])."'			, 
																		'".cleanvars($_POST['id_teacher'])."'		, 
																		'".date('Y-m-d')."'								, 
																		'".date('Y-m-d', strtotime($_POST['exam_date']))."'				, 
																		'".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'	,
																		'".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'		,
																		'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'			, 
																		NOW()			
																	)
										");
//--------------------------------------
if($sqllms) {
$idsetup = $dblms->lastestid();
//--------------------------------------
		$logremarks = 'Add Student Mid Term Award List #: '.$idsetup.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
	$arraychecked = $_POST['id_std'];
//--------------------------------------
	for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
		if($_POST['attendance'][$ichk] == 1) { 
				if($_POST['marks'][$ichk]<=$_POST['maxmarks']) { 
					$marks = $_POST['marks'][$ichk];
				} else { 
					$marks = 0;
				}
			} else { 
				$marks = 0;
			}
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".MIDTERM_DETAILS."( 
																				id_midterm						,
																				id_std							, 
																				marks							,
																				attendance						,
																				remarks								
																			)
	   																VALUES (
																				'".$idsetup."'									, 
																				'".cleanvars($_POST['id_std'][$ichk])."'		, 
																				'".cleanvars($marks)."'							,
																				'".cleanvars($_POST['attendance'][$ichk])."'	,
																				'".cleanvars($_POST['remarks'][$ichk])."'	
																			)
										");
		}
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//------------------------------------------------
}
}
//--------------------------------------
} else if($_POST['id_setup']) { 
//--------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".MIDTERM." SET forward_to	= '".cleanvars($forwardto)."' 
													, dated			= '".date("Y-m-d")."' 
													, exam_date		= '".date('Y-m-d', strtotime($_POST['exam_date']))."' 
													, id_modify		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
													, date_modify	= NOW() 
												WHERE id			= '".cleanvars($_POST['id_setup'])."'");

//--------------------------------------
if($sqllms) {
//--------------------------------------
	$logremarks = 'Update Student Mid Term Award List #: '.$_POST['id_setup'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'			,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."'	, 
															'2'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($logremarks)."'						,
															'".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'			
														  )
									");

//--------------------------------------
//	$sqllmsdelte  = $dblms->querylms("DELETE FROM ".FINALTERM_DETAILS." WHERE id_finalterm = '".$_POST['id_setup']."'");
//--------------------------------------
	$arraychecked = $_POST['id_std'];
//--------------------------------------
	for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
	if($_POST['attendance'][$ichk] == 1) { 
		if($_POST['marks'][$ichk]<=$_POST['maxmarks']) { 
			$marks = $_POST['marks'][$ichk];
		} else { 
			$marks = 0;
		}
	} else { 
		$marks = 0;
	}

if(!empty($_POST['id_edited'][$ichk])) { 
//------------------------------------------------
	$sqllmsmulti  = $dblms->querylms("UPDATE ".MIDTERM_DETAILS." SET 
															marks		= '".cleanvars($marks)."'
														  , attendance	= '".cleanvars($_POST['attendance'][$ichk])."'
														  , remarks		= '".cleanvars($_POST['remarks'][$ichk])."'
													  WHERE  id	= '".cleanvars($_POST['id_edited'][$ichk])."' ");
} else { 
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".MIDTERM_DETAILS."( 
																				id_midterm					,
																				id_std						, 
																				marks						,
																				attendance					,
																				remarks 				
																			)
	   																VALUES (
																				'".$_POST['id_setup']."'					, 
																				'".cleanvars($_POST['id_std'][$ichk])."'	, 
																				'".cleanvars($marks)."'						,
																				'".cleanvars($_POST['attendance'][$ichk])."'	,
																				'".cleanvars($_POST['remarks'][$ichk])."'	
																			)
										");
}
		}
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record Update successfully.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//------------------------------------------------
}
//--------------------------------------
}
//--------------------------------------
}
}