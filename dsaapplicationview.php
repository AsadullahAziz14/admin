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

$sqllmsEdit  = $dblms->querylms("SELECT sa.*, std.std_id, std.std_name, std.std_regno, std.std_photo, std.std_session, std.std_semester, std.std_timing, prg.prg_name, prg.id_cat
                                        FROM ".DSA_APPLICATIONS." sa
                                        INNER JOIN ".STUDENTS." std ON std.std_id = sa.id_std
                                        INNER JOIN ".PROGRAMS." prg ON prg.prg_id = std.id_prg
                                        WHERE sa.id = '".cleanvars($_GET['id'])."'
                                        AND sa.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                        AND sa.is_deleted != '1'
                                        LIMIT 1");
$valueEdit = mysqli_fetch_array($sqllmsEdit);

if($valueEdit['photo']){

    $studentPhoto = '<img class="avatar-smallest image-boardered" style="float:right;" src="downloads/dsa/pictures/'.$valueEdit['photo'].'" alt="'.$valueEdit['std_name'].'"/>';

} else{

    if($valueEdit['std_photo']) { 
        $studentPhoto = '<img class="avatar-smallest image-boardered" style="float:right;" src="images/students/'.$valueEdit['std_photo'].'" alt="'.$valueEdit['std_name'].'"/>';
    } else {
        $studentPhoto = '<img class="avatar-smallest image-boardered" style="float:right;" src="images/students/default.png" alt="'.$valueEdit['std_name'].'"/>';
    }
}

$dueDate        = '';
$issuanceDate   = '-';
$deliveryDate   = '';
if($valueEdit['due_date'] != '0000-00-00'){
    $dueDate = date('d-m-Y', strtotime($valueEdit['due_date']));
}
if($valueEdit['issuance_date'] != '0000-00-00'){
    $issuanceDate = date('d-m-Y', strtotime($valueEdit['issuance_date']));
}
if($valueEdit['delivery_date'] != '0000-00-00'){
    $deliveryDate = date('d-m-Y', strtotime($valueEdit['delivery_date']));
}

echo '
<!DOCTYPE html>
<html lang="en">
<!--HEAD - ONLOAD-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Profile of '.$valueEdit['full_name'].'</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="">
<link href="style/all-vendors.css" rel="stylesheet">
<link href="style/style.css" rel="stylesheet">
<link href="style/style-steps.css" rel="stylesheet">
<link href="style/responsive.css" rel="stylesheet">
<!-- HTML5 Support for IE -->
<!--[if lt IE 9]>
	<script src="js/html5shim.js"></script>
<![endif]-->
<!-- Favicon -->
<link rel="shortcut icon" href="images/favicon/favicon.png">

<style type="text/css">
	#tawkchat-minified-iframe-element { left:2px!important; }
	#tawkchat-minified-iframe-element #tawkchat-minified-container { border:0 !important; }

	.col-sm-41 {position:relative;min-height:1px;padding-right:20px;padding-left:1px}
	.col-sm-41 {float:left}
	.col-sm-41 {width:33%}
</style>
</head>
<!--HEAD - ONLOAD-->
<body class="ModalPopUp">
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<div class="content">
<!--WI_USER_PROFILE_TABLE-->
<div class="row">
<div class="col-md-12">

<!-- 13-03-2024 Start -->
<div class="tsf-nav-step col-md-12">
    <!-- BEGIN STEP INDICATOR-->
    <ul class="gsi-step-indicator triangle gsi-style-3 gsi-transition" style="line-height:1.3;" >';
        $srno = 0;
        foreach($dsaStatus as $status) {

            if($status['id'] != 3 || ($status['id'] == 3 && $valueEdit['status'] == 3)){

                $srno++;

                $applicationStatus = '';
                if($status['id'] <= $valueEdit['status']){
                    $applicationStatus = 'completed';
                }
                if($valueEdit['status'] == 3 && $status['id'] == 3){
                    $applicationStatus = 'current';
                }

                echo '
                <li data-target="step-'.$srno.'" class="'.$applicationStatus.'">
                    <a href="">
                        <span class="number">'.$srno.'</span>
                        <span class="desc">
                            <label>'.$status['name'].'</label>
                        </span>
                    </a>
                </li>';

            }
        }
        echo '
    </ul>
    <!-- END STEP INDICATOR--->
</div>
<!-- 13-03-2024 End -->

<table class="table table-bordered table-hover">
<tbody>
<tr>
	<td bgcolor="#FAFAFA"><strong>Program Name</strong></td>
	<td colspan="5">'.$valueEdit['prg_name'].$studentPhoto.'</td>
</tr>
<tr>
	<td><strong>Reference #</strong></td>
	<td colspan="2"><span class="label label-info">'.$valueEdit['reference_no'].'</span></td>
	<td><strong>Status</strong></td>
	<td colspan="2">'.get_dsa_status($valueEdit['status']).'</td>
</tr>
<tr>
    <td><strong>Apply Date</strong></td>
    <td>'.date('d-m-Y', strtotime($valueEdit['date_added'])).'</td>
    <td><strong>Due Date</strong></td>
	<td>'.$dueDate.'</td>
	<td><strong>Issuance Date</strong></td>
	<td>'.$issuanceDate.'</td>
</tr>
<tr>
    <td><strong>Delivered Date</strong></td>
	<td colspan="2">'.$deliveryDate.'</td>
	<td><strong>Document #</strong></td>
	<td colspan="2"><span class="label label-info">'.$valueEdit['document_number'].'</span></td>
</tr>
<tr>
	<td><strong>Application For</strong></td>
	<td colspan="2">'.get_dsa_degree_transcript($valueEdit['degree_transcript']).'</td>
	<td><strong>Normal/Urgent</strong></td>
	<td colspan="2">'.get_dsa_regular_urgent1($valueEdit['normal_urgent']).'</td>
</tr>
<tr>
	<td><strong>Original/Duplicate</strong></td>
	<td colspan="2">'.get_dsa_original_duplicate1($valueEdit['original_duplicate']).'</td>
	<td><strong>Till Semester(s)</strong></td>
	<td colspan="2">'.$valueEdit['till_semester'].'</td>
</tr>
<tr>
	<td bgcolor="#FAFAFA"><strong>Student Name</strong></td>
	<td colspan="2">'.$valueEdit['full_name'].'</td>
	<td bgcolor="#FAFAFA"><strong>Student CNIC</strong></td>
	<td colspan="2">'.$valueEdit['cnic'].'</td>
</tr>
<tr>
	<td><strong>Date of Birth</strong></td>
	<td colspan="2">'.$valueEdit['dob'].'</td>
	<td><strong>Timing</strong></td>
    
	<td colspan="2"></td>
</tr>
<tr>
	<td><strong>Mobile</strong></td>
	<td colspan="2">'.$valueEdit['mobile'].'</td>
	<td><strong>Email</strong></td>
	<td colspan="2">'.$valueEdit['email'].'</td>
</tr>
<tr>
	<td bgcolor="#FAFAFA"><strong>Postal Address</strong></td>
	<td colspan="5">'.$valueEdit['postal_address'].'</td>
</tr>
<tr>
	<td bgcolor="#FAFAFA"><strong>Remarks</strong></td>
	<td colspan="5">'.$valueEdit['remarks_dsa'].'</td>
</tr>';

/*
if($valueEdit['status'] == 5){
    echo '
    <tr>
        <td bgcolor="#FAFAFA"><strong>Recipient</strong></td>
        <td colspan="5">'.get_dsa_recipient($valueEdit['recipient']).'</td>
    </tr>';

    if($valueEdit['recipient'] == 2){

        echo '
        <tr>
            <td><strong>Full Name</strong></td>
            <td>'.$valueEdit['recipient_full_name'].'</td>
            <td><strong>Relationship with student</strong></td>
            <td>'.$valueEdit['recipient_relationship'].'</td>
            <td><strong>Recipient CNIC</strong></td>
            <td>'.$valueEdit['recipient_cnic'].'</td>
        </tr>';
    }

}
*/

echo '
</tbody>
</table>';




//Picture / Docuemnts		
if($valueEdit['photo'] || $valueEdit['cnic_photo'] || $valueEdit['matric_result_card']) {  

    $picture            = '';
    $cnicPhoto          = '';
    $matricResultCard   = '';
    $transcript         = '';
    $thesisFile         = '';
    $gatTestProof       = '';
    $fir                 = '';

    if($valueEdit['photo']){
        $picture = ' <a href="/downloads/dsa/pictures/'.$valueEdit['photo'].'" target="_blank"><image class="avatar-large image-boardered" src="/downloads/dsa/pictures/'.$valueEdit['photo'].'" alt="Picture"></a>';
    }

    if($valueEdit['cnic_photo']){

        $cnicPathInfo = pathinfo($valueEdit['cnic_photo']);
        $cnicExtension = $cnicPathInfo['extension'];

        if($cnicExtension == 'pdf'){
            $cnicPath = '/images/icons/v2/Adobe Acrobat Reader.png';
        } else {
            $cnicPath = '/downloads/dsa/documents/'.$valueEdit['cnic_photo'].'';
        }

        $cnicPhoto = ' <a href="/downloads/dsa/documents/'.$valueEdit['cnic_photo'].'" target="_blank"><image class="avatar-large image-boardered" src="'.$cnicPath.'" alt="CNIC"></a>';
    }

    if($valueEdit['matric_result_card']){

        $matricPathInfo = pathinfo($valueEdit['matric_result_card']);
        $matricExtension = $matricPathInfo['extension'];

        if($matricExtension == 'pdf'){
            $matricPath = '/images/icons/v2/Adobe Acrobat Reader.png';
        } else {
            $matricPath = '/downloads/dsa/documents/'.$valueEdit['matric_result_card'].'';
        }

        $matricResultCard = ' <a href="/downloads/dsa/documents/'.$valueEdit['matric_result_card'].'" target="_blank"><image class="avatar-large image-boardered" src="'.$matricPath.'" alt="Matric Result Card"></a>';
    }

    if($valueEdit['transcript']){

        $transcriptPathInfo = pathinfo($valueEdit['transcript']);
        $transcriptExtension = $transcriptPathInfo['extension'];

        if($transcriptExtension == 'pdf'){
            $transcriptPath = '/images/icons/v2/Adobe Acrobat Reader.png';
        } else {
            $transcriptPath = '/downloads/dsa/documents/'.$valueEdit['transcript'].'';
        }

        $transcript = ' <a href="/downloads/dsa/documents/'.$valueEdit['transcript'].'" target="_blank"><image class="avatar-large image-boardered" src="'.$transcriptPath.'" alt="Transcript"></a>';
    }

    if($valueEdit['thesis_title_photo']){

        $thesisPathInfo = pathinfo($valueEdit['thesis_title_photo']);
        $thesisExtension = $thesisPathInfo['extension'];

        if($thesisExtension == 'pdf'){
            $thesisPath = '/images/icons/v2/Adobe Acrobat Reader.png';
        } else {
            $thesisPath = '/downloads/dsa/documents/'.$valueEdit['thesis_title_photo'].'';
        }

        $thesisFile = ' <a href="/downloads/dsa/documents/'.$valueEdit['thesis_title_photo'].'" target="_blank"><image class="avatar-large image-boardered" src="'.$thesisPath.'" alt="Thesis"></a>';
    }

    if($valueEdit['gat_test_proof']){

        $gatPathInfo = pathinfo($valueEdit['gat_test_proof']);
        $gatExtension = $gatPathInfo['extension'];

        if($gatExtension == 'pdf'){
            $gatPath = '/images/icons/v2/Adobe Acrobat Reader.png';
        } else {
            $gatPath = '/downloads/dsa/documents/'.$valueEdit['gat_test_proof'].'';
        }

        $gatTestProof = ' <a href="/downloads/dsa/documents/'.$valueEdit['gat_test_proof'].'" target="_blank"><image class="avatar-large image-boardered" src="'.$gatPath.'" alt="GAT Test"></a>';
    }

    if($valueEdit['fir_photo']){

        $firPathInfo = pathinfo($valueEdit['fir_photo']);
        $firExtension = $firPathInfo['extension'];

        if($firExtension == 'pdf'){
            $firPath = '/images/icons/v2/Adobe Acrobat Reader.png';
        } else {
            $firPath = '/downloads/dsa/documents/'.$valueEdit['fir_photo'].'';
        }

        $fir = ' <a href="/downloads/dsa/documents/'.$valueEdit['fir_photo'].'" target="_blank"><image class="avatar-large image-boardered" src="'.$firPath.'" alt="FIR"></a>';
    }

    echo '
    <div class="row">
        <div class="modal-dialog" style="padding-left:0px;padding-right:0px;width:100%;">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="col-lg-12 heading-modal bg-info" style="margin-top:5px; margin-bottom:0px; color:#fff;"">Documents</div>
                    
                    <div class="col-sm-41">
                        <div class="form_sep">
                            <label><b>Picture</b></label>
                        </div>
                        '.$picture.'
                    </div>

                    <div class="col-sm-41">
                        <div class="form_sep">
                            <label><b>CNIC</b></label>
                        </div>
                        '.$cnicPhoto.'
                    </div>

                    <div class="col-sm-41">
                        <div class="form_sep">
                            <label><b>Matric Result Card</b></label>
                        </div>
                        '.$matricResultCard.'
                    </div>
    
                    <div style="clear:both; margin-bottom:10px;"></div>';
    
                    if(cleanvars($valueEdit['degree_transcript']) == 2 && $valueEdit['transcript']) {
                        echo '
                        <div class="col-sm-41">
                            <div class="form_sep">
                                <label><b>Transcript</b></label>
                            </div>
                            '.$transcript.'
                        </div>';
                    }

                    if(cleanvars($valueEdit['degree_transcript']) == 1 && cleanvars($valueEdit['id_cat']) == 5 && $valueEdit['thesis_title_photo']) {

                        echo '
                        <div class="col-sm-41">
                            <div class="form_sep">
                                <label><b>Image of Thesis Title Page</b></label>
                            </div>
                            '.$thesisFile.'
                        </div>';
                    }

                    if(cleanvars($valueEdit['degree_transcript']) == 1 && (cleanvars($valueEdit['id_cat']) == 4 || cleanvars($valueEdit['id_cat']) == 5) && $valueEdit['gat_test_proof']) {

                        echo '
                        <div class="col-sm-41">
                            <div class="form_sep">
                                <label><b>GAT Test Proof</b></label>
                            </div>
                            '.$gatTestProof.'
                        </div>';

                    }

                    if(cleanvars($valueEdit['original_duplicate']) == 2 && $valueEdit['fir_photo']) {
                        echo '
                        <div class="col-sm-41">
                            <div class="form_sep">
                                <label><b>FIR Picture</b></label>
                            </div>
                            '.$fir.'
                        </div>';
                    }

                    echo '<div style="clear:both;"></div>
                </div>
            </div>
        </div>
    </div>';
}

$queryRepeatCourses = $dblms->querylms("SELECT rc.offered_semester, rc.repeat_semester, cr.curs_code, cr.curs_name
                                            FROM ".DSA_APPLICATIONS_REPEAT_COURSES." rc
                                            INNER JOIN ".COURSES." cr ON cr.curs_id = rc.id_course
                                            WHERE rc.id_setup = '".$valueEdit['id']."'
                                            ORDER BY rc.id ASC");
if(mysqli_num_rows($queryRepeatCourses)>0) {

    echo '
    <div class="col-lg-12 heading-modal bg-info" style="margin-top:5px; margin-bottom:0px; color:#fff;"">Repeat Courses</div>
    <table class="table table-bordered invE_tableed" >
        <thead>
        <tr class="heading-modal">
            <th style="font-weight:600;"> Sr. #</th>
            <th style="font-weight:600;"> Course</th>
            <th style="font-weight:600; width:150px;"> Semester Offered In</th>
            <th style="font-weight:600; width:150px;"> Semester Repeat In</th>
        </tr>
        </thead>
        <tbody>';
        $sr = 0;

        while($valueRepeatCourse = mysqli_fetch_array($queryRepeatCourses)) {

            $sr ++;

            echo '
            <tr>
                <td style="vertical-align:middle;width:50px!important;">'.$sr.'</td>
                <td style="vertical-align:middle;"><span style="font-weight:600; color:#666; font-size:12px;">'.$valueRepeatCourse['curs_code'].' - '.$valueRepeatCourse['curs_name'].'</span></td>
                <td style="vertical-align:middle;text-align:center;"><span style="font-weight:600; color:#666; font-size:12px;">'.$valueRepeatCourse['offered_semester'].'</span></td>
                <td style="vertical-align:middle;text-align:center;"><span style="font-weight:600; color:#666; font-size:12px;">'.$valueRepeatCourse['repeat_semester'].'</span></td>
            </tr>';

        }//End While Loop
        echo '
        <tr class="last_rowed"></tr>
        </tbody>
    </table>';
}

if($valueEdit['status'] == 5){

    $relationWithStudent    = '';
    $recepientColSpan       = '';
    if($valueEdit['recipient'] == 2){

        $relationWithStudent = '
            <td><strong>Relationship with student</strong></td>
            <td>'.$valueEdit['recipient_relationship'].'</td>';
    } else {
        $recepientColSpan = ' colspan="3"';
    }

    echo '
    <h4 class="modal-title" style="font-weight:700;">Recipient Details</h4>
    <table class="table table-bordered table-hover">
        <tbody>
            <tr>
                <td style="width:25%;"><strong>Recipient</strong></td>
                <td>'.get_dsa_recipient($valueEdit['recipient']).'</td>
                <td style="width:20%;"><strong>Full Name</strong></td>
                <td>'.$valueEdit['recipient_full_name'].'</td>
            </tr>
            <tr>
                '.$relationWithStudent.'
                <td><strong>Recipient CNIC</strong></td>
                <td '.$recepientColSpan.'><span class="label label-info">'.$valueEdit['recipient_cnic'].'</span></td>
            </tr>
        </tbody>
    </table>';
}

// 13-03-2024 Start
//Query Log
$sqllmsLog  = $dblms->querylms("SELECT l.id, l.details, l.remarks, l.date_added, a.adm_username
                                    FROM ".DSA_APPLICATIONS_LOG." l
                                    INNER JOIN ".ADMINS." a ON a.adm_id = l.id_added 
                                    WHERE l.id_application =  '".cleanvars($_GET['id'])."'
                                    ORDER BY l.id DESC LIMIT 10");
if(mysqli_num_rows($sqllmsLog) > 0){

    echo'
    <h4 class="modal-title" style="font-weight:700;">History</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="font-weight:600;text-align:center;">Sr. #</th>
                <th style="font-weight:600;text-align:center;">Detail</th>
                <th style="font-weight:600;text-align:center;">Updated By</th>
                <th style="font-weight:600;text-align:center;">Update At</th>
                <th style="font-weight:600;text-align:center;">Remarks</th>
            </tr>
        </thead>
        <tbody>';
        $srno = 0;
        while($valueLog = mysqli_fetch_array($sqllmsLog)) { 
            $srno++;
            echo '
                <tr>
                    <td>'.$srno.'</td>
                    <td> 
                        '.html_entity_decode($valueLog['details']).'
                    </td>
                    <td>'.$valueLog['adm_username'].'</td>
                    <td>'.date("D d M, Y", strtotime($valueLog['date_added'])).'</td>
                    <td>';
                        if($valueLog['remarks']){
                            echo''.html_entity_decode($valueLog['remarks']).'';
                        }
                        echo'
                    </td>
                </tr>
           ';
        }
        echo '
    </tbody>
    </table>';
}
// 13-03-2024 End

echo '
</div>
</div>
<!--WI_USER_PROFILE_TABLE-->
<!--WI_NOTIFICATION-->
</div>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
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
<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript">
	$(function () {
		$(".footable").footable();
	});
</script>
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>';
?>