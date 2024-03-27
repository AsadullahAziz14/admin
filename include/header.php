<?php 
if($_SESSION['userlogininfo']['LOGINAFOR'] != 3) { 

echo '
<!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns# fb: http://www.facebook.com/2008/fbml fb: http://ogp.me/ns/fb# og: http://opengraphprotocol.org/schema/ website: http://ogp.me/ns/website#" itemscope itemtype="http://schema.org/NewsArticle">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="index" title="Campus Management System - Minhaj University Lahore" href="https://cms.mul.edu.pk">
<link rel="canonical" href="'.curPageURL().'">
<link rel="image_src" href="https://cms.mul.edu.pk/images/campus/Minhaj-University-Lahore_1.png">
<meta property="og:image:secure_url" content="https://cms.mul.edu.pk/images/campus/Minhaj-University-Lahore_1.png">
<meta property="og:title" content="Campus Management System, Student information system deals with all kind of student details, academic related reports, college details, course details, curriculum web portal for Students, Teachers and Staff by Minhaj University Lahore">
<meta property="og:url" content="'.curPageURL().'">
<meta property="og:site_name" content="Campus Management System - Minhaj University Lahore">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_US">
<meta property="article:author" content="https://www.facebook.com/MinhajUniversityLahore">
<meta property="article:publisher" content="https://www.facebook.com/MinhajUniversityLahore">
<meta name="description" content="Campus Management System, Student information system deals with all kind of student details, academic related reports, college details, course details, curriculum web portal for Students, Teachers and Staff by Minhaj University Lahore" />
<meta name="keywords" content="Minhaj, university, lahore, education, cms, student, portal, web portal, ranking, admission, apply online, degree, hec, in hec ranking, information, courses, academic, semester, college, school, faculty, exams, library, grade, account">
<meta name="author" content="Minhaj University Lahore"/>
<meta name="robots" content="index, follow">
<meta name="copyright" content="Minhaj University Lahore. '.date("Y").'">
<meta name="distribution" content="Global">
<meta name="coverage" content="Worldwide">
<meta name="rating" content="General">
<meta name="identifier" content="https://cms.mul.edu.pk">
<meta name="organization-Email" content="support.cms@mul.edu.pk">
<link href="style/all-vendors.css" rel="stylesheet">
<link href="style/style.css" rel="stylesheet">
<link href="style/responsive.css" rel="stylesheet">';
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "lrccirculations") && ($view == "Checkout") ) {
	echo'
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>';
	
} else { 
	echo '<script type="text/javascript" src="js/jquery/jquery.js"></script>';
	
}
echo '
<script type="text/javascript" src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

<!-- HTML5 Support for IE -->
<!--[if lt IE 9]>
<script src="js/html5shim.js"></script>
<![endif]-->';
//-------------------------------------------------------------------
if($_SESSION['userlogininfo']['LOGINAFOR'] == 2 || $_SESSION['userlogininfo']['LOGINAFOR'] == 3) { 
	
//-------------------------------------------------------------------
echo '
<link href="style/dashboard/css/Site.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 8]>
<link rel="stylesheet" media="screen" href="style/dashboard/css/ie.css" />
<![endif]-->';
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) != "dashboard") ) {
echo '
<script src="style/dashboard/js/jquery.tools.min.js" type="text/javascript"></script>
<link href="style/dashboard/css/jquery.cleditor.css" rel="stylesheet" type="text/css" />
<script src="style/dashboard/js/jquery.cleditor.js" type="text/javascript"></script>
<script src="style/dashboard/js/global.js" type="text/javascript"></script>';
} 
	
echo '
<!--[if lt IE 9]>
<script type="text/javascript" src="style/dashboard/js/html5.js"></script>
<script type="text/javascript" src="style/dashboard/js/PIE.js"></script>
<script type="text/javascript" src="style/dashboard/js/IE9.js"></script>
<script type="text/javascript" src="style/dashboard/js/ie.js"></script>
<![endif]-->
<link rel="stylesheet" href="style/dashboard/css/jquery-ui.css" />';

