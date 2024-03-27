<?php
//--------------------------------------
if (isset ($_POST['submit_assignment'])) {
	//------------------------------------------------
	$sqllmsselect = $dblms->querylms("SELECT id, status    
										FROM " . COURSES_ASSIGNMENTS . " 
										WHERE id_campus = '" . cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) . "' 
										AND academic_session = '" . cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR']) . "' 
										AND id_teacher = '" . cleanvars($rowsstd['emply_id']) . "' 
										AND id_curs = '" . cleanvars($_GET['id']) . "'
										AND id_prg = '".cleanvars($_GET['id_prg'])."' 
										AND date_end = '" . date("Y-m-d", strtotime(cleanvars($_POST['date_end']))) . "' 
										AND date_start = '" . date("Y-m-d", strtotime(cleanvars($_POST['date_start']))) . "'");
	//------------------------------------------------
	if (mysqli_num_rows($sqllmsselect) > 0) {
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>record already exists.</div>';
		header("Location:courses.php?id=" . $_GET['id'] . "&view=Assignments", true, 301);
		exit();
	} else {
		if (cleanvars($_POST['is_midterm']) == 1) {
			$sqllmsmidelect = $dblms->querylms("SELECT id, status    
											FROM " . COURSES_ASSIGNMENTS . " 
											WHERE id_campus = '" . cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) . "' 
											AND academic_session = '" . cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR']) . "' 
											AND id_teacher = '" . cleanvars($rowsstd['emply_id']) . "' 
											AND id_curs = '" . cleanvars($_GET['id']) . "' 
											AND id_prg = '".cleanvars($_GET['id_prg'])."' 
											AND status = '1' AND is_midterm = '1'");
			$count = mysqli_num_rows($sqllmsmidelect);
		} else {
			$count = 0;
		}
		//------------------------------------------------
		if ($count > 0) {
			$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>Midterm Examination Assignment already exist.</div>';
			header("Location:courses.php?id=" . $_GET['id'] . "&view=Assignments", true, 301);
			exit();
		} else {
			$topicprograms = '';
				//--------------------------------------
				if (!empty (sizeof($_POST['idprg']))) {
					//--------------------------------------
					for ($ichk = 0; $ichk < count($_POST['idprg']); $ichk++) {
						//--------------------------------------
						$arr = $_POST['idprg'][$ichk];
						$splitted = explode(",", trim($arr));

						$idprg = $splitted[0];
						$semester = $splitted[1];
						$timing = $splitted[2];
						$section = $splitted[3];
						//--------------------------------------
						// 'id_setup' => cleanvars($fileid),
						$datadetail = array(
							
							'id_prg' => cleanvars($idprg),
							'semester' => cleanvars($semester),
							'section' => cleanvars($section),
							'timing' => cleanvars($timing),
						);

						$sqllmsInsertDetail = $dblms->Insert(COURSES_ASSIGNMENTSPROGRAM, $datadetail);

						$topicprograms .= '"id_prg:"' . '=>' . '"' . ($idprg) . '",' . "\n";
						$topicprograms .= '"semester:"' . '=>' . '"' . ($semester) . '",' . "\n";
						$topicprograms .= '"section:"' . '=>' . '"' . ($section) . '",' . "\n";
						$topicprograms .= '"timing:"' . '=>' . '"' . ($timing) . '"' . "\n";
					}
					//--------------------------------------
				}
				//--------------------------------------

			$quesIds = array();
				if(isset($_POST['ques_number'])) {
					$quesNumbers = implode(",",cleanvars($_POST['ques_number']));
					for ($i = 0; $i <  sizeof(cleanvars($_POST['ques_number'])); $i++) {
						if(isset($_POST['ques_statement'])) {
							$quesStatement = cleanvars($_POST['ques_statement'][$i]);
						} else {
							$quesStatement = '';
						}
						// implode('',cleanvars($_POST['ques_clo'][$i + 1]))
						$quesData = [
							'ques_status'          => '1'                                                   	,
							'ques_category'        => cleanvars($_POST['ques_category'][$i])                	,
							'ques_type'            => '1'                                                   	,
							'ques_statement'       => $quesStatement                                        	,
							'ques_marks'           => cleanvars($_POST['ques_marks'][$i])                   	,
							'id_clo'               => implode(',',cleanvars($_POST['ques_clo'][$i + 1]))		,
							'ques_number'          => cleanvars($_POST['ques_number'][$i])                  	,
							'id_teacher'           => cleanvars($rowsstd['emply_id'])                           ,
							'id_course'            => cleanvars($_POST['id_curs'])                          	,
							'theory_paractical'    => COURSE_TYPE                                           	,
							'id_prg'               => cleanvars($_POST['id_prg'])                               ,
							'semester'             => $semester                                              	,
							'section'              => $section                                               	,
							'timing'               => $timing                                                	,
							'academic_session'     => cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])	,
							'id_campus'            => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])   	,
							'id_added'             => cleanvars($_SESSION['LOGINIDA_SSS'])     					,
							'date_added'           => date('Y-m-d H:i:s')                
						];
						$queryInsertQues = $dblms->Insert(OBE_QUESTIONS, $quesData);

						$latest_id = $dblms->lastestid();
						$quesIds[] = $latest_id;

						if($queryInsertQues && cleanvars($_POST['ques_category'][$i]) === '2') {
							$mcqOptions =  cleanvars($_POST['option']);

							$mcqData = [
								'id_ques'           => $latest_id               ,
								'option1'           => $mcqOptions[$i][1]       ,
								'option2'           => $mcqOptions[$i][2]       ,
								'option3'           => $mcqOptions[$i][3]       ,
								'option4'           => $mcqOptions[$i][4]       ,
								'option5'           => $mcqOptions[$i][5]       ,              
							];
							$queryInsertMcq = $dblms->Insert(OBE_MCQS, $mcqData);        
						}
					}
				}

				$quesids = implode('', $quesIds);
				if (count($quesIds) > 1) {
					$quesids = implode(',', $quesIds);
				}

			if ($_POST['is_midterm'] == 1) {
				$total_marks = 25;
			} else {
				$total_marks = $_POST['total_marks'];
			}

			$data = array(
				'status' => cleanvars($_POST['status']),
				'caption' => cleanvars($_POST['caption']),
				'detail' => cleanvars($_POST['detail']),
				'date_start' => date("Y-m-d", strtotime(cleanvars($_POST['date_start']))),
				'date_end' => date("Y-m-d", strtotime(cleanvars($_POST['date_end']))),
				'is_midterm' => cleanvars($_POST['is_midterm']),
				'total_marks' => cleanvars($total_marks),
				'passing_marks' => cleanvars($_POST['passing_marks']),
				'id_ques' => $quesids,
				'id_curs' => cleanvars($_POST['id_curs']),
				'id_prg'  => cleanvars($_POST['id_prg']),
				'id_teacher' => cleanvars($rowsstd['emply_id']),
				'academic_session' => cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR']),
				'id_campus' => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']),
				'id_added' => cleanvars($_SESSION['userlogininfo']['LOGINIDA']),
				'date_added' => date("Y-m-d H:i:s"),
			);
			$sqllmsInsert = $dblms->Insert(COURSES_ASSIGNMENTS, $data);
			$fileid = $dblms->lastestid();
			//--------------------------------------
			if ($sqllmsInsert) {
				$originalImage = '';
				//--------------------------------------
				if (!empty ($_FILES['assign_file']['name'])) {
					//--------------------------------------
					$acdsess = removeWhiteSpace(cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR']));
					$sesdir = to_seo_url($acdsess);

					$directoryName = 'downloads/assignments/teachers/' . $sesdir;
					if (!is_dir($directoryName)) {
						//Directory does not exist, so lets create it.
						mkdir($directoryName, 0777);
						$content = "Options -Indexes";
						$fp = fopen($directoryName . "/.htaccess", "wb");
						fwrite($fp, $content);
						fclose($fp);
					}
					$img_dir = $directoryName . "/";
					$filesize = $_FILES['assign_file']['size'];
					$path_parts = pathinfo($_FILES["assign_file"]["name"]);
					$extension = $path_parts['extension'];
					$originalImage = $img_dir . to_seo_url($rowsurs['curs_code']) . '-' . to_seo_url(cleanvars($_POST['caption'])) . '_' . $fileid . "." . strtolower($extension);
					$img_fileName = $sesdir . "/" . to_seo_url($rowsurs['curs_code']) . '-' . to_seo_url(cleanvars($_POST['caption'])) . '_' . $fileid . "." . strtolower($extension);
					//	$extension 		= strtolower($img[1]);
					if (in_array($extension, array('jpg', 'jpeg', 'gif', 'png', 'pdf', 'docx', 'doc', 'xlsx', 'xls'))) {
						//--------------------------------------
						$sqllmsupload = $dblms->querylms("UPDATE " . COURSES_ASSIGNMENTS . "
														SET fileattach = '" . $img_fileName . "'
												 WHERE  id		= '" . cleanvars($fileid) . "'");
						unset($sqllmsupload);
						$mode = '0644';
						//--------------------------------------	
						move_uploaded_file($_FILES['assign_file']['tmp_name'], $originalImage);
						chmod($originalImage, octdec($mode));
					}
					//--------------------------------------
				}
				
				//	echo "<h1>$extension</h1>";

				// $requestedvars = "\n";
				// $requestedvars .= '"ID:"' . '=>' . '"' . $fileid . '",' . "\n";
				// $requestedvars .= '"Status:"' . '=>' . '"' . $_POST['status'] . '",' . "\n";
				// $requestedvars .= '"Caption:"' . '=>' . '"' . $_POST['caption'] . '",' . "\n";
				// $requestedvars .= '"Details:"' . '=>' . '"' . $_POST['detail'] . '",' . "\n";
				// $requestedvars .= '"Start Date:"' . '=>' . '"' . $_POST['date_start'] . '",' . "\n";
				// $requestedvars .= '"End Date:"' . '=>' . '"' . $_POST['date_end'] . '",' . "\n";
				// $requestedvars .= '"Total Marks:"' . '=>' . '"' . $total_marks . '",' . "\n";
				// $requestedvars .= '"Passing Marks:"' . '=>' . '"' . $_POST['passing_marks'] . '",' . "\n";
				// $requestedvars .= '"File:"' . '=>' . '"' . $originalImage . '",' . "\n";
				// $requestedvars .= '"Course ID:"' . '=>' . '"' . $_GET['id'] . '",' . "\n";
				// $requestedvars .= '"Course Code:"' . '=>' . '"' . $rowsurs['curs_code'] . '",' . "\n";
				// $requestedvars .= '"Course Name:"' . '=>' . '"' . $rowsurs['curs_name'] . '",' . "\n";
				// $requestedvars .= '"Emply ID:"' . '=>' . '"' . $rowsstd['emply_id'] . '",' . "\n";
				// $requestedvars .= '"programs:"' . '=>' . 'array(' . "\n";
				// $requestedvars .= $topicprograms . "\n";
				// $requestedvars .= ")\n";

				// // insert for log
				// $logremarks = 'Add Assignments #: ' . $lessonid . ' for Course: ' . $rowsurs['curs_code'] . '-' . $rowsurs['curs_name'];
				// $datalogs = array(
				// 	'id_user' => cleanvars($_SESSION['userlogininfo']['LOGINIDA']),
				// 	'filename' => basename($_SERVER['REQUEST_URI']),
				// 	'action' => 1,
				// 	'dated' => date("Y-m-d H:i:s"),
				// 	'ip' => cleanvars($ip),
				// 	'remarks' => cleanvars($logremarks),
				// 	'details' => cleanvars($requestedvars),
				// 	'sess_id' => cleanvars(session_id()),
				// 	'device_details' => cleanvars($devicedetails),
				// 	'id_campus' => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']),
				// );

				// $sqllmsInsertLog = $dblms->Insert(LOGSTEACHER, $datalogs);


				// $_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
				// header("Location:courses.php?id=".$_GET['id']."&prg_id=".$_GET['id_prg']."&view=Assignments", true, 301);
				// exit();

			}
		}
	}
	//--------------------------------------
}

