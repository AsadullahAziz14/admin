<?php 
	define('TITLE_HEADER'		, 'Admin Panel - Minhaj University Lahore');
	define("SITE_NAME"			, "Admin Panel - Minhaj University Lahore");
	define("COPY_RIGHTS"		, "Minhaj Internet Bureau");
	define("COPY_RIGHTS_ORG"	, "&copy; ".date("Y")." - All Rights Reserved.");
	define("COPY_RIGHTS_URL"	, "http://www.minhaj.net/");
//---------------------------------------
	include "functions/login_func.php";
if(isset($_SESSION['LOGINIDA_SSS'])) {
	header("Location: dashboard.php");
} else { 

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
<html lang="en" class="bg-dark">
<head>
<meta charset="utf-8" />
<link rel="shortcut icon" href="images/favicon.ico">
<title>Welcome to '.TITLE_HEADER.' login panel</title>
<meta name="description" content="Minhaj Internet Bureau " />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="stylesheet" href="login/css/app.v2.css" type="text/css" />
<link rel="stylesheet" href="login/css/font.css" type="text/css" cache="false" />
<!--[if lt IE 9]>
<script src="login/js/ie/html5shiv.js" cache="false"></script>
<script src="login/js/ie/respond.min.js" cache="false"></script>
<script src="login/js/ie/excanvas.js" cache="false"></script>
<![endif]-->
<style type="text/css">
@import url(http://fonts.googleapis.com/css?family=Dosis:300|Lato:300,400,600,700|Roboto+Condensed:300,700|Open+Sans+Condensed:300,600|Open+Sans:400,300,600,700|Maven+Pro:400,700);
	@import url("login/css/font-awesome.css");
.content:before {
	content: "";  position: fixed;  left: 0;  right: 0;  top: 0;  bottom: 0;  z-index: -1;  display: block;  background-color: black;
	background-image: url("login/images/login-.jpg");  width: 100%;  height: 100%;  background-size: cover;
	-webkit-filter: blur(2px);  -moz-filter: blur(1px);  -o-filter: blur(1px);  -ms-filter: blur(1px);  filter: blur(1px);
}

.content {
	top: 0;  bottom: 0;  left: 0;  right: 0;  background-color: rgba(10, 10, 10, 0.5);  margin: auto auto;
	-moz-border-radius: 4px;  -webkit-border-radius: 4px;  border-radius: 4px;  -moz-box-shadow: 0 0 10px black;
	-webkit-box-shadow: 0 0 10px black;  box-shadow: 0 0 10px black; margin-top:80px;
}

.panel { margin-bottom: 10px; }
</style>
</head>
<body> 
<!--main content start-->
<div class="content">
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
<div class="container aside-xxl">
<section class="panel panel-default bg-white m-t-lg">
<header class="panel-heading text-center">
	<strong>'.SITE_NAME.'</strong> 
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
<button type="reset" class="btn btn-primary">Reset</button>
</form>
</section>
<!-- footer --> 
<footer id="footer">
	<div class="text-center text-white padder">
		<p> <small>'.COPY_RIGHTS_ORG.'
        <br>Develop by <a href="'.COPY_RIGHTS_URL.'">'.COPY_RIGHTS.'</a>  v1.0</small></p>
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
}
?>