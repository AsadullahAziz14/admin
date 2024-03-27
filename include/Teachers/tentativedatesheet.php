<?php 
//----------------------------------------
if(($_SESSION['userlogininfo']['LOGINAFOR'] != 1)) { 
//------------------------------------
	header('location: index.php');
//------------------------------------
} else if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '18')) { 
//----------------------------------------
if($view == 'delete') {
	if(isset($_GET['id'])) {
		$sqllms  	= $dblms->querylms("DELETE FROM ".STUDYSCHEME." WHERE id = '".cleanvars($_GET['id'])."'");
		$sqllmsedu  = $dblms->querylms("DELETE FROM ".STUDYSCHEME_DETAILS." WHERE id_setup = '".cleanvars($_GET['id'])."'");
		header('location:'.$_SERVER['HTTP_REFERER']);
	}
}
//----------------------------------------
	include_once("include/header.php");
//----------------------------------------
$sql2 		= '';
$sqlstring	= "";
//----------------------------------------
if(($_GET['program'])) { 
	$sql2 		.= " AND st.id_prg = '".$_GET['program']."'"; 
	$sqlstring	.= "&program=".$_GET['program']."";
}
//----------------------------------------
if(($_GET['session'])) { 
	$sql2 		.= " AND st.session = '".$_GET['session']."'"; 
	$sqlstring	.= "&session=".$_GET['session']."";
}
//----------------------------------------
echo '<title>Manage Scheme of Study - '.TITLE_HEADER.'</title>
<!-- Matter -->
<div class="matter">
<!--WI_CLIENTS_SEARCH-->
<div class="navbar navbar-default" role="navigation">
<!-- .container-fluid -->
<div class="container-fluid">
<div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
</div>
<!-- .navbar-collapse -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<form class="navbar-form navbar-left form-small" action="" method="get">
	<div class="form-group">
		<select id="projects-list5" data-placeholder="Program" name="program" style="width:350px;">
			<option></option>';
			$sqllmsprg  = $dblms->querylms("SELECT prg_id, prg_name, prg_code FROM ".PROGRAMS." 
													WHERE prg_status = '1' AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
													ORDER BY prg_name ASC");
			while($valueprg = mysqli_fetch_array($sqllmsprg)) {
				echo '<option value="'.$valueprg['prg_id'].'">'.$valueprg['prg_name'].'</option>';
			}
			unset($sqllmsprg);
echo '</select>
	</div>
	<div class="form-group">
		<select id="projects-session" data-placeholder="Session" name="session" style="width:130px">
			<option></option>';
			$sqllmssess	= $dblms->querylms("SELECT DISTINCT session FROM ".STUDYSCHEME." 
													WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
													ORDER BY session ASC");
			while($valuesess 	= mysqli_fetch_array($sqllmssess)) {
				echo '<option value="'.$valuesess['session'].'">'.$valuesess['session'].'</option>';
			}
			unset($sqllmssess);
echo '</select>
	</div>
	<button type="submit" class="btn btn-primary">Search</button>
	<a href="studyscheme.php" class="btn btn-purple"><i class="icon-list"></i> All</a>';
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '18', 'add' => '1'))) { 
	echo ' <a class="btn btn-success" href="studyscheme.php?view=add"><i class="icon-plus"></i> Add Scheme of Study</a>';
}
//--------------------------------------------
echo '
</form>
<script>
	$("#projects-list5").select2({
		allowClear: true
	});
	$("#projects-list1").select2({
		allowClear: true
	});
	$("#projects-session").select2({
		allowClear: true
	});
