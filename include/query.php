<?php 

//--------------------------------------
if(isset($_POST['introduction_add'])) {
	
	//header("Location:courses.php?id=".$_GET['id']."&view=Introduction&add", true, 301);
	//exit();
//------------------------------------------------
	if(cleanvars(removeWhiteSpace($_POST['intro'])) == '') {
	
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Error: </span>The introduction should not be empty.</div>';
		
		header("Location:courses.php?id=".$_GET['id']."&view=Introduction&add", true, 301);
		exit();
		
	} else { 
		
	$sqllmslesson = $dblms->querylms("INSERT INTO ".COURSES_INFO." (
													status								, 
													introduction						, 
													introduction_date					, 
													id_curs								,
													id_teacher							,
													academic_session					,
													id_campus							,
													id_added							, 
													date_added 
												)
	   									VALUES (
													'1'															,
													'".($_POST['intro'])."'			, 
													NOW()														, 
													'".cleanvars($_POST['id_curs'])."'							, 
													'".cleanvars($_POST['id_teacher'])."'						, 
													'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
													'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
													'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
													NOW() 
											  )"
							);
//--------------------------------------
		if($sqllmslesson) { 
		$lessonid = $dblms->lastestid();

	
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
		header("Location:courses.php?id=".$_GET['id']."", true, 301);
		exit();	
	}
}
//--------------------------------------
}

//--------------------------------------
if(isset($_POST['import_introduction'])) {
//------------------------------------------------
	if(cleanvars(removeWhiteSpace($_POST['info_id'])) == '' || cleanvars(removeWhiteSpace($_POST['id_teacher'])) == '') {
	
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Error: </span>Something is missing</div>';
		
		header("Location:courses.php?id=".$_GET['id']."", true, 301);
		exit();
		
	} else { 

		// course info
		$sqllmsInfoArchive  = $dblms->querylms("SELECT status, objectives, introduction, outlines
													FROM ".COURSES_INFO."   										 
													WHERE id 	= '".cleanvars($_POST['info_id'])."' 
													AND id_teacher = '".cleanvars($_POST['id_teacher'])."' LIMIT 1");
		$rowInfoArchive = mysqli_fetch_array($sqllmsInfoArchive);
		
		$sqllmsIntro = $dblms->querylms("INSERT INTO ".COURSES_INFO." (
														status								, 
														objectives							, 
														objectives_date						, 
														introduction						, 
														introduction_date					, 
														outlines							, 
														outlines_date						, 
														id_curs								,
														id_teacher							,
														academic_session					,
														id_campus							,
														id_added							, 
														date_added 
													)
											VALUES (
														'".cleanvars($rowInfoArchive['status'])."'					,
														'".html_entity_decode($rowInfoArchive['objectives'])."'		, 
														NOW()														, 
														'".html_entity_decode($rowInfoArchive['introduction'])."'			, 
														NOW()														, 
														'".html_entity_decode($rowInfoArchive['outlines'])."'				, 
														NOW()														, 
														'".cleanvars($_GET['id'])."'								, 
														'".cleanvars($_POST['id_teacher'])."'						, 
														'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
														'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
														'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
														NOW() 
												)"
								);
//--------------------------------------
		if($sqllmsIntro) { 	
			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."", true, 301);
			exit();	
		}
	}
//--------------------------------------
}


