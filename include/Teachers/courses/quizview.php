<?php 
	include "../../../dbsetting/lms_vars_config.php";
	include "../../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../../functions/login_func.php";
	include "../../../functions/functions.php";
	checkCpanelLMSALogin();
//--------------------------------------------------
	$sqllmsstds  = $dblms->querylms("SELECT qz.quiz_id, qz.quiz_status, qz.quiz_title, qz.quiz_startdate, qz.quiz_enddate,
											qz.quiz_term, qz.quiz_questions, qz.quiz_time, qz.quiz_totalmarks, qz.date_modify, 
											qz.quiz_passingmarks, crs.curs_id, crs.curs_code, crs.curs_name, qz.date_added  
											FROM ".QUIZ." qz 
											INNER JOIN ".COURSES." crs ON crs.curs_id = qz.id_curs 
										  	WHERE qz.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  	AND qz.quiz_id = '".cleanvars($_GET['id'])."' LIMIT 1");
	$rowstdpro 	= mysqli_fetch_array($sqllmsstds);

	if($rowdwnlad['date_modify'] != '0000-00-00 00:00:00') {
	$objetdate = '<span class="pull-right style="color:#fff !important;">Last Update: <i class="icon-time"></i> '. date("j F, Y h:i A", strtotime(date_added['date_modify'])).'</span>';
} elseif($rowdwnlad['date_added'] != '0000-00-00 00:00:00') {
	$objetdate = '<span class="pull-right style="color:#fff !important;">Last Update: <i class="icon-time"></i> '. date("j F, Y h:i A", strtotime(date_added['date_added'])).'</span>';
} else {
	$objetdate = '';
}

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
<h3 style="font-weight:600;">'.$rowstdpro['quiz_title'].'</h3>
<table class="table table-bordered table-hover">
<tbody>

<tr>
	<td bgcolor="#FAFAFA" style="vertical-align:middle; width:100px;"><strong>Course</td>
	<td colspan="3" style="vertical-align:middle;">'.$rowstdpro['curs_code'].' - '.$rowstdpro['curs_name'].'</td>
</tr>

<tr>
	<td><strong>Marks</strong></td>
	<td colspan="3" >'.$rowstdpro['quiz_totalmarks'].'</td>
</tr>
</tbody>
</table>

<div class="navbar-form navbar-right" style="font-weight:700; color:green; margin-right:10px; margin-top:0px;"> 
	Total Questions: ('.$rowstdpro['quiz_questions'].') 
</div>

<table class="table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th style="font-weight:700; text-align:center;vertical-align:middle;">Sr #</th>
	<th style="font-weight:700;vertical-align:middle;">Difficulty Level</th>
	<th style="font-weight:700;vertical-align:middle;text-align:center;">Question(s)</th>
	<th style="font-weight:700;vertical-align:middle;text-align:center;">Type</th>
</tr>
</thead>
<tbody>';
$srbk = 0;


	$sqllmschapter  = $dblms->querylms("SELECT *   
												FROM ".QUIZ_DETAIL." 
												WHERE id_quiz = '".cleanvars($_GET['id'])."' ORDER BY id ASC");
//------------------------------------------------
while($value_chapter = mysqli_fetch_array($sqllmschapter)) { 
$srbk++;
//------------------------------------------------
	
echo '
<tr>
	<td style="width:70px; text-align:center;">'.$srbk.'</td>
	<td>'.get_difficultylevel($value_chapter['difficulty_level']).'</td>
	<td style="text-align:center; width:60px;">'.($value_chapter['questions']).'</td>
	<td style="text-align:center; width:150px;">'.get_questiontype($value_chapter['question_type']).'</td>
	
</tr>';
	
//------------------------------------------------
}
//------------------------------------------------
echo '
</tbody>
</table>
<div style="font-size:11px; color:#666;">'.$objetdate.'</div>
</div>
</div>
<!--WI_USER_PROFILE_TABLE-->
<!--WI_NOTIFICATION-->
<!--WI_NOTIFICATION-->
</div>
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
					<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--WI_IFRAME_MODAL-->
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