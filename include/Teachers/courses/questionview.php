<?php 
	include "../../../dbsetting/lms_vars_config.php";
	include "../../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../../functions/login_func.php";
	include "../../../functions/functions.php";
	checkCpanelLMSALogin();
//--------------------------------------------------
	$sqllmsstds  = $dblms->querylms("SELECT *
											FROM ".QUIZ_QUESTION." q 
											INNER JOIN ".QUIZ_QUESTION_OPTION." d ON d.id_question = q.question_id 
										  	WHERE q.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  	AND q.question_id = '".cleanvars($_GET['id'])."' ORDER BY d.id ASC");
	
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
<div class="col-md-12">';
$srbk = 0;
//------------------------------------------------
while($listquestion = mysqli_fetch_array($sqllmsstds)) {
$srbk++;
//------------------------------------------------
if($srbk == 1) {
echo '<h4 style="font-weight:600;">Question: '.($listquestion['question_title']).'</h4>

<table class="table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th style="font-weight:700; text-align:center;vertical-align:middle;">Sr #</th>
	<th style="font-weight:700;vertical-align:middle;">Options</th>
	<th style="font-weight:700;vertical-align:middle;text-align:center;">Is Option Correct?</th>
</tr>
</thead>
<tbody>';	
}
	
if($listquestion['answer_correct'] == 1) {
	$correct = '<span style="color:green; font-size:14px; font-weight:600;">Correct</span>';
} else {
	$correct = '';
}
	
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srbk.'</td>
	<td>'.htmlspecialchars($listquestion['answer_option'], ENT_QUOTES).'</td>
	<td style="text-align:center;">'.$correct.'</td>
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