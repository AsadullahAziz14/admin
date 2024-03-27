<?php 

$sqllmsempid  = $dblms->querylms("SELECT emp.emply_id  
										FROM ".EMPLYS." emp  
										WHERE emp.id_campus	= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
										AND emp.emply_loginid = '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' LIMIT 1");
//----------------------------------------
$rowempid 	= mysqli_fetch_array($sqllmsempid);
//--------------------------------------------
	include_once("query.php");
//--------------------------------------------


//--------------------------------------------
if(!LMS_VIEW) { $detail = 'side-menu-main-active'; $delfont = 'font-weight:600;'; } else { $detail = ''; $delfont = ''; }
//--------------------------------------------
if(LMS_VIEW == 'language') { $lang = 'side-menu-main-active'; $langfont = 'font-weight:600;'; } else { $lang = ''; $langfont = ''; }
//--------------------------------------------
if(LMS_VIEW == 'education') { $edu = 'side-menu-main-active'; $edufont = 'font-weight:600;'; } else { $edu = ''; $edufont = ''; }
//--------------------------------------------
if(LMS_VIEW == 'membership') { $mem = 'side-menu-main-active'; $memfont = 'font-weight:600;'; } else { $mem = ''; $memfont = ''; }
//--------------------------------------------
if(LMS_VIEW == 'experience') { $exp = 'side-menu-main-active'; $expfont = 'font-weight:600;'; } else { $exp = ''; $expfont = ''; }
//--------------------------------------------
if(LMS_VIEW == 'achievement') { $achi = 'side-menu-main-active'; $achifont = 'font-weight:600;'; } else { $achi = ''; $achifont = ''; }
//--------------------------------------------
if(LMS_VIEW == 'training') { $trn = 'side-menu-main-active'; $trnfont = 'font-weight:600;'; } else { $trn = ''; $trnfont = ''; }
//--------------------------------------------
if(LMS_VIEW == 'publications') { $pub = 'side-menu-main-active'; $pubfont = 'font-weight:600;'; } else { $pub = ''; $pubfont = ''; }
//--------------------------------------------
echo '<title>Manage Profile - '.TITLE_HEADER.'</title>
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<!----------------------COMMON PAGE HEADING--------------------------------->
<div class="matter">
<!----------------------COMMON PROJECT HEAD--------------------------------->
<!--WI_PROJECT_HEADER-->
<div class="headerbar">
	<div class="widget headerbar-widget">
		<div class="pull-left dashboard-user-picture">
			<img class="avatar-small" src="'.$_SESSION['userlogininfo']['LOGINIDAPIC'].'" alt="'.$_SESSION['userlogininfo']['LOGINFNAMEA'].'"/>
		</div>
		<div class="headerbar-project-title pull-left"><h3><b>'.$_SESSION['userlogininfo']['LOGINFNAMEA'].'</b></h3></div>
	</div>
</div>
<!--WI_PROJECT_HEADER-->
<!----------------------COMMON PROJECT HEAD--------------------------------->
<div class="container">
<div class="row">

<!--WI_Menu-->
<div class="col-lg-3">
	<div class="row">
		<div class="col-lg-12 project-menu">
			<div class="box side-menu-main">
				<div class="box-head-dark"><b><i class="icon-user"></i> Profile Menu</b> </div>
				<div class="box-content">
					<ul>
						<li><a class="'.$detail.'" href="profile.php" style="'.$delfont.'"> Details</a></li>
						<li><a class="'.$edu.'" href="profile.php?view=education" style="'.$edufont.'"> Qualification</a></li>
						<li><a class="'.$exp.'" href="profile.php?view=experience" style="'.$expfont.'"> Experience</a></li>
						<li><a class="'.$lang.'" href="profile.php?view=language" style="'.$langfont.'"> Language Skills</a></li>
						<li><a class="'.$trn.'" href="profile.php?view=training" style="'.$trnfont.'"> Training</a></li>
						<li><a class="'.$mem.'" href="profile.php?view=membership" style="'.$memfont.'"> Membership</a></li>
						<li><a class="'.$achi.'" href="profile.php?view=achievement" style="'.$achifont.'"> Achievements</a></li>
						<li><a class="'.$pub.'" href="profile.php?view=publications" style="'.$pubfont.'"> Publications</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- WI_Menu -->';
//--------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
}
//-------------------------------------
if(!LMS_VIEW) {
	include_once("details.php");
}
//--------------- Language -------------
if(LMS_VIEW) {
	include_once(LMS_VIEW.".php");
}
//-------------------------------------
echo '

</div>
<!--WI_NOTIFICATION-->

<!--WI_NOTIFICATION-->
</div>
</div>
</div>
<div class="clearfix"></div>
</div>
<!----------------------COMMON FOOTER--------------------------------->

<!-- Footer starts -->
<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<p class="copy">Powered by: | <a href="'.COPY_RIGHTS_URL.'" target="_blank">'.COPY_RIGHTS.'</a> </p>
			</div>
		</div>
	</div>
</footer>
<!-- Footer ends -->

<!-- Scroll to top -->
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>';
//-------------------------------------
	if(!LMS_VIEW) { include_once("modals/detail.php"); }
	if(LMS_VIEW != 'publications') { include_once("modals/".LMS_VIEW.".php"); } 
//-------------------------------------
echo '

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
<!--JS_SELECT_LISTS-->
<script type="text/javascript">
// close the div in 5 secs
window.setTimeout("closeHelpDiv();", 5000, 2500);

function closeHelpDiv(){
	document.getElementById("infoupdated").style.display=" none";
}
</script>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
<script>
jQuery(function($) {
      $.mask.definitions["~"]="[+-]";
      $("#emply_cnic").mask("99999-9999999-9");
	  $("#emply_cnic_edit").mask("99999-9999999-9");
	  $("#emply_mobile").mask("9999-9999999");
	  $("#emply_mobile_edit").mask("9999-9999999");
        });
</script>
<script type="text/javascript">
	$(function () {
		$(".footable").footable();
	});
</script>
<script type="text/javascript">
	function getPublicationForm(id_type) {  
		//$("#loading").html("<img src="images/ajax-loader-horizintal.gif"> loading...");  
		$.ajax({  
			type: "GET",  
			async:false,
			cache:false,
			url: "include/ajax/teachers/getPublicationForm.php",  
			data: "id_type="+id_type,  
			success: function(msg){  
				$("#getPublicationForm").html(msg); 
				$("#loading").html(""); 
			}
		});  
	}
</script>
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
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>';