<?php
error_reporting(0);
include "../../dbsetting/lms_vars_config.php";
include "../../dbsetting/classdbconection.php";
$dblms = new dblms();
include "../../functions/login_func.php";
include "../../functions/functions.php";
checkCpanelLMSALogin();

// Retrieve data from the AJAX request
$data = json_decode(file_get_contents("php://input"), true);

// Access the data sent from JavaScript
$id_curs = $data['id_curs'];
$id_prg = $data['id_prg'];
//--------------------------------------------
$sqllms = $dblms->querylms("SELECT em.emply_id, em.emply_name
                                        FROM ".EMPLYS." em 					 
                                        WHERE em.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                        AND em.emply_loginid = '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' LIMIT 1");
$rowsstd = mysqli_fetch_array($sqllms); 
//--------------------------------------------

$sqllms = $dblms->querylms("SELECT c.clo_id, c.clo_number
                                FROM ".OBE_CLOS." c
                                INNER JOIN ".OBE_CLOS_PROGRAMS." as cp ON c.clo_id = cp.id_clo
                                WHERE c.id_teacher = '".$rowsstd['emply_id']."' 
                                AND c.id_course = '".$id_curs."'
                                AND cp.id_prg = '".$id_prg."'
                                AND c.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'  
                                AND c.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                        ");
                   
echo '<option value = "">Select CLO</option>';
while ($value_clo = mysqli_fetch_assoc($sqllms)) {
        echo '<option value = "'.$value_clo['clo_id'].'">CLO '.$value_clo['clo_number'].'</option>';
}

?>
