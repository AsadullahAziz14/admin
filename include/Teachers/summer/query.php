<?php 
//--------------------------------------
if(isset($_POST['submit_marks'])) { 
//------------------------------------------------
	if($_POST['submit_marks'] == 'saveonly') { 
		$forwardto  = $_POST['forward_to']; 	
	} else if($_POST['submit_marks'] == 'saveforward') { 
		$forwardto = "4"; 
	}
//------------------------------------------------
if(empty(removeWhiteSpace($_POST['id_teacher'])) || (count( array_filter($_POST['marks_obtained'])) < 1)) {
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div  class="alert-box error"><span>Oop: </span>Record can not added due to some missing fields.</b></div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
} else {
//------------------------------------------------
if(empty($_POST['id_setup'])) { 
$sqllmschecker  = $dblms->querylms("SELECT m.id  
												FROM ".SUMMER_FINAL." m 
												WHERE m.id_campus 		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND m.id_teacher 		= '".cleanvars($_POST['id_teacher'])."'
												AND m.theory_practical 	= '1'
												AND m.academic_session	= '".ARCHIVE_SESS."'
												AND m.id_curs 			= '".cleanvars($_POST['id_curs'])."' LIMIT 1");
	$valuemarks 		= mysqli_fetch_array($sqllmschecker);
if($valuemarks['id']) { 
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>warning: </span>Record already added.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
} else {
	$sqllms = $dblms->querylms("INSERT INTO ".SUMMER_FINAL." (
															status										,
															forward_to									, 
															id_curs										,
															theory_practical							, 
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
															'".cleanvars($_POST['id_curs'])."'			, 
															'1'											, 
															'".cleanvars($_POST['id_teacher'])."'		, 
															'".date("Y-m-d")."'							, 
															'".date('Y-m-d', strtotime($_POST['exam_date']))."'			, 
															'".ARCHIVE_SESS."'											,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
															NOW()			
														)
							");

//--------------------------------------
if($sqllms) {
$idsetup = $dblms->lastestid();
//--------------------------------------
	$logremarks = 'Add Student Summer Final Term Award List #: '.$idsetup.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".SUMMER_FINALTERM_DETAILS."( 
																				id_finalterm									,
																				id_std											, 
																				assignment										, 
																				quiz											, 
																				attendance										, 
																				midterm											, 
																				finalterm										, 
																				marks_obtained									, 
																				numerical										, 
																				credithour										, 
																				gradepoint										, 
																				lettergrade										, 
																				remarks										
																			)
	   																VALUES (
																				'".$idsetup."'										, 
																				'".cleanvars($_POST['id_std'][$ichk])."'			, 
																				'".cleanvars($_POST['assignment'][$ichk])."'		, 
																				'".cleanvars($_POST['quiz'][$ichk])."'				, 
																				'".cleanvars($_POST['attendance'][$ichk])."'		, 
																				'".cleanvars($_POST['midterm'][$ichk])."'			, 
																				'".cleanvars($_POST['finalterm'][$ichk])."'			, 
																				'".cleanvars($_POST['marks_obtained'][$ichk])."'	, 
																				'".cleanvars($_POST['numerical'][$ichk])."'			, 
																				'".cleanvars($_POST['credithour'][$ichk])."'		, 
																				'".cleanvars($_POST['gradepoint'][$ichk])."'		, 
																				'".cleanvars($_POST['lettergrade'][$ichk])."'		, 
																				'".cleanvars($_POST['remarks'][$ichk])."'	
																			)
										");
		}
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div class="alert-box success"><span>warning: </span>Record added successfully.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//------------------------------------------------
}
}
//--------------------------------------
} else if($_POST['id_setup']) { 
//--------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".SUMMER_FINAL." SET status	= '2'
													, forward_to	= '".cleanvars($forwardto)."' 
													, id_curs		= '".cleanvars($_POST['id_curs'])."' 
													, theory_practical	= '1' 
													, dated			= '".date("Y-m-d")."' 
													, exam_date		= '".date('Y-m-d', strtotime($_POST['exam_date']))."' 
													, id_modify		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
													, date_modify	= NOW() 
												WHERE id			= '".cleanvars($_POST['id_setup'])."'");

//--------------------------------------
if($sqllms) {
//--------------------------------------
	$logremarks = 'Update Student Summer Final Term Award List #: '.$_POST['id_setup'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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

//--------------------------------------
//	$sqllmsdelte  = $dblms->querylms("DELETE FROM ".SUMMER_FINALTERM_DETAILS." WHERE id_finalterm = '".$_POST['id_setup']."'");
//--------------------------------------
	$arraychecked = $_POST['id_std'];
//--------------------------------------
	for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
if(!empty($_POST['id_edit'][$ichk])) {
//------------------------------------------------
				$sqllmsmulti  = $dblms->querylms("UPDATE ".SUMMER_FINALTERM_DETAILS." SET 
													  assignment		= '".cleanvars($_POST['assignment'][$ichk])."' 
													, quiz				= '".cleanvars($_POST['quiz'][$ichk])."' 
													, attendance		= '".cleanvars($_POST['attendance'][$ichk])."' 
													, midterm			= '".cleanvars($_POST['midterm'][$ichk])."' 
													, finalterm			= '".cleanvars($_POST['finalterm'][$ichk])."' 
													, marks_obtained	= '".cleanvars($_POST['marks_obtained'][$ichk])."' 
													, numerical			= '".cleanvars($_POST['numerical'][$ichk])."' 
													, credithour		= '".cleanvars($_POST['credithour'][$ichk])."' 
													, gradepoint		= '".cleanvars($_POST['gradepoint'][$ichk])."' 
													, lettergrade		= '".cleanvars($_POST['lettergrade'][$ichk])."' 
													, remarks			= '".cleanvars($_POST['remarks'][$ichk])."' 	
												WHERE id				= '".cleanvars($_POST['id_edit'][$ichk])."' 
													AND id_finalterm 	= '".cleanvars($_POST['id_setup'])."'
													AND id_std 			= '".cleanvars($_POST['id_std'][$ichk])."'"); 			
} else { 
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".SUMMER_FINALTERM_DETAILS."( 
																				id_finalterm									,
																				id_std											, 
																				assignment										, 
																				quiz											, 
																				attendance										, 
																				midterm											, 
																				finalterm										, 
																				marks_obtained									, 
																				numerical										, 
																				credithour										, 
																				gradepoint										, 
																				lettergrade										, 
																				remarks										
																			)
	   																VALUES (
																				'".$_POST['id_setup']."'										, 
																				'".cleanvars($_POST['id_std'][$ichk])."'			, 
																				'".cleanvars($_POST['assignment'][$ichk])."'		, 
																				'".cleanvars($_POST['quiz'][$ichk])."'				, 
																				'".cleanvars($_POST['attendance'][$ichk])."'		, 
																				'".cleanvars($_POST['midterm'][$ichk])."'			, 
																				'".cleanvars($_POST['finalterm'][$ichk])."'			, 
																				'".cleanvars($_POST['marks_obtained'][$ichk])."'	, 
																				'".cleanvars($_POST['numerical'][$ichk])."'			, 
																				'".cleanvars($_POST['credithour'][$ichk])."'		, 
																				'".cleanvars($_POST['gradepoint'][$ichk])."'		, 
																				'".cleanvars($_POST['lettergrade'][$ichk])."'		, 
																				'".cleanvars($_POST['remarks'][$ichk])."'	
																			)
										");
//------------------------------------------------
}
		}
//------------------------------------------------
	
	$_SESSION['msg']['status'] = '<div class="alert-box success"><span>warning: </span>Record Update successfully.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//------------------------------------------------
}
//--------------------------------------
}
//--------------------------------------
}
}