<?php

if(isset($_POST['submit_application'])) {

    if(cleanvars($_POST['leave_applied_for']) < 0 || cleanvars($_POST['leave_applied_for']) == 'Enter the days equal or less than Balance'){

        $_SESSION['msg']['status'] = '<div class="alert-box error"><span>Error: </span>Maximum leaves in this category are already availed</div>';
        header('location: employee_leaves.php');
        exit();

    } else {

        $data = array(
                'id_emply'                  =>      cleanvars($_POST['id_emply'])                       ,
                'id_substitute'             =>      cleanvars($_POST['id_substitute'])                  ,
                'status'                    =>      '2'                                                 ,
                'id_cat'                    =>      cleanvars($_POST['leave_category'])                 ,
                'leave_start_date'          =>      cleanvars($_POST['leave_from'])                     ,
                'leave_end_date'            =>      cleanvars($_POST['leave_to'])                       ,
                'leave_applied_for'         =>      cleanvars($_POST['leave_applied_for'])              ,
                'already_availed'           =>      cleanvars($_POST['leave_already_availed'])          ,
                'in_balance'                =>      cleanvars($_POST['leave_in_balance'])               ,
                'leave_reason'              =>      cleanvars($_POST['leave_reason'])                   ,
                'id_campus'                 =>      cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) ,
                'id_added'                  =>      cleanvars($_SESSION['userlogininfo']['LOGINIDA'])   ,
                'date_added'                =>      date("Y-m-d H:i:s")                                 
        );
        
        $queryInsert = $dblms->Insert(SALARY_EMPLYS_LEAVES, $data);

        if($queryInsert) {
            
            $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record added successfully.</div>';
            header('location: employee_leaves.php');
            exit();

        }

    }
}

?>