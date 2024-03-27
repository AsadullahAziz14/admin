<?php 

//----------------------------------------
$sqllmspro  = $dblms->querylms("SELECT emp.emply_id, emp.emply_status, emp.emply_regno, emp.emply_joining_date, emp.id_dept, emp.id_designation, 
										emp.id_type, emp.emply_job_title, emp.emply_name, emp.emply_fathername, emp.emply_cnic, emp.emply_dob, 
										emp.emply_gender, emp.emply_postal_address, emp.emply_permanent_address, emp.id_city, emp.id_country, 
										emp.emply_phone, emp.emply_mobile, emp.emply_email, emp.emply_officialemail, emp.emply_photo, 
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
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">

<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3 style="display:none;">Profile Details</h3></span>
			<button data-toggle="modal" class="btn btn-mid btn-info" href="#addNewHstModal" style="float:right;"><i class="icon-setting"></i> Change Password</button></h4>
			<button data-toggle="modal" class="btn btn-mid btn-info pull-right edit-emply-modal" data-toggle="modal" data-modal-window-title="Edit Employee" data-height="350" data-width="100%" data-emp-no="'.$rowstdpro['emply_regno'].'" data-emp-name="'.$rowstdpro['emply_name'].'" data-emp-fname="'.$rowstdpro['emply_fathername'].'" data-emp-dob="'.$rowstdpro['emply_dob'].'" data-emp-paddress="'.$rowstdpro['emply_postal_address'].'" data-emp-peaddress="'.$rowstdpro['emply_permanent_address'].'" data-emp-phone="'.$rowstdpro['emply_phone'].'" data-emp-mobile="'.$rowstdpro['emply_mobile'].'" data-emp-email="'.$rowstdpro['emply_email'].'" data-emp-cnic="'.$rowstdpro['emply_cnic'].'" data-emp-id="'.$rowstdpro['emply_id'].'" data-target="#editEmplyModal">
				<i class="icon-edit"></i> Edit Profile
			</button>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<!--WI_MILESTONES_NAVIGATION-->

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
    <td width="18%"><strong>Department</strong></td>
    <td width="31%">'.$rowstdpro['dept_name'].'</td>
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
<br>
<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th colspan="10">
		<h4 class="modal-title" style="font-weight:700;">Personal Information</h4>
	</th>
</tr>
</thead>
<tbody>

<tr>
    <td width="13%"><strong>Name </strong></td>
    <td width="27%">'.$rowstdpro['emply_name'].'</td>
    <td width="18%"><strong>Postal Address</strong></td>
    <td width="40%">'.$rowstdpro['emply_postal_address'].'</td>
</tr>

<tr>
    <td><strong>Gender</strong></td>
    <td>'.$rowstdpro['emply_gender'].'</td>
    <td><strong>Permanent Address</strong></td>
    <td>'.$rowstdpro['emply_permanent_address'].'</td>
</tr>

<tr>
    <td><strong>Birth Date</strong></td>
    <td>'.date("F j, Y", strtotime($rowstdpro['emply_dob'])).'</td>
    <td><strong>City</strong></td>
    <td>'.$rowstdpro['city_name'].'</td>
</tr>

<tr>
    <td><strong>Phone (Res)</strong></td>
    <td>'.$rowstdpro['emply_phone'].'</td>
    <td><strong>Phone (Mobile)</strong></td>
    <td>'.$rowstdpro['emply_mobile'].'</td>
</tr>

<tr>
    <td><strong>Email Address</strong></td>
    <td>'.$rowstdpro['emply_email'].'</td>
    <td><strong>CNIC</strong></td>
    <td>'.$rowstdpro['emply_cnic'].'</td>
</tr>

<tr>
    <td><strong>Offical Email Adress</strong></td>
    <td colspan="3">'.$rowstdpro['emply_officialemail'].'</td>

</tbody>
</table>


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


?>