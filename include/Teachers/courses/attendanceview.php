<?php 
	include "../../../dbsetting/lms_vars_config.php";
	include "../../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../../functions/login_func.php";
	include "../../../functions/functions.php";
	checkCpanelLMSALogin();
//------------------------------------------------
	if(isset($_GET['section'])) {
		$section 	= ' '.$_GET['section'];
	} else {
		$section 	= '';
	}
//--------------------------------------------------
	$sqllmsstds  = $dblms->querylms("SELECT at.status, at.remarks, std.std_id, std.std_rollno, std.std_regno, 
											std.std_section, std.std_photo, std.std_name, std.std_session 
											FROM ".COURSES_ATTENDANCE_DETAIL." at 
											INNER JOIN ".STUDENTS." std ON std.std_id = at.id_std 
										  	WHERE std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  	AND at.id_setup = '".cleanvars($_GET['id'])."' 
											AND (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
											ORDER BY std.std_rollno ASC, std.std_regno ASC");	
echo '
<!DOCTYPE html>
<html lang="en">
<!--HEAD - ONLOAD-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="Shahzad Ahmad">
<link href="../../../style/all-vendors.css" rel="stylesheet">
<link href="../../../style/style.css" rel="stylesheet">
<link href="../../../style/responsive.css" rel="stylesheet">
<!-- HTML5 Support for IE -->
<!--[if lt IE 9]>
	<script src="../../../js/html5shim.js"></script>
<![endif]-->
<!-- Favicon -->
<link rel="shortcut icon" href="../../../images/favicon/favicon.png">
<style type="text/css">
	#tawkchat-minified-iframe-element { left:2px!important; }
	#tawkchat-minified-iframe-element #tawkchat-minified-container { border:0 !important; }
</style>
</head>
<!--HEAD - ONLOAD-->
<body class="ModalPopUp">
<script type="text/javascript" src="../../../js/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../js/select2/jquery.select2.js"></script>
<div class="content">
<!--WI_USER_PROFILE_TABLE-->
<div class="row">
<div class="col-md-12">
<h3  style="font-weight:700;">'.$_GET['prgname'].' Semester: '.addOrdinalNumberSuffix($_GET['semester']).$section.' ('.get_programtiming($_GET['timing']).')</h3>
<div class="navbar-form navbar-right" style="font-weight:700; color:green; margin-right:10px; margin-top:0px;"> 
	Total Students: ('.mysqli_num_rows($sqllmsstds).') 
	<span style="margin-left:30px; color:blue;">Present: '.$_GET['present'].'</span> 
	<span style="margin-left:30px; color:#FF8000;">Absent: '.$_GET['absent'].'</span>
</div>
<table class="table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th style="font-weight:600; vertical-align:middle; text-align:center;">Sr.#</th>
	<th style="font-weight:600; vertical-align:middle; text-align:center;">Roll #</th>
	<th style="font-weight:600; vertical-align:middle;">Reg #</th>
	<th width="35px" style="font-weight:600;text-align:center; vertical-align:middle;">Pic</th>
	<th style="font-weight:600; vertical-align:middle;">Student Name</th>
	<th style="font-weight:600; vertical-align:middle; text-align:center;">Session</th>
	<th style="font-weight:600; text-align:center; vertical-align:middle;">Status</th>
	<th style="font-weight:600; vertical-align:middle;">Remarks</th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
while($rowcurstds = mysqli_fetch_array($sqllmsstds)) { 
$srbk++;
//------------------------------------------------
if($rowcurstds['std_photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="../../../images/students/'.$rowcurstds['std_photo'].'" alt="'.$rowcurstds['std_name'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="../../../images/students/default.png" alt="'.$rowcurstds['std_name'].'"/>';
}
//------------------------------------------------
	
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srbk.'</td>
	<td style="width:60px; text-align:center;">'.$rowcurstds['std_rollno'].'</td>
	<td style="width:150px;">'.$rowcurstds['std_regno'].'</td>
	<td>'.$stdphoto.'</td>
	<td>'.$rowcurstds['std_name'].'</td>
	<td style="width:80px; text-align:center;">'.$rowcurstds['std_session'].'</td>
	<td style="width:70px; text-align:center;">'.get_absentpresent($rowcurstds['status']).'</td>
	<td style="width:100px;">'.$rowcurstds['remarks'].'</td>
</tr>';
	
//------------------------------------------------
}
//------------------------------------------------
echo '
</tbody>
</table>
</div>
</div>
<!--WI_USER_PROFILE_TABLE-->
<!--WI_NOTIFICATION-->
<!--WI_NOTIFICATION-->
</div>
<script type="text/javascript" src="../../../js/custom/all-vendors.js"></script>
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
<script type="text/javascript" src="../../../js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript">
	$(function () {
		$(".footable").footable();
	});
</script>
<script type="text/javascript" src="../../../js/custom/custom.js"></script>
<script type="text/javascript" src="../../../js/custom/custom.general.js"></script>
</body>
</html>';
?>