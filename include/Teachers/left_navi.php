<?php 
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "dashboard")) {
	$lhomeclsactive = 'class="open"';
	$thomeclsactive = 'class="heading-menu-active"';
} else { 
	$lhomeclsactive	= '';
	$thomeclsactive = '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "profile")) {
	$lproclsactive = 'class="open"';
	$tproclsactive = 'class="heading-menu-active"';
} else { 
	$lproclsactive 	= '';
	$tproclsactive 	= '';
}

//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "archive")) {
	$larchiveclsactive = 'class="open"';
	$tarchivelsactive 	= 'class="heading-menu-active"';
} else { 
	$larchiveclsactive	= '';
	$tarchivelsactive 	= '';
}

//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "personaldiary")) {
	$lpdryclsactive = 'class="open"';
	$tpdrylsactive 	= 'class="heading-menu-active"';
} else { 
	$lpdryclsactive	= '';
	$tpdrylsactive 	= '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "personalcontacts")) {
	$lpcontsclsactive = 'class="open"';
	$tcontlsactive 	= 'class="heading-menu-active"';
} else { 
	$lpcontsclsactive	= '';
	$tcontlsactive 	= '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "personaltodolist")) {
	$ltodolistclsactive = 'class="open"';
	$ttodolistlsactive 	= 'class="heading-menu-active"';
} else { 
	$ltodolistclsactive	= '';
	$ttodolistlsactive 	= '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "weeklylectureschedule")) {
	$lstimeclsactive 	= 'class="open"';
	$tstimelsactive 	= 'class="heading-menu-active"';
} else { 
	$lstimeclsactive	= '';
	$tstimelsactive 	= '';
}

if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "tentativedatesheet")) {
	$ltdatesheetclsactive 	= 'class="open"';
	$ttdatesheetsactive 	= 'class="heading-menu-active"';
} else { 
	$ltdatesheetclsactive	= '';
	$ttdatesheetsactive 	= '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "academiccalendar")) {
	$lacalenderclsactive 	= 'class="open"';
	$tacalendersactive 		= 'class="heading-menu-active"';
} else { 
	$lacalenderclsactive	= '';
	$tacalendersactive 		= '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "assemblyattendance")) {
	$lassemblyattendanceclsactive 	= 'class="open"';
	$tassemblyattendanceactive 		= 'class="heading-menu-active"';
} else { 
	$lassemblyattendanceclsactive	= '';
	$tassemblyattendanceactive 		= '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "datesheet")) {
	$ldatesheetclsactive 	= 'class="open"';
	$tdatesheetactive 		= 'class="heading-menu-active"';
} else { 
	$ldatesheetclsactive	= '';
	$tdatesheetactive 		= '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "bogmessages")) {
	$lbogmsgsclsactive = 'class="open"';
	$tbogmsgsclsactive = 'class="heading-menu-active"';
} else { 
	$lbogmsgsclsactive	= '';
	$tbogmsgsclsactive = '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "laadvisees")) {
	$ladviseesclsactive = 'class="open"';
	$tadviseesclsactive = 'class="heading-menu-active"';
} else { 
	$ladviseesclsactive	= '';
	$tadviseesclsactive = '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "lateacherappointments")) {
	$lstudentappointmentclsactive 	= 'class="open"';
	$tstudentappointmentactive 		= 'class="heading-menu-active"';
} else { 
	$lstudentappointmentclsactive	= '';
	$tstudentappointmentactive 		= '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "lateacherappointmentsgroup")) {
	$lstudentgroupappointmentclsactive 	= 'class="open"';
	$tstudentgroupappointmentactive 	= 'class="heading-menu-active"';
} else { 
	$lstudentgroupappointmentclsactive	= '';
	$tstudentgroupappointmentactive 	= '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "guidances")) {
	$lguidancesclsactive 	= 'class="open"';
	$tguidancesactive 		= 'class="heading-menu-active"';
} else { 
	$lguidancesclsactive	= '';
	$tguidancesactive 		= '';
}
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "noticeboard")) {
	$lnoticeclsactive 	= 'class="open"';
	$tnoticeactive 		= 'class="heading-menu-active"';
} else { 
	$lnoticeclsactive	= '';
	$tnoticeactive 		= '';
}

