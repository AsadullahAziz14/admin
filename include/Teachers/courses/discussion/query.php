<?php 
//--------------------------------------
if(isset($_POST['submit_discussion'])) { 
//------------------------------------------------
	$sqllmsCheck  = $dblms->querylms("SELECT topic_id   
										FROM ".COURSES_DISTOPIC." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' 
										AND topic_title = '".cleanvars($_POST['title'])."' 
										AND topic_weekno = '".cleanvars($_POST['week'])."' LIMIT 1");
//------------------------------------------------
	if(mysqli_num_rows($sqllmsCheck) > 0) { 
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>Record already exists.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=Discussion", true, 301);
		exit();
	} else {
		$sqllmsTopic  = $dblms->querylms("INSERT INTO ".COURSES_DISTOPIC." (
																topic_status			, 
																topic_title				, 
																topic_detail			,
																topic_weekno			,
																topic_startdate			,
																topic_enddate			,
																topic_minwords			,
																id_curs					,
																id_teacher				,
																academic_session		,
																id_campus				,
																id_added				, 
																date_added 
															)
													VALUES (
															'".cleanvars($_POST['status'])."'			,
															'".cleanvars($_POST['title'])."'			,
															'".cleanvars($_POST['detail'])."'			, 
															'".cleanvars($_POST['week'])."'				, 
															'".date("Y-m-d", strtotime(cleanvars($_POST['start_date'])))."'		, 
															'".date("Y-m-d", strtotime(cleanvars($_POST['end_date'])))."'		, 
															'".cleanvars($_POST['min_words'])."'		, 
															'".cleanvars($_POST['id_curs'])."'			, 
															'".cleanvars($rowsstd['emply_id'])."'		, 
															'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
															'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
															NOW() 
														)"
								);
		//--------------------------------------
		if($sqllmsTopic) {

			$lastid  = $dblms->lastestid();
			$topicprograms = "\n";

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
					$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_DISTOPICPROGRAM." (
																						id_topic				, 
																						id_prg					, 
																						semester				,
																						section					,
																						timing							
																				)
																			VALUES (
																						'".cleanvars($lastid)."'	,
																						'".cleanvars($idprg)."'		,
																						'".cleanvars($semester)."'	, 
																						'".cleanvars($section)."'	, 
																						'".cleanvars($timing)."'		 
																						
																				)"
											);
					//--------------------------------------
					$topicprograms 	.= '"id_prg:"'.'=>'.'"'.($idprg).'",'."\n";
					$topicprograms 	.= '"semester:"'.'=>'.'"'.($semester).'",'."\n";
					$topicprograms 	.= '"section:"'.'=>'.'"'.($section).'",'."\n";
					$topicprograms 	.= '"timing:"'.'=>'.'"'.($timing).'"'."\n";
				}
			//--------------------------------------
			}
			
				
//--------------------------------------
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$lastid.'",'."\n";
			$requestedvars .= '"topic_status:"'.'=>'.'"'.$_POST['status'].'",'."\n";
			$requestedvars .= '"topic_title:"'.'=>'.'"'.$_POST['title'].'",'."\n";
			$requestedvars .= '"topic_detail:"'.'=>'.'"'.($_POST['detail']).'",'."\n";
			$requestedvars .= '"topic_weekno:"'.'=>'.'"'.($_POST['week']).'",'."\n";
			$requestedvars .= '"topic_startdate:"'.'=>'.'"'.$_POST['start_date'].'",'."\n";
			$requestedvars .= '"topic_enddate:"'.'=>'.'"'.$_POST['end_date'].'",'."\n";
			$requestedvars .= '"topic_minwords:"'.'=>'.'"'.($_POST['min_words']).'",'."\n";
			$requestedvars .= '"id_teacher:"'.'=>'.'"'.$rowsstd['emply_id'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"topic_programs:"'.'=>'.'array('."\n";
			$requestedvars .= $topicprograms."\n";
			$requestedvars .= ")\n";
//--------------------------------------
		$logremarks = 'Add Discussion Topic  for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			header("Location:courses.php?id=".$_GET['id']."&view=Discussion", true, 301);
			exit();
			
		}

	}
	//--------------------------------------
}
//end if isset check------------------------