//--------------------------------------
if (isset ($_POST['import_assignments'])) {
	//------------------------------------------------
	$checkbox = $_POST['assignarchive'];
	for ($i = 0; $i < count($_POST['assignarchive']); $i++) {
		$del_id = $checkbox[$i];

		$sqllmschecker = $dblms->querylms("SELECT *  
										FROM " . COURSES_ASSIGNMENTS . " 
										WHERE id = '" . cleanvars($del_id) . "' LIMIT 1");
		if (mysqli_num_rows($sqllmschecker) > 0) {
			$valuearachive = mysqli_fetch_array($sqllmschecker);
			$sqllmsassign = $dblms->querylms(
				"INSERT INTO " . COURSES_ASSIGNMENTS . " (
																		status					, 
																		caption					, 
																		detail					,
																		fileattach				,
																		date_start				,
																		date_end				,
																		total_marks				,
																		passing_marks			,
																		id_curs					,
																		id_teacher				,
																		academic_session		,
																		id_campus				,
																		id_added				, 
																		date_added 
																   )
	   											VALUES (
														'" . cleanvars($valuearachive['status']) . "'			,
														'" . cleanvars($valuearachive['caption']) . "'			,
														'" . cleanvars($valuearachive['detail']) . "'			, 
														'" . cleanvars($valuearachive['fileattach']) . "'		, 
														'" . date("Y-m-d", strtotime(cleanvars($valuearachive['date_start']))) . "'		, 
														'" . date("Y-m-d", strtotime(cleanvars($valuearachive['date_end']))) . "'		, 
														'" . cleanvars($valuearachive['total_marks']) . "'		, 
														'" . cleanvars($valuearachive['passing_marks']) . "'	, 
														'" . cleanvars($_GET['id']) . "'			, 
														'" . cleanvars($rowsstd['emply_id']) . "'		, 
														'" . $_SESSION['userlogininfo']['LOGINIDACADYEAR'] . "' 		,
														'" . $_SESSION['userlogininfo']['LOGINIDCOM'] . "' 				,
														'" . cleanvars($_SESSION['userlogininfo']['LOGINIDA']) . "'		, 
														NOW() 
												)"
			);
			//--------------------------------------
			if ($sqllmsassign) {
				$lessonid = $dblms->lastestid();


				$requestedvars = "\n";
				$requestedvars .= '"ID:"' . '=>' . '"' . $lessonid . '",' . "\n";
				$requestedvars .= '"Status:"' . '=>' . '"' . $valuearachive['status'] . '",' . "\n";
				$requestedvars .= '"Caption:"' . '=>' . '"' . $valuearachive['caption'] . '",' . "\n";
				$requestedvars .= '"Details:"' . '=>' . '"' . $valuearachive['detail'] . '",' . "\n";
				$requestedvars .= '"Start Date:"' . '=>' . '"' . $valuearachive['date_start'] . '",' . "\n";
				$requestedvars .= '"End Date:"' . '=>' . '"' . $valuearachive['date_end'] . '",' . "\n";
				$requestedvars .= '"Total Marks:"' . '=>' . '"' . $valuearachive['total_marks'] . '",' . "\n";
				$requestedvars .= '"Passing Marks:"' . '=>' . '"' . $valuearachive['passing_marks'] . '",' . "\n";
				$requestedvars .= '"Passing Marks:"' . '=>' . '"' . $valuearachive['passing_marks'] . '",' . "\n";
				$requestedvars .= '"Course ID:"' . '=>' . '"' . $_GET['id'] . '",' . "\n";
				$requestedvars .= '"Course Code:"' . '=>' . '"' . $rowsurs['curs_code'] . '",' . "\n";
				$requestedvars .= '"Course Name:"' . '=>' . '"' . $rowsurs['curs_name'] . '",' . "\n";
				$requestedvars .= '"Emply ID:"' . '=>' . '"' . $rowsstd['emply_id'] . '"';
				//--------------------------------------
				$logremarks = 'Add Assignments #: ' . $lessonid . ' for Course: ' . $rowsurs['curs_code'] . '-' . $rowsurs['curs_name'];
				$sqllmslog = $dblms->querylms("INSERT INTO " . LOGSTEACHER . " (
															id_user						, 
															filename					, 
															action						,
															dated						,
															ip							,
															remarks						,
															details						,
															sess_id						,
															device_details				,
															id_campus				
														  )
		
													VALUES(
															'" . cleanvars($_SESSION['userlogininfo']['LOGINIDA']) . "'	,
															'" . basename($_SERVER['REQUEST_URI']) . "'		, 
															'1'											, 
															NOW()										,
															'" . cleanvars($ip) . "'						,
															'" . cleanvars($logremarks) . "'				,
															'" . cleanvars($requestedvars) . "'				,
															'" . cleanvars(session_id()) . "'				,
															'" . cleanvars($devicedetails) . "'				,
															'" . cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])) . "'			
														  )
									");


			}
		}
	}
	if ($sqllmsassign) {
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record has been successfully Import.</div>';
		header("Location:courses.php?id=" . $_GET['id'] . "&view=Assignments", true, 301);
		exit();
	}
	//--------------------------------------
}


