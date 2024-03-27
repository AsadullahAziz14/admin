<?php 

// Add Update non Liberal arts Award List
if(isset($_POST['submit_marks'])) { 
	if($_POST['submit_marks'] == 'saveonly') { 
		$forwardto  = $_POST['forward_to']; 	
	} else if($_POST['submit_marks'] == 'saveforward') { 
		$forwardto = "4"; 
	}
//------------------------------------------------
if(empty(removeWhiteSpace($_GET['prgid'])) || empty(removeWhiteSpace($_GET['timing'])) || removeWhiteSpace($_GET['semester']) == '' || empty(removeWhiteSpace($_POST['id_teacher'])) || (count( array_filter($_POST['marks_obtained'])) < 1)) {
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div  class="alert-box error"><span>Oop: </span>Record can not added due to some missing fields.</b></div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
} else {
//------------------------------------------------
if(empty($_POST['id_setup'])) { 
	
$sqllmschecker  = $dblms->querylms("SELECT m.id 
											FROM ".FINALTERM." m 
											WHERE m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										  	AND m.id_prg 	= '".cleanvars($_GET['prgid'])."' 
											AND m.timing 	= '".cleanvars($_GET['timing'])."' 
											AND m.semester 	= '".cleanvars($_GET['semester'])."' 
											AND m.id_teacher 	= '".cleanvars($_POST['id_teacher'])."'
											AND m.section = '".cleanvars($section)."' 
											AND m.theory_practical = '1'
											AND m.is_liberalarts != '1' 
											AND m.id_curs 	= '".cleanvars($_POST['id_curs'])."' LIMIT 1");
	$valuemarks 		= mysqli_fetch_array($sqllmschecker);
if($valuemarks['id']) { 
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>warning: </span>Record already added.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//------------------------------------------------
} else { 
	
// Add Award list
	$data = array(
			'status'		            => '2'							   	, 
			'is_liberalarts'	      	=> '2'			        			, 
			'forward_to'		        => cleanvars($forwardto)		  	, 
			'id_curs'		       		=> cleanvars($_POST['id_curs'])		, 
			'theory_practical'		   	=> '1'	                			,
			'semester'		   			=> cleanvars($_GET['semester'])		,
			'section'		   			=> cleanvars($section)				,
			'timing'		   			=> cleanvars($_GET['timing'])		,
			'id_prg'		   			=> cleanvars($_GET['prgid'])		,
			'id_teacher'		   		=> cleanvars($_POST['id_teacher'])	,
			'dated'		   				=> date("Y-m-d")					,
			'exam_date'		   			=> date('Y-m-d', strtotime($_POST['exam_date']))	,
			'id_teacher'		   		=> cleanvars($_POST['id_teacher'])					,
			'academic_session'	        => cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])	, 
			'id_campus'	        		=> cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])		, 
			'id_added'	        		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])		, 
			'date_added'		        => date("Y-m-d H:i:s")		            					, 
		);
	
	
		$sqllmsInsert  = $dblms->Insert(FINALTERM , $data);

		if($sqllmsInsert) { 

		$idsetup = $dblms->lastestid();

	
//--------------------------------------
	$arraychecked 	= $_POST['id_std'];
	$awarddetails 	= "";
//--------------------------------------
	for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
		
		$datadetails = array(
						'id_finalterm'		    => $idsetup							   				, 
						'id_std'	      		=> cleanvars($_POST['id_std'][$ichk])				, 
						'repeat_migration'		=> cleanvars($_POST['rep_mig'][$ichk])		  		, 
						'assignment'		    => cleanvars($_POST['assignment'][$ichk])			, 
						'assignment_default'	=> cleanvars($_POST['assignment_default'][$ichk])	,
						'quiz'		   			=> cleanvars($_POST['quiz'][$ichk])					,
						'quiz_default'		   	=> cleanvars($_POST['quiz_default'][$ichk])			,
						'attendance'		   	=> cleanvars($_POST['attendance'][$ichk])			,
						'midterm'		   		=> cleanvars($_POST['midterm'][$ichk])				,
						'finalterm'		   		=> cleanvars($_POST['finalterm'][$ichk])			,
						'finalterm_default'		=> cleanvars($_POST['finalterm_default'][$ichk])	,
						'viva'		   			=> cleanvars($_POST['viva'][$ichk])					,
						'marks_obtained'		=> cleanvars($_POST['marks_obtained'][$ichk])		,
						'numerical'	        	=> cleanvars($_POST['numerical'][$ichk])			, 
						'credithour'	        => cleanvars($_POST['credithour'][$ichk])			, 
						'gradepoint'	        => cleanvars($_POST['gradepoint'][$ichk])			, 
						'lettergrade'	        => cleanvars($_POST['lettergrade'][$ichk])			, 
						'remarks'	        	=> cleanvars($_POST['remarks'][$ichk])				, 
					);
			$sqllmsInsertdetails  = $dblms->Insert(FINALTERM_DETAILS , $datadetails);
		
		$awarddetails .= '"Finalterm ID:"		'.'=> '.'"'.$idsetup.'",'."\n";
		$awarddetails .= '"Student ID:"			'.'=> '.'"'.$_POST['id_std'][$ichk].'",'."\n";
		$awarddetails .= '"Repeat Migration:"	'.'=> '.'"'.$_POST['rep_mig'][$ichk].'",'."\n";
		$awarddetails .= '"Assignment"			'.'=> '.'"'.$_POST['assignment'][$ichk].'",'."\n";
		$awarddetails .= '"Assignment Default:"	'.'=> '.'"'.$_POST['assignment_default'][$ichk].'",'."\n";
		$awarddetails .= '"Quiz:"				'.'=> '.'"'.$_POST['quiz'][$ichk].'",'."\n";
		$awarddetails .= '"Quiz Default:"		'.'=> '.'"'.$_POST['quiz_default'][$ichk].'",'."\n";
		$awarddetails .= '"Attendance:"			'.'=> '.'"'.$_POST['attendance'][$ichk].'",'."\n";
		$awarddetails .= '"Midterm:"			'.'=> '.'"'.$_POST['midterm'][$ichk].'",'."\n";
		$awarddetails .= '"Finalterm:"			'.'=> '.'"'.$_POST['finalterm'][$ichk].'",'."\n";
		$awarddetails .= '"Finalterm Default:"	'.'=> '.'"'.$_POST['finalterm_default'][$ichk].'",'."\n";
		$awarddetails .= '"Viva:"				'.'=> '.'"'.$_POST['viva'][$ichk].'",'."\n";
		$awarddetails .= '"Marks Obtained:"		'.'=> '.'"'.$_POST['marks_obtained'][$ichk].'",'."\n";
		$awarddetails .= '"Numerical:"			'.'=> '.'"'.$_POST['numerical'][$ichk].'",'."\n";
		$awarddetails .= '"Credithour:"			'.'=> '.'"'.$_POST['credithour'][$ichk].'",'."\n";
		$awarddetails .= '"Gradepoint:"			'.'=> '.'"'.$_POST['gradepoint'][$ichk].'",'."\n";
		$awarddetails .= '"Lettergrade:"		'.'=> '.'"'.$_POST['lettergrade'][$ichk].'",'."\n";
		$awarddetails .= '"Remarks:"			'.'=> '.'"'.$_POST['remarks'][$ichk].'",'."\n";

//------------------------------------------------
			
		}
			
			
		$detailPrams  = "";
		$detailPrams .= '"ID"					'.'=> '.'"'.$idsetup.'",'."\n";
		$detailPrams .= '"status"				'.'=> '.'"2",'."\n";
		$detailPrams .= '"Liberal Arts"			'.'=> '.'"'.get_yesno12(2).'",'."\n";
		$detailPrams .= '"Course ID"			'.'=> '.'"'.$_POST['id_curs'].'",'."\n";
		$detailPrams .= '"Course Name"			'.'=> '.'"'.$cursename.'",'."\n";
		$detailPrams .= '"Theory Practical		'.'=> '.'"Theory",'."\n";
		$detailPrams .= '"Semester"				'.'=> '.'"'.$_GET['semester'].'",'."\n";
		$detailPrams .= '"Section"				'.'=> '.'"'.$section.'",'."\n";
		$detailPrams .= '"Timing"				'.'=> '.'"'.$_GET['timing'].'",'."\n";
		$detailPrams .= '"Program ID"			'.'=> '.'"'.$_GET['prgid'].'",'."\n";
		$detailPrams .= '"Teacher ID"			'.'=> '.'"'.$_POST['id_teacher'].'",'."\n";
		$detailPrams .= '"Academic Session"		'.'=> '.'"'.$_SESSION['userlogininfo']['LOGINIDADMISSION'].'",'."\n";
		$detailPrams .= '"Awardlist Details:"	'.'=> '.'array('."\n";
		$detailPrams .= $awarddetails."\n";
		$detailPrams .= ")";	