//--------------------------------------
if(isset($_POST['changes_discussion'])) { 
//------------------------------------------------
	$sqllmsTopic  = $dblms->querylms("UPDATE ".COURSES_DISTOPIC." SET 
												topic_status	= '".cleanvars($_POST['status'])."'
											  , topic_title		= '".cleanvars($_POST['title'])."'
											  , topic_detail	= '".cleanvars($_POST['detail'])."' 
											  , topic_weekno	= '".cleanvars($_POST['weekno'])."' 
											  , topic_startdate	= '".date("Y-m-d", strtotime(cleanvars($_POST['start_date'])))."' 
											  , topic_enddate	= '".date("Y-m-d", strtotime(cleanvars($_POST['end_date'])))."'
											  , topic_minwords	= '".cleanvars($_POST['min_words'])."' 
											  , id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
											  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
											  , date_modify		= NOW()
										WHERE   topic_id		= '".cleanvars($_POST['editid'])."'");
//------------------------------------
	if($sqllmsTopic) {
			$topicprograms = '';
		if(!empty(sizeof($_POST['idprg']))) {
			$sqllmsdelte  = $dblms->querylms("DELETE FROM ".COURSES_DISTOPICPROGRAM." WHERE id_topic = '".cleanvars($_POST['editid'])."'");
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
			$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_DISTOPICPROGRAM." (
																				id_topic				, 
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
				$topicprograms 	.= '"id_prg:"'.'=>'.'"'.($idprg).'",'."\n";
				$topicprograms 	.= '"semester:"'.'=>'.'"'.($semester).'",'."\n";
				$topicprograms 	.= '"section:"'.'=>'.'"'.($section).'",'."\n";
				$topicprograms 	.= '"timing:"'.'=>'.'"'.($timing).'"'."\n";
			}
		//--------------------------------------
		}
		//--------------------------------------

				
//--------------------------------------
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$_POST['editid'].'",'."\n";
			$requestedvars .= '"topic_status:"'.'=>'.'"'.$_POST['status'].'",'."\n";
			$requestedvars .= '"topic_title:"'.'=>'.'"'.$_POST['title'].'",'."\n";
			$requestedvars .= '"topic_detail:"'.'=>'.'"'.($_POST['detail']).'",'."\n";
			$requestedvars .= '"topic_weekno:"'.'=>'.'"'.($_POST['week']).'",'."\n";
			$requestedvars .= '"topic_startdate:"'.'=>'.'"'.$_POST['start_date'].'",'."\n";
			$requestedvars .= '"topic_enddate:"'.'=>'.'"'.$_POST['end_date'].'",'."\n";
			$requestedvars .= '"topic_minwords:"'.'=>'.'"'.($_POST['min_words']).'",'."\n";
			$requestedvars .= '"id_teacher:"'.'=>'.'"'.$rowsstd['emply_id'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"topic_programs:"'.'=>'.'array('."\n";
			$requestedvars .= $topicprograms."\n";
			$requestedvars .= ")\n";
//--------------------------------------
		$logremarks = 'Update Discussion Topic  for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
		header("Location:courses.php?id=".$_GET['id']."&view=Discussion", true, 301);
		exit();
		
	}
//--------------------------------------
}

//--------------------------------------
if(isset($_POST['changes_discussionreply'])) { 
	
	$sqllmsdiss  = $dblms->querylms("SELECT ds.reply  
											FROM ".COURSES_DISCUSSION." ds
											WHERE ds.id = '".cleanvars($_POST['dscussid_edit'])."' ");
	$itemstd 	= mysqli_fetch_array($sqllmsdiss);
	
	if(removeWhiteSpace($_POST['reply_edit']) != ($itemstd['reply'])) { 
		
		$updatereply 	= ", reply      = '".$_POST['reply_edit']."'";	
		$updaterepdats 	= ", reply_date = NOW()
						   , reply_id   = '".$_SESSION['userlogininfo']['LOGINIDA']."'";	
		
	} else {
		
		$updatereply 	= "";
		$updaterepdats 	= "";
		
	}
	
//------------------------------------------------
	$sqllmsTopic  = $dblms->querylms("UPDATE ".COURSES_DISCUSSION." SET 
												status			= '".cleanvars($_POST['status_edit'])."'
											  , publish			= '".cleanvars($_POST['publish_edit'])."'
											  $updatereply
											  , rating			= '".cleanvars($_POST['rating_edit'])."' 
											  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
											  , date_modify		= NOW()
											  $updaterepdats
										WHERE   id				= '".cleanvars($_POST['dscussid_edit'])."'");
//------------------------------------
	if($sqllmsTopic) {

//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location:".$_SERVER['HTTP_REFERER'], true, 301);
		exit();
	
	}
//--------------------------------------
}
//--------------------------------------