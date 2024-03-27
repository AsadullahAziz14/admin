<?php 
//--------------------------------------
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
											AND m.section = '".cleanvars($_POST['stdsection'])."' 
											AND m.theory_practical = '2' 
											AND m.id_curs 	= '".cleanvars($_POST['id_curs'])."' LIMIT 1");

if(mysqli_num_rows($sqllmschecker)>0) { 
	$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>warning: </span>Record already added.</div>';
	header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
	exit();
} else {

	if(($_GET['prgid'] =='la')) { $isLA = 1;} else {$isLA = 2;}
	
	// Add Award list
	$data = array(
			'status'		            => '2'							   	, 
			'is_liberalarts'	      	=> $isLA			        		, 
			'forward_to'		        => cleanvars($forwardto)		  	, 
			'id_curs'		       		=> cleanvars($_POST['id_curs'])		, 
			'theory_practical'		   	=> '2'	                			,
			'semester'		   			=> cleanvars($_GET['semester'])		,
			'section'		   			=> cleanvars($_POST['stdsection'])	,
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
	

//--------------------------------------
if($sqllmsInsert) {
$idsetup = $dblms->lastestid();
//--------------------------------------
	$logremarks = 'Add Student Practical Award List #: '.$idsetup.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."'		, 
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
		$datadetails = array(
						'id_finalterm'		    => $idsetup							   				, 
						'id_std'	      		=> cleanvars($_POST['id_std'][$ichk])				, 
						'repeat_migration'		=> cleanvars($_POST['rep_mig'][$ichk])		  		, 
						'marks_obtained'		=> cleanvars($_POST['marks_obtained'][$ichk])		,
						'numerical'	        	=> cleanvars($_POST['numerical'][$ichk])			, 
						'credithour'	        => cleanvars($_POST['credithour'][$ichk])			, 
						'gradepoint'	        => cleanvars($_POST['gradepoint'][$ichk])			, 
						'lettergrade'	        => cleanvars($_POST['lettergrade'][$ichk])			, 
						'remarks'	        	=> cleanvars($_POST['remarks'][$ichk])				, 
					);
			$sqllmsInsertdetails  = $dblms->Insert(FINALTERM_DETAILS , $datadetails);
			
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
	
//--------------------------------------
if($sqllmsUpdate) {
//--------------------------------------
	$logremarks = 'Update Student Practical  Award List #: '.$_POST['id_setup'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."'		, 
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
if(!empty($_POST['id_edit'][$ichk])) {
//------------------------------------------------
	$datadetails = array(
						'repeat_migration'		=> cleanvars($_POST['rep_mig'][$ichk])		  		, 
						'marks_obtained'		=> cleanvars($_POST['marks_obtained'][$ichk])		,
						'numerical'	        	=> cleanvars($_POST['numerical'][$ichk])			, 
						'credithour'	        => cleanvars($_POST['credithour'][$ichk])			, 
						'gradepoint'	        => cleanvars($_POST['gradepoint'][$ichk])			, 
						'lettergrade'	        => cleanvars($_POST['lettergrade'][$ichk])			, 
						'remarks'	        	=> cleanvars($_POST['remarks'][$ichk])				, 
					);
		$sqllmsUpdateDetail = $dblms->Update(FINALTERM_DETAILS, $datadetails, "WHERE id	= '".cleanvars($_POST['id_edit'][$ichk])."' AND id_finalterm = '".cleanvars($_POST['id_setup'])."' AND id_std 	= '".cleanvars($_POST['id_std'][$ichk])."'");
						
} else { 
//------------------------------------------------
		$datadetails = array(
						'id_finalterm'		    => $_POST['id_setup']				   				, 
						'id_std'	      		=> cleanvars($_POST['id_std'][$ichk])				, 
						'repeat_migration'		=> cleanvars($_POST['rep_mig'][$ichk])		  		, 
						'marks_obtained'		=> cleanvars($_POST['marks_obtained'][$ichk])		,
						'numerical'	        	=> cleanvars($_POST['numerical'][$ichk])			, 
						'credithour'	        => cleanvars($_POST['credithour'][$ichk])			, 
						'gradepoint'	        => cleanvars($_POST['gradepoint'][$ichk])			, 
						'lettergrade'	        => cleanvars($_POST['lettergrade'][$ichk])			, 
						'remarks'	        	=> cleanvars($_POST['remarks'][$ichk])				, 
					);
			$sqllmsInsertdetails  = $dblms->Insert(FINALTERM_DETAILS , $datadetails);
			
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