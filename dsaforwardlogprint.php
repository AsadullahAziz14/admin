<?php
//Require Vars, DB Connection and Function Files
require_once('dbsetting/lms_vars_config.php');
require_once('dbsetting/classdbconection.php');
$dblms = new dblms();
require_once('functions/login_func.php');
require_once('functions/functions.php');
require_once('functions/studentservices.php');

//User Authentication
checkCpanelLMSALogin();

//Check If User ID is $ or has rights
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 8) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 9) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '190')) {   

    $id 	= (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';

    $sqllmsEdit  = $dblms->querylms("SELECT sa.*, std.std_id, std.std_name, std.std_regno, std.std_photo, std.std_session, std.std_semester, std.std_timing, prg.prg_name, prg.id_cat
                                            FROM ".DSA_APPLICATIONS." sa
                                            INNER JOIN ".STUDENTS." std ON std.std_id = sa.id_std
                                            INNER JOIN ".PROGRAMS." prg ON prg.prg_id = std.id_prg
                                            WHERE sa.id = '".cleanvars($id)."'
                                            AND sa.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                            AND sa.is_deleted != '1'
                                            LIMIT 1");
    $valueEdit = mysqli_fetch_array($sqllmsEdit);

    if($valueEdit['photo']){

        $studentPhoto = 'downloads/dsa/pictures/'.$valueEdit['photo'];

    } else{

        if($valueEdit['std_photo']) { 
            $studentPhoto = 'images/students/'.$valueEdit['std_photo'];
        } else {
            $studentPhoto = 'images/students/default.png';
        }

    }

    $queryRepeatCourses = $dblms->querylms("SELECT COUNT(rc.id) AS total
                                            FROM ".DSA_APPLICATIONS_REPEAT_COURSES." rc
                                            INNER JOIN ".COURSES." cr ON cr.curs_id = rc.id_course
                                            WHERE rc.id_setup = '".$valueEdit['id']."'
                                            ORDER BY rc.id ASC");
    $valueRepeatCourse = mysqli_fetch_array($queryRepeatCourses);

    $completePartialTranscript = '';
	if($valueEdit['degree_transcript'] == 1){
        if($valueEdit['complete_partial'] == 1){
            $completePartialTranscript = 'Final ';
        } elseif($valueEdit['complete_partial'] == 2){
            $completePartialTranscript = 'Partial ';
        }
    }

    $expectedDateOfIssuance = '';
    if($valueEdit['due_date'] != '0000-00-00'){

        $expectedDateOfIssuance = date('d-m-Y', strtotime($valueEdit['due_date']));
    }

    if($valueEdit['comprehensive_year'] == '0000'){
        $comprehensiveYear = date('Y');
    } else{
        $comprehensiveYear = $valueEdit['comprehensive_year'];
    }

    if($valueEdit['gat_year'] == '0000'){
        $gatYear = date('Y');
    } else{
        $gatYear = $valueEdit['gat_year'];
    }

    if($valueEdit['thesis_submission_date'] == '0000-00-00'){
        $thesisSubmissionDate = date('Y-m-d');
    } else{
        $thesisSubmissionDate = $valueEdit['thesis_submission_date'];
    }

    if($valueEdit['thesis_submission_date_islrc'] == '0000-00-00'){
        $thesisSubmissionDateISLRC = date('Y-m-d');
    } else{
        $thesisSubmissionDateISLRC = $valueEdit['thesis_submission_date_islrc'];
    }

    //$title = 'Pay Slip for the Month of '.date('M, Y', strtotime($valuePaySlip['yearmonth']));

    echo '
    <!doctype html>
    <html>
    <head>
    <meta charset="utf-8">
    <title>'.$valueEdit['std_regno'].'</title>
    <style type="text/css">
        body { overflow: -moz-scrollbars-vertical; margin:0; font-family: Calibri, "Calibri Light", Arial, Helvetica, sans-serif; }
        /* All margins set to 2cm */
        @media all {
            .page-break	{ display: none; }
        }

        @media print {
            .page-break	{ display: block; page-break-before: always; }
        }

        @media all {
            .page-break	{ display: none; }
        }
        @media print { 
            .page-break	{ display: block; page-break-before: always; }
            @page {
                size: A4 portrait;
                thead {display: table-header-group;}    
            }
            
        }
        @page :first {  margin-top:30px;    /* Top margin on first page 10cm */ }
        h1 { 
            text-align:center;margin:0; margin-top:0; margin-bottom:5px; 
            font-family: Calibri, "Calibri Light", Arial, Helvetica, sans-serif; font-size:45px; font-weight:bold; 
            text-transform:uppercase; text-decoration:underline;
        }
        h3 { 
            text-align:center; margin-top:10px; margin-bottom:-10px; 
            font-family: Calibri, "Calibri Light", Arial, Helvetica, sans-serif; font-size:24px; font-weight:bold;
        }
        h4 { 
            text-align:center; margin:0; margin-bottom:5px; margin-top:5px; 
            font-family: Calibri, "Calibri Light", Arial, Helvetica, sans-serif; font-weight:700; font-size:18px;  
        }

        table.datatable { 
            border: 1px solid #333; border-collapse: collapse; border-spacing: 0; margin-top:10px; 
            font-family: Calibri, "Calibri Light", Arial, Helvetica, sans-serif;
        }

        table.datatable td { 
            border: 1px solid #222; border-collapse:collapse; border-spacing: 0; padding:4px; 
            font-family: Calibri, "Calibri Light", Arial, Helvetica, sans-serif; font-size:16px; color:#000; 
        }

        table.datatable th { 
            border: 1px solid #222; border-collapse:collapse; border-spacing: 0; padding:4px; background:#eee;
            font-family: Calibri, "Calibri Light", Arial, Helvetica, sans-serif; font-size:18px;  
        }
    </style>
    <script language="JavaScript1.2">
    function openwindow() {
        window.open("salaryslipprint", "salaryslipprint","toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no,width=800,height=700");
    }
    </script>
    <link rel="shortcut icon" href="images/favicon/favicon.ico">
    </head>

    <body style="">
    <div style="text-align:center;">
    <table width="850" class="page" border="0" align="center" style="border-collapse:collapse;">
        <tr>
            <td width="120" align="right"><img src="images/mul_logo.jpg" style="height:100px; width:100px;"></td>
            <td>
                <h1>'.cleanvars($_SESSION['userlogininfo']['LOGINIDCOMNAME']).' </h1>
                <h3 style="text-decoration:underline;text-transform:none;">Directorate of Student Affairs</h3>
            </td>
            <td style="width: 15%;"><img src="'.$studentPhoto.'" style="display: flex; justify-content: end; height:100px; width:100px;"></td>
        </tr>
    </table>
    <div style="clear:both;"></div>
    <table style="margin-top:30px; width:95%;" class="page" border="0" align="center" style="border-collapse:collapse;">
        <tr style="font-size:18px;">
            <td style="text-align:left; width:80px;"><b>Ref #:</b></td>
            <td style="text-align:left; width:320px;">'.$valueEdit['reference_no'].'</td>
            <td style="text-align:left;"><b>Date Applied:</b></td>
            <td style="text-align:left;">'.date('d-m-Y', strtotime($valueEdit['dated'])).'</td>
        </tr>
        <tr style="font-size:18px;">
            <td style="text-align:left; width:140px;"><b>RN:</b></td>
            <td style="text-align:left;">'.$valueEdit['std_regno'].'</td>
            <td style="text-align:left;"><b>Name:</b></td>
            <td style="text-align:left;">'.$valueEdit['full_name'].'</td>
        </tr>
        <tr style="font-size:18px;">
            <td style="text-align:left; width:140px;"><b>App. For:</b></td>
            <td style="text-align:left;">'.get_dsa_degree_transcript1($valueEdit['degree_transcript']).'</td>
            <td style="text-align:left;"><b>Semester(s):</b></td>
            <td style="text-align:left;">'.addOrdinalNumberSuffix($valueEdit['till_semester']).'</td>
        </tr>
        <tr style="font-size:18px;">
            <td style="text-align:left; width:140px;"><b>Doc. Type:</b></td>
            <td style="text-align:left;">'.get_dsa_regular_urgent2($valueEdit['normal_urgent']).'</td>
            <td style="text-align:left;"><b>Nature:</b></td>
            <td style="text-align:left;">'.get_dsa_original_duplicate2($valueEdit['original_duplicate']).'</td>
        </tr>
        <tr style="font-size:18px;">
            <td style="text-align:left; width:140px;"><b>Partial/Final:</b></td>
            <td style="text-align:left;">'.$completePartialTranscript.'</td>
            <td style="text-align:left;"><b>Issuance:</b></td>
            <td style="text-align:left;">'.$expectedDateOfIssuance.'</td>
        </tr>
        <!-- 13-03-2024 Start -->
        <tr style="font-size:18px;">
            <td style="text-align:left;"><b>Program:</b></td>
            <td style="text-align:left;">'.$valueEdit['prg_name'].'</td>
        </tr>
        <!-- 13-03-2024 -->
        <tr style="font-size:18px;">
            <td colspan="2" style="text-align:left; width:200px;"><b>Number of Repeat Courses:</b></td>
            <td style="text-align:left;">'.$valueRepeatCourse['total'].'</td>
        </tr>';

        if($valueEdit['coursework_thesis'] != 0){

            echo '
            <tr style="font-size:18px;">
                <td colspan="2" style="text-align:left;"><b>Degree Completed with:</b></td>
                <td style="text-align:left;">'.get_cwthesis($valueEdit['coursework_thesis']).'</td>
            </tr>';
        }

    echo '
    </tr>
    </table>
    <div style="clear:both;"></div>';

    $queryRepeatCourses = $dblms->querylms("SELECT rc.offered_semester, rc.repeat_semester, cr.curs_code, cr.curs_name
                                                FROM ".DSA_APPLICATIONS_REPEAT_COURSES." rc
                                                INNER JOIN ".COURSES." cr ON cr.curs_id = rc.id_course
                                                WHERE rc.id_setup = '".$valueEdit['id']."'
                                                ORDER BY rc.id ASC");
    if(mysqli_num_rows($queryRepeatCourses)>0) {

        echo '
        <div style="margin-top:20px; margin-left:2.5%; width:95%; text-align:left;">
            <h4 style="text-align:left; text-transform:uppercase;margin-bottom:10px;">Repeat Courses Detail</h4>
            <table class="datatable" width="100%" border="1" align="center" style="border-collapse:collapse;">
                <thead>
                <tr>
                    <th style="font-weight:600;text-align:center;"> Sr. #</th>
                    <th style="font-weight:600;"> Course</th>
                    <th style="font-weight:600; width:180px;text-align:center;"> Semester Offered In</th>
                    <th style="font-weight:600; width:180px;text-align:center;"> Semester Repeat In</th>
                </tr>
                </thead>
                <tbody>';
                $sr = 0;

                while($valueRepeatCourse = mysqli_fetch_array($queryRepeatCourses)) {

                    $sr ++;

                    echo '
                    <tr>
                        <td style="vertical-align:middle;text-align:center;width:50px!important;">'.$sr.'</td>
                        <td style="vertical-align:middle;">'.$valueRepeatCourse['curs_code'].' - '.$valueRepeatCourse['curs_name'].'</td>
                        <td style="vertical-align:middle;text-align:center;">'.$valueRepeatCourse['offered_semester'].'</td>
                        <td style="vertical-align:middle;text-align:center;">'.$valueRepeatCourse['repeat_semester'].'</td>
                    </tr>';

                }//End While Loop
                echo '
                </tbody>
            </table>
        </div>';
    }

    echo '
    <div style="clear:both;"></div>
    <div style="margin-top:20px; margin-left:2.5%; width:95%; text-align:left;">
        <h3 style="text-align:left; text-transform:uppercase;margin-bottom:20px;">Forwaded Details</h3>';
        $sqllmsForward  = $dblms->querylms("SELECT af.remarks, af.forwaded_to, af.attachment, af.date_added, ad.adm_fullname, ad.adm_email, ad.adm_username
                                                    FROM ".DSA_APPLICATIONS_FORWARD." af
                                                    INNER JOIN ".ADMINS." ad ON ad.adm_id = af.id_added
                                                    WHERE af.id_application = '".cleanvars($_GET['id'])."'
                                                    ORDER BY af.id DESC");
        if(mysqli_num_rows($sqllmsForward) > 0){
            
            //<span style="float:right;">Attachment <br><a class="btn btn-sm btn-warning" href="https://admission.mul.edu.pk/documents/Spring-2023/MUL-54436_Intermediate.jpg" target="_blank"><i class="icon-eye-open"></i></a></span>

            while($valueForward = mysqli_fetch_array($sqllmsForward)){

                if($valueForward['adm_email']){ $usernameEmail = $valueForward['adm_email']; } else { $usernameEmail = $valueForward['adm_username'];}

                echo '
                <div style="font-weight:600;margin-bottom:0px;">'.$valueForward['adm_fullname'].' <span style="font-weight:normal;">('.$usernameEmail.')</span> <span style="float:right;font-weight:normal;"><small><i class="icon-time"></i>'.date("D, d M, Y", strtotime($valueForward['date_added'])).' at '.date("h:i A", strtotime($valueForward['date_added'])).'</small></span></div>
                <div style="margin-bottom:5px;">To:';

                $sqllmsForwadedAdmins  = $dblms->querylms("SELECT adm.adm_fullname, adm.adm_email, adm.adm_username
                                                                FROM ".ADMINS." adm
                                                                WHERE adm.adm_id IN (".$valueForward['forwaded_to'].")
                                                                ORDER BY adm.adm_id ASC");
                while($valueAdmin = mysqli_fetch_array($sqllmsForwadedAdmins)){

                    if($valueAdmin['adm_email']){ $usernameEmail = $valueAdmin['adm_email']; } else { $usernameEmail = $valueAdmin['adm_username'];}

                    echo $valueAdmin['adm_fullname'].' <span style="font-weight:normal;">('.$usernameEmail.')</span>,';
                }
                echo '
                </div>
                <div>'.html_entity_decode($valueForward['remarks']).'</div>
                <hr>
                <div style="clear:both;margin-top:10px;margin-bottom:10px;"></div>';

            }
        }
    echo '
    </div>';

    if($valueEdit['cnic_photo']){

        $cnicPathInfo = pathinfo($valueEdit['cnic_photo']);
        $cnicExtension = $cnicPathInfo['extension'];

        if($cnicExtension == 'pdf'){
            $cnicFile = '<embed src="/downloads/dsa/documents/'.$valueEdit['cnic_photo'].'#toolbar=0&navpanes=0&scrollbar=0&view=Fit" type="application/pdf" style="width: 90%; height: 1050px;">';
        } else {
            $cnicFile = '<img src="/downloads/dsa/documents/'.$valueEdit['cnic_photo'].'" alt="CNIC" style="height:80%!important; width:95%;">';
        }

        echo '
        <div style="clear:both;"></div>
        <div class="page-break"></div>
        <div style="margin-top:10px;">
            '.$cnicFile.'
        </div>';
    }

    if($valueEdit['matric_result_card']){

        $matricPathInfo = pathinfo($valueEdit['matric_result_card']);
        $matricExtension = $matricPathInfo['extension'];

        if($matricExtension == 'pdf'){
            $matricResultFile = '<embed src="/downloads/dsa/documents/'.$valueEdit['matric_result_card'].'#toolbar=0&navpanes=0&scrollbar=0&zoom=50" type="application/pdf" style="width: 90%; height: 1050px;">';
        } else {
            $matricResultFile = '<img src="/downloads/dsa/documents/'.$valueEdit['matric_result_card'].'" alt="Matric Result" style="height:80%!important; width:95%;">';
        }

        echo '
        <div style="clear:both;"></div>
        <div class="page-break"></div>
        <div style="margin-top:10px;">
            '.$matricResultFile.'
        </div>';
    }

    echo '
    <div style="clear:both;"></div>
    
    <!--
    <div style="border-top:2px solid #000000; width:100%; position: fixed; bottom: 1px;  font-size:13px; text-align:center;">
        <h3 style="margin-bottom:3px; margin-top:5px;">Minhaj University Lahore</h3>
        <span style="">Hamdard, Chowk, Township, Lahore. 04235145621</span>
        <div style="margin-bottom:15px; font-size:14px; text-align:left; ">
            <a href="https://gptech.pk" style="text-decoration:none;" target="_blank">Powered by: GP Tech</a>
            <span style="font-size:12px; float:right; margin-top:3px;margin-left:30px;">Printed date: '.date("m/d/Y").'</span> 
            <span style="font-size:12px; float:right; margin-top:3px;">Printed By: '.$_SESSION['userlogininfo']['LOGINFNAMEA'].'</span>
        </div>
    </div>
    <div class="page-break"></div>
    -->


    </body>
    <script type="text/javascript" language="javascript1.2">
    <!--
    //Do print the page
    if (typeof(window.print) != "undefined") {
        window.print();
    }
    -->
    </script>
    </html>';
}
?>