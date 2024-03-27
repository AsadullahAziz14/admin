<?php

require_once('../../../dbsetting/lms_vars_config.php');
require_once('../../../dbsetting/classdbconection.php');
$dblms = new dblms();
require_once('../../../functions/login_func.php');
require_once('../../../functions/functions.php');

if(isset($_POST['cat_id'])) {

    $queryTotalAllowed = $dblms->querylms("SELECT cat_leaves_allowed
                                            FROM ".SALARY_EMPLYS_LEAVES_CATS." 
                                            WHERE cat_id = ".cleanvars($_POST['cat_id'])."");
    $valueTotalAllowed = mysqli_fetch_array($queryTotalAllowed);

    $queryLeavesAvailed = $dblms->querylms("SELECT SUM(leave_applied_for) AS totalAvailed 
                                                FROM ".SALARY_EMPLYS_LEAVES."
                                                WHERE id_emply = ".$_POST['emply_id']." 
                                                AND id_cat = ".cleanvars($_POST['cat_id'])."
                                                AND status = '1'");
    $valueLeavesAvailed  = mysqli_fetch_array($queryLeavesAvailed);
    
    $data = [
        'allowed'   =>      $valueTotalAllowed['cat_leaves_allowed']    ,
        'availed'   =>      $valueLeavesAvailed['totalAvailed']         ,
        'balance'   =>      ($valueTotalAllowed['cat_leaves_allowed'] - $valueLeavesAvailed['totalAvailed'])
    ];

    print_r(json_encode($data));

}

?>