//Query Insert Log
		$logRemarks = 'Add Students Final Term Award List #: '.$idsetup.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$datalog = array(
				'id_user'		    => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])	, 
				'filename'	      	=> basename($_SERVER['REQUEST_URI'])			   		, 
				'id_record'		    => cleanvars($idsetup)		  			, 
				'action'		    => '1'									, 
				'dated'		   		=>  date("Y-m-d H:i:s")	                ,
				'ip'		   		=> $ip.':'.$_SERVER['REMOTE_PORT']		,
				'remarks'		   	=> cleanvars($logRemarks)				,
				'details'		   	=> cleanvars($detailPrams)				,
				'sess_id'		   	=> cleanvars(session_id())				,
				'device_details'	=> cleanvars($devicedetails)			,
				'id_campus'	        => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])		 
			);
		$sqllmslog  = $dblms->Insert(FINALTERM_LOGS , $datalog);
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//------------------------------------------------
}
}
	
// if award list already exist
} else if($_POST['id_setup']) { 
//--------------------------------------

	$data = array(
			'status'		            => '2'							   	, 
			'forward_to'		        => cleanvars($forwardto)		  	, 
			'dated'		   				=> date("Y-m-d")					,
			'exam_date'		   			=> date('Y-m-d', strtotime($_POST['exam_date']))			,
			'id_modify'	        		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])		, 
			'date_modify'		        => date("Y-m-d H:i:s")		            					, 
		);
	
	$sqllmsUpdate = $dblms->Update(FINALTERM, $data, "WHERE id	= '".cleanvars($_POST['id_setup'])."'");