</script>
</div>
<!-- /.navbar-collapse -->
</div>
<!-- /.container-fluid -->
</div>
<!--WI_CLIENTS_SEARCH END-->
<div class="container">
<!--WI_MY_TASKS_TABLE-->
<div class="row fullscreen-mode">
<div class="col-md-12">
<div class="widget">
<div class="widget-content">';
//--------------------------------------
if(isset($_POST['submit_hreg'])) { 

	$sqllms = $dblms->querylms("INSERT INTO ".STUDYSCHEME." (
															status										,
															session										, 
															id_prg										, 
															semester									,
															totalcredithours							,  
															id_campus									,
															id_added									,
															date_added
														)
												VALUES (
															'1'											, 
															'".cleanvars($_POST['session'])."'			, 
															'".cleanvars($_POST['id_prg'])."'			, 
															'".cleanvars($_POST['semester'])."'			, 
															'".cleanvars($_POST['totalcredithours'])."'	, 
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'			,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	, 
															NOW()			
														)
							");

//--------------------------------------
		if($sqllms) {
			$idsetup = $dblms->lastestid();
			echo '<div id="infoupdated" class="alert-box success"><span>success: </span>Record added successfully.</div>';
//--------------------------------------
$arraychecked = $_POST['semester_no'];
//--------------------------------------
	for($ichk=0; $ichk<=sizeof($arraychecked); $ichk++){
		if(!empty($_POST['curs_id'][$ichk])) {	
//------------------------------------------------
			$sqllms  = $dblms->querylms("INSERT INTO ".STUDYSCHEME_DETAILS."( 
																				id_setup									,
																				id_curs										, 
																				credithours_theory							, 
																				credithours_practical						, 
																				credithours_total							, 
																				semester										
																			)
	   																VALUES (
																				'".$idsetup."'									, 
																				'".cleanvars($_POST['curs_id'][$ichk])."'		, 
																				'".cleanvars($_POST['theory_crd'][$ichk])."'	, 
																				'".cleanvars($_POST['practical_crd'][$ichk])."'	, 
																				'".cleanvars($_POST['totalcrd'][$ichk])."'		,
																				'".cleanvars($_POST['semester_no'][$ichk])."'		
																			)
										");
		}
//------------------------------------------------
		}

//------------------------------------------------
}
//------------------------------------------------
}
//--------------------------------------
if(!LMS_VIEW && !isset($_GET['id'])) { 
//------------------------------------------------
if (!($Limit))   { $Limit = 50; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT st.id, st.status, st.session, st.id_prg, st.semester, prg.prg_name, prg.prg_code
										FROM ".STUDYSCHEME." st  
										INNER JOIN ".PROGRAMS." prg ON st.id_prg = prg.prg_id  
										WHERE st.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' $sql2 
										ORDER BY prg.prg_name ASC");
//------------------------------------------------
	$sql_print  = "SELECT st.id, st.status, st.session, st.id_prg, st.semester, prg.prg_name, prg.prg_code
										FROM ".STUDYSCHEME." st  
										INNER JOIN ".PROGRAMS." prg ON st.id_prg = prg.prg_id  
										WHERE st.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' $sql2 
										ORDER BY prg.prg_name ASC";
//--------------------------------------------------
	$count 		   = mysqli_num_rows($sqllms);
	$NumberOfPages = ceil($count/$Limit);
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT st.id, st.status, st.session, st.id_prg, st.semester, prg.prg_name, prg.prg_code
										FROM ".STUDYSCHEME." st  
										INNER JOIN ".PROGRAMS." prg ON st.id_prg = prg.prg_id  
										WHERE st.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' $sql2 
										ORDER BY prg.prg_name ASC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<div style=" float:right; text-align:right; font-weight:700; color:red; margin-right:10px;"> 
	<form class="navbar-form navbar-left form-small" action="export.php" method="post" target="_blank">
		<input type="hidden" name="type" value="Studyscheme">
		<input type="hidden" name="print_sql" value="'.$sql_print.'">
		<button type="submit" class="btn btn-info">Export</button>
	</form>
</div>
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600; text-align:center;"> Sr. #</th>
	<th style="font-weight:600; text-align:left;"> Program Name</th>
	<th style="font-weight:600; text-align:center;"> Semesters</th>
	<th style="font-weight:600; text-align:center;"> Session</th>
	<th style="font-weight:600; text-align:center;"> Total Courses</th>
	<th style="font-weight:600; text-align:center;"> Credit Hours</th>
	<th style="font-weight:600; text-align:center;"> Status</th>
	<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
$srno++;
//------------------------------------------------
$regstatus 	= get_admstatus($rowstd['status']);
//------------------------------------------------
	$sqllmssumcrdh  = $dblms->querylms("SELECT SUM(credithours_total) AS Totalcrdh, COUNT(id_curs) AS Totalcurs
										FROM ".STUDYSCHEME_DETAILS." 
										WHERE id_setup = '".cleanvars($rowstd['id'])."'");
	$valuecrdh		= mysqli_fetch_assoc($sqllmssumcrdh);
//--------------------------------------------
echo '
<tr>
	<td style="width:80px; text-align:center;">'.$srno.'</td>
	<td><a class="links-blue" href="studyscheme.php?id='.$rowstd['id'].'">'.$rowstd['prg_name'].'</a> </td>
	<td style="width:100px; text-align:center;">'.$rowstd['semester'].'</td>
	<td>'.$rowstd['session'].'</td>
	<td style="width:110px; text-align:right;">'.number_format($valuecrdh['Totalcurs']).'</td>
	<td style="width:100px; text-align:right;">'.number_format($valuecrdh['Totalcrdh']).'</td>
	<td style="text-align:center; width:80px;">'.$regstatus.'</td>
	<td style="text-align:center;">';
	if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '18', 'edit' => '1'))) { 
	echo '<a class="btn btn-xs btn-info" href="studyscheme.php?id='.$rowstd['id'].'"><i class="icon-pencil"></i></a> ';
	}
	if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '18', 'delete' => '1'))) { 
	echo '<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="studyscheme.php?id='.$rowstd['id'].'&view=delete" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure want to delete?"> <i class="icon-trash"></i></a>';
	}
	echo '
		<a class="btn btn-xs btn-deepblue" href="studyschemeprint.php?id='.$rowstd['id'].'" target="_blank"><i class="icon-print"></i></a> 
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//-----------------------------------------
if($count>$Limit) {
echo '
<div class="widget-foot">
<!--WI_PAGINATION-->
<ul class="pagination pull-right">';
	$Nav= ""; 
if($page > 1) { 
	$Nav .= '<li><a href="studyscheme.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
} 
for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
if($i == $page) { 
	$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
} else { 
	$Nav .= '<li><a href="studyscheme.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
} } 
if($page < $NumberOfPages) { 
	$Nav .= '<li><a href="studyscheme.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
} 
	echo $Nav;
