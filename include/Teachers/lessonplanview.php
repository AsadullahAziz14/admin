<?php 
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
	checkCpanelLMSALogin();
//----------------------------------------
	$sqllmsannouncements  = $dblms->querylms("SELECT *       
										FROM ".COURSES_LESSONS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND id = '".cleanvars($_GET['id'])."' LIMIT 1");
$rowanns = mysqli_fetch_array($sqllmsannouncements);
//------------------------------------------------

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
<meta name="author" content="">
<link href="style/all-vendors.css" rel="stylesheet">
<link href="style/style.css" rel="stylesheet">
<link href="style/responsive.css" rel="stylesheet">
<!-- HTML5 Support for IE -->
<!--[if lt IE 9]>
	<script src="js/html5shim.js"></script>
<![endif]-->
<!-- Favicon -->
<link rel="shortcut icon" href="images/favicon/favicon.png">
<style type="text/css">
	#tawkchat-minified-iframe-element { left:2px!important; }
	#tawkchat-minified-iframe-element #tawkchat-minified-container { border:0 !important; }
</style>
<script language="JavaScript">
function resize() {
	window.moveTo(100,100)
	window.resizeTo(750,550)
}
</script>
</head>
<!--HEAD - ONLOAD-->
<body class="ModalPopUp" style="text-align: center" onload="javascript:resize();">

<script type="text/javascript" src="js/jquery/jquery.js"></script>
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<div class="content">
<!--WI_USER_PROFILE_TABLE-->
<div class="row">
<div class="col-md-12" style="text-align:left;">
<div style="text-align:left;margin-top:20px; font-size:15px; color:#444; font-family:Calibri, "Calibri Light", sans-serif; line-height:1.5em;">'.nl2br(html_entity_decode($rowanns['detail'], ENT_QUOTES)).'</div>
</p>
</div>
</div>
<!--WI_USER_PROFILE_TABLE-->
<!--WI_NOTIFICATION-->
<!--WI_NOTIFICATION-->
</div>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
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
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>';
?>