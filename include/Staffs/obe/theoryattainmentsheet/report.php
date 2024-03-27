<?php
$page = (int)$page;
$sql2 = '';
$sqlstring = "";
$search_term = (isset($_REQUEST['search_term'])  && $_REQUEST['search_term'] != '')  ? $_REQUEST['search_term']  : '';
$searchFeild = (isset($_REQUEST['searchFeild'])  && $_REQUEST['searchFeild'] != '')  ? $_REQUEST['searchFeild']  : '';
$searchOP = (isset($_REQUEST['searchOP'])     && $_REQUEST['searchOP'] != '')     ? $_POST['searchOP']        : '';

if(!LMS_VIEW && !isset($_GET['id'])) 
{  
	if(!($Limit)) 	{ $Limit = 50; } 
	if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}    

	$quiz_sqllms = $dblms->querylms("SELECT quiz_id, quiz_number, id_ques, quiz_marks
										FROM ".OBE_QUIZZES."
										WHERE quiz_id != '' AND id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
									");
	$totalquizes = mysqli_num_rows($quiz_sqllms);
	$totalquizes = $totalquizes + 1; 

	$assignment_sqllms = $dblms->querylms("SELECT assignment_id, assignment_number, id_ques, assignment_marks
											FROM ".OBE_ASSIGNMENTS."
											WHERE assignment_id != '' AND id_teacher = ".ID_TEACHER."  AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
										"); 
	$totalassignments = mysqli_num_rows($assignment_sqllms);    
	$totalassignments = $totalassignments + 1;

	$midterm_sqllms = $dblms->querylms("SELECT mt_id, mt_number, id_ques, mt_marks
											FROM ".OBE_MIDTERMS."
											WHERE mt_id != '' AND id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
										");
	$rowmidterm = mysqli_fetch_array($midterm_sqllms);

	$midtermcols = 1;
	if($rowmidterm){
		$midterm_question_string = $rowmidterm['id_ques'];
		$midterm_questions = explode(',',$rowmidterm['id_ques']);
		$midterm_marks[] = $rowmidterm['mt_marks'];
		$totalmidtermques = count($midterm_questions);
		$midtermcols = $totalmidtermques ;
	}

	$finalterm_sqllms = $dblms->querylms("SELECT ft_id, ft_number, id_ques, ft_marks
												FROM ".OBE_FINALTERMS."
												WHERE ft_id != '' AND id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND theory_paractical = ".COURSE_TYPE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
										");
	$rowFinalterm = mysqli_fetch_array($finalterm_sqllms);

	$finaltermCols = 1;
	if($rowFinalterm) {
		$finaltermQues = $rowFinalterm['id_ques'];
		$finaltermQuesArray = explode(',',$rowFinalterm['id_ques']);
		$finaltermMarks[] = $rowFinalterm['ft_marks'];
		$totalFinaltermQues = count($finaltermQuesArray);
		$finaltermCols = $totalFinaltermQues ;
	}

	$course_clo_sqllms = $dblms->querylms("SELECT GROUP_CONCAT(qu.id_clo) as cloIds
												FROM ".OBE_QUESTIONS." as qu
												Where ques_id != '' AND  id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND theory_paractical = ".COURSE_TYPE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
											");
	$row_course_clo_sqllms = mysqli_fetch_array($course_clo_sqllms);

	if($row_course_clo_sqllms){
		$num_course_clo = 1;
		$num_course_plo = 1;

		if($row_course_clo_sqllms['cloIds'] != NULL) {
			$course_cloids_arr = array_unique(explode(',',$row_course_clo_sqllms['cloIds']));
			$num_course_clo = count($course_cloids_arr);
			
			$course_plo_sqllms = $dblms->querylms("SELECT GROUP_CONCAT(id_plo) as ploIds
													FROM ".OBE_CLOS."
													Where clo_id IN (".implode(',',$course_cloids_arr).") AND clo_id != ''
												");
			$row_course_plo_sqllms = mysqli_fetch_array($course_plo_sqllms);

			if($row_course_plo_sqllms['ploIds'] != NULL) {
				$course_ploids_arr = array_unique(explode(',',$row_course_plo_sqllms['ploIds']));
				$num_course_plo = count($course_ploids_arr);
			}
		}
	}
		
	require_once("include/page_title.php"); 
	echo '
		<div class="table-responsive" style="overflow: auto;">
			<table class="footable table table-bordered table-hover table-with-avatar">
				<thead>
					<tr>
						<th style="vertical-align: middle;" rowspan="5" nowrap="nowrap">Sr. NO.</th>
						<th style="vertical-align: middle;" rowspan="2" colspan="3" nowrap="nowrap">Student Roll No. and Name▼</th>
						<th style="vertical-align: middle;" colspan= "'.$totalquizes.'" nowrap="nowrap">Quizes</th>
						<th style="vertical-align: middle;" colspan= "'.$totalassignments.'" nowrap="nowrap">Assignments</th>
						<th style="vertical-align: middle;" rowspan = "2" colspan= "1" nowrap="nowrap">Total Sessional</th>
						<th style="vertical-align: middle;" rowspan="1" colspan= "'.$midtermcols.'" nowrap="nowrap">MidTerm</th>
						<th style="vertical-align: middle;" rowspan="2" colspan= "1" nowrap="nowrap">Total MidTerm</th>
						<th style="vertical-align: middle;" rowspan="1" colspan= "'.$finaltermCols.'" nowrap="nowrap">FinalTerm</th>
						<th style="vertical-align: middle;" rowspan="2" colspan= "1" nowrap="nowrap">Total FinalTerm</th>
						<th style="vertical-align: middle;" rowspan="2" colspan= "1" nowrap="nowrap">Total Marks</th>
						<th style="vertical-align: middle;" rowspan="5" colspan= "1" nowrap="nowrap">Grades</th>
						<th style="vertical-align: middle;" rowspan="5" colspan= "1">Minimum Criteria of KPI for CLOs & PLOs at Individual Level</th>
						<th style="vertical-align: middle;" rowspan="2" colspan= "'.$num_course_clo.'">Attainment of CLO</th>
						<th style="vertical-align: middle;" rowspan="2" colspan= "'.$num_course_plo.'">Attainment of Mapped PLOs</th>
					</tr>
					<tr>'; 
						if($quiz_sqllms) {
							$quizes_questions = [];
							$quizes_marks = [];
							
							while($value_quiz_sqllms = mysqli_fetch_array($quiz_sqllms)) {
								echo '<th style="vertical-align: middle;" nowrap="nowrap">Q'.$value_quiz_sqllms['quiz_number'].'</th>';

								$quizes_questions[$value_quiz_sqllms['quiz_id']] = $value_quiz_sqllms['id_ques'];
								$quizes_marks[$value_quiz_sqllms['quiz_id']] = $value_quiz_sqllms['quiz_marks'];
							}
							echo '<th style="vertical-align: middle;" nowrap="nowrap">Tot. Q</th>';
						}

						if($assignment_sqllms) {
							$assignments_questions = [];
							$assignments_marks = [];

							while($value_assignment_sqllms = mysqli_fetch_array($assignment_sqllms)) {
								echo '<th style="vertical-align: middle;" nowrap="nowrap">A'.$value_assignment_sqllms['assignment_number'].'</th>';
								$assignments_questions[$value_assignment_sqllms['assignment_id']] = $value_assignment_sqllms['id_ques'];
								$assignments_marks[$value_assignment_sqllms['assignment_id']] = $value_assignment_sqllms['assignment_marks'];
							}
							echo '<th style="vertical-align: middle;" nowrap="nowrap">Tot. A</th>';
						}

						if(isset($rowmidterm['id_ques']) && $rowmidterm['id_ques'] != NULL) {
							for($i = 1; $i <= $totalmidtermques; $i++){
								echo '<th style="vertical-align: middle;" nowrap="nowrap">M'.$i.'</th>';
							}
						} else {
							echo '<th></th>';
						}

						if(isset($rowFinalterm['id_ques']) && $rowFinalterm['id_ques'] != NULL) {
							for($i = 1; $i <= $totalFinaltermQues; $i++) {
								echo '<th style="vertical-align: middle;" nowrap="nowrap">F'.$i.'</th>';
							}
						} else {
							echo '<th></th>';
						}
						echo '  
					</tr>
					<tr>
						<th rowspan="3" style="vertical-align: middle;" nowrap="nowrap">Roll Num</th>
						<th rowspan="3" style="vertical-align: middle;" nowrap="nowrap">Name</th>
						<th rowspan="1" nowrap="nowrap">CLO &#9658;</th>';
						$sessional_clo_number = []; 
						$course_cloNumbers_array = [];
						$course_cloIds_array = [];
						$course_ploIds_array = [];
						
						if(mysqli_num_rows($quiz_sqllms) > 0) {
							$quiz_cloNumbers_array = [];
							$quiz_ploIds_array = [];
							foreach ($quizes_questions as $item) {
								if($item != NULL) {
									$quiz_clo_sqllms = $dblms->querylms("SELECT GROUP_CONCAT(id_clo) AS id_clo 
																			FROM ".OBE_QUESTIONS." 
																			WHERE ques_id IN ($item)");
									$value_quiz_clo_sqllms = mysqli_fetch_array($quiz_clo_sqllms);

									$clo_sqllms = $dblms->querylms("SELECT  GROUP_CONCAT(clo_id) as cloIds, 
																			GROUP_CONCAT(clo_number) as cloNumbers,
																			GROUP_CONCAT(id_plo) as ploIds 
																		FROM ".OBE_CLOS." 
																		WHERE clo_id IN (".$value_quiz_clo_sqllms['id_clo'].")");
									$value_clo_sqllms = mysqli_fetch_array($clo_sqllms);

									$sessional_clo_number[] = $value_clo_sqllms['cloNumbers'];
									$course_cloNumbers_array[] = $value_clo_sqllms['cloNumbers'];
									$course_cloIds_array[] = $value_clo_sqllms['cloIds'];
									$course_ploIds_array[] = $value_clo_sqllms['ploIds'];
									$quiz_cloNumbers_array[] = $value_clo_sqllms['cloNumbers'];
									$quiz_ploIds_array[] = $value_clo_sqllms['ploIds'];

									echo '<th ><span>'.$value_clo_sqllms['cloNumbers'].'</span></th>';
								} else {
									$quiz_ploIds_array[] = NULL;
									echo '<th ><span></span></th>';                
								}
							}
						
							$clo_string = implode(',',$quiz_cloNumbers_array);
							$clo_array = explode(',',$clo_string);
							$clo_array = array_unique($clo_array);
							sort($clo_array);
							echo '<th ><span>'.implode(',',$clo_array).'</span></th>';
						} else {
							echo '<th ><span></span></th>';                
						}
						
						if(mysqli_num_rows($assignment_sqllms) > 0) {
							$assignment_cloNumbers_array = [];
							$assignment_ploIds_array = [];
							foreach ($assignments_questions as $item) {
								if($item != NULL) {
									$assignment_clo_sqllms = $dblms->querylms("SELECT GROUP_CONCAT(id_clo) AS id_clo 
																			FROM ".OBE_QUESTIONS." 
																			WHERE ques_id IN ($item)");
									$value_assignment_clo_sqllms = mysqli_fetch_array($assignment_clo_sqllms);
									if(isset($value_assignment_clo_sqllms['id_clo'])) {
										$clo_sqllms = $dblms->querylms("SELECT  GROUP_CONCAT(clo_id) as cloIds,
																				GROUP_CONCAT(clo_number) as cloNumbers,
																				GROUP_CONCAT(id_plo) as ploIds 
																			FROM ".OBE_CLOS." 
																			WHERE clo_id IN (".$value_assignment_clo_sqllms['id_clo'].")");

										if(mysqli_num_rows($clo_sqllms) > 0) {
											$value_clo_sqllms = mysqli_fetch_array($clo_sqllms);
											$sessional_clo_number[] = $value_clo_sqllms['cloNumbers'];
											$course_cloNumbers_array[] = $value_clo_sqllms['cloNumbers'];
											$course_cloIds_array[] = $value_clo_sqllms['cloIds'];
											$course_ploIds_array[] = $value_clo_sqllms['ploIds'];
											$assignment_cloNumbers_array[] = $value_clo_sqllms['cloNumbers'];
											$assignment_ploIds_array[] = $value_clo_sqllms['ploIds'];
											
											echo '<th ><span>'.$value_clo_sqllms['cloNumbers'].'</span></th>';
										}
									}
								} else {
									$assignment_ploIds_array[] = NULL;
									echo '<th ><span></span></th>';
								}
							}

							$clo_string = implode(',',$assignment_cloNumbers_array);
							$clo_array = explode(',',$clo_string);
							$clo_array = array_unique($clo_array);
							sort($clo_array);

							echo '<th ><span>'.implode(',',$clo_array).'</span></th>'; 
						} else {
							echo '<th ><span></span></th>';
						}

						$sessional_clo_string = implode(',',$sessional_clo_number);
						$sessional_clo_array = explode(',',$sessional_clo_string);
						$sessional_clo_array = array_unique($sessional_clo_array);
						
						sort($sessional_clo_array);
						echo '<th ><span>'.implode(',',$sessional_clo_array).'</span></th>';

						if(isset($rowmidterm['id_ques']) && $rowmidterm['id_ques'] != NULL) {
							$midterm_cloNumbers_array = [];
							$midterm_ploIds_array = [];
							$midterm_ques_marks = [];
							foreach($midterm_questions as $item) {
								if($item != NULL) {
									$midterm_ques_clo_sqllms = $dblms->querylms("SELECT id_clo, ques_marks 
																					FROM ".OBE_QUESTIONS." 
																					WHERE ques_id IN ($item)");
									$value_midterm_ques_clo_sqllms = mysqli_fetch_array($midterm_ques_clo_sqllms);
									if(isset($value_midterm_ques_clo_sqllms['id_clo'])) {
										$clo_sqllms = $dblms->querylms("SELECT GROUP_CONCAT(clo_id) as cloIds, GROUP_CONCAT(clo_number) as cloNumbers, GROUP_CONCAT(id_plo) as ploIds 
																			FROM ".OBE_CLOS." 
																			WHERE clo_id IN (".$value_midterm_ques_clo_sqllms['id_clo'].")");
										$value_clo_sqllms = mysqli_fetch_array($clo_sqllms);

										$course_cloNumbers_array[] = $value_clo_sqllms['cloNumbers'];
										$course_cloIds_array[] = $value_clo_sqllms['cloIds'];
										$course_ploIds_array[] = $value_clo_sqllms['ploIds'];
										$midterm_cloNumbers_array[] = $value_clo_sqllms['cloNumbers'];
										$midterm_ploIds_array[] = $value_clo_sqllms['ploIds'];
										$midterm_ques_marks[] = $value_midterm_ques_clo_sqllms['ques_marks'];
									
										echo '<th ><span>'.$value_clo_sqllms['cloNumbers'].'</span></th>';
									}
								} else {
									$midterm_ploIds_array[] = NULL;
									echo '<th ><span></span></th>';
								}
							}

							$clo_string = implode(',',$midterm_cloNumbers_array);
							$clo_array = explode(',',$clo_string);
							$clo_array = array_unique($clo_array);
							sort($clo_array);
							echo '<th ><span>'.implode(',',$clo_array).'</span></th>'; 
						} else {
							echo '<th ><span></span></th>';
							echo '<th ><span></span></th>';
						}

						if(isset($rowFinalterm['id_ques']) && $rowFinalterm['id_ques'] != NULL) {
							$finalterm_cloNumbers_array = [];
							$finalterm_ploIds_array = [];
							$finalterm_ques_marks = [];

							foreach($finaltermQuesArray as $item) {
								if($item != NULL) {
									$finalterm_ques_clo_sqllms = $dblms->querylms("SELECT id_clo, ques_marks 
																						FROM ".OBE_QUESTIONS." 
																						WHERE ques_id IN ($item)");
									$value_finalterm_ques_clo_sqllms = mysqli_fetch_array($finalterm_ques_clo_sqllms);

									$clo_sqllms = $dblms->querylms("SELECT GROUP_CONCAT(clo_id) as cloIds,
																			GROUP_CONCAT(clo_number) as cloNumbers, 
																			GROUP_CONCAT(id_plo) as ploIds 
																		FROM ".OBE_CLOS." 
																		WHERE clo_id IN (".$value_finalterm_ques_clo_sqllms['id_clo'].")");
									$value_clo_sqllms = mysqli_fetch_array($clo_sqllms);
									
									$course_cloNumbers_array[] = $value_clo_sqllms['cloNumbers'];
									$course_cloIds_array[] = $value_clo_sqllms['cloIds'];
									$course_ploIds_array[] = $value_clo_sqllms['ploIds'];
									$finalterm_cloNumbers_array[] = $value_clo_sqllms['cloNumbers'];
									$finalterm_ploIds_array[] = $value_clo_sqllms['ploIds'];
									$finalterm_ques_marks[] = $value_finalterm_ques_clo_sqllms['ques_marks'];

									echo '<th ><span>'.$value_clo_sqllms['cloNumbers'].'</span></th>';
								} else {
									$finalterm_ploIds_array[] = NULL;
									echo '<th ><span></span></th>';
								}
							}
							$clo_string = implode(',',$finalterm_cloNumbers_array);
							$clo_array = explode(',',$clo_string);
							$clo_array= array_unique($clo_array);
							sort($clo_array);
							echo '<th ><span>'.implode(',',$clo_array).'</span></th>'; 
						} else {
							echo '<th ><span></span></th>';
							echo '<th ><span></span></th>';
						}

						if(count($course_cloNumbers_array) > 0) {
							$course_cloNumbers_string = implode(',',$course_cloNumbers_array);
							$course_cloNumbers_array = explode(',',$course_cloNumbers_string);
							$course_cloNumbers_array = array_unique($course_cloNumbers_array);
							sort($course_cloNumbers_array);
							echo '<th ><span>'.implode(",", $course_cloNumbers_array).'</span></th>';
						} else {
							echo '<th ><span></span></th>';
						}
						
						if(count($course_cloNumbers_array) > 0) {
							foreach ($course_cloNumbers_array as $clo) {
								echo '<th rowspan = "3" style="vertical-align: middle;"><span>CLO'.$clo.'</span></th>';
							}
						} else {
							echo '<th rowspan = "3" style="vertical-align: middle;"><span></span></th>';
						}
						$unique_course_ploNumbers_array = [];
						if(count($course_ploIds_array) > 0) { 
							$unique_course_ploIds_array = array_unique(explode(',',implode(',',$course_ploIds_array)));
							$unique_course_ploIds_str = implode(',',$unique_course_ploIds_array); 
							
							$plo_sqllms = $dblms->querylms("SELECT plo_id, plo_number
															FROM ".OBE_PLOS." 
															WHERE plo_id IN (".$unique_course_ploIds_str.")
														");
							
							while($value_plo_sqllms = mysqli_fetch_array($plo_sqllms)) {
								$unique_course_ploNumbers_array[$value_plo_sqllms['plo_number']] = $value_plo_sqllms['plo_number'];
								echo '<th rowspan = "3" style="vertical-align: middle;"><span>PLO'.$value_plo_sqllms['plo_number'].'</span></th>';
							}
						} else {
							echo '<th rowspan = "3" style="vertical-align: middle;"><span></span></th>';
						}
						echo '
					</tr> 
					<tr>              
						<th rowspan="1" nowrap="nowrap">PLO &#9658;</th>';
						$sessional_ploNumbers_array = [];

						if(mysqli_num_rows($quiz_sqllms) > 0) {
							$quiz_ploNumbers_array = [];
							
							foreach($quiz_ploIds_array as $item) {
								if($item != NULL) {
									$plo_sqllms = $dblms->querylms("SELECT  GROUP_CONCAT(plo_id) as ploIds, GROUP_CONCAT(plo_number) as ploNumbers
																	FROM ".OBE_PLOS." 
																	WHERE plo_id IN (".$item.")");
									$value_plo_sqllms = mysqli_fetch_array($plo_sqllms);
									$quiz_ploNumbers_array[] = $value_plo_sqllms['ploNumbers'];
									$sessional_ploNumbers_array[] = $value_plo_sqllms['ploNumbers'];

									echo '<th ><span>'.$value_plo_sqllms['ploNumbers'].'</span></th>';
								} else {
									echo '<th ><span></span></th>';
								}
							}
							$plo_string = implode(',',$quiz_ploNumbers_array);
							$plo_array = explode(',',$plo_string);
							$plo_array = array_unique($plo_array);
							sort($plo_array);
							echo '<th ><span>'.implode(',',$plo_array).'</span></th>';
						} else {
							echo '<th ><span></span></th>';
						}

						if(mysqli_num_rows($assignment_sqllms) > 0) {
							$assignment_ploNumbers_array = [];
							
							foreach ($assignment_ploIds_array as $item) {
								if($item != NULL) {
									$plo_sqllms = $dblms->querylms("SELECT  GROUP_CONCAT(plo_id) as ploIds, GROUP_CONCAT(plo_number) as ploNumbers
																		FROM ".OBE_PLOS." 
																		WHERE plo_id IN (".$item.")");
									$value_plo_sqllms = mysqli_fetch_array($plo_sqllms);
									$assignment_ploNumbers_array[] = $value_plo_sqllms['ploNumbers'];
									$sessional_ploNumbers_array[] = $value_plo_sqllms['ploNumbers'];
														
									echo '<th ><span>'.$value_plo_sqllms['ploNumbers'].'</span></th>';
								} else {
									echo '<th ><span></span></th>';
								}
							}

							$plo_string = implode(',',$assignment_ploNumbers_array);
							$plo_array = explode(',',$plo_string);
							$plo_array = array_unique($plo_array);
							sort($plo_array);
							echo '<th ><span>'.implode(',',$plo_array).'</span></th>';
						} else {
							echo '<th ><span></span></th>';
						}

						$sessional_plo_string = implode(',',$sessional_ploNumbers_array);
						$sessional_plo_array = explode(',',$sessional_plo_string);
						$sessional_plo_array = array_unique($sessional_plo_array);
						sort($sessional_plo_array);
						echo '<th ><span>'.implode(',',$sessional_plo_array).'</span></th>';

						if(isset($rowmidterm['id_ques']) && $rowmidterm['id_ques'] != NULL) {
							$midterm_ploNumbers_array = [];
							foreach ($midterm_ploIds_array as $item) {
								if($item != NULL) {
									$plo_sqllms = $dblms->querylms("SELECT  GROUP_CONCAT(plo_id) as ploIds, GROUP_CONCAT(plo_number) as ploNumbers
																FROM ".OBE_PLOS." 
																WHERE plo_id IN (".$item.")");
									$value_plo_sqllms = mysqli_fetch_array($plo_sqllms);
									$midterm_ploNumbers_array[] = $value_plo_sqllms['ploNumbers'];
									$sessional_ploNumbers_array[] = $value_plo_sqllms['ploNumbers'];
									
									echo '<th ><span>'.$value_plo_sqllms['ploNumbers'].'</span></th>';
								} else {
									echo '<th ><span></span></th>';
								}
							}
							$plo_string = implode(',',$midterm_ploNumbers_array);
							$plo_array = explode(',',$plo_string);
							$plo_array = array_unique($plo_array);
							sort($plo_array);
							echo '<th ><span>'.implode(',',$plo_array).'</span></th>';
						} else {
							echo '<th ><span></span></th>';
							echo '<th ><span></span></th>';
						}
						
						if(isset($rowFinalterm['id_ques']) && $rowFinalterm['id_ques'] != NULL) {
							$finalterm_ploNumbers_array = [];

							foreach ($finalterm_ploIds_array as $item) {
								if($item != NULL) {
									$plo_sqllms = $dblms->querylms("SELECT  GROUP_CONCAT(plo_id) as ploIds, GROUP_CONCAT(plo_number) as ploNumbers
																FROM ".OBE_PLOS." 
																WHERE plo_id IN (".$item.")");
									$value_plo_sqllms = mysqli_fetch_array($plo_sqllms);
									$finalterm_ploNumbers_array[] = $value_plo_sqllms['ploNumbers'];
									$sessional_ploNumbers_array[] = $value_plo_sqllms['ploNumbers'];
									
									echo '<th ><span>'.$value_plo_sqllms['ploNumbers'].'</span></th>';
								} else {
									echo '<th ><span></span></th>';
								}
							}
							$plo_string = implode(',',$finalterm_ploNumbers_array);
							$plo_array = explode(',',$plo_string);
							$plo_array = array_unique($plo_array);
							sort($plo_array);
							echo '<th ><span>'.implode(',',$plo_array).'</span></th>';
						} else {
							echo '<th ><span></span></th>';
							echo '<th ><span></span></th>';
						}

						if(count($unique_course_ploNumbers_array) > 0) {
							$unique_course_ploNumbers_str = implode(",", $unique_course_ploNumbers_array);
							echo '<th ><span>'.$unique_course_ploNumbers_str.'</span></th>'; 
						} else {
							echo '<th ><span></span></th>';
						}
						echo '
					</tr>
					<tr>
						<th nowrap="nowrap">Marks &#9658;</th>';
						$total_sessional_marks = 0;

						if(mysqli_num_rows($quiz_sqllms) > 0) {
							$totalquizmarks = 0;
							foreach ($quizes_marks as $item) {
								echo '<th>'.$item.'</th>';
								$totalquizmarks = $totalquizmarks + $item;
							}

							$val = (10 * (count($quizes_questions) + 1)) - $totalquizmarks;
							$relative_quiz = ($val + $totalquizmarks) / (count($quizes_questions) + 1) ;
							echo '<th ><span>'.$relative_quiz.'</span></th>';

							$total_sessional_marks = $total_sessional_marks + $relative_quiz;
						} else {
							echo '<th ><span>0</span></th>';
						}

						if(mysqli_num_rows($assignment_sqllms) > 0) {
							$totalassignmentmarks = 0;
							$relative_assignment = 0;
							foreach ($assignments_marks as $value) {
								echo '<th>'.$value.'</th>';
								$totalassignmentmarks = $totalassignmentmarks + $value;
							}
							
							$val = (15 * (count($assignments_questions) + 1)) - $totalassignmentmarks;
							$relative_assignment = ($val + $totalassignmentmarks) / (count($assignments_questions) + 1) ;
							echo '<th ><span>'.$relative_assignment.'</span></th>';

							$total_sessional_marks = $total_sessional_marks + $relative_assignment;
						} else {
							echo '<th ><span>0</span></th>';
						}

						echo '<th ><span>'.$total_sessional_marks.'</span></th>';
						
						$total_midterm_marks = 0;
						$relative_midterm = 0;
						if(isset($rowmidterm['id_ques']) && $rowmidterm['id_ques'] != NULL) {
							foreach ($midterm_ques_marks as $value) {
								echo '<th>'.$value.'</th>';
								$total_midterm_marks = $total_midterm_marks + $value;
							}
							$val = (25 * (count(explode(',',$rowmidterm['id_ques'])) + 1)) - $total_midterm_marks;
							$relative_midterm = ($val + $total_midterm_marks) / (count(explode(',',$rowmidterm['id_ques'])) + 1) ;
							echo '<th ><span>'.$relative_midterm.'</span></th>';
						} else {
							echo '<th ><span></span></th>';
							echo '<th ><span>'.$total_midterm_marks.'</span></th>';
						}

						$total_finaltermMarks = 0;
						$relative_finalterm = 0;
						if(isset($rowFinalterm['id_ques']) && $rowFinalterm['id_ques'] != NULL) {
							foreach ($finalterm_ques_marks as $value) {
								echo '<th>'.$value.'</th>';
								$total_finaltermMarks = $total_finaltermMarks + $value;
							}
							$val = (50 * (count(explode(',',$rowFinalterm['id_ques'])) + 1)) - $total_finaltermMarks;
							$relative_finalterm = ($val + $total_finaltermMarks) / (count(explode(',',$rowFinalterm['id_ques'])) + 1) ;
							echo '<th ><span>'.$relative_finalterm.'</span></th>';
						} else {
							echo '<th ><span></span></th>';
							echo '<th ><span>'.$total_finaltermMarks.'</span></th>';
						}

						$total_marks = $relative_finalterm + $relative_midterm + $total_sessional_marks;
						echo '<th ><span>'.$total_marks.'</span></th>
					</tr>
				</thead>
				<tbody>';
               if($page == 1) { $srno = 0; } else { $srno = ($Limit * ($page-1));}
					$stdCount = 0;
					$attainedCloMarks = [];
					$attainedPloMarks = [];
					
					if(count(STUDENT) > 0) {
						foreach (STUDENT as $stdRollNum => $stdId)  {
							$columns = 4;
							$stdCount++;
							$srno++;
							echo '
							<tr>
								<td nowrap="nowrap">'.$srno.'</td>
								<td nowrap="nowrap">'.$stdId['id'].'</td>
								<td colspan="2" nowrap="nowrap">'.$stdId['name'].'</td>';

								$obt_sessional_marks = 0;
								if(mysqli_num_rows($quiz_sqllms) > 0) {
									$obt_quiz_marks = 0;
									foreach ($quizes_questions as $item) {
										$columns++;
										if($item != NULL) {
											$resultsqllms = $dblms->querylms("SELECT sum(obt_marks) as obt_marks
																		FROM ".OBE_QUESTIONS_RESULTS."
																		Where id_ques IN (".$item.") 
																		&& id_std = ".$stdRollNum."
																		");
											$marks = mysqli_fetch_array($resultsqllms);
											
											echo '<td>'.$marks['obt_marks'].'</td>';
											$obt_quiz_marks = $obt_quiz_marks + $marks['obt_marks'];
										} else {
											echo '<td></td>';
										}
									}

									$columns++;
									if($obt_quiz_marks > 0) {
										$ratio = $obt_quiz_marks / array_sum($quizes_marks);
										$relativeQuizMarks = $ratio * 10;
										echo '<td><span>'.round($relativeQuizMarks,0).'</span></td>';

										$obt_sessional_marks = $obt_sessional_marks + $relativeQuizMarks;
										} else {
										echo '<td><span></span></td>';
									}   
								} else {
									$columns++;
									echo '<td></td>';
								}
								
								if(mysqli_num_rows($assignment_sqllms) > 0) {
									$obt_assignment_marks = 0;
									foreach ($assignments_questions as $item) {
										$columns++;
										if($item != NULL) {
											$resultsllms = $dblms->querylms("SELECT sum(obt_marks) as obt_marks
																		FROM ".OBE_QUESTIONS_RESULTS."
																		Where id_ques IN (".$item.") 
																		&& id_std = ".$stdRollNum."
																		");
											$marks = mysqli_fetch_array($resultsllms);

											echo '<td>'.$marks['obt_marks'].'</td>';
											$obt_assignment_marks = $obt_assignment_marks + $marks['obt_marks'];
										
										} else {
											echo '<td></td>';
										}
									}
									$columns++;

									if($obt_assignment_marks > 0) {
										$ratio = $obt_assignment_marks / array_sum($assignments_marks);
										$relativeAssignmentMarks = $ratio * 15;

										echo '<td><span>'.round($relativeAssignmentMarks,0).'</span></td>';

										$obt_sessional_marks = $obt_sessional_marks + $relativeAssignmentMarks;
										} else {
										echo '<td><span></span></td>';
									}
								} else {
									$columns++;
									echo '<td></td>';
								}

								$columns++;
								echo '<td>'.round($obt_sessional_marks,0).'</td>';
								
								$obt_midterm_marks = 0;
								if(isset($rowmidterm['id_ques']) && $rowmidterm['id_ques'] != NULL) {
									foreach ($midterm_questions as $item) {
										$columns++;
										if($item != NULL) {
											$resultsllms = $dblms->querylms("SELECT sum(obt_marks) as obt_marks
																		FROM ".OBE_QUESTIONS_RESULTS."
																		Where id_ques IN (".$item.") 
																		AND id_std = ".$stdRollNum."
																		");
											$marks = mysqli_fetch_array($resultsllms);

											echo '<td>'.$marks['obt_marks'].'</td>';
											$obt_midterm_marks = $obt_midterm_marks + $marks['obt_marks'];
										} else {
											echo '<td></td>';
										} 
									}

									$columns++;
									$ratio = $obt_midterm_marks / array_sum($midterm_marks);
									$obt_midterm_marks = $ratio * 25;

									echo '<td><span>'.round($obt_midterm_marks,0).'</span></td>';
								} else { 
									$columns = $columns + 2;
									echo '<td ><span></span></td>';
									echo '<td ><span>'.round($obt_midterm_marks,0).'</span></td>';
								}

								$obt_finaltermMarks = 0;
								if(isset($rowFinalterm['id_ques']) && $rowFinalterm['id_ques'] != NULL) {
									foreach ($finaltermQuesArray as $item) {
										$columns++;
										if($item != NULL) {
											$resultsllms = $dblms->querylms("SELECT sum(obt_marks) as obt_marks
																		FROM ".OBE_QUESTIONS_RESULTS."
																		Where id_ques IN (".$item.") 
																		&& id_std = ".$stdRollNum."
																		");
											$marks = mysqli_fetch_array($resultsllms);

											echo '<td>'.$marks['obt_marks'].'</td>';
											$obt_finaltermMarks = $obt_finaltermMarks + $marks['obt_marks'];
										} else {
											echo '<td></td>';
										} 
									}
									
									$ratio = $obt_finaltermMarks / array_sum($finaltermMarks);
									$obt_finaltermMarks = $ratio * 50;

									echo '<td><span>'.round($obt_finaltermMarks,0).'</span></td>';
								} else {
									$columns++;
									echo '<td ><span></span></td>';
									echo '<td ><span>'.round($obt_finaltermMarks,0).'</span></td>';
								}

								$total_obt_marks = $obt_sessional_marks + $obt_midterm_marks + $obt_finaltermMarks;
								$obt_percentage = 0;
								if($total_obt_marks > 0) {
									$obt_percentage = round((($total_obt_marks)/($total_marks)*100),0);
								}

								echo '<td>'.round($total_obt_marks,0).'</td>';
								
								if($total_obt_marks < 50) {
									echo '<td>'.GRADES['f'].'</td>';
								}
								elseif ($total_obt_marks >= 50 && $total_obt_marks < 55) {
									echo '<td>'.GRADES['d'].'</td>';
								}
								elseif ($total_obt_marks >= 55 && $total_obt_marks < 58) {
									echo '<td>'.GRADES['c-'].'</td>';
								}
								elseif ($total_obt_marks >= 58 && $total_obt_marks < 61) {
									echo '<td>'.GRADES['c'].'</td>';
								}
								elseif ($total_obt_marks >= 61 && $total_obt_marks < 65) {
									echo '<td>'.GRADES['c+'].'</td>';
								}
								elseif ($total_obt_marks >= 65 && $total_obt_marks < 70) {
									echo '<td>'.GRADES['b-'].'</td>';
								}
								elseif ($total_obt_marks >= 70 && $total_obt_marks < 75) {
									echo '<td>'.GRADES['b'].'</td>';
								}
								elseif ($total_obt_marks >= 75 && $total_obt_marks < 80) {
									echo '<td>'.GRADES['b+'].'</td>';
								}
								elseif ($total_obt_marks >= 80 && $total_obt_marks < 85) {
									echo '<td>'.GRADES['a'].'</td>';
								}
								elseif ($total_obt_marks >= 85) {
									echo '<td>'.GRADES['a+'].'</td>';
								}

								echo '<td>50%</td>';

								$unique_courseCloIds_array = array_unique(explode(',',implode(',',$course_cloIds_array)));
								$cloCount = 0;
								if(isset($unique_courseCloIds_array)) {
									foreach ($unique_courseCloIds_array as $clo) {
									$clo_totalMarks = 0;
									$clo_obtMarks = 0;
									$quizes = array();
									$assignments = array();
									$clo_marks = array();
									
									if($clo != NULL) {
										$cloCount++;
										$sqllms = $dblms->querylms("SELECT GROUP_CONCAT(ques_id) as ques_ids
																	FROM ".OBE_QUESTIONS."
																	Where FIND_IN_SET(".$clo.", id_clo)  
																	");
										$rowstd = mysqli_fetch_array($sqllms);
										if($rowstd['ques_ids'] != NULL) {
											$ques_ids = explode(",",$rowstd['ques_ids']);
											foreach ($ques_ids as $q_id) {
												$sqllms = $dblms->querylms("SELECT quiz_id, quiz_marks, id_ques
																		FROM ".OBE_QUIZZES."
																		Where FIND_IN_SET(".$q_id.", id_ques) 
																		");
												$result = mysqli_fetch_array($sqllms);
												if($result) {
													$quizes[$result['quiz_id']] = $result['quiz_marks'];
													
													$sqllms = $dblms->querylms("SELECT sum(obt_marks) as obtMarks
																		FROM ".OBE_QUESTIONS_RESULTS."
																		Where id_ques IN (".$result['id_ques'].") && id_std = ".$stdRollNum."
																		");
													$record = mysqli_fetch_array($sqllms);

													$clo_marks['quiz'][$result['quiz_id']] = $record['obtMarks'];
													continue;
												}
												
												$sqllms = $dblms->querylms("SELECT assignment_id, assignment_marks, id_ques
																			FROM ".OBE_ASSIGNMENTS."
																			Where FIND_IN_SET(".$q_id.", id_ques) 
																			");
												$result = mysqli_fetch_array($sqllms);
												if($result) {
													$assignments[$result['assignment_id']] = $result['assignment_marks'];
													
													$sqllms = $dblms->querylms("SELECT sum(obt_marks) as obtMarks
																		FROM ".OBE_QUESTIONS_RESULTS."
																		Where id_ques IN (".$result['id_ques'].") && id_std = ".$stdRollNum." 
																		");
													$record = mysqli_fetch_array($sqllms);
													
													$clo_marks['assignment'][$result['assignment_id']] = $record['obtMarks'];
													continue;
												}

												$sqllms = $dblms->querylms("SELECT id_ques
																			FROM ".OBE_MIDTERMS."
																			Where FIND_IN_SET(".$q_id.", id_ques) 
																			");
												$record = mysqli_fetch_array($sqllms);
												if($record) {
													$sqllms = $dblms->querylms("SELECT ques_marks
																				FROM ".OBE_QUESTIONS."
																				Where ques_id IN (".$q_id.") 
																			");
													$result = mysqli_fetch_array($sqllms);
													$clo_totalMarks = $clo_totalMarks + $result['ques_marks'];

													$sqllms = $dblms->querylms("SELECT sum(obt_marks) as obtMarks
																					FROM ".OBE_QUESTIONS_RESULTS."
																					Where id_ques IN (".$q_id.") && id_std = ".$stdRollNum." 
																				");
													$record = mysqli_fetch_array($sqllms);
													$clo_obtMarks = $clo_obtMarks + $record['obtMarks'];

													continue;
												}

												$sqllms = $dblms->querylms("SELECT id_ques
																			FROM ".OBE_FINALTERMS."
																			Where FIND_IN_SET(".$q_id.", id_ques) 
																		");
												$record = mysqli_fetch_array($sqllms);
												if($record) {
													$sqllms = $dblms->querylms("SELECT ques_marks
																				FROM ".OBE_QUESTIONS."
																				Where ques_id IN (".$q_id.") 
																			");
													$result = mysqli_fetch_array($sqllms);
													$clo_totalMarks = $clo_totalMarks + $result['ques_marks'];

													$sqllms = $dblms->querylms("SELECT sum(obt_marks) as obtMarks
																					FROM ".OBE_QUESTIONS_RESULTS."
																					Where id_ques IN (".$q_id.") && id_std = ".$stdRollNum." 
																				");
													$result = mysqli_fetch_array($sqllms);
													$clo_obtMarks = $clo_obtMarks + $result['obtMarks'];

													continue;
												}
											}
										}
									
										foreach ($clo_marks as $idkey => $value)  {
											foreach ($value as $item) {
												$clo_obtMarks = $clo_obtMarks + $item;
											}
										}

										foreach ($quizes as $value)  {
											$clo_totalMarks = $clo_totalMarks + $value;
										}

										foreach ($assignments as $value) {
											$clo_totalMarks = $clo_totalMarks + $value;
										}
									
										$cloPercentage = round((($clo_obtMarks / $clo_totalMarks)*100),0);
										echo '<td>'.$cloPercentage.'%</td>';

										$attainedCloMarks[$stdRollNum][$clo] = $cloPercentage;
									} else {
										echo '<td></td>';
									}
									
									}
								} else {
									echo '<td></td>';
								}
					
								$ploCount = 0;
								if(isset($unique_course_ploIds_array)) {
									foreach ($unique_course_ploIds_array as $plo) {
										if($plo != '') {
											$ploCount++;
											$plo_totalMarks = 0;
											$plo_obtMarks = 0;
											$quizes = array();
											$assignments = array();
											$plo_marks = array();
											
											$sqllms = $dblms->querylms("SELECT GROUP_CONCAT(clo_id) as clo_ids
																			FROM ".OBE_CLOS."
																			Where FIND_IN_SET(".$plo.", id_plo)  
																		");
											$rowstd = mysqli_fetch_array($sqllms);
											$clo_ids = explode(",",$rowstd['clo_ids']);
											
											foreach ($clo_ids as $clo)  { 
												if($clo != '') {
													$sqllms = $dblms->querylms("SELECT GROUP_CONCAT(ques_id) as ques_ids
																					FROM ".OBE_QUESTIONS."
																					Where FIND_IN_SET(".$clo.", id_clo)  
																				");
													$rowstd = mysqli_fetch_array($sqllms);
													if($rowstd['ques_ids'] != NULL) {
														$ques_ids = explode(",",$rowstd['ques_ids']);
														foreach ($ques_ids as $q_id) {
															$sqllms = $dblms->querylms("SELECT quiz_id, quiz_marks, id_ques
																						FROM ".OBE_QUIZZES."
																						Where FIND_IN_SET(".$q_id.", id_ques) 
																					");
															$result = mysqli_fetch_array($sqllms);
															if($result) {
																$quizes[$result['quiz_id']] = $result['quiz_marks'];
																
																$sqllms = $dblms->querylms("SELECT sum(obt_marks) as obtMarks
																								FROM ".OBE_QUESTIONS_RESULTS."
																								Where id_ques IN (".$result['id_ques'].") && id_std = ".$stdRollNum."
																							");
																$record = mysqli_fetch_array($sqllms);
										
																$plo_marks[$result['quiz_id']] = $record['obtMarks'];
																continue;
															}

															$sqllms = $dblms->querylms("SELECT assignment_id, assignment_marks, id_ques
																							FROM ".OBE_ASSIGNMENTS."
																							Where FIND_IN_SET(".$q_id.", id_ques) 
																					");
															$result = mysqli_fetch_array($sqllms);
															if($result) {
																$assignments[$result['assignment_id']] = $result['assignment_marks'];
																
																$sqllms = $dblms->querylms("SELECT sum(obt_marks) as obtMarks
																								FROM ".OBE_QUESTIONS_RESULTS."
																								Where id_ques IN (".$result['id_ques'].") && id_std = ".$stdRollNum." 
																							");
																$record = mysqli_fetch_array($sqllms);
																
																$plo_marks[$result['assignment_id']] = $record['obtMarks'];
																continue;
															}

															$sqllms = $dblms->querylms("SELECT id_ques
																						FROM ".OBE_MIDTERMS."
																						Where FIND_IN_SET(".$q_id.", id_ques) 
																					");
															$record = mysqli_fetch_array($sqllms);
															if($record) {
																$sqllms = $dblms->querylms("SELECT ques_marks
																								FROM ".OBE_QUESTIONS."
																								Where ques_id IN (".$q_id.") 
																							");
																$result = mysqli_fetch_array($sqllms);
																$plo_totalMarks = $plo_totalMarks + $result['ques_marks'];

																$sqllms = $dblms->querylms("SELECT sum(obt_marks) as obtMarks
																								FROM ".OBE_QUESTIONS_RESULTS."
																								Where id_ques IN (".$q_id.") && id_std = ".$stdRollNum." 
																							");
																$result = mysqli_fetch_array($sqllms);
																$plo_obtMarks = $plo_obtMarks + $result['obtMarks'];
																continue;
															}

															$sqllms = $dblms->querylms("SELECT id_ques
																							FROM ".OBE_FINALTERMS."
																							Where FIND_IN_SET(".$q_id.", id_ques) 
																						");
															$record = mysqli_fetch_array($sqllms);
															if($record) {
																$sqllms = $dblms->querylms("SELECT ques_marks
																								FROM ".OBE_QUESTIONS."
																								Where ques_id IN (".$q_id.") 
																							");
																$result = mysqli_fetch_array($sqllms);
																$plo_totalMarks = $plo_totalMarks + $result['ques_marks'];

																$sqllms = $dblms->querylms("SELECT sum(obt_marks) as obtMarks
																								FROM ".OBE_QUESTIONS_RESULTS."
																								Where id_ques IN (".$q_id.") && id_std = ".$stdRollNum." 
																					");
																$result = mysqli_fetch_array($sqllms);
																$plo_obtMarks = $plo_obtMarks + $result['obtMarks'];
																continue;
															}
														}
													}
												}
											}

											foreach ($plo_marks as $value)  {
												$plo_obtMarks = $plo_obtMarks + $value;
											}

											foreach ($quizes as $value)  {
												$plo_totalMarks = $plo_totalMarks + $value;
											}

											foreach ($assignments as $value) {
												$plo_totalMarks = $plo_totalMarks + $value;
											}
											
											$ploPercentage = round((($plo_obtMarks / $plo_totalMarks)*100),0);
											echo '<td><span>'.$ploPercentage.'%</span></td>';
											$attainedPloMarks[$stdRollNum][$plo] = $ploPercentage;
										} else {
											echo '<td><span></span></td>';  
										}
									}
								} else {
									echo '<td></td>';
								}
								echo '
							</tr>'; 
						}
					}
					
					$numArrays = count($attainedCloMarks);
					$averagesClo = array();
					$countsClo = [];

					foreach ($attainedCloMarks as $cloMarksArray) {
						foreach ($cloMarksArray as $cloId => $marks) {
							if (!isset($averagesClo[$cloId])) {
								$averagesClo[$cloId] = 0;
								$countsClo[$cloId] = 0; 
							}
							$averagesClo[$cloId] += $marks;
							if($marks > 50) {
							$countsClo[$cloId]++;
							}
						}
					}

					foreach ($averagesClo as $cloId => $total) {
						$averagesClo[$cloId] = $total / $numArrays;
					}
			
					echo ' 
					<tr>
						<td colspan="'.$columns.'" rowspan="8"></td>
						<td colspan="4" style="text-align: right;" nowrap="nowrap">No. of Students who Attained 50% in CLO &#9658</td>';
						if(count($countsClo) > 0)  {
							foreach ($countsClo as $cloId => $item) {
								echo '<td>'.$item.'</td>';
							}
						} else {
							echo '<td></td>';
							echo '<td></td>';
						}
						if(isset($ploCount) && $ploCount > 0) {                
							echo '<td colspan="'.$ploCount.'" rowspan="4"></td>';
						}
						
						echo '
					</tr>
					<tr>
						<td colspan="4" style="text-align: right;" nowrap="nowrap">Attainment of CLO at Cohort Level &#9658</td>';
						if(count($countsClo) > 0)  {
							foreach ($countsClo as $cloId => $item) {
							$cloattainmentcohort[$cloId] = round((($item/$stdCount)*100),0); 
								echo '<td>'.round((($item/$stdCount)*100),0).'%</td>';
							}
						} else {
							echo '<td></td>';
							echo '<td></td>';
						}
						echo '
					</tr>
					<tr>
						<td colspan="4" style="text-align: right;" nowrap="nowrap">Average attainment of KPI (CLO) &#9658</td>';
						if(count($averagesClo) > 0) {
							foreach ($averagesClo as $item) {
								echo '<td>'.round($item,0).'%</td>';
							}
						} else {
							echo '<td></td>';
							echo '<td></td>';
						}
						echo '
					</tr>
					<tr>
						<td colspan="4" style="text-align: right;" nowrap="nowrap">Minimum Criteria of KPI for CLO at Cohort Level &#9658</td>';
						if(isset($cloCount) && $cloCount > 0) {
							for ($i=0; $i < $cloCount; $i++) { 
								echo '<td>60%</td>';
							}
						} else {
							echo '<td></td>';
							echo '<td></td>';
						}
						echo '
					</tr>'; 
					$numArrays = count($attainedPloMarks);
					$averagesPlo = array();
					$countsPlo = [];

					foreach ($attainedPloMarks as $ploMarksArray) {
						foreach ($ploMarksArray as $ploId => $marks) {
							if (!isset($averagesPlo[$ploId])) {
								$averagesPlo[$ploId] = 0;
								$countsPlo[$ploId] = 0; 
							}
							$averagesPlo[$ploId] += $marks;
							if($marks > 50) {
								$countsPlo[$ploId]++;
							}	
						}
					}

					foreach ($averagesPlo as $ploId => $total) {
						$averagesPlo[$ploId] = $total / $numArrays;
					}
					
					if(isset($cloCount) && $cloCount > 0) {
						$col = $cloCount + 4;
					} else {
						$col = 5;
					}
					echo '
					<tr>
						<td colspan="'.$col.'" style="text-align: right;" nowrap="nowrap">No. of Students who Attained 50% in PLOs &#9658</td>';
					
						if(count($countsPlo) > 0) {
							foreach ($countsPlo as $ploId => $item) {
								echo '<td>'.$item.'</td>';
							}
						} else {
							echo '<td></td>';
						}
						echo '
					</tr>
					<tr>
						<td colspan="'.$col.'" style="text-align: right;" nowrap="nowrap">Attainment of PLOs at Cohort Level &#9658</td>';
						if(count($countsPlo) > 0) {
							foreach ($countsPlo as $ploId => $item) {
								$ploattainmentcohort[$ploId] = round((($item/$stdCount)*100),0); 
								echo '<td>'.round((($item/$stdCount)*100),0).'%</td>';
							}
						} else {
							echo '<td></td>';
						}
						echo '
					</tr>
					<tr>
						<td colspan="'.$col.'" style="text-align: right;" nowrap="nowrap">Average attainment of KPI (PLO) &#9658</td>';
						if(count($averagesPlo)) {
							foreach ($averagesPlo as $item) {
								echo '<td>'.round($item,0).'%</td>';
							}
						} else {
							echo '<td></td>';
						}
						echo '
					</tr>
					
					<tr>
						<td colspan="'.$col.'" style="text-align: right;" nowrap="nowrap">Minimum Criteria of KPI for PLOs at Cohort Level &#9658</td>';
						if(isset($ploCount) && $ploCount > 0)  {
							for ($i=0; $i < $ploCount; $i++)  { 
								echo '<td>60%</td>';
							}
						} else {
							echo '<td></td>';
						}
						echo '
					</tr>
				</tbody>
			</table>
		</div>';
		
	$stdIds = array_keys($attainedCloMarks);
	$studentIDs = array();
	foreach ($stdIds as $value) {
		if(isset(STUDENT[$value]['id']))
		{
			$studentIDs[] = STUDENT[$value]['id'];
		}
	}

	$datasetsClo = array();
	if(count($attainedCloMarks) > 0) {
		foreach ($attainedCloMarks[1] as $cloId => $value) {
			$dataClo = array();
			foreach ($attainedCloMarks as $index => $item) {
				$dataClo[] = $item[$cloId];
			}

			$backgroundColors = [
			'rgba(58, 200, 225, 0.6)', 'rgba(255, 99, 132, 0.6)', 'rgba(255, 206, 86, 0.6)',
			'rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)', 'rgba(255, 159, 64, 0.6)',
			'rgba(54, 162, 235, 0.6)', 'rgba(255, 102, 102, 0.6)', 'rgba(255, 153, 204, 0.6)',
			'rgba(139, 0, 0, 0.6)', 'rgba(0, 100, 0, 0.6)', 'rgba(128, 0, 128, 0.6)',
			'rgba(128, 128, 0, 0.6)', 'rgba(0, 128, 128, 0.6)', 'rgba(0, 0, 128, 0.6)',
			'rgba(255, 165, 0, 0.6)', 'rgba(0, 128, 0, 0.6)', 'rgba(218, 112, 214, 0.6)',
			'rgba(128, 0, 0, 0.6)', 'rgba(255, 0, 0, 0.6)'
			];
			$borderColors = [
						'rgba(58, 200, 225, 1)', 'rgba(255, 99, 132, 1)', 'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)',
						'rgba(54, 162, 235, 1)', 'rgba(255, 102, 102, 1)', 'rgba(255, 153, 204, 1)',
						'rgba(139, 0, 0, 1)', 'rgba(0, 100, 0, 1)', 'rgba(128, 0, 128, 1)',
						'rgba(128, 128, 0, 1)', 'rgba(0, 128, 128, 1)', 'rgba(0, 0, 128, 1)',
						'rgba(255, 165, 0, 1)', 'rgba(0, 128, 0, 1)', 'rgba(218, 112, 214, 1)',
						'rgba(128, 0, 0, 1)', 'rgba(255, 0, 0, 1)'
				];
			$backgroundColor = $backgroundColors[$cloId - 1]; // Assign a different color for each dataset
			$borderColor = $borderColors[$cloId - 1]; // Assign a different color for each dataset

			$dataset = array(
				'label' => 'CLO'.$cloId,
				'backgroundColor' => $backgroundColor,
				'borderColor' => $borderColor,
				'borderWidth' => 2,
				'data' => $dataClo,
				'datalabels' => [
				'color'=>'blue',
				'anchor'=>'end',
				'align'=>'top'
				]
			);
			$datasetsClo[] = $dataset;
		}
	}

	$dataClo = array(
		'labels' => $studentIDs,
		'datasets' => $datasetsClo,
	);


	$datasetsPlo = array();
	if(count($attainedPloMarks) > 0) {
		foreach ($attainedPloMarks[1] as $ploId => $value) {
			$dataPlo = array();
			foreach ($attainedPloMarks as $index => $item) {
				$dataPlo[] = $item[$ploId];
			}
			$backgroundColors = [
						'rgba(58, 200, 225, 0.6)', 'rgba(255, 99, 132, 0.6)', 'rgba(255, 206, 86, 0.6)',
						'rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)', 'rgba(255, 159, 64, 0.6)',
						'rgba(54, 162, 235, 0.6)', 'rgba(255, 102, 102, 0.6)', 'rgba(255, 153, 204, 0.6)',
						'rgba(139, 0, 0, 0.6)', 'rgba(0, 100, 0, 0.6)', 'rgba(128, 0, 128, 0.6)',
						'rgba(128, 128, 0, 0.6)', 'rgba(0, 128, 128, 0.6)', 'rgba(0, 0, 128, 0.6)',
						'rgba(255, 165, 0, 0.6)', 'rgba(0, 128, 0, 0.6)', 'rgba(218, 112, 214, 0.6)',
						'rgba(128, 0, 0, 0.6)', 'rgba(255, 0, 0, 0.6)'
						];
			$borderColors = [
								'rgba(58, 200, 225, 1)', 'rgba(255, 99, 132, 1)', 'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)',
								'rgba(54, 162, 235, 1)', 'rgba(255, 102, 102, 1)', 'rgba(255, 153, 204, 1)',
								'rgba(139, 0, 0, 1)', 'rgba(0, 100, 0, 1)', 'rgba(128, 0, 128, 1)',
								'rgba(128, 128, 0, 1)', 'rgba(0, 128, 128, 1)', 'rgba(0, 0, 128, 1)',
								'rgba(255, 165, 0, 1)', 'rgba(0, 128, 0, 1)', 'rgba(218, 112, 214, 1)',
								'rgba(128, 0, 0, 1)', 'rgba(255, 0, 0, 1)'
						];
			$backgroundColor = $backgroundColors[$ploId - 1]; // Assign a different color for each dataset
			$borderColor = $borderColors[$ploId - 1]; // Assign a different color for each dataset

			$dataset = array(
				'label' => 'PLO'.$ploId,
				'backgroundColor' => $backgroundColor,
				'borderColor' => $borderColor,
				'borderWidth' => 2,
				'data' => $dataPlo,
				'datalabels' => [
					'color'=>'blue',
					'anchor'=>'end',
					'align'=>'top'
				]
			);
			$datasetsPlo[] = $dataset;
		}
	}

	$dataPlo = array(
		'labels' => $studentIDs,
		'datasets' => $datasetsPlo,
	);

	echo '

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0-rc.1/chartjs-plugin-datalabels.min.js" integrity="sha512-+UYTD5L/bU1sgAfWA0ELK5RlQ811q8wZIocqI7+K0Lhh8yVdIoAMEs96wJAIbgFvzynPm36ZCXtkydxu1cs27w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<div style="overflow: auto;">
		<canvas id="chartCohort" height="100" style="margin-top: 20px; margin-bottom: 20px; overflow: auto;" ></canvas>
		<canvas id="chart_clo" height="100" style="margin-top: 20px; margin-bottom: 20px; overflow: auto;"></canvas>
		<canvas id="chart_plo" height="100" style="margin-top: 20px; margin-bottom: 20px; overflow: auto;"></canvas>

	</div>


	<script>
		var cloattainmentcohort = "";
		var ploattainmentcohort = "";
		';
		if(!empty($cloattainmentcohort) && !empty($ploattainmentcohort)) {
			echo '
			var cloattainmentcohort = '.json_encode($cloattainmentcohort, JSON_NUMERIC_CHECK).'
			var ploattainmentcohort = '.json_encode($ploattainmentcohort, JSON_NUMERIC_CHECK).'';
		}
			echo '
			var labels = Object.keys(cloattainmentcohort).map(Number);

			var clovalues = Object.values(cloattainmentcohort);
			var plovalues = Object.values(ploattainmentcohort);
			console.log(ploattainmentcohort);
			
			var datasets = [ {
				label: "CLOs",
				data: clovalues,
				backgroundColor: "rgba(58, 200, 225, 0.5)",
				borderColor: "rgba(58, 200, 225, 1)",
				borderWidth: 2,
				datalabels:{
					color:"blue",
					anchor:"end",
					align:"top"
				}        
				}, {
				label: "PLOs",
				data: plovalues,
				backgroundColor: "rgba(255, 99, 132, 0.5)",
				borderColor: "rgba(255, 99, 132, 1)",
				borderWidth: 2,
				datalabels:{
					color:"blue",
					anchor:"end",
					align:"top"
				}
				}
			];

			var ctx = document.getElementById("chartCohort");
			var myChart = new Chart(ctx, {
				type: "bar",
				data: {
				labels : labels,
				datasets: datasets
				},
				options: {
				responsive: true,
				plugins: {
					legend: {
					position: "top",
					},
					title: {
					display: true,
					text: "Attainment of CLO & PLOs at Cohort Level ",
					},
				},
				scales: {
					x: {
					display:false,
					},
					y: {
					beginAtZero: true,
					title: {
						display: true,
					},
					ticks: {
						callback: function(value){return value + "%"}
					}
					}
				}
				}
			});
		
		var configClo = {
		type: "bar",
		data: '.json_encode($dataClo, JSON_NUMERIC_CHECK).',
		options: {
			responsive: true,
			plugins: {
				legend: {
				position: "top",
				},
				title: {
				display: true,
				text: "Attainment of CLO at Individual Level"
				}
			},
			scales: {
			x: 
			{
				title: {
				display: true,
				barPercentage: 0.5,
				},
				ticks: {
				maxRotation: 45,
				minRotation: 45,
				}
			},
			y: 
			{
				beginAtZero: true,
				title:  {
				display: true,
				text: "Percentage Attainment",
				color: "#191",
				font:  {
					family: "Comic Sans MS",
					size: 20,
					weight: "bold"
				}
				},
				ticks: {
				callback: function(value){return value + "%"}
				}
			}
			}
		}
		};
		
		var configPlo = {
		type: "bar",
		data: '.json_encode($dataPlo, JSON_NUMERIC_CHECK).',
		options: {
			responsive: true,
			plugins: {
				legend: {
				position: "top",
				},
				title: {
				display: true,
				text: "Attainment of PLOs at Individual Level"

				}
			},
			scales: {
			x: 
			{
				title:  {
				display: true,
				},
				ticks: {
				maxRotation: 45,
				minRotation: 45,
				}
			},
			y: 
			{
				beginAtZero: true,
				title:  {
				display: true,
				text: "Percentage Attainment",
				color: "#191",
				font:  {
					family: "Comic Sans MS",
					size: 20,
					weight: "bold",
					lineHeight: 1.2
				},
				},
				ticks: {
				callback: function(value){return value + "%"}
				}
			}
			}
		}
		};
		
		new Chart("chart_clo", configClo);
		new Chart("chart_plo", configPlo);
	</script>';
}