//HR Menu
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "hremployeeattendance") ) {
	$lhrclsactive 	= 'class="open"';
	$lhractive		= 'style="display:block; visibility:visible;"';
	$thrclsactive 	= 'class="heading-menu-active"';
} else { 
	$lhrclsactive	= '';
	$lhractive		= '';
	$thrclsactive 	= '';
}

//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "dashboard")) { 
	$lefttitlename 	= 'Dashboard';
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-home"></i> Dashboard</h2>';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "profile")) { 
	$lefttitlename 	= 'My Profile';
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-user"></i> My Profile</h2>';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "personaldiary")) { 
	$lefttitlename 	= 'Persoanl Diary';
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-file-text"></i> Persoanl Diary</h2>';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "personalcontacts")) { 
	$lefttitlename 	= 'Persoanl Contacts';
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-group"></i> Persoanl Contacts</h2>';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "personaltodolist")) { 
	$lefttitlename 	= 'Persoanl To Do List';
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-list"></i> Persoanl To Do List</h2>';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "courses")) { 
	$lefttitlename 	= 'Manage Course';
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-folder-open"></i> Manage Course</h2>';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "weeklylectureschedule")) { 
	$lefttitlename 	= 'Weekly Lecture Schedule';
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-time"></i> Weekly Lecture Schedule</h2>';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "tentativedatesheet")) { 
	$lefttitlename 	= 'Tentative Date Sheet';
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-time"></i> Tentative Date Sheet</h2>';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "assemblyattendance")) { 
	$lefttitlename 	= 'Assembly Attendance';
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-calendar"></i> Assembly Attendance</h2>';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "datesheet")) { 
	$lefttitlename 	= 'Date Sheet';
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-calendar"></i> Date Sheet</h2>';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "archive")) { 
	$lefttitlename 	= ARCHIVE_SESS.' Archive';
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-calendar"></i> '.ARCHIVE_SESS.' Archive</h2>';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "academiccalendar")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-calendar"></i> Academic Calendar for Session: '.$_SESSION['userlogininfo']['LOGINIDCALENDAR'].'</h2>';
	$lefttitlename 	= 'Academic Calendar for Session: '.$_SESSION['userlogininfo']['LOGINIDCALENDAR'];
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "summer")) { 
	$lefttitlename 	= 'Summer Courses';
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-time"></i> Summer Courses</h2>';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "bogmessages")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-envelope"></i> BOG Messages</h2>';
	$lefttitlename 	= 'BOG Messages';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "changepassword")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-key"></i> Change Password</h2>';
	$lefttitlename 	= 'Change Password';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "laadvisees")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-group"></i> My Advisees List</h2>';
	$lefttitlename 	= 'My Advisees List';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "lateacherappointments")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-user"></i> Student Appointments</h2>';
	$lefttitlename 	= 'Student Appintments';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "lateacherappointmentsgroup")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-group"></i> Student Group Appointments</h2>';
	$lefttitlename 	= 'Student Group Appintments';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "guidances")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-info"></i> Guidance & Help</h2>';
	$lefttitlename 	= 'Guidance & Help';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "noticeboard")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-adjust"></i> Notice Board</h2>';
	$lefttitlename 	= 'Notice Board';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "complaintsuggestionbox")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-mail-reply-all"></i> Complaint / Suggestion</h2>';
	$lefttitlename 	= 'Complaint / Suggestion';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "hremployeeattendance")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-time"></i> Employee Attendance</h2>';
	$lefttitlename 	= 'Employee Attendance';
}