//--------------------------------------
if($sqllmsUpdate) {
	

	
//--------------------------------------
//	$sqllmsdelte  = $dblms->querylms("DELETE FROM ".FINALTERM_DETAILS." WHERE id_finalterm = '".$_POST['id_setup']."'");
//--------------------------------------
	$arraychecked 	= $_POST['id_std'];
	$awarddetails 	= "";
//--------------------------------------
	for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
if(!empty($_POST['id_edit'][$ichk])) {
//------------------------------------------------
		$datadetails = array(
						'repeat_migration'		=> cleanvars($_POST['rep_mig'][$ichk])		  		, 
						'assignment'		    => cleanvars($_POST['assignment'][$ichk])			, 
						'quiz'		   			=> cleanvars($_POST['quiz'][$ichk])					,
						'attendance'		   	=> cleanvars($_POST['attendance'][$ichk])			,
						'midterm'		   		=> cleanvars($_POST['midterm'][$ichk])				,
						'finalterm'		   		=> cleanvars($_POST['finalterm'][$ichk])			,
						'viva'		   			=> cleanvars($_POST['viva'][$ichk])					,
						'marks_obtained'		=> cleanvars($_POST['marks_obtained'][$ichk])		,
						'numerical'	        	=> cleanvars($_POST['numerical'][$ichk])			, 
						'credithour'	        => cleanvars($_POST['credithour'][$ichk])			, 
						'gradepoint'	        => cleanvars($_POST['gradepoint'][$ichk])			, 
						'lettergrade'	        => cleanvars($_POST['lettergrade'][$ichk])			, 
						'remarks'	        	=> cleanvars($_POST['remarks'][$ichk])				, 
					);
		$sqllmsUpdateDetail = $dblms->Update(FINALTERM_DETAILS, $datadetails, "WHERE id	= '".cleanvars($_POST['id_edit'][$ichk])."' AND id_finalterm = '".cleanvars($_POST['id_setup'])."' AND id_std 	= '".cleanvars($_POST['id_std'][$ichk])."'");
	
		$awarddetails .= '"Finalterm ID:"		'.'=> '.'"'.$_POST['id_setup'].'",'."\n";
		$awarddetails .= '"Student ID:"			'.'=> '.'"'.$_POST['id_std'][$ichk].'",'."\n";
		$awarddetails .= '"Repeat Migration:"	'.'=> '.'"'.$_POST['rep_mig'][$ichk].'",'."\n";
		$awarddetails .= '"Assignment"			'.'=> '.'"'.$_POST['assignment'][$ichk].'",'."\n";
		$awarddetails .= '"Quiz:"				'.'=> '.'"'.$_POST['quiz'][$ichk].'",'."\n";
		$awarddetails .= '"Attendance:"			'.'=> '.'"'.$_POST['attendance'][$ichk].'",'."\n";
		$awarddetails .= '"Midterm:"			'.'=> '.'"'.$_POST['midterm'][$ichk].'",'."\n";
		$awarddetails .= '"Finalterm:"			'.'=> '.'"'.$_POST['finalterm'][$ichk].'",'."\n";
		$awarddetails .= '"Viva:"				'.'=> '.'"'.$_POST['viva'][$ichk].'",'."\n";
		$awarddetails .= '"Marks Obtained:"		'.'=> '.'"'.$_POST['marks_obtained'][$ichk].'",'."\n";
		$awarddetails .= '"Numerical:"			'.'=> '.'"'.$_POST['numerical'][$ichk].'",'."\n";
		$awarddetails .= '"Credithour:"			'.'=> '.'"'.$_POST['credithour'][$ichk].'",'."\n";
		$awarddetails .= '"Gradepoint:"			'.'=> '.'"'.$_POST['gradepoint'][$ichk].'",'."\n";
		$awarddetails .= '"Lettergrade:"		'.'=> '.'"'.$_POST['lettergrade'][$ichk].'",'."\n";
		$awarddetails .= '"Remarks:"			'.'=> '.'"'.$_POST['remarks'][$ichk].'",'."\n";
			
} else { 
//------------------------------------------------
		$datadetails = array(
						'id_finalterm'		    => $_POST['id_setup']				   				, 
						'id_std'	      		=> cleanvars($_POST['id_std'][$ichk])				, 
						'repeat_migration'		=> cleanvars($_POST['rep_mig'][$ichk])		  		, 
						'assignment'		    => cleanvars($_POST['assignment'][$ichk])			, 
						'assignment_default'	=> cleanvars($_POST['assignment_default'][$ichk])	,
						'quiz'		   			=> cleanvars($_POST['quiz'][$ichk])					,
						'quiz_default'		   	=> cleanvars($_POST['quiz_default'][$ichk])			,
						'attendance'		   	=> cleanvars($_POST['attendance'][$ichk])			,
						'midterm'		   		=> cleanvars($_POST['midterm'][$ichk])				,
						'finalterm'		   		=> cleanvars($_POST['finalterm'][$ichk])			,
						'finalterm_default'		=> cleanvars($_POST['finalterm_default'][$ichk])	,
						'viva'		   			=> cleanvars($_POST['viva'][$ichk])					,
						'marks_obtained'		=> cleanvars($_POST['marks_obtained'][$ichk])		,
						'numerical'	        	=> cleanvars($_POST['numerical'][$ichk])			, 
						'credithour'	        => cleanvars($_POST['credithour'][$ichk])			, 
						'gradepoint'	        => cleanvars($_POST['gradepoint'][$ichk])			, 
						'lettergrade'	        => cleanvars($_POST['lettergrade'][$ichk])			, 
						'remarks'	        	=> cleanvars($_POST['remarks'][$ichk])				, 
					);
		
		$sqllmsInsertdetails  = $dblms->Insert(FINALTERM_DETAILS , $datadetails);
	
		$awarddetails .= '"Finalterm ID:"		'.'=> '.'"'. $_POST['id_setup'].'",'."\n";
		$awarddetails .= '"Student ID:"			'.'=> '.'"'.$_POST['id_std'][$ichk].'",'."\n";
		$awarddetails .= '"Repeat Migration:"	'.'=> '.'"'.$_POST['rep_mig'][$ichk].'",'."\n";
		$awarddetails .= '"Assignment"			'.'=> '.'"'.$_POST['assignment'][$ichk].'",'."\n";
		$awarddetails .= '"Assignment Default:"	'.'=> '.'"'.$_POST['assignment_default'][$ichk].'",'."\n";
		$awarddetails .= '"Quiz:"				'.'=> '.'"'.$_POST['quiz'][$ichk].'",'."\n";
		$awarddetails .= '"Quiz Default:"		'.'=> '.'"'.$_POST['quiz_default'][$ichk].'",'."\n";
		$awarddetails .= '"Attendance:"			'.'=> '.'"'.$_POST['attendance'][$ichk].'",'."\n";
		$awarddetails .= '"Midterm:"			'.'=> '.'"'.$_POST['midterm'][$ichk].'",'."\n";
		$awarddetails .= '"Finalterm:"			'.'=> '.'"'.$_POST['finalterm'][$ichk].'",'."\n";
		$awarddetails .= '"Finalterm Default:"	'.'=> '.'"'.$_POST['finalterm_default'][$ichk].'",'."\n";
		$awarddetails .= '"Viva:"				'.'=> '.'"'.$_POST['viva'][$ichk].'",'."\n";
		$awarddetails .= '"Marks Obtained:"		'.'=> '.'"'.$_POST['marks_obtained'][$ichk].'",'."\n";
		$awarddetails .= '"Numerical:"			'.'=> '.'"'.$_POST['numerical'][$ichk].'",'."\n";
		$awarddetails .= '"Credithour:"			'.'=> '.'"'.$_POST['credithour'][$ichk].'",'."\n";
		$awarddetails .= '"Gradepoint:"			'.'=> '.'"'.$_POST['gradepoint'][$ichk].'",'."\n";
		$awarddetails .= '"Lettergrade:"		'.'=> '.'"'.$_POST['lettergrade'][$ichk].'",'."\n";
		$awarddetails .= '"Remarks:"			'.'=> '.'"'.$_POST['remarks'][$ichk].'",'."\n";
			
//------------------------------------------------
}
		}
		
		$detailPrams  = "";
		$detailPrams .= '"ID"					'.'=> '.'"'.$_POST['id_setup'].'",'."\n";
		$detailPrams .= '"Status"				'.'=> '.'"2",'."\n";
		$detailPrams .= '"Forward To"			'.'=> '.'"'.$forwardto.'",'."\n";
		$detailPrams .= '"Liberal Arts"			'.'=> '.'"'.get_yesno12(2).'",'."\n";
		$detailPrams .= '"Course ID"			'.'=> '.'"'.$_POST['id_curs'].'",'."\n";
		$detailPrams .= '"Course Name"			'.'=> '.'"'.$cursename.'",'."\n";
		$detailPrams .= '"Theory Practical		'.'=> '.'"Theory",'."\n";
		$detailPrams .= '"Semester"				'.'=> '.'"'.$_GET['semester'].'",'."\n";
		$detailPrams .= '"Section"				'.'=> '.'"'.$section.'",'."\n";
		$detailPrams .= '"Timing"				'.'=> '.'"'.$_GET['timing'].'",'."\n";
		$detailPrams .= '"Program ID"			'.'=> '.'"'.$_GET['prgid'].'",'."\n";
		$detailPrams .= '"Teacher ID"			'.'=> '.'"'.$_POST['id_teacher'].'",'."\n";
		$detailPrams .= '"Academic Session"		'.'=> '.'"'.$_SESSION['userlogininfo']['LOGINIDADMISSION'].'",'."\n";
		$detailPrams .= '"Awardlist Details:"	'.'=> '.'array('."\n";
		$detailPrams .= $awarddetails."\n";
		$detailPrams .= ")";	
