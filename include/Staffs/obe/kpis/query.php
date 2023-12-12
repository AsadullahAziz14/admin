<?php

if(isset($_GET['deleteId'])) {
    $sqllms  = $dblms->querylms("DELETE FROM ".OBE_KPIS." WHERE kpi_id = '".cleanvars($_GET['deleteId'])."'");
    if($sqllms) {
        $_SESSION['msg']['status'] = 'toastr.info("Deleted Succesfully");';
        header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
        exit();
    }
}

if(isset($_POST['submit_kpi'])) { 
    $kpiData = [
        'kpi_status'       => cleanvars($_POST['kpi_status'])                       ,
        'kpi_number'       => cleanvars($_POST['kpi_number'])                       ,
        'kpi_statement'    => cleanvars($_POST['kpi_statement'])                    ,
        'kpi_marks'        => cleanvars($_POST['kpi_marks'])                        ,
        //'kpi_weightage'    => cleanvars($_POST['kpi_weightage']                   ,
        'id_pac'           => cleanvars($_POST['id_pac'])                           ,
        'id_clo'           => implode(",",cleanvars($_POST['clo']))                 ,
        'id_teacher'       => ID_TEACHER                                            ,
        'id_course'        => ID_COURSE                                             ,
        'id_prg'           => ID_PRG                                                ,
        'semester'         => SEMESTER                                              ,
        'section'          => SECTION                                               ,
        'timing'           => TIMING                                                ,
        'academic_session' => ACADEMIC_SESSION                                      ,
        'id_campus'        => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])   ,
        'id_added'         => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])     ,
        'date_added'       => date('Y-m-d H:i:s')                
    ];
    $queryInsert = $dblms->Insert(OBE_KPIS, $kpiData);
    
    if($queryInsert) {
        $latest_id = $dblms->lastestid();
        $_SESSION['msg']['status'] = 'toastr.success("Inserted Succesfully");';
        header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
        exit(); 
    }
}

if(isset($_POST['edit_kpi'])) { 
    $kpiData = [
        'kpi_status'       => cleanvars($_POST['kpi_status'])                       ,
        'kpi_number'       => cleanvars($_POST['kpi_number'])                       ,
        'kpi_statement'    => cleanvars($_POST['kpi_statement'])                    ,
        'kpi_marks'        => cleanvars($_POST['Kpi_marks'])                        ,
        //'kpi_weightage'    => cleanvars($_POST['kpi_weightage']                   ,
        'id_pac'           => cleanvars($_POST['id_pac'])                           ,
        'id_clo'           => implode(",",cleanvars($_POST['clo']))                 ,
        'id_modify'        => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])     ,
        'date_modify'      => date('Y-m-d H:i:s')              
    ];
    $conditions = "WHERE  kpi_id  = ".cleanvars($_GET['id'])."";
    $queryUpdate = $dblms->Update(OBE_KPIS, $kpiData, $conditions);

    if($queryUpdate) { 
        $latest_id = cleanvars($_GET['id']);
        
        $_SESSION['msg']['status'] = 'toastr.info("Updated Succesfully");';
        header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
        exit();
    }
}