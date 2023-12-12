<?php
error_reporting(0);
include "../../dbsetting/lms_vars_config.php";
include "../../dbsetting/classdbconection.php";
$dblms = new dblms();
include "../../functions/login_func.php";
include "../../functions/functions.php";
checkCpanelLMSALogin();

//--------------------------------------------

$selectedDemands = $_GET['selectedDemands'];
if($selectedDemands != '')
{
        $sqllms = $dblms->querylms("SELECT * FROM ".SMS_DEMAND." Where demand_id NOT IN (".$selectedDemands.")");

        echo '<option value = "">Select Demand</option>';
        while ($rowstd = mysqli_fetch_array($sqllms)) {
                echo '<option value = "'.$rowstd['demand_id'].'">'.$rowstd['demand_code'].'-'.$rowstd['demand_title'].'</option>';
        }

}
else
{
        $sqllms = $dblms->querylms("SELECT * FROM ".SMS_DEMAND);

        echo '<option value = "">Select Demand</option>';
        while ($rowstd = mysqli_fetch_array($sqllms)) {
                echo '<option value = "'.$rowstd['demand_id'].'">'.$rowstd['demand_code'].'-'.$rowstd['demand_title'].'</option>';
        }

}


?>
