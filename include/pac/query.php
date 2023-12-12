<?php

if(isset($_GET['deleteId']))
{
    $sqllms  = $dblms->querylms("DELETE FROM ".OBE_PACS." WHERE pac_id = '".cleanvars($_GET['deleteId'])."'");

    if($sqllms)
    {
        $_SESSION['msg']['status'] = 'toastr.info("Deleted Succesfully");';
        header("Location: pac.php");
        exit();
    }

}

if(isset($_POST['submit_pac'])) 
{ 
    $pacData = [
        'pac_status'        => cleanvars($_POST['pac_status'])
        ,'pac_number'       => cleanvars($_POST['pac_number'])
        ,'pac_statement'    => cleanvars($_POST['pac_statement'])
        ,'pac_marks'        => 0
        ,'pac_weightage'    => cleanvars($_POST['pac_weightage'])
        ,'id_teacher'       => ID_TEACHER
        ,'id_course'        => ID_COURSE
        ,'id_prg'           => ID_PRG
        ,'semester'         => SEMESTER
        ,'section'          => SECTION
        ,'timing'           => TIMING
        ,'academic_session' => ACADEMIC_SESSION
        ,'id_campus'        => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])  
        ,'id_added'         => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])           
        ,'date_added'       => date('Y-m-d H:i:s')                
    ];
    $queryInsert = $dblms->Insert(OBE_PACS , $pacData);
    
    if($queryInsert) {
        $latest_id = $dblms->lastestid();
        $_SESSION['msg']['status'] = 'toastr.success("Inserted Succesfully");';
        header("Location: pac.php", true, 301);
        exit(); 
    }
}

if(isset($_POST['edit_pac'])) { 
    //------------------------------------------------
    $pacData = [
        'pac_status'        => cleanvars($_POST['pac_status'])
        ,'pac_number'       => cleanvars($_POST['pac_number'])
        ,'pac_statement'    => cleanvars($_POST['pac_statement'])
        ,'pac_marks'        => 0
        ,'pac_weightage'    => cleanvars($_POST['pac_weightage'])
        ,'id_modify'        => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ,'date_modify'      => date('Y-m-d H:i:s')              
    ];
    $conditions = "WHERE  pac_id  = ".cleanvars($_GET['id'])."";
    $queryUpdate = $dblms->Update(OBE_PACS, $pacData,$conditions);

    if($queryUpdate) { 
        $latest_id = cleanvars($_GET['id']);
        $_SESSION['msg']['status'] = 'toastr.info("Updated Succesfully");';
        header("Location: pac.php", true, 301);
        exit();

    }

}