//Query Employee 
$sqllms  = $dblms->querylms("SELECT emply_id, id_dept, emply_name, emply_mobile, emply_email, emply_officialemail 
								FROM ".EMPLYS."   										 
								WHERE id_campus 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
								AND emply_loginid 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' LIMIT 1");
$rowsstd = mysqli_fetch_array($sqllms);

//For Campus other then MUL
if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) != 1) {

	//Count Total Number of CLasses incharge of
	$sqllmsInchargeTimetable  = $dblms->querylms("SELECT t.id_prg, t.semester, t.section, t.timing, p.prg_name  
														FROM ".TIMETABLE." t
														INNER JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg 
														WHERE t.status = '1' AND t.class_incharge = '".cleanvars($rowsstd['emply_id'])."' 
														AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
														AND t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'");
}

$lsrvcclsactive = '';
$lsrvcvis = '';
echo '
<!-- Sidebar -->
<div class="sidebar">
<!--SIDE MENU - ONLOAD -->
<div class="sidebar-dropdown"><a href="#">'.$lefttitlename.'</a></div>
<ul id="nav" class="main-nav">
	<div class="nav_logo"> <img class="img-responsive" src="'.$_SESSION['userlogininfo']['LOGINIDCOMLOGO'].'" alt="Campus Management System"> </div>
	<li class="nav_alternative">  
		<ul class="nav_alternative_controls" tabindex="-1" data-reactid=".1.0.1.0">
			<li class="url-link" data-link=""><i class="icon-file-text"></i></li>
			<li class="url-link" data-link=""><i class="icon-list-ul"></i> </li>
			<li class="url-link" data-link=""><i class="icon-time"></i></li>
			<li class="url-link" data-link=""><i class="icon-sitemap"></i></li>
			<li class="url-link" data-link=""><i class="icon-wrench"></i></li>
		</ul>
	</li>
	<li> <a href="dashboard.php" '.$lhomeclsactive.'> <i class="icon-home"></i> Dashboard<span class="pull-right"></span></a> </li>
	<li><a href="academiccalendar.php" '.$lacalenderclsactive.'> <i class="icon-calendar"></i> Academic Calendar</a> </li>
	<li><a href="weeklylectureschedule.php" '.$lstimeclsactive.'> <i class="icon-time"></i> Lecture Schedule</a> </li>';
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) == 1) {
		echo '
		<!--HR-->
		<li class="has_sub"><a href="javascript:void(0)" '.$lhrclsactive.'> <i class="icon-group"></i> HR <span class="pull-right"><i class="icon-chevron-right" style="font-size:12px"></i></span></a>
			<ul '.$lhractive.'>
				<li><a href="hremployeeattendance.php">Attendance</a></li>
			</ul>
		</li>
		<!--HR-->';
	}

	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) != 1) {
		if(mysqli_num_rows($sqllmsInchargeTimetable) > 0){
			echo '<li><a href="assemblyattendance.php" '.$lassemblyattendanceclsactive.'> <i class="icon-group"></i> Assembly Attendance</a> </li>';
		}
	}
	echo '
	<li><a href="laadvisees.php" '.$ladviseesclsactive.'> <i class="icon-group"></i> Advisees List</a> </li>
	<li><a href="lateacherappointments.php" '.$lstudentappointmentclsactive.'> <i class="icon-user"></i> Student Appointments</a>
	
	<li><a href="datesheet.php" '.$ldatesheetclsactive.'> <i class="icon-calendar"></i> Date Sheet</a> </li>
	<li><a href="guidances.php" '.$lguidancesclsactive.'> <i class="icon-info"></i> Guidance & Help</a> </li>
	<li> <a href="personaldiary.php" '.$lpdryclsactive.'> <i class="icon-file-text"></i> Personal Diary</a> </li>
	<li><a href="personalcontacts.php" '.$lpcontsclsactive.'> <i class="icon-group"></i> Personal Contacts</a> </li>
	<li> <a href="bogmessages.php" '.$lbogmsgsclsactive.'> <i class="icon-envelope"></i> BOG Messages<span class="pull-right"></span></a> </li>
	<li><a href="noticeboard.php" '.$lnoticeclsactive.'> <i class="icon-adjust"></i> Notice Board</a> </li>
	<li><a href="personaltodolist.php" '.$ltodolistclsactive.'> <i class="icon-list"></i> Todo List</a> </li>
	<li> <a href="profile.php" '.$lproclsactive.'> <i class="icon-user"></i> Profile</a> </li>
</ul>
<!--SIDE MENU - ONLOAD -->
</div>
<!-- Sidebar ends -->';
?>