//--------------------------------------
if(isset($_POST['introduction_edit'])) {
	
	//header("Location:courses.php?id=".$_GET['id']."&view=Introduction&add", true, 301);
	//exit();
//------------------------------------------------
	if(cleanvars(removeWhiteSpace($_POST['intro'])) == '') {
	
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Error: </span>The introduction should not be empty.</div>';
		
		header("Location:courses.php?id=".$_GET['id']."&view=Introduction", true, 301);
		exit();
		
	} else { 
		
//------------------------------------------------
$sqllmslesson  = $dblms->querylms("UPDATE ".COURSES_INFO." SET 
														introduction	= '".($_POST['intro'])."'
													  , introduction_date	= NOW() 
													  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
													  , date_modify		= NOW()
												  WHERE id				= '".cleanvars($_POST['editid'])."'");
//--------------------------------------
		if($sqllmslesson) { 
		$lessonid = $dblms->lastestid();

	
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record update successfully.</div>';
		header("Location:courses.php?id=".$_GET['id']."", true, 301);
		exit();	
	}
}
//--------------------------------------
}



//-------------COurse Leanring Outcomes-------------------------
if(isset($_POST['outcomes_submit'])) {
	
	//header("Location:courses.php?id=".$_GET['id']."&view=Introduction&add", true, 301);
	//exit();
//------------------------------------------------
	if(cleanvars(removeWhiteSpace($_POST['outcomes'])) == '') {
	
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Error: </span>The Learning Outcomes should not be empty.</div>';
		
		header("Location:courses.php?id=".$_GET['id']."&view=Outcomes", true, 301);
		exit();
		
	} else { 
	
if($_POST['editid']) {	
//------------------update------------------------------
$sqllmslesson  = $dblms->querylms("UPDATE ".COURSES_INFO." SET 
														outcomes		= '".($_POST['outcomes'])."'
													  , outcomes_date	= NOW() 
													  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
													  , date_modify		= NOW()
												  WHERE id				= '".cleanvars($_POST['editid'])."'");
} else {
	
// Add record
$sqllmslesson = $dblms->querylms("INSERT INTO ".COURSES_INFO." (
													status								, 
													outcomes							, 
													outcomes_date						, 
													id_curs								,
													id_teacher							,
													academic_session					,
													id_campus							,
													id_added							, 
													date_added 
												)
	   									VALUES (
													'1'															,
													'".($_POST['outcomes'])."'		, 
													NOW()														, 
													'".cleanvars($_POST['id_curs'])."'							, 
													'".cleanvars($_POST['id_teacher'])."'						, 
													'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
													'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
													'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
													NOW() 
											  )"
							);
}
//--------------------------------------
		if($sqllmslesson) { 
	
	
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record update successfully.</div>';
		header("Location:courses.php?id=".$_GET['id']."", true, 301);
		exit();	
	}
}
//--------------------------------------
}


//-------------COurse Teaching & Leanring Strategies-------------------------
if(isset($_POST['strategies_submit'])) {
	
	//header("Location:courses.php?id=".$_GET['id']."&view=Introduction&add", true, 301);
	//exit();
//------------------------------------------------
	if(cleanvars(removeWhiteSpace($_POST['strategies'])) == '') {
	
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Error: </span>The Strategies should not be empty.</div>';
		
		header("Location:courses.php?id=".$_GET['id']."&view=Strategies", true, 301);
		exit();
		
	} else { 
	
if($_POST['editid']) {	
//------------------update------------------------------
$sqllmslesson  = $dblms->querylms("UPDATE ".COURSES_INFO." SET 
														strategies		= '".($_POST['strategies'])."'
													  , strategies_date	= NOW() 
													  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
													  , date_modify		= NOW()
												  WHERE id				= '".cleanvars($_POST['editid'])."'");
} else {
	
// Add record
$sqllmslesson = $dblms->querylms("INSERT INTO ".COURSES_INFO." (
													status								, 
													strategies							, 
													strategies_date						, 
													id_curs								,
													id_teacher							,
													academic_session					,
													id_campus							,
													id_added							, 
													date_added 
												)
	   									VALUES (
													'1'															,
													'".($_POST['strategies'])."'		, 
													NOW()														, 
													'".cleanvars($_POST['id_curs'])."'							, 
													'".cleanvars($_POST['id_teacher'])."'						, 
													'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
													'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
													'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
													NOW() 
											  )"
							);
}
//--------------------------------------
		if($sqllmslesson) { 
	
	
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record update successfully.</div>';
		header("Location:courses.php?id=".$_GET['id']."", true, 301);
		exit();	
	}
}
//--------------------------------------
}



//-------------Soft Skills & Personal Effectiveness -------------------------
if(isset($_POST['effectiveness_submit'])) {
	
	//header("Location:courses.php?id=".$_GET['id']."&view=Introduction&add", true, 301);
	//exit();
//------------------------------------------------
	if(cleanvars(removeWhiteSpace($_POST['effectiveness'])) == '') {
	
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Error: </span>The Effectiveness should not be empty.</div>';
		
		header("Location:courses.php?id=".$_GET['id']."&view=Effectiveness", true, 301);
		exit();
		
	} else { 
	
if($_POST['editid']) {	
//------------------update------------------------------
$sqllmslesson  = $dblms->querylms("UPDATE ".COURSES_INFO." SET 
														effectiveness		= '".($_POST['effectiveness'])."'
													  , effectiveness_date	= NOW() 
													  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
													  , date_modify		= NOW()
												  WHERE id				= '".cleanvars($_POST['editid'])."'");
} else {
	
// Add record
$sqllmslesson = $dblms->querylms("INSERT INTO ".COURSES_INFO." (
													status								, 
													effectiveness						, 
													effectiveness_date					, 
													id_curs								,
													id_teacher							,
													academic_session					,
													id_campus							,
													id_added							, 
													date_added 
												)
	   									VALUES (
													'1'															,
													'".($_POST['effectiveness'])."'								, 
													NOW()														, 
													'".cleanvars($_POST['id_curs'])."'							, 
													'".cleanvars($_POST['id_teacher'])."'						, 
													'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
													'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
													'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
													NOW() 
											  )"
							);
}
//--------------------------------------
		if($sqllmslesson) { 
	
	
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record update successfully.</div>';
		header("Location:courses.php?id=".$_GET['id']."", true, 301);
		exit();	
	}
}
//--------------------------------------
}


//-------------COurse Outline-------------------------
if(isset($_POST['outlines_submit'])) {
	
	//header("Location:courses.php?id=".$_GET['id']."&view=Introduction&add", true, 301);
	//exit();
//------------------------------------------------
	if(cleanvars(removeWhiteSpace($_POST['outlines'])) == '') {
	
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Error: </span>The outlines should not be empty.</div>';
		
		header("Location:courses.php?id=".$_GET['id']."&view=Outlines", true, 301);
		exit();
		
	} else { 
	
if($_POST['editid']) {	
//------------------update------------------------------
$sqllmslesson  = $dblms->querylms("UPDATE ".COURSES_INFO." SET 
														outlines		= '".($_POST['outlines'])."'
													  , outlines_date	= NOW() 
													  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
													  , date_modify		= NOW()
												  WHERE id				= '".cleanvars($_POST['editid'])."'");
} else {
	
// Add record
$sqllmslesson = $dblms->querylms("INSERT INTO ".COURSES_INFO." (
													status								, 
													outlines							, 
													outlines_date						, 
													id_curs								,
													id_teacher							,
													academic_session					,
													id_campus							,
													id_added							, 
													date_added 
												)
	   									VALUES (
													'1'															,
													'".($_POST['outlines'])."'		, 
													NOW()														, 
													'".cleanvars($_POST['id_curs'])."'							, 
													'".cleanvars($_POST['id_teacher'])."'						, 
													'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
													'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
													'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
													NOW() 
											  )"
							);
}
//--------------------------------------
		if($sqllmslesson) { 
	
	
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record update successfully.</div>';
		header("Location:courses.php?id=".$_GET['id']."", true, 301);
		exit();	
	}
}
//--------------------------------------
}

//-------------COurse objectives-------------------------
if(isset($_POST['objectives_submit'])) {
	
	//header("Location:courses.php?id=".$_GET['id']."&view=Introduction&add", true, 301);
	//exit();
//------------------------------------------------
	if(cleanvars(removeWhiteSpace($_POST['objectives'])) == '') {
	
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Error: </span>The objectives should not be empty.</div>';
		
		header("Location:courses.php?id=".$_GET['id']."&view=Objectives", true, 301);
		exit();
		
	} else { 
	
if($_POST['editid']) {	
//------------------update------------------------------
$sqllmslesson  = $dblms->querylms("UPDATE ".COURSES_INFO." SET 
														objectives		= '".($_POST['objectives'])."'
													  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
													  , objectives_date	= NOW()
													  , date_modify		= NOW()
												  WHERE id				= '".cleanvars($_POST['editid'])."'");
} else {
	
// Add record
$sqllmslesson = $dblms->querylms("INSERT INTO ".COURSES_INFO." (
													status								, 
													objectives							, 
													objectives_date						, 
													id_curs								,
													id_teacher							,
													academic_session					,
													id_campus							,
													id_added							, 
													date_added 
												)
	   									VALUES (
													'1'															,
													'".($_POST['objectives'])."'		, 
													NOW()														, 
													'".cleanvars($_POST['id_curs'])."'							, 
													'".cleanvars($_POST['id_teacher'])."'						, 
													'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
													'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
													'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
													NOW() 
											  )"
							);
}
//--------------------------------------
		if($sqllmslesson) { 
	
	
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record update successfully.</div>';
		header("Location:courses.php?id=".$_GET['id']."", true, 301);
		exit();	
	}
}
//--------------------------------------
}

