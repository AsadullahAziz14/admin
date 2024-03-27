<?php 
//------------------------------------------------
	$sqllmssetting  = $dblms->querylms("SELECT exam_datesheet, midterm_mattendance, finalterm_mattendance, course_evaluation, teacher_evaluation,  
												graduating_survey, midterm_eattendance, finalterm_eattendance, exclude_attendance  
												FROM ".SETTINGS." 
												WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												LIMIT 1");
	$rowsetting 	= mysqli_fetch_array($sqllmssetting);
//--------------------------------------------
echo '<title>Date Sheet - '.TITLE_HEADER.'</title>
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
<div class="row">';
//----------------------------------------
$sqllmspro  = $dblms->querylms("SELECT emp.emply_id, emp.emply_status, emp.emply_regno, emp.emply_joining_date, emp.id_dept, emp.id_designation, 
										emp.id_type, emp.emply_job_title, emp.emply_name, emp.emply_fathername, emp.emply_cnic, emp.emply_dob, 
										emp.emply_gender, emp.emply_postal_address, emp.emply_permanent_address, emp.id_city, emp.id_country, 
										emp.emply_phone, emp.emply_mobile, emp.emply_email, emp.emply_email, emp.emply_officialemail, emp.emply_photo, 
										emp.emply_basicsalary, emp.emply_paymode, emp.id_bank, emp.emply_bankaccount, 
										emp.emply_loginid, desig.designation_name, dept.dept_name, city.city_name    
										FROM ".EMPLYS." emp 
										INNER JOIN ".DESIGNATIONS." desig ON desig.designation_id = emp.id_designation 
										INNER JOIN ".DEPTS." dept ON dept.dept_id = emp.id_dept 
										INNER JOIN ".CITIES." city ON city.city_id = emp.id_city 
										WHERE emp.id_campus	= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
										AND emp.emply_loginid = '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' LIMIT 1");
//----------------------------------------
$rowstdpro = mysqli_fetch_array($sqllmspro);
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-12">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">
<!--WI_MILESTONES_TABLE-->
<div class="row">
<div class="col-lg-12">
  
<div class="widget wtabs">
<div class="widget-content">';
//------------------------------------------------
if($rowstdpro['emply_photo']) { 
	$stdphoto = '<img class="avatar-large image-boardered" src="images/employees/'.$rowstdpro['emply_photo'].'" alt="'.$rowstdpro['emply_name'].'" />';
} else {
	$stdphoto = '<img class="avatar-large image-boardered" src="images/employees/default.png" alt="'.$rowstdpro['emply_name'].'" />';
}
//-----------------------------------------
echo '
<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th colspan="10">
		<h4 class="modal-title" style="font-weight:700;">Employee Profile</h4>
	</th>
</tr>
</thead>
<tbody>
<tr>
    <td width="13%"><strong>Employee No.</strong></td>
    <td idth="29%"><span class="label label-info">'.$rowstdpro['emply_regno'].'</span></td>
    <td width="18%"><strong>Name</strong></td>
    <td width="31%">'.$rowstdpro['emply_name'].'</td>
    <td rowspan="2" width="9%">'.$stdphoto.'</td>
</tr>
<tr>
    <td><strong>Designation</strong></td>
    <td>'.$rowstdpro['designation_name'].'</td>
    <td><strong>Join Date</strong></td>
    <td>'.date("F j, Y", strtotime($rowstdpro['emply_joining_date'])).'</td>
</tr>

</tbody>
</table>
<br>'; 

//-------------------------------------------------------------------
if($rowsetting['exam_datesheet']) {
//-------------------------------------------------------------------
	if($rowsetting['exam_datesheet'] == 1) { 
		include_once("datesheet/midterm.php");
	} else if($rowsetting['exam_datesheet'] == 2) { 
		include_once("datesheet/finalterm.php");
	} else if($rowsetting['exam_datesheet'] == 3) { 
		include_once("datesheet/summer.php");
	}
//-------------------------------------------------------------------
}
echo '

</div>
</div>
</div>
</div>

<!--WI_MILESTONES_TABLE-->
<!--WI_TABS_NOTIFICATIONS-->

</div>
<div class="clearfix"></div>
</div>
</div>
</div>';
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
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>


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
					<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
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