echo '
</ul>
<!--WI_PAGINATION-->
	<div class="clearfix"></div>
</div>';
}
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}

} // if not view
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '18', 'add' => '1'))) { 
//----------------------------------------------------------------
if(LMS_VIEW == 'add' && !isset($_GET['id'])) { 
//----------------------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="studyscheme.php?view=add" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<h4 class="modal-title" style="font-weight:700;"> Add Scheme of Study</h4>
</div>

<div class="modal-body">

	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Session</label>
			<select id="for_session" name="session" style="width:100%" required autocomplete="off">
			<option value="">Select Session</option>';
			foreach($session as $itemsession) {
				echo '<option value="'.$itemsession.'">'.$itemsession.'</option>';
			}
	echo'
			</select>
		</div> 
	</div>	

	<div class="col-sm-43">
		<div class="form_sep">
			<label class="req">Program</label>
			<select id="id_prg" name="id_prg" style="width:100%" autocomplete="off" required onchange="get_programsemesters(this.value)">
				<option value="">Select Program</option>';
			$sqllmsprg  = $dblms->querylms("SELECT prg_id, prg_name, prg_code FROM ".PROGRAMS." 
																			  WHERE prg_status = '1' 
																			  AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
																			  ORDER BY prg_name ASC");
			while($valueprg = mysqli_fetch_array($sqllmsprg)) {
				echo '<option value="'.$valueprg['prg_id'].'">'.$valueprg['prg_name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div id="getprogramsemesters">
		<div class="col-sm-31">
			<div class="form_sep">
				<label class="req">Semester</label>
				<input type="number" class="form-control" id="semester" name="semester" readonly>
			</div>
		</div>
		<div class="col-sm-31">
			<div class="form_sep">
				<label class="req">Credit Hours</label>
				<input type="number" class="form-control" id="credithours" name="credithours" readonly>
			</div>
		</div>
	</div>
	
	
	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'studyscheme.php\'" >Closed</button>
	<input type="hidden" name="semesterno" id="semesterno" value="1">
	<input class="btn btn-primary" type="submit" value="Create Scheme" id="submit_hreg" name="submit_hreg">
</div>

</div>
</form>
<script>
    $("#for_session").select2({
        allowClear: true
    });
</script>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
//----------------------------------------------------------------
} // end if add view
}
//--------------------------------------------
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '18', 'edit' => '1'))) { 
//----------------------------------------------------------------
if(!LMS_VIEW && isset($_GET['id'])) { 
//--------------------------------------
if(isset($_POST['submit_permission'])) { 
//------------------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".STUDYSCHEME." SET session		= '".cleanvars($_POST['session'])."'
													, semester			= '".cleanvars($_POST['semester'])."'
													, totalcredithours	= '".cleanvars($_POST['totalcredithours'])."'
													, id_modify			= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
													, date_modify		= NOW() 
												WHERE id				= '".cleanvars($_GET['id'])."'");
if($sqllms) { 
//--------------------------------------
	echo '<div id="infoupdated" class="alert-box success"><span>success: </span>permissions update successfully.</div>';
//--------------------------------------
	$sqllmsdelte  = $dblms->querylms("DELETE FROM ".STUDYSCHEME_DETAILS." WHERE id_setup = '".$_GET['id']."'");
//--------------------------------------
$arraychecked = $_POST['semester_no'];
//--------------------------------------
	for($ichk=0; $ichk<=sizeof($arraychecked); $ichk++){
		if(!empty($_POST['curs_id'][$ichk])) {	
//------------------------------------------------
			$sqllms  = $dblms->querylms("INSERT INTO ".STUDYSCHEME_DETAILS."( 
																				id_setup									,
																				id_curs										, 
																				credithours_theory							, 
																				credithours_practical						, 
																				credithours_total							, 
																				semester										
																			)
	   																VALUES (
																				'".$_GET['id']."'								, 
																				'".cleanvars($_POST['curs_id'][$ichk])."'		, 
																				'".cleanvars($_POST['theory_crd'][$ichk])."'	, 
																				'".cleanvars($_POST['practical_crd'][$ichk])."'	, 
																				'".cleanvars($_POST['totalcrd'][$ichk])."'		,
																				'".cleanvars($_POST['semester_no'][$ichk])."'		
																			)
										");
		}
//------------------------------------------------
	}
//--------------------------------------
}
}
//--------------------------------------

//----------------------------------------------------------------
	$sqllmscheme  = $dblms->querylms("SELECT st.id, st.status, st.session, st.id_prg, st.semester, prg.prg_name, prg.prg_code  
										FROM ".STUDYSCHEME." st  
										INNER JOIN ".PROGRAMS." prg ON st.id_prg = prg.prg_id  
										WHERE st.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND st.id = '".cleanvars($_GET['id'])."' LIMIT 1");
	$rowscheme = mysqli_fetch_array($sqllmscheme);
//----------------------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="#" method="post" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<h4 class="modal-title" style="font-weight:700;"> Edit Scheme of Study</h4>
</div>

<div class="modal-body">

	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Session</label>
			<input type="text" class="form-control" id="session" name="session" value="'.$rowscheme['session'].'" readonly>
		</div> 
	</div>	

	<div class="col-sm-43">
		<div class="form_sep">
			<label class="req">Program</label>
			<input type="text" class="form-control" id="prgname" name="prgname" value="'.$rowscheme['prg_name'].'" readonly>
		</div>
	</div>
	
	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Semester</label>
			<input type="number" class="form-control" id="semester" name="semester" value="'.$rowscheme['semester'].'" readonly>
		</div>
	</div>
	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Credit Hours</label>
			<input type="number" class="form-control" id="totalcredithours" name="totalcredithours" readonly>
		</div>
	</div>
	<div style="clear:both;"></div>';
$sisMh = 0;
//---------------------------------------
for($isMSes=1; $isMSes<=$rowscheme['semester']; $isMSes++) { 
//---------------------------------------
echo '
<div class="col-lg-6 countcrd">
	<div style="clear:both;"></div>	
	<div class="col-lg-12 heading-modal" style="margin-top:10px; margin-bottom:5px;">Semester '.$isMSes.'</div>
	<div style="clear:both;"></div>


	<div class="col-sm-35">
		<div class="form_sep" style="margin-bottom:10px;">
			<label>Code </label>
		</div> 
	</div>
	<div class="col-sm-42">
		<div class="form_sep" style="margin-bottom:10px;">
			<label>Course Name </label>
		</div> 
	</div>
	<div class="col-sm-34">
		<div class="form_sep" style="margin-bottom:10px;">
			<label>Theory </label>
		</div> 
	</div>
	<div class="col-sm-34">
		<div class="form_sep" style="margin-bottom:10px;">
			<label>Practical </label>
		</div> 
	</div>
	<div class="col-sm-34">
		<div class="form_sep" style="margin-bottom:10px; text-align:center;">
			<label>Total </label>
		</div> 
	</div>';
//------------------------------------------------
	$sqllmsschcurse  = $dblms->querylms("SELECT d.id_setup, d.id_curs, d.credithours_theory, d.credithours_practical, 
												d.credithours_total, d.semester, c.curs_name, c.curs_code    
												FROM ".STUDYSCHEME_DETAILS." d 
												INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs  
												WHERE d.id_setup = '".$rowscheme['id']."' 
												AND d.semester = '".$isMSes."' ORDER BY d.id ASC");
//------------------------------------------------

	while($rowcursname = mysqli_fetch_array($sqllmsschcurse)) {
$sisMh++;
echo '
	<div class="col-sm-35">
		<div class="form_sep" style="margin-bottom:5px;">
			<input type="text" class="form-control sumcrd" id="curs_code_'.$sisMh.'" name="curs_code['.$sisMh.']" autocomplete="off" onchange="get_coursedetail(this.value, '.$sisMh.', '.$isMSes.')" value="'.$rowcursname['curs_code'].'">
		</div> 
	</div>
<div id="getcoursedetail_'.$sisMh.'">
	<div class="col-sm-42">
		<div class="form_sep" style="margin-bottom:5px;">
			<input type="text" class="form-control" id="curs_name['.$sisMh.']" name="curs_name['.$sisMh.']" autocomplete="off" value="'.$rowcursname['curs_name'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-34">
		<div class="form_sep" style="margin-bottom:5px;">
			<input type="text" class="form-control" id="theory_crd['.$sisMh.']" name="theory_crd['.$sisMh.']" autocomplete="off" value="'.$rowcursname['credithours_theory'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-34">
		<div class="form_sep" style="margin-bottom:5px;">
			<input type="text" class="form-control" id="practical_crd['.$sisMh.']" name="practical_crd['.$sisMh.']" autocomplete="off" value="'.$rowcursname['credithours_practical'].'" readonly>
		</div> 
	</div>
	<div class="col-sm-34">
		<div class="form_sep" style="margin-bottom:5px;">
			<input type="text" class="form-control sumcrd txtpay" id="totalcrd['.$sisMh.']" name="totalcrd['.$sisMh.']" autocomplete="off" value="'.$rowcursname['credithours_total'].'" readonly>
		</div> 
	</div>
</div>
	<div style="clear:both;"></div>
	<input type="hidden" name="curs_id['.$sisMh.']" id="curs_id['.$sisMh.']" value="'.$rowcursname['id_curs'].'">
	<input type="hidden" name="semester_no['.$sisMh.']" id="semester_no['.$sisMh.']" value="'.$isMSes.'">';
//----------------------------------------
}
//----------------------------------------
if(mysqli_num_rows($sqllmsschcurse)<6) {
//----------------------------------------
for($icuSchs = (mysqli_num_rows($sqllmsschcurse)+1); $icuSchs<=6; $icuSchs++) { 
//----------------------------------------
$sisMh++;
echo '
	<div class="col-sm-35">
		<div class="form_sep" style="margin-bottom:5px;">
			<input type="text" class="form-control sumcrd" id="curs_code_'.$sisMh.'" name="curs_code['.$sisMh.']" autocomplete="off" onchange="get_coursedetail(this.value, '.$sisMh.', '.$isMSes.')">
		</div> 
	</div>
<div id="getcoursedetail_'.$sisMh.'">
	<div class="col-sm-42">
		<div class="form_sep" style="margin-bottom:5px;">
			<input type="text" class="form-control" id="curs_name[]" name="curs_name[]" autocomplete="off">
		</div> 
	</div>
	<div class="col-sm-34">
		<div class="form_sep" style="margin-bottom:5px;">
			<input type="text" class="form-control" id="theory_crd[]" name="theory_crd[]" autocomplete="off">
		</div> 
	</div>
	<div class="col-sm-34">
		<div class="form_sep" style="margin-bottom:5px;">
			<input type="text" class="form-control" id="practical_crd[]" name="practical_crd[]" autocomplete="off">
		</div> 
	</div>
	<div class="col-sm-34">
		<div class="form_sep" style="margin-bottom:5px;">
			<input type="text" class="form-control sumcrd txtpay" id="totalcrd[]" name="totalcrd[]" autocomplete="off">
		</div> 
	</div>
</div>
	<div style="clear:both;"></div>
	<input type="hidden" name="semester_no['.$sisMh.']" id="semester_no['.$sisMh.']" value="'.$isMSes.'">';
//----------------------------------------
}
}
//----------------------------------------
echo '
<div style="clear:both;"></div>
<span style="float:right; font-weight:700;">Total Credit Hours: <span class="sumcrd_sum" style="color:#00F;">0</span></span>
</div>';
//---------------------------------------
}
//---------------------------------------
echo '
<div style="clear:both;"></div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'studyscheme.php\'" >Closed</button>
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_permission" name="submit_permission">
</div>

</div>
</form>
<script>
    $("#for_session").select2({
        allowClear: true
    });
</script>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
//----------------------------------------------------------------
} // end if add view
}
//----------------------------------------------------------------
echo '
</div>
</div>
</div>
</div>
<!--WI_MY_TASKS_TABLE-->
<!--WI_NOTIFICATION-->       
<!--WI_NOTIFICATION-->
</div>
</div>
<!-- Matter ends -->
</div>
<!-- Mainbar ends -->
<div class="clearfix"></div>
</div>
<!-- Content ends -->
<!-- Footer starts -->
<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<p class="copy">Powered by: | <a href="'.COPY_RIGHTS_URL.'" target="_blank">'.COPY_RIGHTS.'</a> </p>
			</div>
		</div>
	</div>
</footer>
<!-- Footer ends -->

<!-- Scroll to top -->
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>




<!--WI_IFRAME_MODAL-->
<div class="row">
	<div id="modalIframe" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
					<h4 class="modal-title" id="modal-iframe-title"> Edit</h4>
					<div class="clearfix"></div>
				</div>
				<div class="modal-body">
					<iframe frameborder="0" class="slimScrollBarModal----"></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--WI_IFRAME_MODAL-->
<script type="text/javascript" src="js/courses.js"></script>
<script type="text/javascript">
// close the div in 5 secs
window.setTimeout("closeHelpDiv();", 5000, 2500);

function closeHelpDiv(){
	document.getElementById("infoupdated").style.display=" none";
}
</script>
<!--JS_SELECT_LISTS-->
<script>


    $("#id_dept").select2({
        allowClear: true
    });
    $("#id_dept_edit").select2({
        allowClear: true
    });
	
	$("#status").select2({
        allowClear: true
    });
	$("#status_edit").select2({
        allowClear: true
    });
	$("#id_prg").select2({
        allowClear: true
    });
	$("#id_prg_edit").select2({
        allowClear: true
    });
	$("#semester").select2({
        allowClear: true
    });
	$("#semester_edit").select2({
        allowClear: true
    });
	$("#for_session").select2({
        allowClear: true
    });
	$("#session_edit").select2({
        allowClear: true
    });
	$("#id_curs").select2({
        allowClear: true
    });
	$("#id_curs_edit").select2({
        allowClear: true
    });
	$("#projects-list").select2({
        allowClear: true
    });
	$("#projects-list1").select2({
        allowClear: true
    });
	$("#projects-list2").select2({
        allowClear: true
    });
	$("#projects-list3").select2({
        allowClear: true
    });
	$("#projects-list4").select2({
        allowClear: true
    });
	$("#projects-list5").select2({
        allowClear: true
    });
	$("#project-list").select2({
        allowClear: true
    });
	$("#project-list1").select2({
        allowClear: true
    });
	$("#project-list2").select2({
        allowClear: true
    });
	$("#project-list3").select2({
        allowClear: true
    });
</script>
<!--JS_SELECT_LISTS-->
<!--JS_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_ADD_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#addNewFrm").validate({
		rules: {
             id_dept: "required",
			 id_prg: "required",
		  	 semester: "required",
			 for_session: "required"
		},
		messages: {
			id_dept: "This field is required",
			id_prg: "This field is required",
			for_session: "This field is required",
			semester: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>
<!--JS_ADD_NEW_TASK_MODAL-->
<!--JS_EDIT_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_EDIT_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#editFrm").validate({
		rules: {
			 id_prg_edit: "required",
		  	 semester_edit: "required",
			 session_edit: "required",
			 status_edit: "required",
			 id_curs_edit: "required"
		},
		messages: {
			id_prg_edit: "This field is required",
			semester_edit: "This field is required",
			session_edit: "This field is required",
			status_edit: "This field is required",
			id_curs_edit: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
		
    //---edit item link clicked-------
//---edit item link clicked-------
    $(".edit-hst-modal").click(function(){
    
        //get variables from "edit link" data attributes
        var status_edit 		= $(this).attr("data-std-status");
		var id_prg_edit			= $(this).attr("data-std-prg");
		var semester_edit 		= $(this).attr("data-std-semester");
		var session_edit 		= $(this).attr("data-std-session");
		var id_curs_edit 		= $(this).attr("data-std-curs");
		var reg_id_edit 		= $(this).attr("data-std-id");

        //set modal input values dynamically
		$("#semester_edit")		.val(semester_edit);
		$("#reg_id_edit")		.val(reg_id_edit);

       //pre-select data in pull down lists
       $("#status_edit")		.select2().select2("val", status_edit); 
	   $("#session_edit")		.select2().select2("val", session_edit); 
	   $("#id_prg_edit")		.select2().select2("val", id_prg_edit); 
	   $("#id_curs_edit")		.select2().select2("val", id_curs_edit); 
  });
    
});
</script>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script>
//USED BY: All date picking forms
$(document).ready(function(){
    $(".pickadate").datepicker({
       format: "yyyy-mm-dd",
       language: "lang",
       autoclose: true,
       todayHighlight: true
    });	
});

</script>

<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript">
	$(function () {
		$(".footable").footable();
	});
</script>
<script type="text/javascript" src="js/admission_inquiry.js"></script>
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>';
//----------------------------------------
} 
//----------------------------------------
?>