<?php
error_reporting(0);
include "../../dbsetting/lms_vars_config.php";
include "../../dbsetting/classdbconection.php";
$dblms = new dblms();
include "../../functions/login_func.php";
include "../../functions/functions.php";
checkCpanelLMSALogin();

//--------------------------------------------

$sqllms = $dblms->querylms("SELECT *
                                FROM ".OBE_CLOS."
                                INNER JOIN ".OBE_CLOS_PROGRAMS." as cp ON ".OBE_CLOS.".clo_id = cp.id_clo
                                WHERE ".OBE_CLOS.".id_teacher = ".ID_TEACHER." 
                                && ".OBE_CLOS.".id_course = ".ID_COURSE." 
                                && ".OBE_CLOS.".academic_session = '".ACADEMIC_SESSION."'  
                                && ".OBE_CLOS.".id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                && cp.id_prg = ".ID_PRG." 
                                && cp.semester = ".SEMESTER." 
                                && cp.section = '".SECTION."'");

                                
echo '<option value = "">Select CLOs</option>';
while ($value_clo = mysqli_fetch_assoc($sqllms)) {
        echo '<option value = "'.$value_clo['clo_id'].'">'.$value_clo['clo_number'].'</option>';
}

?>
