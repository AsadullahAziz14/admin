<?php
include "../../dbsetting/lms_vars_config.php";
include "../../dbsetting/classdbconection.php";
$dblms = new dblms();
include "../../functions/login_func.php";
include "../../functions/functions.php";
checkCpanelLMSALogin();

//--------------------------------------------


$selectedValue = $_GET['selectedValue'];

// Perform a MySQL query to fetch options based on the selected value
$sqllms = $dblms->querylms("SELECT sub_category_id, sub_category_name 
                                FROM ".SMS_SUB_CATEGORY." 
                                WHERE id_category = '$selectedValue'");

echo '<option value = "">Select Sub-Category</option>';

while ($rowstd = mysqli_fetch_assoc($sqllms)) {
    echo '<option value = "'.$rowstd['sub_category_id'].'">'.$rowstd['sub_category_name'].'</option>';
}

