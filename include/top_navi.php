<?php 
echo '
<div class="page-head">
	'.$toptitlename.'
<!-- menu -->
<div class="heading-menu pull-right responsive-heading-tabs">
<ul>';
//-------------------------------------------------

	echo '<li><div class="btn-group"> <a '.$tsfrclsactive.' data-toggle="modal" href="#PorgramModal"> <i class="icon-folder-open"></i> <span>Program</span></a> </div></li>';
//-------------------------------------------------
if(($_SESSION['LOGINFEES_SSS'] == 1) || ($_SESSION['LOGINTYPE_SSS'] == 2)) { 
	echo '<li><div class="btn-group"> <a '.$tfeeclsactive.' href="feedashboard.php"> <i class="icon-credit-card"></i> <span>Fee Record</span></a> </div></li>';
}
//-------------------------------------------------
if(($_SESSION['LOGINFORMSUBMIT_SSS'] == 1) || ($_SESSION['LOGINTYPE_SSS'] == 2)) {
	echo '<li><div class="btn-group"> <a '.$tadmsclsactive.' href="form_submission.php"> <i class="icon-folder-open"></i> <span>Form Submission</span></a> </div></li>';
}
//-------------------------------------------------
if(($_SESSION['LOGINADMISSIONS_SSS'] == 1) || ($_SESSION['LOGINTYPE_SSS'] == 2)) {
	echo '<li><div class="btn-group"> <a '.$tadmsclsactive.' href="admissions.php"> <i class="icon-folder-open"></i> <span>Admissions</span></a> </div></li>';
}
//-------------------------------------------------
if(($_SESSION['LOGININQUIRIES_SSS'] == 1) || ($_SESSION['LOGINTYPE_SSS'] == 2)) { 
	echo '<li><div class="btn-group"> <a '.$tadmclsactive.' href="admission_inquiry.php"> <i class="icon-group"></i> <span>Inquiry</span></a> </div></li>';
}

//-------------------------------------------------
echo '
	<li>
		<div class="btn-group dropup"> <a href="myaccount.php"> <i class="icon-gears"></i> <span>My Account</span></a></div>
	</li>
	<li><div class="btn-group dropup"> <a class="" href="index.php?logout"> <i class="icon-off"></i> <span>Logout</span></a> </div></li>
</ul>
</div>
	<div class="clearfix"></div>
</div>';
?>