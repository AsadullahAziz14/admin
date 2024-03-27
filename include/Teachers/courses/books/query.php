<?php 


//---------Add Book-----------------------------
if(isset($_POST['submit_book'])) { 
$sqllmschecker  = $dblms->querylms("SELECT *   
										FROM ".COURSES_BOOKS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND book_name = '".cleanvars($_POST['book_name'])."'
										AND author_name = '".cleanvars($_POST['author_name'])."'  LIMIT 1");
	if(mysqli_num_rows($sqllmschecker)>0) { 
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>record already exists.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=Books", true, 301);
		//header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	} else { 
//------------------------------------------------
	$sqllmsbook  = $dblms->querylms("INSERT INTO ".COURSES_BOOKS." (
																		status								, 
																		book_name							, 
																		author_name							,
																		edition								,
																		isbn								,
																		publisher							,
																		url									,
																		id_curs								,
																		id_teacher							,
																		academic_session					,
																		id_campus							,
																		id_added							, 
																		date_added 
																   )
	   														VALUES (
																		'".cleanvars($_POST['status'])."'			,
																		'".cleanvars($_POST['book_name'])."'		,
																		'".cleanvars($_POST['author_name'])."'		, 
																		'".cleanvars($_POST['edition'])."'			, 
																		'".cleanvars($_POST['isbn'])."'				, 
																		'".cleanvars($_POST['publisher'])."'		, 
																		'".cleanvars($_POST['url'])."'				, 
																		'".cleanvars($_POST['id_curs'])."'			,
																		'".cleanvars($rowsstd['emply_id'])."'		, 
																		'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 	,
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 			,
																		'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	, 
																		NOW() 
													 			 )"
							);
//--------------------------------------
if($sqllmsbook) {
	$idbook = $dblms->lastestid();
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
	$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_BOOKSPROGRAM." (
																		id_setup				, 
																		id_prg					, 
																		semester				,
																		section					,
																		timing							
																   )
	   														VALUES (
																		'".cleanvars($idbook)."'	,
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
			$requestedvars .= '"ID:"'.'=>'.'"'.$idbook.'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status'].'",'."\n";
			$requestedvars .= '"Book Name:"'.'=>'.'"'.$_POST['book_name'].'",'."\n";
			$requestedvars .= '"Author Name:"'.'=>'.'"'.$_POST['author_name'].'",'."\n";
			$requestedvars .= '"Edition:"'.'=>'.'"'.$_POST['edition'].'",'."\n";
			$requestedvars .= '"isbn:"'.'=>'.'"'.$_POST['isbn'].'",'."\n";
			$requestedvars .= '"publisher:"'.'=>'.'"'.$_POST['publisher'].'",'."\n";
			$requestedvars .= '"url:"'.'=>'.'"'.$_POST['url'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'",'."\n";
			$requestedvars .= '"programs:"'.'=>'.'array('."\n";
			$requestedvars .= $topicprograms."\n";
			$requestedvars .= ")\n";
//--------------------------------------
	$logremarks = 'Add Reference Book: '.$idbook.'-'.$_POST['book_name'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."&view=Books", true, 301);
			exit();
		}
	}
//--------------------------------------
}