//Query Insert Log
		$logRemarks = 'Update Student Final Term Award List #: '.$_POST['id_setup'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$datalog = array(
						'id_user'		    => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])	, 
						'filename'	      	=> basename($_SERVER['REQUEST_URI'])			   		, 
						'id_record'		    => cleanvars($_POST['id_setup'])		  				, 
						'action'		    => '2'									, 
						'dated'		   		=>  date("Y-m-d H:i:s")	                ,
						'ip'		   		=> $ip.':'.$_SERVER['REMOTE_PORT']		,
						'remarks'		   	=> cleanvars($logRemarks)				,
						'details'		   	=> cleanvars($detailPrams)				,
						'sess_id'		   	=> cleanvars(session_id())				,
						'device_details'	=> cleanvars($devicedetails)			,
						'id_campus'	        => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])		 
				);
		$sqllmslog  = $dblms->Insert(FINALTERM_LOGS , $datalog);
//--------------------------------------
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

// Add Update  Liberal arts Award List
if(isset($_POST['submit_lamarks'])) {

	if($_POST['submit_lamarks'] == 'saveonly') { 
		$forwardto  = $_POST['forward_to']; 	
	} else if($_POST['submit_lamarks'] == 'saveforward') { 
		$forwardto = "4"; 
	}

if(empty(removeWhiteSpace($_GET['prgid'])) || empty(removeWhiteSpace($_GET['timing'])) || empty(removeWhiteSpace($_POST['id_teacher'])) || (count( array_filter($_POST['marks_obtained'])) < 1)) {

	$_SESSION['msg']['status'] = '<div  class="alert-box error"><span>Oop: </span>Record can not added due to some missing fields.</b></div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();

} else {
//------------------------------------------------
if(empty($_POST['id_setup'])) { 
	
$sqllmschecker  = $dblms->querylms("SELECT m.id 
											FROM ".FINALTERM." m 
											WHERE m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND m.timing 	= '".cleanvars($_GET['timing'])."' 
											AND m.id_teacher 	= '".cleanvars($_POST['id_teacher'])."'
											AND m.section = '".cleanvars($section)."' 
											AND m.theory_practical = '1'
											AND m.is_liberalarts = '1' 
											AND m.id_curs 	= '".cleanvars($_POST['id_curs'])."' LIMIT 1");
	$valuemarks 		= mysqli_fetch_array($sqllmschecker);
if($valuemarks['id']) { 
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>warning: </span>Record already added.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//------------------------------------------------
} else { 
	
// Add Award list
	$data = array(
			'status'		            => '2'							   	, 
			'is_liberalarts'	      	=> '1'			        			, 
			'forward_to'		        => cleanvars($forwardto)		  	, 
			'id_curs'		       		=> cleanvars($_POST['id_curs'])		, 
			'theory_practical'		   	=> '1'	                			,
			'semester'		   			=> cleanvars($_GET['semester'])		,
			'section'		   			=> cleanvars($section)				,
			'timing'		   			=> cleanvars($_GET['timing'])		,
			'id_teacher'		   		=> cleanvars($_POST['id_teacher'])	,
			'dated'		   				=> date("Y-m-d")					,
			'exam_date'		   			=> date('Y-m-d', strtotime($_POST['exam_date']))	,
			'id_teacher'		   		=> cleanvars($_POST['id_teacher'])					,
			'academic_session'	        => cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])	, 
			'id_campus'	        		=> cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])		, 
			'id_added'	        		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])		, 
			'date_added'		        => date("Y-m-d H:i:s")		            					, 
		);
	
	
		$sqllmsInsert  = $dblms->Insert(FINALTERM , $data);

		if($sqllmsInsert) { 

		$idsetup = $dblms->lastestid();

	
//--------------------------------------
	$arraychecked 	= $_POST['id_std'];
	$awarddetails 	= "";
//--------------------------------------
	for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
		
		$datadetails = array(
						'id_finalterm'		    => $idsetup							   				, 
						'id_std'	      		=> cleanvars($_POST['id_std'][$ichk])				, 
						'repeat_migration'		=> cleanvars($_POST['rep_mig'][$ichk])		  		, 
						'assignment'		    => cleanvars($_POST['assignment'][$ichk])			, 
						'assignment_default'	=> cleanvars($_POST['assignment_default'][$ichk])	,
						'quiz'		   			=> cleanvars($_POST['quiz'][$ichk])					,
						'quiz_default'		   	=> cleanvars($_POST['quiz_default'][$ichk])			,
						'attendance'		   	=> cleanvars($_POST['attendance'][$ichk])			,
						'midterm'		   		=> cleanvars($_POST['midterm'][$ichk])				,
						'finalterm'		   		=> cleanvars($_POST['finalterm'][$ichk])			,
						'finalterm_default'		=> cleanvars($_POST['finalterm_default'][$ichk])	,
						'viva'		   			=> cleanvars($_POST['viva'][$ichk])					,
						'marks_obtained'		=> cleanvars($_POST['marks_obtained'][$ichk])		,
						'numerical'	        	=> cleanvars($_POST['numerical'][$ichk])			, 
						'credithour'	        => cleanvars($_POST['credithour'][$ichk])			, 
						'gradepoint'	        => cleanvars($_POST['gradepoint'][$ichk])			, 
						'lettergrade'	        => cleanvars($_POST['lettergrade'][$ichk])			, 
						'remarks'	        	=> cleanvars($_POST['remarks'][$ichk])				, 
					);
			$sqllmsInsertdetails  = $dblms->Insert(FINALTERM_DETAILS , $datadetails);
		
		$awarddetails .= '"Finalterm ID:"		'.'=> '.'"'.$idsetup.'",'."\n";
		$awarddetails .= '"Student ID:"			'.'=> '.'"'.$_POST['id_std'][$ichk].'",'."\n";
		$awarddetails .= '"Repeat Migration:"	'.'=> '.'"'.$_POST['rep_mig'][$ichk].'",'."\n";
		$awarddetails .= '"Assignment"			'.'=> '.'"'.$_POST['assignment'][$ichk].'",'."\n";
		$awarddetails .= '"Assignment Default:"	'.'=> '.'"'.$_POST['assignment_default'][$ichk].'",'."\n";
		$awarddetails .= '"Quiz:"				'.'=> '.'"'.$_POST['quiz'][$ichk].'",'."\n";
		$awarddetails .= '"Quiz Default:"		'.'=> '.'"'.$_POST['quiz_default'][$ichk].'",'."\n";
		$awarddetails .= '"Attendance:"			'.'=> '.'"'.$_POST['attendance'][$ichk].'",'."\n";
		$awarddetails .= '"Midterm:"			'.'=> '.'"'.$_POST['midterm'][$ichk].'",'."\n";
		$awarddetails .= '"Finalterm:"			'.'=> '.'"'.$_POST['finalterm'][$ichk].'",'."\n";
		$awarddetails .= '"Finalterm Default:"	'.'=> '.'"'.$_POST['finalterm_default'][$ichk].'",'."\n";
		$awarddetails .= '"Viva:"				'.'=> '.'"'.$_POST['viva'][$ichk].'",'."\n";
		$awarddetails .= '"Marks Obtained:"		'.'=> '.'"'.$_POST['marks_obtained'][$ichk].'",'."\n";
		$awarddetails .= '"Numerical:"			'.'=> '.'"'.$_POST['numerical'][$ichk].'",'."\n";
		$awarddetails .= '"Credithour:"			'.'=> '.'"'.$_POST['credithour'][$ichk].'",'."\n";
		$awarddetails .= '"Gradepoint:"			'.'=> '.'"'.$_POST['gradepoint'][$ichk].'",'."\n";
		$awarddetails .= '"Lettergrade:"		'.'=> '.'"'.$_POST['lettergrade'][$ichk].'",'."\n";
		$awarddetails .= '"Remarks:"			'.'=> '.'"'.$_POST['remarks'][$ichk].'",'."\n";

//------------------------------------------------
			
		}
			
			
		$detailPrams  = "";
		$detailPrams .= '"ID"					'.'=> '.'"'.$idsetup.'",'."\n";
		$detailPrams .= '"status"				'.'=> '.'"2",'."\n";
		$detailPrams .= '"Liberal Arts"			'.'=> '.'"'.get_yesno12(1).'",'."\n";
		$detailPrams .= '"Course ID"			'.'=> '.'"'.$_POST['id_curs'].'",'."\n";
		$detailPrams .= '"Course Name"			'.'=> '.'"'.$cursename.'",'."\n";
		$detailPrams .= '"Theory Practical		'.'=> '.'"Theory",'."\n";
		$detailPrams .= '"Semester"				'.'=> '.'"'.$_GET['semester'].'",'."\n";
		$detailPrams .= '"Section"				'.'=> '.'"'.$section.'",'."\n";
		$detailPrams .= '"Timing"				'.'=> '.'"'.$_GET['timing'].'",'."\n";
		$detailPrams .= '"Teacher ID"			'.'=> '.'"'.$_POST['id_teacher'].'",'."\n";
		$detailPrams .= '"Academic Session"		'.'=> '.'"'.$_SESSION['userlogininfo']['LOGINIDADMISSION'].'",'."\n";
		$detailPrams .= '"Awardlist Details:"	'.'=> '.'array('."\n";
		$detailPrams .= $awarddetails."\n";
		$detailPrams .= ")";	