//-------------------------------------------------------------------
}
//-------------------------------------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "lrccirculations") && ($view == "Checkout")) {
	echo'
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script>';

} else { 

	echo '<script type="text/javascript" src="js/select2/jquery.select2.js"></script>';

}
echo '
<!-- Favicon -->
<link rel="shortcut icon" href="images/favicon/favicon.ico">
<style type="text/css">
	#tawkchat-minified-iframe-element { left:2px!important; }
	#tawkchat-minified-iframe-element #tawkchat-minified-container { border:0 !important; }
	.col-sm-10 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-10 {float:left}
	.col-sm-10 {width:99%}
	
	.col-sm-71 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-71 {float:left}
	.col-sm-71 {width:67%}
	
	
	.col-sm-72 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-72 {float:left}
	.col-sm-72 {width:60%}
	
	.col-sm-61 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-61 {float:left}
	.col-sm-61 {width:50%}
	
	.col-sm-41 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-41 {float:left}
	.col-sm-41 {width:33%}
	
	.col-sm-42 {position:relative;min-height:1px;padding-right:5px;padding-left:1px}
	.col-sm-42 {float:left}
	.col-sm-42 {width:48%}
	
	.col-sm-43 {position:relative;min-height:1px;padding-right:5px;padding-left:1px}
	.col-sm-43 {float:left}
	.col-sm-43 {width:40%}
	
	
	.col-sm-45 {position:relative;min-height:1px;padding-right:5px;padding-left:1px}
	.col-sm-45 {float:left}
	.col-sm-45 {width:35%}

	.col-sm-32 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-32 {float:left}
	.col-sm-32 {width:25%}
	
	
	.col-sm-31 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-31 {float:left}
	.col-sm-31 {width:20%}
	
	.col-sm-30 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-30 {float:left}
	.col-sm-30 {width:30%}
	
	.col-sm-311 {position:relative;min-height:1px;padding-right:5px;padding-left:1px}
	.col-sm-311 {float:left}
	.col-sm-311 {width:20%}
	
	.col-sm-15 {position:relative;min-height:1px;padding-right:10px;padding-left:1px}
	.col-sm-15 {float:left}
	.col-sm-15 {width:15%}
	
	.col-sm-33 {position:relative;min-height:1px;padding-right:10px;padding-left:1px}
	.col-sm-33 {float:left}
	.col-sm-33 {width:18%}	
	
	.col-sm-34 {position:relative;min-height:1px;padding-right:5px;padding-left:1px}
	.col-sm-34 {float:left}
	.col-sm-34 {width:11.75%}	
	
	.col-sm-35 {position:relative;min-height:1px;padding-right:5px;padding-left:1px}
	.col-sm-35 {float:left}
	.col-sm-35 {width:16.75%}	
	
	.req:after {content:"*";font-size:14px;color:#cc0000;padding-left:4px}
	.form_sep + .form_sep {margin-top:5px;padding-top:5px;border-top:1px dashed #e3e3e3}
	.form_sep:before,.form_sep:after {content:"";display:table;}
	.form_sep:after {clear:both;}
	.alert-box {
		color:#555;	border-radius:10px;	font-family:Tahoma,Geneva,Arial,sans-serif;font-size:13px; padding:10px 36px; margin:20px 100px 0 100px;
	}
	.alert-box span { font-weight:bold; text-transform:uppercase; }
	.error { background:#ffecec url("images/error.png") no-repeat 10px 50%; border:1px solid #f5aca6; margin-bottom:10px; }
	.success { background:#e9ffd9 url("images/success.png") no-repeat 10px 50%;	border:1px solid #a6ca8a; margin-bottom:10px; }
	.warning { background:#fff8c4 url("images/warning.png") no-repeat 10px 50%;	border:1px solid #f2c779; margin-bottom:10px; }
	.notice { background:#e3f7fc url("images/notice.png") no-repeat 10px 50%; border:1px solid #8ed9f6; margin-bottom:10px; }
	.inv_clone_btn {cursor:pointer; }
	.inv_remove_btn {cursor:pointer; }
	
.modal-dialog.newsletter-popup {
	margin-top: 5%;
	color: #000000;
	min-width: 600px;
	padding: 0px;
	text-align: left;
	width:600px;
	text-align: center;
	background: #3ab54a;
	padding: 20px;
	box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
	overflow: hidden;
	opacity: 1;
	box-shadow: none;
}
.newsletter-popup .modal-content {
	background: inherit;
	padding: 20px;
	text-align: center;
	position: initial;
	border: none;
}
.newsletter-popup .close {
	cursor: pointer;
	line-height: 27px;
	min-width: 30px;
	height: 30px;
	position: absolute;
	right: -2px;
	text-align: center;
	text-transform: uppercase;
	top: -5px;
	font-size: 30px;
	font-weight: 600;
	letter-spacing: 1px;
	color: #eee;
	font-family: Verdana, Geneva, sans-serif;
	opacity: 1;
}
.newsletter-popup .close:hover {
	color: #fe0100;
}
.newsletter-popup h4.modal-title {
	font-size: 25px;
	font-weight: 700;
	line-height: 1;
	margin-bottom: 0;
	margin-top: 0px;
	text-transform: uppercase;
	letter-spacing: 1px;
	color: #fff;
}
#newsletter-form .content-subscribe {
	overflow: hidden
}
.form-subscribe-header p {
	color: #fff;
	font-size: 16px;
	text-align: left;
	font-weight: normal;
	line-height: 25px;
	margin: 10px 0;
	max-width: 95%;
}
#newsletter-form .input-box .input-text {
	border: 1px solid #ddd;
	height: 50px;
	line-height: 50px;
	margin: 0 0 5px;
	padding-left: 15px;
	width: 95%;
	border-radius: 0px;
	color: #000000;
	font-size: 14px;
}
.subscribe-bottom input[type=checkbox] {
	vertical-align: sub;
}
#newsletter-form .actions .button-subscribe {
	background-color: #000;
	border: medium none;
	color: #fff;
	font-size: 16px;
	line-height: 40px;
	padding: 4px 20px;
	text-transform: uppercase;
	font-weight: 600;
	letter-spacing: 1px;
	margin-top: 8px;
}
#newsletter-form .actions .button-subscribe:hover {
	background: #111;
	color: #fff;
}
.subscribe-bottom {
	color: #eee;
	display: block;
	margin-top: 15px;
	overflow: hidden;
}
.subscribe-bottom label {
	color: #eee;
	font-size: 12px;
	margin-bottom: 0;
}
#dont_show {
	margin: 0;
	vertical-align: middle;
}
.modal-open .modal {
	background: none repeat scroll 0 0 rgba(0, 0, 0, 0.6);
}

.flashmsgs{
	width:80%;
	font-family: Calibri, Calibri Light;
	margin: 0 auto;
}

.flashmsgs .nortification{
	display:block;
	font-size:18px;
	padding:10px; 
	line-height: 1.3em;
	top:0;
	box-sizing:border-box;
 	border-radius:10px;
	background-color:#f00;
	color:#fff;
	font-weight: bold;
	
	box-shadow: 0 1px 0 rgba(0,0,0,0.2);
}

.flashmsgs .animateOpen{
	-webkit-animation:moveOpen 4s;
 	-webkit-animation-iteration-count: infinite;
 	-webkit-animation-fill-mode: forwards;
}
/* Safari and Chrome */
@-webkit-keyframes moveOpen  {
  from {-webkit-transform: translate(0,-100px);}
  10% {-webkit-transform: translate(0,20px);}
  12% {-webkit-transform: translate(0,22px);}
  16% {-webkit-transform: translate(0,20px);}
  80% {-webkit-transform: translate(0,20px);}
  85% {-webkit-transform: translate(0,25px);}
  to {-webkit-transform: translate(0,-100px);}
}

</style>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-157765548-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag(\'js\', new Date());

  gtag(\'config\', \'UA-157765548-1\');
</script>
</head>
<body>
<!--[if lte IE 8]>
<script language="javascript" type="text/javascript" src="js/flot/excanvas.min.js"></script>
<![endif]-->
<script type="text/javascript" src="js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="js/flot/jquery.flot.canvas.js"></script>
<!-- Main content starts -->
<div class="content">';
//---------------------------------
include_once(get_logintypes($_SESSION['userlogininfo']['LOGINAFOR'])."/left_navi.php");
//---------------------------------
echo '
<!-- Main bar -->
<div class="mainbar">
<!----------------------COMMON PAGE HEADING--------------------------------->';
//-----------------------------------
	include_once(get_logintypes($_SESSION['userlogininfo']['LOGINAFOR'])."/top_navi.php");
}
?>