<?php 
//--------------------------------------
if(isset($_POST['submit_password'])) { 
//------------------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".ADMINS." SET adm_userpass		= '".md5(cleanvars($_POST['new_password']))."'  
 													, adm_restpassdate	= NOW()
												WHERE adm_id			= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'");
//--------------------------------------
	if($sqllms) {
//--------------------------------------
		$_SESSION['msg']['status'] = '<div class="alert-box success notice col-lg-6"><span>success: </span>Password updated successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	}
//--------------------------------------
}

//-------------------Update-------------------
if(isset($_POST['submit_changes'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".EMPLYS." SET emply_regno				= '".cleanvars($_POST['emply_regno_edit'])."'
												, emply_name				= '".cleanvars($_POST['emply_name_edit'])."'
												, emply_fathername			= '".cleanvars($_POST['emply_fathername_edit'])."'
												, emply_cnic				= '".cleanvars($_POST['emply_cnic_edit'])."'
												, emply_dob					= '".cleanvars($_POST['emply_dob_edit'])."'
												, emply_postal_address		= '".cleanvars($_POST['emply_postal_address_edit'])."'
												, emply_permanent_address	= '".cleanvars($_POST['emply_permanent_address_edit'])."'
												, emply_phone				= '".cleanvars($_POST['emply_phone_edit'])."'
												, emply_mobile				= '".cleanvars($_POST['emply_mobile_edit'])."'
												, emply_email				= '".cleanvars($_POST['emply_email_edit'])."'
												, emply_date_modify			= NOW()
												, id_campus					= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
											WHERE emply_id					= '".cleanvars($_POST['emply_id'])."'");
//--------------------------------------
if(!empty($_FILES['emply_photo']['name'])) { 
//--------------------------------------
	$img_dir		= "images/employees/";
	$img 			= explode('.', $_FILES['emply_photo']['name']);
	$originalImage	= $img_dir.to_seo_url(cleanvars($_POST['emply_name_edit'])).'_'.$_POST['emply_id'].".".strtolower($img[1]);
	$img_fileName	= to_seo_url(cleanvars($_POST['emply_name_edit'])).'_'.$_POST['emply_id'].".".strtolower($img[1]);
	$extension 		= strtolower($img[1]);
//--------------------------------------
	if(in_array($extension , array('jpg','jpeg', 'gif', 'png'))) { 
//--------------------------------------
		$sqllmsupload  = $dblms->querylms("UPDATE ".EMPLYS."
														SET emply_photo = '".$img_fileName."'
												 WHERE  emply_id		= '".cleanvars($_POST['emply_id'])."'");
		unset($sqllmsupload);
		$mode = '0644'; 

 unset($_SESSION['userlogininfo']['LOGINIDAPIC']);
 
 $_SESSION['userlogininfo']['LOGINIDAPIC'] = $originalImage;
//--------------------------------------	
		move_uploaded_file($_FILES['emply_photo']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
//--------------------------------------
	}
//--------------------------------------
}
//--------------------------------------
	if($sqllms) { 
		$_SESSION['msg']['status'] = '<div class="alert-box notice col-lg-6"><span>success: </span>Record update successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	}
//--------------------------------------
}

// edducation

//--------------------------------------
if(isset($_POST['submit_education'])) { 
//------------------------------------------------
	$sqllms  = $dblms->querylms("INSERT INTO ".EMPLYS_EDUCATION." (
																		status								, 
																		id_employee							, 
																		id_degree							,
																		program								,
																		subjects							,
																		institute							,
																		grade								,
																		year								,
																		id_campus
																   )
	   														VALUES (
																		'1'												, 
																		'".cleanvars($rowempid['emply_id'])."'		, 
																		'".cleanvars($_POST['id_degree'])."'			,
																		'".cleanvars($_POST['program'])."'				, 
																		'".cleanvars($_POST['subjects'])."'				, 
																		'".cleanvars($_POST['institute'])."'			, 
																		'".cleanvars($_POST['grade'])."'				, 
																		'".cleanvars($_POST['year'])."'					, 
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."'
													 			 )"
							);
//--------------------------------------
		if($sqllms) {
			$id = $dblms->lastestid();
//--------------------------------------
if(!empty($_FILES['resultcard']['name'])) { 
//--------------------------------------
	$img_dir		= "images/employees-documents/";
	$img 			= explode('.', $_FILES['resultcard']['name']);
	$originalImage	= $img_dir.to_seo_url(cleanvars($_POST['program'])).'_'.LMS_EPOCH.'_'.$id.".".strtolower($img[1]);
	$img_fileName	= to_seo_url(cleanvars($_POST['program'])).'_'.LMS_EPOCH.'_'.$id.".".strtolower($img[1]);
	$extension 		= strtolower($img[1]);
//--------------------------------------
	if(in_array($extension , array('jpg','jpeg', 'gif', 'png', 'pdf'))) { 
//--------------------------------------
		$sqllmsupload  = $dblms->querylms("UPDATE ".EMPLYS_EDUCATION."
														SET resultcard = '".$img_fileName."'
												 WHERE  id		= '".cleanvars($id)."'");
		unset($sqllmsupload);
		$mode = '0644'; 
//--------------------------------------	
		move_uploaded_file($_FILES['resultcard']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
//--------------------------------------
	}
//--------------------------------------
}
		$_SESSION['msg']['status'] = '<div class="col-lg-9">
										<div class="alert-box success"><span>success: </span>Record added successfully.</div>
									</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	}
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['changes_education'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".EMPLYS_EDUCATION." SET  id_employee	= '".cleanvars($rowempid['emply_id'])."' 
															, id_degree		= '".cleanvars($_POST['id_degree_edit'])."'
															, program		= '".cleanvars($_POST['program_edit'])."'
															, subjects		= '".cleanvars($_POST['subjects_edit'])."'
															, institute		= '".cleanvars($_POST['institute_edit'])."'
															, grade			= '".cleanvars($_POST['grade_edit'])."'
															, year			= '".cleanvars($_POST['year_edit'])."'
															, id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
														WHERE id			= '".cleanvars($_POST['eduid_edit'])."'");
//--------------------------------------
		if($sqllms) {
//--------------------------------------
if(!empty($_FILES['resultcard']['name'])) { 
//--------------------------------------
	$img_dir		= "images/employees-documents/";
	$img 			= explode('.', $_FILES['resultcard']['name']);
	$originalImage	= $img_dir.to_seo_url(cleanvars($_POST['program_edit'])).'_'.LMS_EPOCH.'_'.$_POST['eduid_edit'].".".strtolower($img[1]);
	$img_fileName	= to_seo_url(cleanvars($_POST['program_edit'])).'_'.LMS_EPOCH.'_'.$_POST['eduid_edit'].".".strtolower($img[1]);
	$extension 		= strtolower($img[1]);
//--------------------------------------
	if(in_array($extension , array('jpg','jpeg', 'gif', 'png', 'pdf'))) { 
//--------------------------------------
		$sqllmsupload  = $dblms->querylms("UPDATE ".EMPLYS_EDUCATION."
														SET resultcard = '".$img_fileName."'
												 WHERE  id		= '".cleanvars($_POST['eduid_edit'])."'");
		unset($sqllmsupload);
		$mode = '0644'; 
//--------------------------------------	
		move_uploaded_file($_FILES['resultcard']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
//--------------------------------------
	}
//--------------------------------------
}
			$_SESSION['msg']['status'] = '<div class="col-lg-9">
											<div class="alert-box notice "><span>success: </span>Record update successfully.</div>
										</div>';
			header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
			exit();
		}
//--------------------------------------
	}
	
//-------ACHIEVEMENT------------------------------
if(isset($_POST['submit_achi'])) { 
//------------------------------------------------
	$sqllms  = $dblms->querylms("INSERT INTO ".EMPLYS_ACHIEVEMENT." (
																		status								, 
																		id_employee							, 
																		title								,
																		organization						,
																		dated								,
																		detail								,
																		id_campus
																   )
	   														VALUES (
																		'1'											, 
																		'".cleanvars($rowempid['emply_id'])."'		, 
																		'".cleanvars($_POST['title'])."'			, 
																		'".cleanvars($_POST['organization'])."'		, 
																		'".cleanvars($_POST['dated'])."'			, 
																		'".cleanvars($_POST['detail'])."'			,
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."'
													 			 )"
							);
//--------------------------------------
		if($sqllms) {
			$_SESSION['msg']['status'] = '<div class="col-lg-9">
											<div class="alert-box success"><span>success: </span>Record added successfully.</div>
										</div>';
			header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
			exit();
		}
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['changes_achi'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".EMPLYS_ACHIEVEMENT." SET id_employee	= '".cleanvars($rowempid['emply_id'])."' 
															 , title		= '".cleanvars($_POST['title_edit'])."'
															 , organization	= '".cleanvars($_POST['organization_edit'])."'
															 , dated		= '".cleanvars($_POST['dated_edit'])."'
															 , detail		= '".cleanvars($_POST['detail_edit'])."'
															 , id_campus	= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
														 WHERE id			= '".cleanvars($_POST['achid_edit'])."'");
//--------------------------------------
		if($sqllms) {
			$_SESSION['msg']['status'] = '<div class="col-lg-9">
											<div class="alert-box notice "><span>success: </span>Record update successfully.</div>
										</div>';
			header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
			exit();
		}
//--------------------------------------
	}

// experince
//--------------------------------------
if(isset($_POST['submit_exp'])) { 
//------------------------------------------------
	$sqllms  = $dblms->querylms("INSERT INTO ".EMPLYS_EXPERIENCE." (
																		status								, 
																		id_employee							, 
																		organization						,
																		designation							,
																		jobfield							,
																		jobdetail							,
																		date_start							,
																		date_end							,
																		salary_start						,
																		salary_end							,
																		id_campus
																   )
	   														VALUES (
																		'1'												, 
																		'".cleanvars($rowempid['emply_id'])."'			, 
																		'".cleanvars($_POST['organization'])."'			,
																		'".cleanvars($_POST['designation'])."'			, 
																		'".cleanvars($_POST['jobfield'])."'				, 
																		'".cleanvars($_POST['jobdetail'])."'			, 
																		'".cleanvars($_POST['date_start'])."'			,
																		'".cleanvars($_POST['date_end'])."'				,
																		'".cleanvars($_POST['salary_start'])."'			,
																		'".cleanvars($_POST['salary_end'])."'			, 
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."'
													 			 )"
							);
//--------------------------------------
		if($sqllms) {
			$_SESSION['msg']['status'] = '<div class="col-lg-9">
											<div class="alert-box success"><span>success: </span>Record added successfully.</div>
										</div>';
			header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
			exit();
		}
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['changes_exp'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".EMPLYS_EXPERIENCE." SET id_employee	= '".cleanvars($rowempid['emply_id'])."' 
															, organization	= '".cleanvars($_POST['organization_edit'])."'
															, designation	= '".cleanvars($_POST['designation_edit'])."'
															, jobfield		= '".cleanvars($_POST['jobfield_edit'])."'
															, jobdetail		= '".cleanvars($_POST['jobdetail_edit'])."'
															, date_start	= '".cleanvars($_POST['date_start_edit'])."'
															, date_end		= '".cleanvars($_POST['date_end_edit'])."'
															, salary_start	= '".cleanvars($_POST['salary_start_edit'])."'
															, salary_end	= '".cleanvars($_POST['salary_end_edit'])."'
															, id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
														WHERE id			= '".cleanvars($_POST['expid_edit'])."'");
//--------------------------------------
		if($sqllms) {
			$_SESSION['msg']['status'] = '<div class="col-lg-9">
											<div class="alert-box notice"><span>success: </span>Record update successfully.</div>
										</div>';
			header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
			exit();
		}
//--------------------------------------
	}
	
// lanaguage Skill
//--------------------------------------
if(isset($_POST['submit_skill'])) { 
//------------------------------------------------
	$sqllms  = $dblms->querylms("INSERT INTO ".EMPLYS_LANGS_SKILLS."(
																		status								, 
																		speaking							, 
																		reading								,
																		writing								,
																		id_language							,
																		id_employee							,
																		id_campus
																  )
	   														VALUES(
																		'1'	, 
																		'".cleanvars($_POST['speaking'])."'				,
																		'".cleanvars($_POST['reading'])."'				, 
																		'".cleanvars($_POST['writing'])."'				, 
																		'".cleanvars($_POST['id_language'])."'			, 
																		'".cleanvars($rowempid['emply_id'])."'			, 
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."'
													 			 )"
							);
//--------------------------------------
		if($sqllms) {
			$_SESSION['msg']['status'] = '<div class="col-lg-9">
											<div class="alert-box success"><span>success: </span>Record added successfully.</div>
										</div>';
			header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
			exit();
		}
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['changes_skill'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".EMPLYS_LANGS_SKILLS." SET speaking	= '".cleanvars($_POST['speaking_edit'])."'
															, reading		= '".cleanvars($_POST['reading_edit'])."'
															, writing		= '".cleanvars($_POST['writing_edit'])."'
															, id_language	= '".cleanvars($_POST['id_language_edit'])."'
															, id_employee	= '".cleanvars($rowempid['emply_id'])."'
															, id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
														WHERE id			= '".cleanvars($_POST['skill_id'])."'");
//--------------------------------------
		if($sqllms) {
			$_SESSION['msg']['status'] = '<div class="col-lg-9">
											<div class="alert-box notice"><span>success: </span>Record update successfully.</div>
										</div>';
			header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
			exit();
		}
//--------------------------------------
	}

// training
//--------------------------------------
if(isset($_POST['submit_training'])) { 
//------------------------------------------------
	$sqllms  = $dblms->querylms("INSERT INTO ".EMPLYS_TRAININGS." (
																		status								, 
																		id_employee							, 
																		jobfield							,
																		course								,
																		organization						,
																		address								,
																		date_start							,
																		date_end							,
																		id_campus
																   )
	   														VALUES (
																		'1'											, 
																		'".cleanvars($rowempid['emply_id'])."'		, 
																		'".cleanvars($_POST['jobfield'])."'			,
																		'".cleanvars($_POST['course'])."'			, 
																		'".cleanvars($_POST['organization'])."'		, 
																		'".cleanvars($_POST['address'])."'			, 
																		'".cleanvars($_POST['date_start'])."'		,
																		'".cleanvars($_POST['date_end'])."'			,
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."'
													 			 )"
							);
//--------------------------------------
		if($sqllms) {
			$_SESSION['msg']['status'] = '<div class="col-lg-9">
											<div class="alert-box success"><span>success: </span>Record added successfully.</div>
										</div>';
			header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
			exit();
		}
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['changes_training'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".EMPLYS_TRAININGS." SET id_employee	= '".cleanvars($rowempid['emply_id'])."' 
															, jobfield		= '".cleanvars($_POST['jobfield_edit'])."'
															, course		= '".cleanvars($_POST['course_edit'])."'
															, organization	= '".cleanvars($_POST['organization_edit'])."'
															, address		= '".cleanvars($_POST['address_edit'])."'
															, date_start	= '".cleanvars($_POST['date_start_edit'])."'
															, date_end		= '".cleanvars($_POST['date_end_edit'])."'
															, id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
														WHERE id			= '".cleanvars($_POST['trnid_edit'])."'");
//--------------------------------------
		if($sqllms) {
			$_SESSION['msg']['status'] = '<div class="col-lg-9">
											<div class="alert-box notice"><span>success: </span>Record update successfully.</div>
										</div>';
			header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
			exit();
		}
//--------------------------------------
	}

// membership
//--------------------------------------
if(isset($_POST['submit_mem'])) { 
//------------------------------------------------
	$sqllms  = $dblms->querylms("INSERT INTO ".EMPLYS_MEMBERSHIP." (
																		status								, 
																		id_employee							, 
																		designation							,
																		memno								,
																		organization						,
																		startdate							,
																		enddate								,
																		id_campus
																   )
	   														VALUES (
																		'1'												, 
																		'".cleanvars($rowempid['emply_id'])."'		, 
																		'".cleanvars($_POST['designation'])."'			,
																		'".cleanvars($_POST['memno'])."'				, 
																		'".cleanvars($_POST['organization'])."'			, 
																		'".cleanvars($_POST['startdate'])."'			, 
																		'".cleanvars($_POST['enddate'])."'				, 
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."'
													 			 )"
							);
//--------------------------------------
		if($sqllms) {
			$_SESSION['msg']['status'] = '<div class="col-lg-9">
											<div class="alert-box success"><span>success: </span>Record added successfully.</div>
										</div>';
			header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
			exit();
		}
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['changes_mem'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("UPDATE ".EMPLYS_MEMBERSHIP." SET id_employee	= '".cleanvars($rowempid['emply_id'])."' 
															, designation	= '".cleanvars($_POST['designation_edit'])."'
															, memno			= '".cleanvars($_POST['memno_edit'])."'
															, organization	= '".cleanvars($_POST['organization_edit'])."'
															, startdate		= '".cleanvars($_POST['startdate_edit'])."'
															, enddate		= '".cleanvars($_POST['enddate_edit'])."'
															, id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
														WHERE id			= '".cleanvars($_POST['memid_edit'])."'");
//--------------------------------------
		if($sqllms) {
			$_SESSION['msg']['status'] = '<div class="col-lg-9">
											<div class="alert-box notice"><span>success: </span>Record update successfully.</div>
										</div>';
			header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
			exit();
		}
//--------------------------------------
	}

// publications

//--------------------------------------
if(isset($_POST['submit_publications'])) { 
//------------------------------------------------
	$sqllms  = $dblms->querylms("INSERT INTO ".EMPLYS_PUBLICATIONS." (
																		status								, 
																		id_employee							, 
																		id_type								,
																		title								,
																		sub_title							,
																		journal								,
																		author								,
																		co_author							,
																		corporate_name						,
																		book_type							,
																		isbn								,
																		issn								,
																		doi									,
																		vloume								,
																		page								,
																		issue_num							,
																		subject								,
																		keywords							,
																		abstract							,
																		year_date							,
																		publisher_name						,
																		edition								,
																		editor								,
																		series_name							,
																		series_num							,
																		url									,
																		hec_category						,
																		hec_medallion						,
																		affiliation							,
																		impact_factor						,
																		material							,
																		barcode								,
																		session								,
																		std_regno							,
																		submitted_by						,
																		submitted_to						,
																		indexed_on							,
																		id_language							,
																		id_dept								,
																		id_prg_cat							,
																		id_country							,
																		id_campus
																   )
	   														VALUES (
																		'1'											, 
																		'".cleanvars($rowempid['emply_id'])."'		, 
																		'".cleanvars($_POST['id_type'])."'			,
																		'".cleanvars($_POST['title'])."'			, 
																		'".cleanvars($_POST['sub_title'])."'		, 
																		'".cleanvars($_POST['journal'])."'			, 
																		'".cleanvars($_POST['author'])."'			, 
																		'".cleanvars($_POST['co_author'])."'		, 
																		'".cleanvars($_POST['corporate_name'])."'	, 
																		'".cleanvars($_POST['book_type'])."'		, 
																		'".cleanvars($_POST['isbn'])."'				, 
																		'".cleanvars($_POST['issn'])."'				, 
																		'".cleanvars($_POST['doi'])."'				, 
																		'".cleanvars($_POST['vloume'])."'			, 
																		'".cleanvars($_POST['page'])."'				, 
																		'".cleanvars($_POST['issue_num'])."'		, 
																		'".cleanvars($_POST['subject'])."'			, 
																		'".cleanvars($_POST['keywords'])."'			, 
																		'".cleanvars($_POST['abstract'])."'			, 
																		'".cleanvars($_POST['year_date'])."'		, 
																		'".cleanvars($_POST['publisher_name'])."'	, 
																		'".cleanvars($_POST['edition'])."'			, 
																		'".cleanvars($_POST['editor'])."'			, 
																		'".cleanvars($_POST['series_name'])."'		, 
																		'".cleanvars($_POST['series_num'])."'		, 
																		'".cleanvars($_POST['url'])."'				, 
																		'".cleanvars($_POST['hec_category'])."'		, 
																		'".cleanvars($_POST['hec_medallion'])."'	, 
																		'".cleanvars($_POST['affiliation'])."'		, 
																		'".cleanvars($_POST['impact_factor'])."'	, 
																		'".cleanvars($_POST['material'])."'			, 
																		'".cleanvars($_POST['barcode'])."'			, 
																		'".cleanvars($_POST['session'])."'			, 
																		'".cleanvars($_POST['std_regno'])."'		, 
																		'".cleanvars($_POST['submitted_by'])."'		, 
																		'".cleanvars($_POST['submitted_to'])."'		, 
																		'".cleanvars($_POST['indexed_on'])."'		, 
																		'".cleanvars($_POST['id_language'])."'		, 
																		'".cleanvars($_POST['id_dept'])."'			, 
																		'".cleanvars($_POST['id_prg_cat'])."'		, 
																		'".cleanvars($_POST['id_country'])."'		, 
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."'
													 			 )"
							);
//--------------------------------------
	if($sqllms) {
		$_SESSION['msg']['status'] = '<div class="col-lg-9">
										<div class="alert-box success"><span>Success: </span>Record added successfully.</div>
									</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	}
//--------------------------------------
}

//--------------------------------------
if(isset($_POST['changes_publications'])) { 
//------------------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".EMPLYS_PUBLICATIONS." SET  id_employee	= '".cleanvars($rowempid['emply_id'])."' 
															, title				= '".cleanvars($_POST['title'])."'
															, sub_title			= '".cleanvars($_POST['sub_title'])."'
															, journal			= '".cleanvars($_POST['journal'])."'
															, author			= '".cleanvars($_POST['author'])."'
															, co_author			= '".cleanvars($_POST['co_author'])."'
															, corporate_name	= '".cleanvars($_POST['corporate_name'])."'
															, book_type			= '".cleanvars($_POST['book_type'])."'
															, isbn				= '".cleanvars($_POST['isbn'])."'
															, issn				= '".cleanvars($_POST['issn'])."'
															, doi				= '".cleanvars($_POST['doi'])."'
															, vloume			= '".cleanvars($_POST['vloume'])."'
															, page				= '".cleanvars($_POST['page'])."'
															, issue_num			= '".cleanvars($_POST['issue_num'])."'
															, subject			= '".cleanvars($_POST['subject'])."'
															, keywords			= '".cleanvars($_POST['keywords'])."'
															, abstract			= '".cleanvars($_POST['abstract'])."'
															, year_date			= '".cleanvars($_POST['year_date'])."'
															, publisher_name	= '".cleanvars($_POST['publisher_name'])."'
															, edition			= '".cleanvars($_POST['edition'])."'
															, editor			= '".cleanvars($_POST['editor'])."'
															, series_name		= '".cleanvars($_POST['series_name'])."'
															, series_num		= '".cleanvars($_POST['series_num'])."'
															, url				= '".cleanvars($_POST['url'])."'
															, hec_category		= '".cleanvars($_POST['hec_category'])."'
															, hec_medallion		= '".cleanvars($_POST['hec_medallion'])."'
															, affiliation		= '".cleanvars($_POST['affiliation'])."'
															, impact_factor		= '".cleanvars($_POST['impact_factor'])."'
															, material			= '".cleanvars($_POST['material'])."'
															, barcode			= '".cleanvars($_POST['barcode'])."'
															, session			= '".cleanvars($_POST['session'])."'
															, std_regno			= '".cleanvars($_POST['std_regno'])."'
															, submitted_by		= '".cleanvars($_POST['submitted_by'])."'
															, submitted_to		= '".cleanvars($_POST['submitted_to'])."'
															, indexed_on		= '".cleanvars($_POST['indexed_on'])."'
															, id_language		= '".cleanvars($_POST['id_language'])."'
															, id_dept			= '".cleanvars($_POST['id_dept'])."'
															, id_prg_cat		= '".cleanvars($_POST['id_prg_cat'])."'
															, id_country		= '".cleanvars($_POST['id_country'])."'
															, id_campus			= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
														WHERE id				= '".cleanvars($_POST['id_edit'])."'");
//--------------------------------------
	if($sqllms) {
		$_SESSION['msg']['status'] = '<div class="col-lg-9">
										<div class="alert-box notice "><span>success: </span>Record update successfully.</div>
									</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	}
//--------------------------------------
}