//Query Insert Log
		$logRemarks = 'Add Students Final Term Award List #: '.$idsetup.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$datalog = array(
				'id_user'		    => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])	, 
				'filename'	      	=> basename($_SERVER['REQUEST_URI'])			   		, 
				'id_record'		    => cleanvars($idsetup)		  			, 
				'action'		    => '1'									, 
				'dated'		   		=>  date("Y-m-d H:i:s")	                ,
				'ip'		   		=> $ip.':'.$_SERVER['REMOTE_PORT']		,
				'remarks'		   	=> cleanvars($logRemarks)				,
				'details'		   	=> cleanvars($detailPrams)				,
				'sess_id'		   	=> cleanvars(session_id())				,
				'device_details'	=> cleanvars($devicedetails)			,
				'id_campus'	        => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])		 
			);
		$sqllmslog  = $dblms->Insert(FINALTERM_LOGS , $datalog);
//------------------------------------------------
	$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
//------------------------------------------------
}
}
	
// if award list already exist
} else if($_POST['id_setup']) { 
//--------------------------------------

	$data = array(
			'status'		            => '2'							   	, 
			'forward_to'		        => cleanvars($forwardto)		  	, 
			'dated'		   				=> date("Y-m-d")					,
			'exam_date'		   			=> date('Y-m-d', strtotime($_POST['exam_date']))			,
			'id_modify'	        		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])		, 
			'date_modify'		        => date("Y-m-d H:i:s")		            					, 
		);
	
	$sqllmsUpdate = $dblms->Update(FINALTERM, $data, "WHERE id	= '".cleanvars($_POST['id_setup'])."'");