//------------Update Detail--------------------------
if(isset($_POST['changes_detailbook'])) { 
//------------------------------------------------
$sqllmsbook  = $dblms->querylms("UPDATE ".COURSES_BOOKS." SET 
															status			= '".cleanvars($_POST['status'])."'
														  , book_name		= '".cleanvars($_POST['book_name'])."'
														  , author_name		= '".cleanvars($_POST['author_name'])."' 
														  , edition			= '".cleanvars($_POST['edition'])."' 
														  , isbn			= '".cleanvars($_POST['isbn'])."' 
														  , publisher		= '".cleanvars($_POST['publisher'])."' 
														  , url				= '".cleanvars($_POST['url'])."' 
														  , id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
														  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														  , date_modify		= NOW()
													  WHERE id				= '".cleanvars($_POST['editid'])."'");
//--------------------------------------
		if($sqllmsbook) {
			$topicprograms = '';
//--------------------------------------
if(!empty(sizeof($_POST['idprg']))) {
$sqllmsdelte  = $dblms->querylms("DELETE FROM ".COURSES_BOOKSPROGRAM." WHERE id_setup = '".cleanvars($_POST['editid'])."'");
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
	$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_BOOKSPROGRAM." (
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
			$requestedvars .= '"Book Name:"'.'=>'.'"'.$_POST['book_name'].'",'."\n";
			$requestedvars .= '"Author Name:"'.'=>'.'"'.$_POST['author_name'].'",'."\n";
			$requestedvars .= '"Edition:"'.'=>'.'"'.$_POST['edition'].'",'."\n";
			$requestedvars .= '"isbn:"'.'=>'.'"'.$_POST['isbn'].'",'."\n";
			$requestedvars .= '"publisher:"'.'=>'.'"'.$_POST['publisher'].'",'."\n";
			$requestedvars .= '"url:"'.'=>'.'"'.$_POST['url'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'",'."\n";
			$requestedvars .= '"programs:"'.'=>'.'array('."\n";
			$requestedvars .= $topicprograms."\n";
			$requestedvars .= ")\n";
//--------------------------------------
	$logremarks = 'Update Reference Book:'.$_POST['editid'].'-'.$_POST['book_name_edit'].'for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			header("Location:courses.php?id=".$_GET['id']."&view=Books", true, 301);
			exit();
		}
//--------------------------------------
}

//------------Quick Update--------------------------
if(isset($_POST['changes_book'])) { 
//------------------------------------------------
$sqllmsbook  = $dblms->querylms("UPDATE ".COURSES_BOOKS." SET 
															status			= '".cleanvars($_POST['status_edit'])."'
														  , book_name		= '".cleanvars($_POST['book_name_edit'])."'
														  , author_name		= '".cleanvars($_POST['author_name_edit'])."' 
														  , edition			= '".cleanvars($_POST['edition_edit'])."' 
														  , isbn			= '".cleanvars($_POST['isbn_edit'])."' 
														  , publisher		= '".cleanvars($_POST['publisher_edit'])."' 
														  , url				= '".cleanvars($_POST['url_edit'])."' 
														  , id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
														  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														  , date_modify		= NOW()
													  WHERE id				= '".cleanvars($_POST['bookid_edit'])."'");
//--------------------------------------
		if($sqllmsbook) {
//--------------------------------------
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$_POST['bookid_edit'].'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status_edit'].'",'."\n";
			$requestedvars .= '"Book Name:"'.'=>'.'"'.$_POST['book_name_edit'].'",'."\n";
			$requestedvars .= '"Author Name:"'.'=>'.'"'.$_POST['author_name_edit'].'",'."\n";
			$requestedvars .= '"Edition:"'.'=>'.'"'.$_POST['edition_edit'].'",'."\n";
			$requestedvars .= '"isbn:"'.'=>'.'"'.$_POST['isbn_edit'].'",'."\n";
			$requestedvars .= '"publisher:"'.'=>'.'"'.$_POST['publisher_edit'].'",'."\n";
			$requestedvars .= '"url:"'.'=>'.'"'.$_POST['url_edit'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'"';
//--------------------------------------
	$logremarks = 'Update Reference Book:'.$_POST['bookid_edit'].'-'.$_POST['book_name_edit'].'for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			header("Location:courses.php?id=".$_GET['id']."&view=Books", true, 301);
			exit();
		}
//--------------------------------------
	}


//--------------------------------------
if(isset($_POST['import_books'])) { 
//------------------------------------------------
$checkbox = $_POST['bookarchive'];
for($i=0;$i<count($_POST['bookarchive']);$i++) {
$del_id = $checkbox[$i];
	$sqllmschecker  = $dblms->querylms("SELECT *  
										FROM ".COURSES_BOOKS." 
										WHERE id = '".cleanvars($del_id)."' LIMIT 1");
if(mysqli_num_rows($sqllmschecker)>0) { 
	$valuearachive = mysqli_fetch_array($sqllmschecker);
	$sqllmsbook  = $dblms->querylms("INSERT INTO ".COURSES_BOOKS." (
																		status								, 
																		book_name							, 
																		author_name							,
																		edition								,
																		isbn								,
																		publisher							,
																		url									,
																		id_curs								,
																		id_teacher							,
																		academic_session					,
																		id_campus							,
																		id_added							, 
																		date_added 
																   )
	   														VALUES (
																		'".cleanvars($valuearachive['status'])."'			,
																		'".cleanvars($valuearachive['book_name'])."'		,
																		'".cleanvars($valuearachive['author_name'])."'		, 
																		'".cleanvars($valuearachive['edition'])."'			, 
																		'".cleanvars($valuearachive['isbn'])."'				, 
																		'".cleanvars($valuearachive['publisher'])."'		, 
																		'".cleanvars($valuearachive['url'])."'				, 
																		'".cleanvars($_GET['id'])."'						,
																		'".cleanvars($rowsstd['emply_id'])."'				, 
																		'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 	,
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 			,
																		'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	, 
																		NOW() 
													 			 )"
							);
//--------------------------------------
		if($sqllmsbook) { 
		$lessonid = $dblms->lastestid();
//--------------------------------------
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$lessonid.'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$valuearachive['status'].'",'."\n";
			$requestedvars .= '"Book Name:"'.'=>'.'"'.$valuearachive['book_name'].'",'."\n";
			$requestedvars .= '"Author Name:"'.'=>'.'"'.$valuearachive['author_name'].'",'."\n";
			$requestedvars .= '"Edition:"'.'=>'.'"'.$valuearachive['edition'].'",'."\n";
			$requestedvars .= '"isbn:"'.'=>'.'"'.$valuearachive['isbn'].'",'."\n";
			$requestedvars .= '"publisher:"'.'=>'.'"'.$valuearachive['publisher'].'",'."\n";
			$requestedvars .= '"url:"'.'=>'.'"'.$valuearachive['url'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'"';
//--------------------------------------
		$logremarks = 'Add Book #: '.$lessonid.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
	if($sqllmsbook) { 
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record has been successfully Import.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=Books", true, 301);
		exit();	
	}
//--------------------------------------
}
