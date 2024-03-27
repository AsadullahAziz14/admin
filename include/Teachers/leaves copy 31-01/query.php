<?php

if(isset($_POST['submit_application'])) {

    if(cleanvars($_POST['leave_applied_for']) < 0 || cleanvars($_POST['leave_applied_for']) == 'Enter the days equal or less than Balance'){

        $_SESSION['msg']['status'] = '<div class="alert-box error"><span>Error: </span>Maximum leaves in this category are already availed</div>';
        header('location: salaryleaves.php');
        exit();

    } else {

        $dataLeave = array(
                'id_emply'                  =>      cleanvars($_POST['employee'])                  ,
                'substitute'                =>      cleanvars($_POST['substitution'])              ,
                'id_cat'                    =>      cleanvars($_POST['leave_category'])            ,
                'leave_start_date'          =>      cleanvars($_POST['leave_from'])                ,
                'leave_end_date'            =>      cleanvars($_POST['leave_to'])                  ,
                'leave_applied_for'         =>      cleanvars($_POST['leave_applied_for'])         ,
                'already_availed'           =>      cleanvars($_POST['leave_already_availed'])     ,
                'in_balance'                =>      cleanvars($_POST['leave_in_balance'])          ,
                'leave_reason'              =>      cleanvars($_POST['leave_reason'])              ,
                'id_campus'                 =>      cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']),
                'id_added'                  =>      cleanvars($_SESSION['userlogininfo']['LOGINIDA']),
                'date_added'                =>      date("Y-m-d H:i:s")
                        
        );
        $queryInsert = $dblms->Insert(SALARY_EMPLYS_LEAVES, $dataLeave);

        if($queryInsert) {
            
            $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record added successfully.</div>';
            header('location: salaryleaves.php');
            exit();

        }

    }
}


if(isset($_POST['edit_application'])) {

    $dataLeave = array(
            'id_cat'                    =>      cleanvars($_POST['leave_category'])            ,
            'leave_reason'              =>      cleanvars($_POST['leave_reason'])              ,
            'leave_start_date'          =>      cleanvars($_POST['leave_from'])                ,
            'leave_end_date'            =>      cleanvars($_POST['leave_to'])                  ,
            'leave_applied_for'         =>      cleanvars($_POST['leave_applied_for'])         ,
            'substitute'              =>      cleanvars($_POST['substitution'])              ,
            'id_modify'                 =>      cleanvars($_SESSION['userlogininfo']['LOGINIDA']),
            'date_modify'               =>      date("Y-m-d H:i:s")             
    );
    $queryUpdate = $dblms->Update(SALARY_EMPLYS_LEAVES, $dataLeave, "WHERE id = ".cleanvars($_POST['lid'])."");

    if($queryUpdate) {

        $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been updated successfully.</div>';
        header('location: leave_applications.php');
        exit();

    }
}
?>