//--------------------------------------
if($sqllmsUpdate) {
	

	
//--------------------------------------
//	$sqllmsdelte  = $dblms->querylms("DELETE FROM ".FINALTERM_DETAILS." WHERE id_finalterm = '".$_POST['id_setup']."'");
//--------------------------------------
	$arraychecked 	= $_POST['id_std'];
	$awarddetails 	= "";
//--------------------------------------
	for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
if(!empty($_POST['id_edit'][$ichk])) {
//------------------------------------------------
		$datadetails = array(
						'repeat_migration'		=> cleanvars($_POST['rep_mig'][$ichk])		  		, 
						'assignment'		    => cleanvars($_POST['assignment'][$ichk])			, 
						'quiz'		   			=> cleanvars($_POST['quiz'][$ichk])					,
						'attendance'		   	=> cleanvars($_POST['attendance'][$ichk])			,
						'midterm'		   		=> cleanvars($_POST['midterm'][$ichk])				,
						'finalterm'		   		=> cleanvars($_POST['finalterm'][$ichk])			,
						'viva'		   			=> cleanvars($_POST['viva'][$ichk])					,
						'marks_obtained'		=> cleanvars($_POST['marks_obtained'][$ichk])		,
						'numerical'	        	=> cleanvars($_POST['numerical'][$ichk])			, 
						'credithour'	        => cleanvars($_POST['credithour'][$ichk])			, 
						'gradepoint'	        => cleanvars($_POST['gradepoint'][$ichk])			, 
						'lettergrade'	        => cleanvars($_POST['lettergrade'][$ichk])			, 
						'remarks'	        	=> cleanvars($_POST['remarks'][$ichk])				, 
					);
		$sqllmsUpdateDetail = $dblms->Update(FINALTERM_DETAILS, $datadetails, "WHERE id	= '".cleanvars($_POST['id_edit'][$ichk])."' AND id_finalterm = '".cleanvars($_POST['id_setup'])."' AND id_std 	= '".cleanvars($_POST['id_std'][$ichk])."'");
	
		$awarddetails .= '"Finalterm ID:"		'.'=> '.'"'.$_POST['id_setup'].'",'."\n";
		$awarddetails .= '"Student ID:"			'.'=> '.'"'.$_POST['id_std'][$ichk].'",'."\n";
		$awarddetails .= '"Repeat Migration:"	'.'=> '.'"'.$_POST['rep_mig'][$ichk].'",'."\n";
		$awarddetails .= '"Assignment"			'.'=> '.'"'.$_POST['assignment'][$ichk].'",'."\n";
		$awarddetails .= '"Quiz:"				'.'=> '.'"'.$_POST['quiz'][$ichk].'",'."\n";
		$awarddetails .= '"Attendance:"			'.'=> '.'"'.$_POST['attendance'][$ichk].'",'."\n";
		$awarddetails .= '"Midterm:"			'.'=> '.'"'.$_POST['midterm'][$ichk].'",'."\n";
		$awarddetails .= '"Finalterm:"			'.'=> '.'"'.$_POST['finalterm'][$ichk].'",'."\n";
		$awarddetails .= '"Viva:"				'.'=> '.'"'.$_POST['viva'][$ichk].'",'."\n";
		$awarddetails .= '"Marks Obtained:"		'.'=> '.'"'.$_POST['marks_obtained'][$ichk].'",'."\n";
		$awarddetails .= '"Numerical:"			'.'=> '.'"'.$_POST['numerical'][$ichk].'",'."\n";
		$awarddetails .= '"Credithour:"			'.'=> '.'"'.$_POST['credithour'][$ichk].'",'."\n";
		$awarddetails .= '"Gradepoint:"			'.'=> '.'"'.$_POST['gradepoint'][$ichk].'",'."\n";
		$awarddetails .= '"Lettergrade:"		'.'=> '.'"'.$_POST['lettergrade'][$ichk].'",'."\n";
		$awarddetails .= '"Remarks:"			'.'=> '.'"'.$_POST['remarks'][$ichk].'",'."\n";
			
} else { 
//------------------------------------------------
		$datadetails = array(
						'id_finalterm'		    => $_POST['id_setup']				   				, 
						'id_std'	      		=> cleanvars($_POST['id_std'][$ichk])				, 
						'repeat_migration'		=> cleanvars($_POST['rep_mig'][$ichk])		  		, 
						'assignment'		    => cleanvars($_POST['assignment'][$ichk])			, 
						'assignment_default'	=> cleanvars($_POST['assignment_default'][$ichk])	,
						'quiz'		   			=> cleanvars($_POST['quiz'][$ichk])					,
						'quiz_default'		   	=> cleanvars($_POST['quiz_default'][$ichk])			,
						'attendance'		   	=> cleanvars($_POST['attendance'][$ichk])			,
						'midterm'		   		=> cleanvars($_POST['midterm'][$ichk])				,
						'finalterm'		   		=> cleanvars($_POST['finalterm'][$ichk])			,
						'finalterm_default'		=> cleanvars($_POST['finalterm_default'][$ichk])	,
						'viva'		   			=> cleanvars($_POST['viva'][$ichk])					,
						'marks_obtained'		=> cleanvars($_POST['marks_obtained'][$ichk])		,
						'numerical'	        	=> cleanvars($_POST['numerical'][$ichk])			, 
						'credithour'	        => cleanvars($_POST['credithour'][$ichk])			, 
						'gradepoint'	        => cleanvars($_POST['gradepoint'][$ichk])			, 
						'lettergrade'	        => cleanvars($_POST['lettergrade'][$ichk])			, 
						'remarks'	        	=> cleanvars($_POST['remarks'][$ichk])				, 
					);
		
		$sqllmsInsertdetails  = $dblms->Insert(FINALTERM_DETAILS , $datadetails);
	
		$awarddetails .= '"Finalterm ID:"		'.'=> '.'"'. $_POST['id_setup'].'",'."\n";
		$awarddetails .= '"Student ID:"			'.'=> '.'"'.$_POST['id_std'][$ichk].'",'."\n";
		$awarddetails .= '"Repeat Migration:"	'.'=> '.'"'.$_POST['rep_mig'][$ichk].'",'."\n";
		$awarddetails .= '"Assignment"			'.'=> '.'"'.$_POST['assignment'][$ichk].'",'."\n";
		$awarddetails .= '"Assignment Default:"	'.'=> '.'"'.$_POST['assignment_default'][$ichk].'",'."\n";
		$awarddetails .= '"Quiz:"				'.'=> '.'"'.$_POST['quiz'][$ichk].'",'."\n";
		$awarddetails .= '"Quiz Default:"		'.'=> '.'"'.$_POST['quiz_default'][$ichk].'",'."\n";
		$awarddetails .= '"Attendance:"			'.'=> '.'"'.$_POST['attendance'][$ichk].'",'."\n";
		$awarddetails .= '"Midterm:"			'.'=> '.'"'.$_POST['midterm'][$ichk].'",'."\n";
		$awarddetails .= '"Finalterm:"			'.'=> '.'"'.$_POST['finalterm'][$ichk].'",'."\n";
		$awarddetails .= '"Finalterm Default:"	'.'=> '.'"'.$_POST['finalterm_default'][$ichk].'",'."\n";
		$awarddetails .= '"Viva:"				'.'=> '.'"'.$_POST['viva'][$ichk].'",'."\n";
		$awarddetails .= '"Marks Obtained:"		'.'=> '.'"'.$_POST['marks_obtained'][$ichk].'",'."\n";
		$awarddetails .= '"Numerical:"			'.'=> '.'"'.$_POST['numerical'][$ichk].'",'."\n";
		$awarddetails .= '"Credithour:"			'.'=> '.'"'.$_POST['credithour'][$ichk].'",'."\n";
		$awarddetails .= '"Gradepoint:"			'.'=> '.'"'.$_POST['gradepoint'][$ichk].'",'."\n";
		$awarddetails .= '"Lettergrade:"		'.'=> '.'"'.$_POST['lettergrade'][$ichk].'",'."\n";
		$awarddetails .= '"Remarks:"			'.'=> '.'"'.$_POST['remarks'][$ichk].'",'."\n";
			
//------------------------------------------------
}
		}
		
		$detailPrams  = "";
		$detailPrams .= '"ID"					'.'=> '.'"'.$_POST['id_setup'].'",'."\n";
		$detailPrams .= '"Status"				'.'=> '.'"2",'."\n";
		$detailPrams .= '"Forward To"			'.'=> '.'"'.$forwardto.'",'."\n";
		$detailPrams .= '"Liberal Arts"			'.'=> '.'"'.get_yesno12(1).'",'."\n";
		$detailPrams .= '"Course ID"			'.'=> '.'"'.$_POST['id_curs'].'",'."\n";
		$detailPrams .= '"Course Name"			'.'=> '.'"'.$cursename.'",'."\n";
		$detailPrams .= '"Theory Practical		'.'=> '.'"Theory",'."\n";
		$detailPrams .= '"Semester"				'.'=> '.'"'.$_GET['semester'].'",'."\n";
		$detailPrams .= '"Section"				'.'=> '.'"'.$section.'",'."\n";
		$detailPrams .= '"Program ID"			'.'=> '.'"'.$_GET['prgid'].'",'."\n";
		$detailPrams .= '"Teacher ID"			'.'=> '.'"'.$_POST['id_teacher'].'",'."\n";
		$detailPrams .= '"Academic Session"		'.'=> '.'"'.$_SESSION['userlogininfo']['LOGINIDADMISSION'].'",'."\n";
		$detailPrams .= '"Awardlist Details:"	'.'=> '.'array('."\n";
		$detailPrams .= $awarddetails."\n";
		$detailPrams .= ")";	
//Query Insert Log
		$logRemarks = 'Update Student Final Term Award List #: '.$_POST['id_setup'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$datalog = array(
						'id_user'		    => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])	, 
						'filename'	      	=> basename($_SERVER['REQUEST_URI'])			   		, 
						'id_record'		    => cleanvars($_POST['id_setup'])		  				, 
						'action'		    => '2'									, 
						'dated'		   		=>  date("Y-m-d H:i:s")	                ,
						'ip'		   		=> $ip.':'.$_SERVER['REMOTE_PORT']		,
						'remarks'		   	=> cleanvars($logRemarks)				,
						'details'		   	=> cleanvars($detailPrams)				,
						'sess_id'		   	=> cleanvars(session_id())				,
						'device_details'	=> cleanvars($devicedetails)			,
						'id_campus'	        => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])		 
				);
		$sqllmslog  = $dblms->Insert(FINALTERM_LOGS , $datalog);
//--------------------------------------
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