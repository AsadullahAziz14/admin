<?php  
if(isset($_GET['prgid'])) { 

	$AddProgramSemesterSQL = '';
	if(($_GET['prgid'] !='la')) { 

		$AddProgramSemesterSQL = "AND (FIND_IN_SET('".$_GET['prgid']."', programs) OR programs LIKE'%all%') ";

	} 

	/*
	if(($_SESSION['userlogininfo']['LOGINIDA'] == 5005)){

		echo "SELECT paper_startdate as date_start, paper_enddate as date_end, 
												awardlist_addfrom, awardlist_addto
												FROM ".SETTINGS_PAPERS."
												WHERE status = '1' AND examterm = '2' 
												$AddProgramSemesterSQL	
												AND FIND_IN_SET('".$_GET['timing']."', timings)
												AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
												AND id_campus	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												ORDER BY id DESC LIMIT 1";

	}
	*/

	//Final Term Examination
	$sqllmsfeecats  = $dblms->querylms("SELECT paper_startdate as date_start, paper_enddate as date_end, 
												awardlist_addfrom, awardlist_addto
												FROM ".SETTINGS_PAPERS."
												WHERE status = '1' AND examterm = '2' 
												$AddProgramSemesterSQL	
												AND FIND_IN_SET('".$_GET['semester']."', semesters)
												AND FIND_IN_SET('".$_GET['timing']."', timings)
												AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
												AND id_campus	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												ORDER BY id DESC LIMIT 1");
	$rowfeecats = mysqli_fetch_array($sqllmsfeecats);
	if($_GET['timing'] == 1 || $_GET['timing'] == 4) { 
		$attendancereq 	= $rowsetting['finalterm_mattendance'];
	} else if($_GET['timing'] == 2) {
		$attendancereq 	= $rowsetting['finalterm_eattendance'];
	}

	//Check Section
	if(isset($_GET['section'])) {  
		$section 		= $_GET['section'];
		$sectionlink	= '&section='.$_GET['section'];
	} else { 
		$section 		= '';
		$sectionlink	= '';
	}
//----------------Program Name 
	if(($_GET['prgid'] !='la')) { 
		$sqllmsprgname  = $dblms->querylms("SELECT prg_code, prg_name, prg_under_mul  
												FROM ".PROGRAMS." WHERE prg_id = '".cleanvars($_GET['prgid'])."' LIMIT 1");
		$rowprgmname = mysqli_fetch_array($sqllmsprgname); 

		$prgname 	= ' - '.strtoupper($rowprgmname['prg_code']) .' ('.get_programtiming($_GET['timing']).' - '.addOrdinalNumberSuffix($_GET['semester']).' '.$section.')';

	} else { 
		$prgname 	= ' - '.' ('.get_programtiming($_GET['timing']).' - '.$section.')';

	}
	

//--------------------------------------
	$datetime 	= date('Y-m-d H');
	$activedate = "2018-09-11 17";
//--------------------------------------------
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) ==1) {  
		$disable = "";
		$style = ' ';
	} else { 
		$disable = "";	
		$style = ' ';
	}
	
// attendance marks lock
	if($_SESSION['userlogininfo']['LOGINIDCOM'] == 1) {
		$attendancelock = ' readonly';
	} else {
		$attendancelock = '';
	}

// attendance marks read only
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) == 1) { 

		$attendaceReadOnly = 'readonly';

	} else{

		$attendaceReadOnly = '';

	}
	
if(isset($_GET['section'])) {
	$stdsection 	= " AND std.std_section =  '".cleanvars($_GET['section'])."'"; 
	$seccursquery 	= " AND at.section 		= '".$_GET['section']."'";
	$quesec 		= $_GET['section'];
} else { 
	$stdsection 	= " AND std.std_section =  ''"; 
	$seccursquery 	= " AND at.section 		= ''";
	$quesec 		= "";
}
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-12">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Final Term Award List '.$prgname.'</h3></span>
			<span class="pull-right"><a class="btn btn-mid btn-success" href="courses.php?id='.$_GET['id'].'&view=Finaltermawrd"> Back </a></span>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<!--WI_MILESTONES_NAVIGATION-->

<!--WI_MILESTONES_TABLE-->
<div class="row">
<div class="col-lg-12">
  
<div class="widget wtabs">
<div class="widget-content">';
//--------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
} 

//-----------------------final term Examination-------------------------
if($rowfeecats['date_start']>date("Y-m-d")) { 
//--------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification" style="font-weight:600; color:blue;">After Final term exam, you will be able to upload students award list.</div>
</div>';
//--------------------------------------
} else { 
//-----------------------final term Result Submission-------------------------

if($rowfeecats['awardlist_addto']<date("Y-m-d") ) { 
echo '<div class="col-lg-12">
		<div class="widget-tabs-notification" style="font-weight:600; color:red; font-size:30px;">
			Exam Marking Date has been closed.
		</div>
	</div>';
}  else {
	
	if(($_GET['prgid'] !='la')) { 
		include("nonliberalarts.php");
	} else {
		include("liberalarts.php");
	}

}
	
}
//------------------------------------------------
echo '

</div>
</div>
</div>
</div>

<!--WI_MILESTONES_TABLE-->
<!--WI_TABS_NOTIFICATIONS-->

</div>
<div class="clearfix"></div>
</div>
</div>
</div>
<script>
	evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script> 
<script>
    $("#forward_to").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript" src="js/finaltermaward.js"></script>';
/*
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) != '1' && $rowprgmname['prg_under_mul'] == '0') { 
		echo '<script type="text/javascript" src="js/finaltermawardShariah.js"></script>'; 
	} else{
		echo '<script type="text/javascript" src="js/finaltermaward.js"></script>'; 
	}
*/
}