//--------------------------------------
if (isset ($_POST['changes_detailassignment'])) {
	//------------------------------------------------
	$data = array(
		'status' => cleanvars($_POST['status']),
		'caption' => cleanvars($_POST['caption']),
		'detail' => cleanvars($_POST['detail']),
		'date_start' => date("Y-m-d", strtotime(cleanvars($_POST['date_start']))),
		'date_end' => date("Y-m-d", strtotime(cleanvars($_POST['date_end']))),
		'is_midterm' => cleanvars($_POST['is_midterm']),
		'total_marks' => cleanvars($_POST['total_marks']),
		'passing_marks' => cleanvars($_POST['passing_marks']),
		'id_campus' => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']),
		'id_modify' => cleanvars($_SESSION['userlogininfo']['LOGINIDA']),
		'date_modify' => date("Y-m-d H:i:s"),
	);
	$sqllmsUpdate = $dblms->Update(COURSES_ASSIGNMENTS, $data, "WHERE id = '" . cleanvars($_POST['editid']) . "'");

	//--------------------------------------
	if ($sqllmsUpdate) {

		//--------------------------------------

		$topicprograms = '';
		//--------------------------------------
		if (!empty (sizeof($_POST['idprg']))) {
			$sqllmsdelte = $dblms->querylms("DELETE FROM " . COURSES_ASSIGNMENTSPROGRAM . " WHERE id_setup = '" . cleanvars($_POST['editid']) . "'");
			//--------------------------------------
			for ($ichk = 0; $ichk < count($_POST['idprg']); $ichk++) {
				//--------------------------------------
				$arr = $_POST['idprg'][$ichk];
				$splitted = explode(",", trim($arr));

				$idprg = $splitted[0];
				$semester = $splitted[1];
				$timing = $splitted[2];
				$section = $splitted[3];
				//--------------------------------------

				$datadetail = array(
					'id_setup' => cleanvars($_POST['editid']),
					'id_prg' => cleanvars($idprg),
					'semester' => cleanvars($semester),
					'section' => cleanvars($section),
					'timing' => cleanvars($timing),
				);

				$sqllmsInsertDetail = $dblms->Insert(COURSES_ASSIGNMENTSPROGRAM, $datadetail);


				$topicprograms .= '"id_prg:"' . '=>' . '"' . ($idprg) . '",' . "\n";
				$topicprograms .= '"semester:"' . '=>' . '"' . ($semester) . '",' . "\n";
				$topicprograms .= '"section:"' . '=>' . '"' . ($section) . '",' . "\n";
				$topicprograms .= '"timing:"' . '=>' . '"' . ($timing) . '"' . "\n";
			}
			//--------------------------------------
		}
		//--------------------------------------
		$originalImage = '';
		if (!empty ($_FILES['assign_file']['name'])) {
			//--------------------------------------
			$acdsess = removeWhiteSpace(cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR']));
			$sesdir = to_seo_url($acdsess);

			$directoryName = 'downloads/assignments/teachers/' . $sesdir;
			if (!is_dir($directoryName)) {
				//Directory does not exist, so lets create it.
				mkdir($directoryName, 0777);
				$content = "Options -Indexes";
				$fp = fopen($directoryName . "/.htaccess", "wb");
				fwrite($fp, $content);
				fclose($fp);
			}
			//--------------------------------------
			$img_dir = $directoryName . "/";
			$filesize = $_FILES['assign_file']['size'];
			$path_parts = pathinfo($_FILES["assign_file"]["name"]);
			$extension = $path_parts['extension'];
			$originalImage = $img_dir . to_seo_url($rowsurs['curs_code']) . '-' . to_seo_url(cleanvars($_POST['caption'])) . '_' . $_POST['editid'] . "." . strtolower($extension);
			$img_fileName = $sesdir . "/" . to_seo_url($rowsurs['curs_code']) . '-' . to_seo_url(cleanvars($_POST['caption'])) . '_' . $_POST['editid'] . "." . strtolower($extension);

			if (in_array($extension, array('jpg', 'jpeg', 'gif', 'png', 'pdf', 'docx', 'doc', 'xlsx', 'xls'))) {
				//--------------------------------------
				$sqllmsupload = $dblms->querylms("UPDATE " . COURSES_ASSIGNMENTS . "
														SET fileattach = '" . $img_fileName . "'
												 WHERE  id		= '" . cleanvars($_POST['editid']) . "'");
				unset($sqllmsupload);
				$mode = '0644';
				//--------------------------------------	
				move_uploaded_file($_FILES['assign_file']['tmp_name'], $originalImage);
				chmod($originalImage, octdec($mode));
			}
			//--------------------------------------
		}


		$requestedvars = "\n";
		$requestedvars .= '"ID:"' . '=>' . '"' . $_POST['editid'] . '",' . "\n";
		$requestedvars .= '"Status:"' . '=>' . '"' . $_POST['status'] . '",' . "\n";
		$requestedvars .= '"Caption:"' . '=>' . '"' . $_POST['caption'] . '",' . "\n";
		$requestedvars .= '"Details:"' . '=>' . '"' . $_POST['detail'] . '",' . "\n";
		$requestedvars .= '"Start Date:"' . '=>' . '"' . $_POST['date_start'] . '",' . "\n";
		$requestedvars .= '"End Date:"' . '=>' . '"' . $_POST['date_end'] . '",' . "\n";
		$requestedvars .= '"Total Marks:"' . '=>' . '"' . $_POST['total_marks'] . '",' . "\n";
		$requestedvars .= '"Passing Marks:"' . '=>' . '"' . $_POST['passing_marks'] . '",' . "\n";
		$requestedvars .= '"File:"' . '=>' . '"' . $originalImage . '",' . "\n";
		$requestedvars .= '"Course ID:"' . '=>' . '"' . $_GET['id'] . '",' . "\n";
		$requestedvars .= '"Course Code:"' . '=>' . '"' . $rowsurs['curs_code'] . '",' . "\n";
		$requestedvars .= '"Course Name:"' . '=>' . '"' . $rowsurs['curs_name'] . '",' . "\n";
		$requestedvars .= '"Emply ID:"' . '=>' . '"' . $rowsstd['emply_id'] . '",' . "\n";
		$requestedvars .= '"programs:"' . '=>' . 'array(' . "\n";
		$requestedvars .= $topicprograms . "\n";
		$requestedvars .= ")\n";



		// insert for log
		$logremarks = 'Update Assignments #: ' . $_POST['editid'] . ' for Course: ' . $rowsurs['curs_code'] . '-' . $rowsurs['curs_name'];
		$datalogs = array(
			'id_user' => cleanvars($_SESSION['userlogininfo']['LOGINIDA']),
			'filename' => basename($_SERVER['REQUEST_URI']),
			'action' => 2,
			'dated' => date("Y-m-d H:i:s"),
			'ip' => cleanvars($ip),
			'remarks' => cleanvars($logremarks),
			'details' => cleanvars($requestedvars),
			'sess_id' => cleanvars(session_id()),
			'device_details' => cleanvars($devicedetails),
			'id_campus' => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']),
		);

		$sqllmsInsertLog = $dblms->Insert(LOGSTEACHER, $datalogs);


		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location:courses.php?id=" . $_GET['id'] . "&view=Assignments", true, 301);
		exit();
	}
	//--------------------------------------
}

//--------------------------------------
if (isset ($_POST['changes_assignment'])) {

	$data = array(
		'status' => cleanvars($_POST['status_edit']),
		'caption' => cleanvars($_POST['caption_edit']),
		'date_start' => date("Y-m-d", strtotime(cleanvars($_POST['date_start_edit']))),
		'date_end' => date("Y-m-d", strtotime(cleanvars($_POST['date_end_edit']))),
		'total_marks' => cleanvars($_POST['total_marks_edit']),
		'passing_marks' => cleanvars($_POST['passing_marks_edit']),
		'id_campus' => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']),
		'id_modify' => cleanvars($_SESSION['userlogininfo']['LOGINIDA']),
		'date_modify' => date("Y-m-d H:i:s"),
	);
	$sqllmsUpdate = $dblms->Update(COURSES_ASSIGNMENTS, $data, "WHERE id = '" . cleanvars($_POST['assignid_edit']) . "'");
	//--------------------------------------
	if (sqllmsUpdate) {

		$originalImage = '';
		if (!empty ($_FILES['assign_file_edit']['name'])) {
			//--------------------------------------
			$acdsess = removeWhiteSpace(cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR']));
			$sesdir = to_seo_url($acdsess);

			$directoryName = 'downloads/assignments/teachers/' . $sesdir;
			if (!is_dir($directoryName)) {
				//Directory does not exist, so lets create it.
				mkdir($directoryName, 0777);
				$content = "Options -Indexes";
				$fp = fopen($directoryName . "/.htaccess", "wb");
				fwrite($fp, $content);
				fclose($fp);
			}
			//--------------------------------------
			$img_dir = $directoryName . "/";
			$filesize = $_FILES['assign_file_edit']['size'];
			$img = explode('.', $_FILES['assign_file_edit']['name']);
			$originalImage = $img_dir . to_seo_url($rowsurs['curs_code']) . '-' . to_seo_url(cleanvars($_POST['caption_edit'])) . '_' . $_POST['assignid_edit'] . "." . strtolower($img[1]);
			$img_fileName = $sesdir . "/" . to_seo_url($rowsurs['curs_code']) . '-' . to_seo_url(cleanvars($_POST['caption_edit'])) . '_' . $_POST['assignid_edit'] . "." . strtolower($img[1]);
			$extension = strtolower($img[1]);
			if (in_array($extension, array('jpg', 'jpeg', 'gif', 'png', 'pdf', 'docx', 'doc', 'xlsx', 'xls'))) {
				//--------------------------------------
				$sqllmsupload = $dblms->querylms("UPDATE " . COURSES_ASSIGNMENTS . "
														SET fileattach = '" . $img_fileName . "'
												 WHERE  id		= '" . cleanvars($_POST['assignid_edit']) . "'");
				unset($sqllmsupload);
				$mode = '0644';
				//--------------------------------------	
				move_uploaded_file($_FILES['assign_file_edit']['tmp_name'], $originalImage);
				chmod($originalImage, octdec($mode));
			}
			//--------------------------------------
		}

		$requestedvars = "\n";
		$requestedvars .= '"ID:"' . '=>' . '"' . $_POST['assignid_edit'] . '",' . "\n";
		$requestedvars .= '"Status:"' . '=>' . '"' . $_POST['status_edit'] . '",' . "\n";
		$requestedvars .= '"Caption:"' . '=>' . '"' . $_POST['caption_edit'] . '",' . "\n";
		$requestedvars .= '"Details:"' . '=>' . '"",' . "\n";
		$requestedvars .= '"Start Date:"' . '=>' . '"' . $_POST['date_start_edit'] . '",' . "\n";
		$requestedvars .= '"End Date:"' . '=>' . '"' . $_POST['date_end_edit'] . '",' . "\n";
		$requestedvars .= '"Total Marks:"' . '=>' . '"' . $_POST['total_marks_edit'] . '",' . "\n";
		$requestedvars .= '"Passing Marks:"' . '=>' . '"' . $_POST['passing_marks_edit'] . '",' . "\n";
		$requestedvars .= '"File:"' . '=>' . '"' . $originalImage . '",' . "\n";
		$requestedvars .= '"Course ID:"' . '=>' . '"' . $_GET['id'] . '",' . "\n";
		$requestedvars .= '"Course Code:"' . '=>' . '"' . $rowsurs['curs_code'] . '",' . "\n";
		$requestedvars .= '"Course Name:"' . '=>' . '"' . $rowsurs['curs_name'] . '",' . "\n";
		$requestedvars .= '"Emply ID:"' . '=>' . '"' . $rowsstd['emply_id'] . '"';
		//--------------------------------------


		// insert for log
		$logremarks = 'Update Assignments #: ' . $_POST['assignid_edit'] . ' for Course: ' . $rowsurs['curs_code'] . '-' . $rowsurs['curs_name'];
		$datalogs = array(
			'id_user' => cleanvars($_SESSION['userlogininfo']['LOGINIDA']),
			'filename' => basename($_SERVER['REQUEST_URI']),
			'action' => 2,
			'dated' => date("Y-m-d H:i:s"),
			'ip' => cleanvars($ip),
			'remarks' => cleanvars($logremarks),
			'details' => cleanvars($requestedvars),
			'sess_id' => cleanvars(session_id()),
			'device_details' => cleanvars($devicedetails),
			'id_campus' => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']),
		);

		$sqllmsInsertlog = $dblms->Insert(LOGSTEACHER, $datalogs);

		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		header("Location:courses.php?id=" . $_GET['id'] . "&view=Assignments", true, 301);
		exit();

	}
	//--------------------------------------
}

//--------------------------------------
if (isset ($_POST['submit_stdassignment'])) {
	//------------------------------------------------

	if ($_POST['obtain_marks'] > $_POST['total_marks']) {

		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Warning: </span>Marks Should be less than total marks.</div>';
		header("Location:courses.php?id=" . $_GET['id'] . "&view=StudentAssignments", true, 301);
		exit();

	} else {

		$sqllmsstdassign = $dblms->querylms("UPDATE " . COURSES_ASSIGNMENTS_STUDENTS . " SET 
																marks			= '" . cleanvars($_POST['obtain_marks']) . "' 
															, id_modify			= '" . $_SESSION['userlogininfo']['LOGINIDA'] . "'
															, date_modify		= NOW()
														WHERE id				= '" . cleanvars($_POST['assignid_edit']) . "'");
		if ($sqllmsstdassign) {

			$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
			header("Location:courses.php?id=" . $_GET['id'] . "&view=StudentAssignments", true, 301);
			exit();

		}
	}
	//--------------------------------------
}