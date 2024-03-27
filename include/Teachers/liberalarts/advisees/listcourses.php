<?php 
if(!LMS_VIEW && !isset($_GET['id']) && isset($_GET['std_id']) && $enableRegistrationEdit == 1) {  

    $adjacents = 3;
    if(!($Limit)) { $Limit = 50; } 
    if($page) { $start = ($page - 1) * $Limit; } else {	$start = 0;	}
    $page = (int)$page;

	$sqllmsOfferedCourses = $dblms->querylms("SELECT od.id 
													FROM ".LA_STUDENT_REGISTRATION_DETAIL." od
													INNER JOIN ".LA_STUDENT_REGISTRATION." oc ON oc.id = od.id_setup 
													INNER JOIN ".COURSES." cr ON cr.curs_id = od.id_curs 
													INNER JOIN ".STUDENTS." std ON std.std_id = oc.id_std 
                                                    WHERE oc.id_std = '".cleanvars($_GET['std_id'])."'
                                                    AND oc.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDADMISSION'])."'
                                                    AND oc.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                                    AND oc.is_deleted != '1' 
                                                    ORDER BY od.id DESC");
	$count = mysqli_num_rows($sqllmsOfferedCourses);
	
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;

    if (mysqli_num_rows($sqllmsOfferedCourses) > 0) {
        
        $sqllmsOfferedCourses  = $dblms->querylms("SELECT od.*, cr.curs_code, cr.curs_name, std.std_id, std.std_name, std.std_regno, std.std_photo, std.std_session, std.std_semester, 
                                                        oc.semester 
                                                        FROM ".LA_STUDENT_REGISTRATION_DETAIL." od
                                                        INNER JOIN ".LA_STUDENT_REGISTRATION." oc ON oc.id = od.id_setup 
                                                        INNER JOIN ".COURSES." cr ON cr.curs_id = od.id_curs 
                                                        INNER JOIN ".STUDENTS." std ON std.std_id = oc.id_std 
                                                        WHERE oc.id_std = '".cleanvars($_GET['std_id'])."'
                                                        AND oc.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDADMISSION'])."'
                                                        AND oc.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                                        AND oc.is_deleted != '1' 
                                                        ORDER BY od.id DESC LIMIT ".($page-1)*$Limit .",$Limit");

        echo '
        <h4 style="margin-left:10px;margin-top:10px; font-weight:700;">Academic Semester: <span style="color: royalblue;">'.cleanvars($_SESSION['userlogininfo']['LOGINIDADMISSION']).'</span></h4>
        <div style=" float:right; text-align:right; font-weight:700; color:red; margin-right:10px;"> 
            <span class="navbar-form navbar-left form-small">
                Total Records: ('.number_format($count).') 
            </span>
        </div>
        <form name="frmMain" id="frmMain" method="post" action="laadvisees.php?std_id='.cleanvars($_GET['std_id']).'" OnSubmit="return CheckForm();">
        <div style="clear:both;"></div>
        <table class="table table-bordered">
        <thead>
        <tr>
            <th style="text-align:center;"><input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);" class="checkbox-inline" title="click here to checked all"></th>
            <th style="font-weight:600;text-align:center;">SR #</th>
            <th style="font-weight:600;"> Course Name</th>
            <th style="font-weight:700; text-align:center;" width="35px">Pic</th>
            <th style="font-weight:600;"> Student Name</th>
            <th style="font-weight:600;text-align:center;"> Semester</th>
            <th style="font-weight:600;text-align:center;">Timing</th>	
            <th style="font-weight:600;text-align:center;"> Section</th>
            <th style="text-align:center;font-weight:600;"> Status</th>
            <th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
        </tr>
        </thead>
        <tbody>';
        //------------------------------------------------
        if($page ==1) { $srno = 0;} else { $srno = ($Limit * ($page-1));}
        $hiddencount = 0;
        //------------------------------------------------
        while($valueOfferedCourse = mysqli_fetch_array($sqllmsOfferedCourses)) { 
        //------------------------------------------------
            $srno++;
            $hiddencount++;
            
            if($valueOfferedCourse['stdsemester'] != $valueOfferedCourse['std_semester'] && $valueOfferedCourse['regular_repeat'] != 2) {
                $bgcolor = 'style="background-color:#ECEC00 !important;"';
            } else {
                $bgcolor = '';
            }

            
            if($valueOfferedCourse['std_photo']) { 
                $stdPhoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$valueOfferedCourse['std_photo'].'" alt="'.$valueOfferedCourse['std_name'].'"/>';
            } else {
                $stdPhoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$valueOfferedCourse['std_name'].'"/>';
            }

            // if curs domain 
            if($valueOfferedCourse['cursdomain']) {
                $cursdomain = '<b style="color:#0F5BD0;">'.get_deptdomains($valueOfferedCourse['cursdomain']).'</b>';
            } else {
                $cursdomain = '';
            }

            //$canEdit = '<a class="btn btn-xs btn-info edit-bcat-modal" data-toggle="modal" data-modal-window-title="Edit Courses Registration" data-height="350" data-width="100%" data-cat-stdname="'.$valueOfferedCourse['std_regno'].' - '.$valueOfferedCourse['std_name'].'" data-cat-cursname="'.$valueOfferedCourse['curs_code'].' - '.$valueOfferedCourse['curs_name'].'" data-cat-status="'.$valueOfferedCourse['confirm_status'].'" data-cat-semester="'.$valueOfferedCourse['stdsemester'].'" data-cat-section="'.$valueOfferedCourse['section'].'" data-cat-timing="'.get_programtiming($valueOfferedCourse['timing']).'" data-cat-remarks="'.$valueOfferedCourse['remarks'].'"  data-cat-idsetup="'.$valueOfferedCourse['id_setup'].'" data-cat-idsetup="'.$valueOfferedCourse['id_setup'].'" data-cat-id="'.$valueOfferedCourse['id'].'" data-target="#editBcatModal"><i class="icon-pencil"></i></a>';
            $canEdit = '';
            echo '
            <tr '.$bgcolor.'>
                <td style="width:35px;text-align:center;vertical-align:middle;">
                    <input name="cur_update[]" type="checkbox" id="cur_update'.$hiddencount.'" value="'.$valueOfferedCourse['id'].'" class="checkbox-inline">
                </td>
                <td style="width:50px;text-align:center;vertical-align:middle;">'.$srno.'</td>
                <td  style="vertical-align:middle;font-size:12px;"><b>'.$valueOfferedCourse['curs_code'].' - '.$valueOfferedCourse['curs_name'].'</b> ('.get_regularrepeat1($valueOfferedCourse['regular_repeat']).')<br>(<span style="color:#00f; font-size:11px;">Theory: '.$valueOfferedCourse['theory_credithours'].'</span>, <span style="color:darkorange; font-size:11px;">Practical: '.$valueOfferedCourse['practical_credithours'].'</span>) '.$cursdomain.'   '.get_sequencingcategoryshort($valueOfferedCourse['sequencing_category']).' </td>
                <td style="vertical-align:middle;">'.$stdPhoto.'</td>
                <td  style="vertical-align:middle; font-weight:600; min-width:190px;">
                    '.$valueOfferedCourse['std_regno'].'<div><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$valueOfferedCourse['std_name'].' ('.$valueOfferedCourse['std_session'].')</b>" data-src="studentdetail.php?std_id='.$valueOfferedCourse['std_id'].'" href="#">'.$valueOfferedCourse['std_name'].'</a></div></td>
                <td style="vertical-align:middle;text-align:center;width:70px;">'.addOrdinalNumberSuffix($valueOfferedCourse['stdsemester']).'</td>
                <td style="vertical-align:middle;text-align:center;width:80px;">'.get_programtiming($valueOfferedCourse['timing']).'</td>
                
                <td  style="vertical-align:middle;width:60px;text-align:center;">'.$valueOfferedCourse['section'].'</td>
                
                <td style="width:55px; vertical-align:middle; text-align:center;">'.get_coursestatus($valueOfferedCourse['confirm_status']).'</td>
                <td style="text-align:center; vertical-align:middle;"> '.$canEdit.'</td>
            </tr>';

        } // End While oop
        echo '
        </tbody>
        </table>
        <button class="btn btn-info" name="multiple_submit" id="multiple_submit" value="approved_all" type="submit" style="padding:5px 13px; font-size:12px; margin-top:5px;margin-left:5px;" title="Approve">Approve</button>
        <button class="btn btn-danger" name="multiple_submit" id="multiple_submit" value="rejected_all" type="submit" style="padding:5px 13px; font-size:12px; margin-top:5px;margin-left:5px;" title="Reject">Reject</button> 
        <input type="hidden" name="hdnCount" id="hdnCount" value="'.$hiddencount.'">
        </form>';
      
    } else { 
        echo '
        <div class="col-lg-12">
            <div class="widget-tabs-notification">No Result Found</div>
        </div>';
    }
}