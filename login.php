<?php 
	define('TITLE1_HEADER'		, 'Campus Management System');
	define("SITE1_NAME"			, "Campus Management System");
	define("COPY1_RIGHTS"		, "Minhaj University Lahore");
	define("COPY1_RIGHTS_ORG"	, "&copy; ".date("Y")." - All Rights Reserved.");
	define("COPY1_RIGHTS_URL"	, "https://www.mul.edu.pk/");
//---------------------------------------
	include "functions/login_func.php";
// if(isset($_SESSION['LOGINIDA_SSS'])) {
// 	header("Location: dashboard.php");
// } else { 

$login_id = (isset($_POST['login_id']) && $_POST['login_id'] != '') ? $_POST['login_id'] : '';
	$errorMessage = '';
	if (isset($_POST['login_id'])) {
		$result = cpanelLMSAuserLogin();
		if ($result != '') {
			$errorMessage = $result;
		}
	}
//---------------------------------------
echo '
<!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns# fb: http://www.facebook.com/2008/fbml fb: http://ogp.me/ns/fb# og: http://opengraphprotocol.org/schema/ website: http://ogp.me/ns/website#" itemscope itemtype="http://schema.org/NewsArticle" class="bg-dark">
<head>
<meta charset="utf-8" />
<link rel="shortcut icon" href="images/favicon.ico">
<title>Welcome to '.TITLE1_HEADER.' login panel</title>
<link rel="index" title="Campus Management System - Minhaj University Lahore" href="https://cms.mul.edu.pk">
<link rel="canonical" href="https://cms.mul.edu.pk">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="image_src" href="https://cms.mul.edu.pk/images/campus/Minhaj-University-Lahore_1.png">
<meta property="og:image:secure_url" content="https://cms.mul.edu.pk/images/campus/Minhaj-University-Lahore_1.png">
<meta property="og:title" content="Campus Management System, Student information system deals with all kind of student details, academic related reports, college details, course details, curriculum web portal for Students, Teachers and Staff by Minhaj University Lahore">
<meta property="og:url" content="https://cms.mul.edu.pk">
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
<link rel="stylesheet" href="https://cms.mul.edu.pk/login/css/app.v2.css" type="text/css" />
<link rel="stylesheet" href="https://cms.mul.edu.pk/login/css/font.css" type="text/css" cache="false" />
<!--[if lt IE 9]>
<script src="https://cms.mul.edu.pk/login/js/ie/html5shiv.js" cache="false"></script>
<script src="https://cms.mul.edu.pk/login/js/ie/respond.min.js" cache="false"></script>
<script src="https://cms.mul.edu.pk/login/js/ie/excanvas.js" cache="false"></script>
<![endif]-->
<style type="text/css">
@import url(https://fonts.googleapis.com/css?family=Dosis:300|Lato:300,400,600,700|Roboto+Condensed:300,700|Open+Sans+Condensed:300,600|Open+Sans:400,300,600,700|Maven+Pro:400,700);
	@import url("https://cms.mul.edu.pk/login/css/font-awesome.css");
.content:before {
	content: "";  position: fixed;  left: 0;  right: 0;  top: 0;  bottom: 0;  z-index: -1;  display: block;  background-color: black;
	background-image: url("login/images/11.jpg");  width: 100%;  height: 100%;  background-size: cover; background-repeat: no-repeat; background-position: bottom;
	-webkit-filter: blur(2px);  -moz-filter: blur(1px);  -o-filter: blur(1px);  -ms-filter: blur(1px);  filter: blur(1px);
}

.content {
	top: 0;  bottom: 0;  left: 0;  right: 0;  background-color: rgba(10, 10, 10, 0.5);  margin: auto auto;
	-moz-border-radius: 4px;  -webkit-border-radius: 4px;  border-radius: 4px;  -moz-box-shadow: 0 0 10px black;
	-webkit-box-shadow: 0 0 10px black;  box-shadow: 0 0 10px black; margin-top:80px;
}

.panel { margin-bottom: 10px; }
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
<!--main content start-->
<div class="content">
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
<div class="container aside-xxl">
<section class="panel panel-default bg-white m-t-lg">
<header class="panel-heading text-center">
	<strong>Campus Management System</strong> 
</header>

<form method="post" accept-charset="utf-8" class="panel-body wrapper-lg" name="frmLogin" id="frmLogin">
<div style="display:none"></div>
<div class="form-group">';
//---------------------------------------
if($errorMessage) {
	echo $errorMessage;
}
//---------------------------------------
echo '
	<label class="control-label">Email or Username</label>
	<input type="text" name="login_id" value="'.$login_id.'" class="form-control input-lg" placeholder="your login ID" autofocus required maxlength="80" size="30"  />
</div>
<div class="form-group">
	<label class="control-label">Password</label>
	<input type="password" name="login_pass" value="" id="inputPassword" size="30" placeholder="your login password" required class="form-control input-lg"  />
</div>
<button type="submit" class="btn btn-primary">Sign in</button>
<a href="forgetpassword.php" class="btn btn-warning">Forgot Password</a>
</form>
</section>
<!-- footer --> 
<footer id="footer">
	<div class="text-center text-white padder">
		<p> <small>'.COPY1_RIGHTS_ORG.'
        <br>Powered by: <a href="'.COPY1_RIGHTS_URL.'">'.COPY1_RIGHTS.'</a>  v1.0</small></p>
	</div>
</footer>
<!-- / footer -->
</div> 
</section>
</div>
<!--main content end-->
<script src="login/js/app.v2.js"></script>
<!-- Bootstrap -->
<!-- App -->
</body>
</html>';
// }
?>