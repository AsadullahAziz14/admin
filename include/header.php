<?php 
echo '
<!DOCTYPE html>
<html lang="en">
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
<link rel="shortcut icon" href="images/favicon/favicon.ico">
<style type="text/css">
	#tawkchat-minified-iframe-element { left:2px!important; }
	#tawkchat-minified-iframe-element #tawkchat-minified-container { border:0 !important; }
	.col-sm-91 {position:relative;min-height:1px;padding-right:10px;padding-left:10px}
	.col-sm-91 {float:left}
	.col-sm-91{width:100%}

	.col-sm-92 {position:relative;min-height:1px;padding-right:10px;padding-left:10px}
	.col-sm-92 {float:left}
	.col-sm-92{width:90%}
	
	.col-sm-81 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-81 {float:left}
	.col-sm-81{width:67.67%}

	.col-sm-71 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-71 {float:left}
	.col-sm-71{width:75%}

	.col-sm-70 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-70 {float:left}
	.col-sm-70 {width:70%}
	
	.col-sm-61 {position:relative;min-height:1px;padding-right:10px;padding-left:10px}
	.col-sm-61 {float:left}
	.col-sm-61{width:50%}
	
	.col-sm-62 {position:relative;min-height:1px;padding-right:10px;padding-left:10px}
	.col-sm-62 {float:left}
	.col-sm-62 {width:60%}
	
	.col-sm-51 {position:relative;min-height:1px;padding-right:10px;padding-left:10px}
	.col-sm-51 {float:left}
	.col-sm-51{width:40%}
	
	.col-sm-41 {position:relative;min-height:1px;padding-right:10px;padding-left:10px}
	.col-sm-41 {float:left}
	.col-sm-41 {width:33.33%}

	.col-sm-42 {position:relative;min-height:1px;padding-right:10px;padding-left:10px}
	.col-sm-42 {float:left}
	.col-sm-42 {width:30%}

	.col-sm-32 {position:relative;min-height:1px;padding-right:10px;padding-left:10px}
	.col-sm-32 {float:left}
	.col-sm-32 {width:25%}

	.col-sm-31 {position:relative;min-height:1px;padding-right:10px;padding-left:10px}
	.col-sm-31 {float:left}
	.col-sm-31{width:20%}

	.col-sm-21 {position:relative;min-height:1px;padding-right:10px;padding-left:10px}
	.col-sm-21 {float:left}
	.col-sm-21{width:10%}

	.req:after {content:"*";font-size:14px;color:#cc0000;padding-left:4px}
	.form-sep + .form-sep {margin-top:5px;padding-top:5px;border-top:1px dashed #e3e3e3}
	.form-sep:before,.form-sep:after {content:"";display:table;}
	.form-sep:after {clear:both;}
	
	.alert-box {
		color:#555;	border-radius:10px;	font-family:Tahoma,Geneva,Arial,sans-serif;font-size:13px; padding:10px 36px; margin:20px 100px 20px 100px;
	}
	.alert-box span { font-weight:bold; text-transform:uppercase; }
	.error { background:#ffecec url("images/error.png") no-repeat 10px 50%; border:1px solid #f5aca6; }
	.success { background:#e9ffd9 url("images/success.png") no-repeat 10px 50%;	border:1px solid #a6ca8a; }
	.warning { background:#fff8c4 url("images/warning.png") no-repeat 10px 50%;	border:1px solid #f2c779; }
	.notice { background:#e3f7fc url("images/notice.png") no-repeat 10px 50%; border:1px solid #8ed9f6; }
</style>

</head>
<body>
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--[if lte IE 8]>
<script language="javascript" type="text/javascript" src="js/flot/excanvas.min.js"></script>
<![endif]-->
<script type="text/javascript" src="js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.canvas.js"></script>
<!-- Main content starts -->
<div class="content">';
//---------------------------------
include_once("left_navi.php");
//---------------------------------
echo '
<!-- Main bar -->
<div class="mainbar">
<!----------------------COMMON PAGE HEADING--------------------------------->';
//-----------------------------------
	include_once("top_navi.php");
?>