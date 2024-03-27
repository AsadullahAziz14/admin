<?php 
//--------------------------------------
if(isset($_POST['publish_result'])) { 
//------------------------------------------------
if(empty(removeWhiteSpace($_POST['prgid'])) || empty(removeWhiteSpace($_POST['id_curs'])) || empty(removeWhiteSpace($_POST['timing'])) || removeWhiteSpace($_POST['semester']) == '' || empty(removeWhiteSpace($_POST['id_teacher']))) {
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div  class="alert-box error"><span>Oop: </span>Record can not added due to some missing fields.</b></div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
	
} else {
//------------------------------------------------
	$sqllmschecker  = $dblms->querylms("SELECT m.id 
												FROM ".MIDTERM." m 
												WHERE m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										  		AND m.id_prg 	 = '".cleanvars($_POST['prgid'])."' 
												AND m.timing 	 = '".cleanvars($_POST['timing'])."' 
											  	AND m.semester 	 = '".cleanvars($_POST['semester'])."' 
												AND m.id_teacher = '".cleanvars($_POST['id_teacher'])."'
												AND m.section 	 = '".cleanvars($_POST['section'])."' 
												AND m.id_curs 	 = '".cleanvars($_POST['id_curs'])."' LIMIT 1");
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
															'4'											, 
															'".cleanvars($_POST['id_curs'])."'			, 
															'".cleanvars($_POST['section'])."'			, 
															'".cleanvars($_POST['semester'])."'			, 
															'".cleanvars($_POST['timing'])."'			, 
															'".cleanvars($_POST['prgid'])."'			, 
															'".cleanvars($_POST['id_teacher'])."'		, 
															'".date('Y-m-d')."'							, 
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

	//Attendance % Value from Setting
	$sqllmsSetting  = $dblms->querylms("SELECT exam_datesheet, midterm_mattendance, finalterm_mattendance, 
											course_evaluation, teacher_evaluation,  
											graduating_survey, midterm_eattendance, finalterm_eattendance, exclude_attendance  
											FROM ".SETTINGS." 
											WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											LIMIT 1");
	$rowSetting 	= mysqli_fetch_array($sqllmsSetting);
	
	if($_POST['timing'] == 1 || $_POST['timing'] == 4) { 

		$requiredAttendance = $rowSetting['midterm_mattendance'];
		
	} elseif($_POST['timing'] == 2) {
	
		$requiredAttendance = $rowSetting['midterm_eattendance'];
	}
//--------------------------------------------------
	$sqllmsprmi  = $dblms->querylms("SELECT std.std_id
											FROM ".STUDENTS." std 
											WHERE (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prg = '".cleanvars($_POST['prgid'])."' 
											AND std.std_timing = '".cleanvars($_POST['timing'])."' 
											AND std.std_semester = '".cleanvars($_POST['semester'])."' 
											AND std.std_section = '".cleanvars($_POST['section'])."' 
											AND std.std_session != '".cleanvars($_SESSION['userlogininfo']['LOGINIDADMISSION'])."'
											ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC");
	while($rowcurstds = mysqli_fetch_array($sqllmsprmi)) { 

		//Attendnace
		$sqllmsAttendance  = $dblms->querylms("SELECT dt.status   
													FROM ".COURSES_ATTENDANCE_DETAIL." dt
													INNER JOIN ".COURSES_ATTENDANCE." at ON at.id = dt.id_setup 
													WHERE at.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'
													AND at.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
													AND at.id_curs = '".cleanvars($_POST['id_curs'])."' 
													AND at.semester = '".cleanvars($_POST['semester'])."' 
													AND at.section = '".cleanvars($_POST['section'])."' 
													AND at.timing = '".cleanvars($_POST['timing'])."' 
													AND at.id_prg  = '".cleanvars($_POST['prgid'])."'
													AND dt.id_std = '".cleanvars($rowcurstds['std_id'])."' ORDER BY at.lectureno ASC");
		$totalLecture = mysqli_num_rows($sqllmsAttendance);
		$totalPresent = 0;
		$arrayattendance = array();
		while($rowAttendance = mysqli_fetch_assoc($sqllmsAttendance)) { 
			if($rowAttendance['status'] == 2) { 
				$totalPresent++;
			}
		}

		$attendancePercentage = 0;
		//Calculate Student Course Attendance %
		if($totalLecture>0) { 
			$attendancePercentage = round(($totalPresent/$totalLecture) * 100);
		}

		//Add Student to Array if attendance meets criteria
		if($attendancePercentage >= $requiredAttendance){
		$cursstudents[] = array (
									"std_id"	=> $rowcurstds['std_id'],
									"primary_secondary"	=> '1'
								);
		}
		$countstudents++;
	}
//-----------------Students of 2ndary Program-------------------------------
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) !=1) { 
		
		$sqllmsstd2ndary  = $dblms->querylms("SELECT std.std_id
												FROM ".STUDENTS." std 
												WHERE (std.std_status = '2' OR std.std_status = '7') 
												AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
												AND std.id_campus 		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND std.id_prgsecondary = '".cleanvars($_POST['prgid'])."' 
												AND std.std_timing 		= '".cleanvars($_POST['timing'])."' 
												AND std.std_secondarysemester = '".cleanvars($_POST['semester'])."' 
												AND std.std_section = '".cleanvars($_POST['section'])."' 
												AND std.std_secondarysession != '".cleanvars($_SESSION['userlogininfo']['LOGINIDADMISSION'])."'
												ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC ");
		
		while($rowcur2ndary = mysqli_fetch_array($sqllmsstd2ndary)) { 
			$cursstudents[] = array (
										"std_id"	=> $rowcur2ndary['std_id'],
										"primary_secondary"	=> '2'
									);
			$countstudents++;
		}
		
	} 
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
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'			,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."'	, 
															'1'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($logremarks)."'						,
															'".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'			
														  )
									");
//--------------------------------------

	$arraychecked = $_POST['id_std'];
//------------------------------------------------
		foreach($cursstudents as $itemstd) { 
//------------------------------------------------

			if($itemstd['primary_secondary'] == 1){
				$addAssignmentPrgSQL = "AND std.id_prg = '".cleanvars($_POST['prgid'])."'
										AND std.std_semester = '".cleanvars($_POST['semester'])."'";

			} elseif($itemstd['primary_secondary'] == 2){
				$addAssignmentPrgSQL = "AND std.id_prgsecondary = '".cleanvars($_POST['prgid'])."'
											AND std.std_secondarysemester = '".cleanvars($_POST['semester'])."'";
			}
	$sqllmsAssignment  = $dblms->querylms("SELECT s.id, s.marks 
												FROM ".COURSES_ASSIGNMENTS_STUDENTS." s  
												INNER JOIN ".COURSES_ASSIGNMENTS." a ON a.id = s.id_assignment 
												INNER JOIN ".EMPLYS." emp ON emp.emply_id = a.id_teacher 
												INNER JOIN ".STUDENTS." std ON std.std_id = s.id_std  
												WHERE s.id_modify != '0' 
												AND a.is_midterm = '1' 
												AND a.id_curs = '".cleanvars($_POST['id_curs'])."'
												AND a.id_teacher = '".cleanvars($_POST['id_teacher'])."' 
												AND a.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
												AND a.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
												AND std.std_id = '".cleanvars($itemstd['std_id'])."' 
												$addAssignmentPrgSQL
												AND std.std_section = '".cleanvars($_POST['section'])."' 
												AND std.std_timing = '".cleanvars($_POST['timing'])."'
												LIMIT 1");
 	$valueAss = mysqli_fetch_array($sqllmsAssignment); 
	if($valueAss['id']) {
		
		$marks 		= $valueAss['marks'];
		$attendance = 1;

	} else {
		
		$marks 		= 0;
		$attendance = 2;
		
	}
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".MIDTERM_DETAILS."( 
																				id_midterm						,
																				id_std							, 
																				marks							,
																				attendance							
																			)
	   																VALUES (
																				'".$idsetup."'							, 
																				'".cleanvars($itemstd['std_id'])."'		, 
																				'".cleanvars($marks)."'					,
																				'".cleanvars($attendance)."'	
																			)
										");
		} // end for loop
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div class="alert-box success">
									<span>success: </span>The Result has been published successfully.
								 </div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//------------------------------------------------
} // end query run successfully
	
} // end check if record already exist
	
} // end check values are not empty
	
} // end submit 


//--------------------------------------
if(isset($_POST['publish_reattempt_mid_result'])) { 
//------------------------------------------------
if(empty(removeWhiteSpace($_POST['prgid'])) || empty(removeWhiteSpace($_POST['id_curs'])) || empty(removeWhiteSpace($_POST['timing'])) || empty(removeWhiteSpace($_POST['semester'])) || empty(removeWhiteSpace($_POST['id_teacher']))) {
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div  class="alert-box error"><span>Oop: </span>Record can not added due to some missing fields.</b></div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
	
} else {
//------------------------------------------------
	$sqllmschecker  = $dblms->querylms("SELECT m.id 
											FROM ".REPEAT_MIDTERM." m 
											WHERE m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND m.id_prg 	 = '".cleanvars($_POST['prgid'])."' 
											AND m.timing 	 = '".cleanvars($_POST['timing'])."' 
											AND m.semester 	 = '".cleanvars($_POST['semester'])."' 
											AND m.id_teacher = '".cleanvars($_POST['id_teacher'])."'
											AND m.section 	 = '".cleanvars($_POST['section'])."' 
											AND m.id_curs 	 = '".cleanvars($_POST['id_curs'])."' LIMIT 1");
	$valuemarks 		= mysqli_fetch_array($sqllmschecker);
	
if($valuemarks['id']) { 
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>warning: </span>Record already added.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//------------------------------------------------
} else { 
//------------------------------------------------
	$sqllms = $dblms->querylms("INSERT INTO ".REPEAT_MIDTERM." (
															status										,
															forward_to									,
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
															'4'											, 
															'".cleanvars($_POST['id_curs'])."'			, 
															'".cleanvars($_POST['section'])."'			, 
															'".cleanvars($_POST['semester'])."'			, 
															'".cleanvars($_POST['timing'])."'			, 
															'".cleanvars($_POST['prgid'])."'			, 
															'".cleanvars($_POST['id_teacher'])."'		, 
															'".date('Y-m-d')."'							, 
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
//--------------------------------------------------
	$sqllmsprmi  = $dblms->querylms("SELECT std.std_id 
											FROM ".REPEAT_EXAM." ex  
											INNER JOIN ".EMPLYS." emp ON emp.emply_id = ex.id_teacher 
											INNER JOIN ".STUDENTS." std ON std.std_id = ex.id_std  
											WHERE ex.id_term = '1' AND ex.id_curs = '".cleanvars($_POST['id_curs'])."' 
											AND (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prg = '".cleanvars($_POST['prgid'])."' 
											AND std.std_timing = '".cleanvars($_POST['timing'])."' 
											AND std.std_semester = '".cleanvars($_POST['semester'])."' 
											AND std.std_section = '".cleanvars($_POST['section'])."' 
											ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC");
	while($rowcurstds = mysqli_fetch_array($sqllmsprmi)) { 
		$cursstudents[] = array (
									"std_id"	=> $rowcurstds['std_id']
								);
		$countstudents++;
	}
//--------------------------------------
		$logremarks = 'Add Student Reattempt Mid Term Award List #: '.$idsetup.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
															'1'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($logremarks)."'						,
															'".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'			
														  )
									");
//--------------------------------------
	$arraychecked = $_POST['id_std'];
//------------------------------------------------
	foreach($cursstudents as $itemstd) { 
//--------------------Total Questions ----------------------------
	$sqllmstotalques  = $dblms->querylms("SELECT ex.id, ex.id_std, ex.date_attempt, ex.total_marks, ex.obtain_marks   
											FROM ".REPEAT_EXAM." ex  
											WHERE ex.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND ex.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND ex.id_std = '".cleanvars($itemstd['std_id'])."' 
											AND ex.id_teacher = '".cleanvars($_POST['id_teacher'])."' 
											AND ex.id_prg = '".cleanvars($_POST['prgid'])."'
											AND ex.semester = '".cleanvars($_POST['semester'])."'
											AND ex.section = '".cleanvars($_POST['section'])."'
											AND ex.timing = '".cleanvars($_POST['timing'])."'
											AND ex.id_term = '1' 
											AND ex.id_curs = '".cleanvars($_POST['id_curs'])."' ");	
 
 	$valuesques = mysqli_fetch_array($sqllmstotalques); 
	if($valuesques['id_std']) {
		
	//---------------------update published ---------------------------
		$sqllmspublish  = $dblms->querylms("UPDATE ".REPEAT_EXAM." SET 
																published	= '1'
														WHERE id			= '".cleanvars($valuesques['id'])."' ");
		
	//----------------------------
		$marks 		= $valuesques['obtain_marks'];
		$attendance = 1;
	} else {
		$marks 		= 0;
		$attendance = 2;
		
	}
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".REPEAT_MIDTERM_DETAILS."( 
																				id_midterm						,
																				id_std							, 
																				marks							,
																				attendance							
																			)
	   																VALUES (
																				'".$idsetup."'							, 
																				'".cleanvars($itemstd['std_id'])."'		, 
																				'".cleanvars($marks)."'					,
																				'".cleanvars($attendance)."'	
																			)
										");
		} // end for loop
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div class="alert-box success">
									<span>success: </span>The Result has been published successfully.
								 </div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//------------------------------------------------
} // end query run successfully
	
} // end check if record already exist
	
} // end check values are not empty
	
} // end submit 


//--------------------------------------
if(isset($_POST['publish_reattempt_final_result'])) { 
//------------------------------------------------
if(empty(removeWhiteSpace($_POST['prgid'])) || empty(removeWhiteSpace($_POST['id_curs'])) || empty(removeWhiteSpace($_POST['timing'])) || empty(removeWhiteSpace($_POST['semester'])) || empty(removeWhiteSpace($_POST['id_teacher']))) {
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div  class="alert-box error"><span>Oop: </span>Record can not added due to some missing fields.</b></div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
	
} else {
//------------------------------------------------
	$sqllmschecker  = $dblms->querylms("SELECT m.id 
											FROM ".REPEAT_FINALTERM." m 
											WHERE m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND m.id_prg 	 = '".cleanvars($_POST['prgid'])."' 
											AND m.timing 	 = '".cleanvars($_POST['timing'])."' 
											AND m.semester 	 = '".cleanvars($_POST['semester'])."' 
											AND m.id_teacher = '".cleanvars($_POST['id_teacher'])."'
											AND m.section 	 = '".cleanvars($_POST['section'])."' 
											AND m.id_curs 	 = '".cleanvars($_POST['id_curs'])."' LIMIT 1");
	$valuemarks 		= mysqli_fetch_array($sqllmschecker);
	
if($valuemarks['id']) { 
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>warning: </span>Record already added.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//------------------------------------------------
} else { 
//------------------------------------------------
	$sqllms = $dblms->querylms("INSERT INTO ".REPEAT_FINALTERM." (
															status										,
															forward_to									,
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
															'4'											, 
															'".cleanvars($_POST['id_curs'])."'			, 
															'".cleanvars($_POST['section'])."'			, 
															'".cleanvars($_POST['semester'])."'			, 
															'".cleanvars($_POST['timing'])."'			, 
															'".cleanvars($_POST['prgid'])."'			, 
															'".cleanvars($_POST['id_teacher'])."'		, 
															'".date('Y-m-d')."'							, 
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
//--------------------------------------------------
	$sqllmsprmi  = $dblms->querylms("SELECT std.std_id 
											FROM ".REPEAT_EXAM." ex  
											INNER JOIN ".EMPLYS." emp ON emp.emply_id = ex.id_teacher 
											INNER JOIN ".STUDENTS." std ON std.std_id = ex.id_std  
											WHERE ex.id_term = '2' AND ex.id_curs = '".cleanvars($_POST['id_curs'])."' 
											AND (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prg = '".cleanvars($_POST['prgid'])."' 
											AND std.std_timing = '".cleanvars($_POST['timing'])."' 
											AND std.std_semester = '".cleanvars($_POST['semester'])."' 
											AND std.std_section = '".cleanvars($_POST['section'])."' 
											ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC");
	while($rowcurstds = mysqli_fetch_array($sqllmsprmi)) { 
		$cursstudents[] = array (
									"std_id"	=> $rowcurstds['std_id']
								);
		$countstudents++;
	}
//--------------------------------------
		$logremarks = 'Add Student Reattempt Mid Term Award List #: '.$idsetup.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
															'1'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($logremarks)."'						,
															'".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'			
														  )
									");
//--------------------------------------
	$arraychecked = $_POST['id_std'];
//------------------------------------------------
	foreach($cursstudents as $itemstd) { 
//--------------------Total Questions ----------------------------
	$sqllmstotalques  = $dblms->querylms("SELECT ex.id, ex.id_std, ex.date_attempt, ex.total_marks, ex.obtain_marks   
											FROM ".REPEAT_EXAM." ex  
											WHERE ex.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND ex.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND ex.id_std = '".cleanvars($itemstd['std_id'])."' 
											AND ex.id_teacher = '".cleanvars($_POST['id_teacher'])."' 
											AND ex.id_prg = '".cleanvars($_POST['prgid'])."'
											AND ex.semester = '".cleanvars($_POST['semester'])."'
											AND ex.section = '".cleanvars($_POST['section'])."'
											AND ex.timing = '".cleanvars($_POST['timing'])."'
											AND ex.id_term = '2' 
											AND ex.id_curs = '".cleanvars($_POST['id_curs'])."' ");	
 
 	$valuesques = mysqli_fetch_array($sqllmstotalques); 
	if($valuesques['id_std']) {
		
	//---------------------update published ---------------------------
		$sqllmspublish  = $dblms->querylms("UPDATE ".REPEAT_EXAM." SET 
																published	= '1'
														WHERE id			= '".cleanvars($valuesques['id'])."' ");
		
	//----------------------------
		$marks 		= $valuesques['obtain_marks'];
		$attendance = 1;
	} else {
		$marks 		= 0;
		$attendance = 2;
		
	}
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".REPEAT_FINALTERM_DETAILS."( 
																				id_finalterm						,
																				id_std								, 
																				marks								,
																				attendance							
																			)
	   																VALUES (
																				'".$idsetup."'							, 
																				'".cleanvars($itemstd['std_id'])."'		, 
																				'".cleanvars($marks)."'					,
																				'".cleanvars($attendance)."'	
																			)
										");
		} // end for loop
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div class="alert-box success">
									<span>success: </span>The Result has been published successfully.
								 </div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//------------------------------------------------
} // end query run successfully
	
} // end check if record already exist
	
} // end check values are not empty
	
} // end submit 



//------------------update Paper Check--------------------
if(isset($_POST['changes_detail'])) { 
	

	if(isset($_GET['section'])) {  
		$secthref		= "&section=".$_GET['section'];
		$section 		= $_GET['section'];
		$seccursquery 	= " AND at.section = '".$_GET['section']."'";
		$secLecture 	= " AND t.section = '".$_GET['section']."'";
	} else { 
		$secthref		= '';
		$section 		= '';
		$seccursquery 	= " AND at.section = ''";
		$secLecture 	= " AND t.section = ''";
	}	

$hrefredirect = 'courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Assessments&term='.$_GET['term'];	


//--------------------------------------

//		$sqllmsdelte  = $dblms->querylms("DELETE FROM ".COURSES_ATTENDANCE_DETAIL." WHERE id_setup = '".$_POST['id_setup']."'");

//--------------------------------------
	$arraychecked = $_POST['idedit'];
	
	$totalobt = 0;
//--------------------------------------
	for($ichk=0; $ichk<sizeof($arraychecked); $ichk++){


//------------------------------------------------
	$sqllmsmulti  = $dblms->querylms("UPDATE ".QUIZ_EXAMSQUESTIONS." SET 
															totalmarks		= '".cleanvars($_POST['totalmarks'][$ichk])."'
														  , obtmarks		= '".cleanvars($_POST['obtmarks'][$ichk])."'
														  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."' 
														  , date_modify		= NOW()
													  WHERE id				= '".cleanvars($_POST['idedit'][$ichk])."' ");


			$totalobt = ($totalobt + $_POST['obtmarks'][$ichk]);

		}

//--------------------------------------
if($sqllmsmulti) {	 
	
	
//------------------------------------------------
	$sqllmsbook  = $dblms->querylms("UPDATE ".QUIZ_EXAMS." SET 
															paper_checked	= '1' 
														  ,	total_marks		= '".cleanvars($_POST['total_marks'])."'
														  , obtain_marks	= '".cleanvars($totalobt)."'
														  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														  , date_modify		= NOW()
													  WHERE id				= '".cleanvars($_POST['examid'])."'");
//------------------------------------------------
						
			$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
			header("Location:".$hrefredirect."", true, 301);
			exit();
	
		}
//--------------------------------------
	
}



//------------------update Paper Check--------------------
if(isset($_POST['update_reattempt'])) { 

	if(isset($_GET['section'])) {  
		$secthref		= "&section=".$_GET['section'];
		$section 		= $_GET['section'];
		$seccursquery 	= " AND at.section = '".$_GET['section']."'";
		$secLecture 	= " AND t.section = '".$_GET['section']."'";
	} else { 
		$secthref		= '';
		$section 		= '';
		$seccursquery 	= " AND at.section = ''";
		$secLecture 	= " AND t.section = ''";
	}	

	$hrefredirect = 'courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Assessments&reattempt&term='.$_GET['term'];	

//--------------------------------------
	$arraychecked = $_POST['idedit'];
	
	$totalobt = 0;
//--------------------------------------
	for($ichk=0; $ichk<sizeof($arraychecked); $ichk++){
//------------------------------------------------
		$sqllmsmulti  = $dblms->querylms("UPDATE ".REPEAT_EXAMSQUESTIONS." SET 
															totalmarks		= '".cleanvars($_POST['totalmarks'][$ichk])."'
														  , obtmarks		= '".cleanvars($_POST['obtmarks'][$ichk])."'
														  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."' 
														  , date_modify		= NOW()
													  WHERE id				= '".cleanvars($_POST['idedit'][$ichk])."' ");
		$totalobt = ($totalobt + $_POST['obtmarks'][$ichk]);

	}

//--------------------------------------
	if($sqllmsmulti) {	 
//------------------------------------------------
		$sqllmsbook  = $dblms->querylms("UPDATE ".REPEAT_EXAM." SET 
																paper_checked	= '1' 
															,	total_marks		= '".cleanvars($_POST['total_marks'])."'
															, obtain_marks	= '".cleanvars($totalobt)."'
															, id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
															, date_modify		= NOW()
														WHERE id				= '".cleanvars($_POST['examid'])."'");

		//------------------------------------------------			
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location:".$hrefredirect."", true, 301);
		exit();
	
	}
//--------------------------------------
	
}