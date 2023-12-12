<?php
if(isset($_GET['deleteresultId'])) {  
    $sqllms = $dblms->querylms("DELETE FROM ".OBE_QUESTIONS_RESULTS." WHERE id_result IN (SELECT result_id FROM ".OBE_RESULTS." WHERE id_paractical IN (" .$_GET['deleteresultId']."))  ");
    $sqllms = $dblms->querylms("DELETE FROM ".OBE_RESULTS." WHERE id_paractical IN (" .$_GET['deleteresultId'].") AND theory_paractical = ".COURSE_TYPE."");
    if($sqllms) {
        $_SESSION['msg']['status'] = 'toastr.info("Deleted Succesfully");';
        header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
        exit();
    }   
}

if(isset($_GET['deleteparacticalId'])) {
    $sqllms = $dblms->querylms("DELETE FROM ".OBE_QUESTIONS_RESULTS." WHERE id_result IN (SELECT result_id ". OBE_RESULTS." FROM WHERE id_paractical IN (" .$_GET['deleteresultId']."))  ");
    $sqllms = $dblms->querylms("DELETE FROM ".OBE_RESULTS." WHERE id_paractical IN (" .$_GET['deleteresultId'].") AND theory_paractical = ".COURSE_TYPE."");
    $sqllms = $dblms->querylms("DELETE FROM ".OBE_PARACTICAL_PERFORMANCES." WHERE pp_id IN (".$_GET['deleteparacticalId'].")");
    
    if($sqllms) {
        $_SESSION['msg']['status'] = 'toastr.info("Deleted Succesfully");';
        header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
        exit();
    }   
}

if (isset($_POST['submit_paractical'])) {
    $paracticalData = [
        'pp_status'            => cleanvars($_POST['pp_status'])                        ,
        'pp_number'            => cleanvars($_POST['pp_number'])                        ,
        'pp_marks'             => cleanvars($_POST['pp_marks'])                         ,
        'pp_date'              => cleanvars($_POST['pp_date'])                          ,
        'id_kpi'               => cleanvars($_POST['kpi_ids'])                          ,
        'id_teacher'           => ID_TEACHER                                            ,
        'id_course'            => ID_COURSE                                             ,
        'id_prg'               => ID_PRG                                                ,
        'semester'             => SEMESTER                                              ,
        'section'              => SECTION                                               ,
        'timing'               => TIMING                                                ,
        'academic_session'     => 'Spring 2023'                                         ,
        'id_campus'            => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])   ,
        'id_added'             => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])     ,
        'date_added'           => date('Y-m-d H:i:s')                
    ];
    $queryInsert = $dblms->Insert(OBE_PARACTICAL_PERFORMANCES, $paracticalData);

    if($queryInsert) { 
        $_SESSION['msg']['status'] = 'toastr.info("Inserted Succesfully")';
        header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
        exit();
    }       
}

if(isset($_POST['edit_paractical'])) {
    $paracticalData = [
        'pp_status'            => cleanvars($_POST['pp_status'])                        ,
        'pp_number'            => cleanvars($_POST['pp_number'])                        ,
        'pp_marks'             => cleanvars($_POST['pp_marks'])                         ,
        'pp_date'              => cleanvars($_POST['pp_date'])                          ,
        'id_kpi'               => cleanvars($_POST['kpi_ids'])                          ,
        'id_added'             => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])     ,
        'date_added'           => date('Y-m-d H:i:s')                
    ];
    $conditions = "WHERE pp_id  = ".cleanvars($_GET['id'])."";
    $query = $dblms->update(OBE_PARACTICAL_PERFORMANCES, $paracticalData, $conditions);

    if($query){
        $_SESSION['msg']['status'] = 'toastr.info("Updated Succesfully");';
        header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
        exit();
    }      
}

if(isset($_POST['submit_result'])) {
    $resultData = [
        'result_status'        => cleanvars($_POST['result_status'])                        ,
        'result_number'        => 1                                                         ,
        'result_date'          => date('Y-m-d H:i:s')                                       ,
        'id_teacher'           => ID_TEACHER                                                ,
        'id_course'            => ID_COURSE                                                 ,
        'theory_paractical'    => COURSE_TYPE                                               ,
        'id_paractical'        => cleanvars($_POST['pp_id'])                                ,
        'id_prg'               => ID_PRG                                                    ,
        'semester'             => SEMESTER                                                  ,
        'section'              => SECTION                                                   ,
        'timing'               => TIMING                                                    ,
        'academic_session'     => ACADEMIC_SESSION                                          ,
        'id_campus'            => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])       ,
        'id_added'             => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])         ,
        'date_added'           => date('Y-m-d H:i:s')                
    ];
    $queryInsertQues = $dblms->Insert(OBE_RESULTS, $resultData);

    $latest_id = $dblms->lastestid();

    foreach (cleanvars($_POST['obt_marks']) as $stdid => $kpiId) {
        foreach ($kpiId as $kpinum => $obtmarks) {
            $resultData = [
                'id_result'            => $latest_idm       ,
                'id_ques'              => $kpinumm          ,
                'id_std'               => $stdidm           ,
                'obt_marks'            => $obtmarks[0]
            ];
            $queryInsert = $dblms->Insert(OBE_QUESTIONS_RESULTS, $resultData);
        }
    }

    $_SESSION['msg']['status'] = 'toastr.info("Result Inserted Succesfully")';
    header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
    exit();
}

if(isset($_POST['edit_result'])) {
    $resultData = [
        'result_status'        => cleanvars($_POST['result_status'])                    ,
        'result_number'        => 1                                                     ,
        'id_modify'            => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])     ,
        'date_modify'          => date('Y-m-d H:i:s')                
    ];
    $conditions = "WHERE result_id  = ".cleanvars($_POST['result_id'])."";
    $queryUpdateResult = $dblms->update(OBE_RESULTS, $resultData, $conditions);

    foreach (cleanvars($_POST['obt_marks']) as $stdid => $kpiId) {
        foreach ($kpiId as $kpinum => $obtmarks) {
            $resultData = [
                'id_ques'              => $kpinum       ,
                'id_std'               => $stdid        ,
                'obt_marks'            => $obtmarks 
            ];
            $conditions = "WHERE id_ques  = ".$kpinum." AND id_std = ".$stdid." AND id_result = ".cleanvars($_POST['result_id'])." ";
            $queryUpdateResult = $dblms->update(OBE_QUESTIONS_RESULTS, $resultData, $conditions);
        }
    }
    $_SESSION['msg']['status'] = 'toastr.info("Result Updated Succesfully")';
    header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
    exit();
}

?>