<?php
if(isset($_GET['deleteFinaltermId'])) {  
    $sqllms = $dblms->querylms("SELECT id_ques 
                                    FROM ".OBE_FINALTERMS." 
                                    WHERE ft_id =  ".cleanvars($_GET['deleteFinaltermId'])."
                                ");
    $value_finalterm = mysqli_fetch_assoc($sqllms);

    if($value_finalterm['id_ques'] != '') {        
        $deleteQuessqllms = $dblms->querylms("DELETE FROM ".OBE_QUESTIONS." WHERE ques_id IN (".$value_finalterm['id_ques'].")");
        $deleteMcqsqllms = $dblms->querylms("DELETE FROM ".OBE_MCQS." WHERE id_ques IN (".$value_finalterm['id_ques'].")");
        $sqllms = $dblms->querylms("SELECT DISTINCT id_result as resultId FROM ".OBE_QUESTIONS_RESULTS." WHERE id_ques IN (".$value_finalterm['id_ques'].")");
        $row = mysqli_fetch_array($sqllms);

        $deleteQuestionResultsqllms = $dblms->querylms("DELETE FROM ".OBE_QUESTIONS_RESULTS." WHERE id_ques IN (".$value_finalterm['id_ques'].") AND id_result IN (".$row['resultId'].")");
        $deleteResultsqllms = $dblms->querylms("DELETE FROM ".OBE_RESULTS." WHERE result_id IN (".$row['resultId'].")");
    }

    $deletefinaltermsqllms = $dblms->querylms("DELETE FROM ".OBE_FINALTERMS." WHERE ft_id = '".cleanvars($_GET['deleteFinaltermId'])."'");

    if($deletefinaltermsqllms) {
        $_SESSION['msg']['status'] = '<div class="alert-box error"><span>Success: </span>Record has been deleted successfully.</div>';
        header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
        exit();
    }
}

if(isset($_POST['questionId'])) {
    $deleteQuessqllms = $dblms->querylms("DELETE FROM ".OBE_QUESTIONS." WHERE ques_id IN (".cleanvars($_POST['questionId']).")");
    $deletesqllms = $dblms->querylms("DELETE FROM ".OBE_MCQS." WHERE id_ques IN (".cleanvars($_POST['questionId']).") ");
    $sqllms = $dblms->querylms("UPDATE ".OBE_FINALTERMS." SET id_ques = TRIM(BOTH ',' FROM REPLACE(REPLACE(id_ques, '".cleanvars($_POST['questionId'])."',''), ',,', ',')) WHERE id_ques LIKE '%".cleanvars($_POST['questionId'])."%'");
}

if (isset($_POST['submit_finalterm'])) {
    $quesIds = array();

    if(isset($_POST['ques_number'])) {
        $quesNumbers = implode(",",cleanvars($_POST['ques_number']));
            
        for ($i = 0; $i <  sizeof(cleanvars($_POST['ques_number'])); $i++) {
            if(isset($_POST['ques_statement'])) {
                $quesStatement = cleanvars($_POST['ques_statement'][$i]);
            } else {
                $quesStatement = '';
            }

            $quesData = [
                'ques_status'          => '1'                                                       ,
                'ques_category'        => cleanvars($_POST['ques_category'][$i])                    ,
                'ques_type'            => '3'                                                       ,
                'ques_statement'       => $quesStatement                                            ,
                'ques_marks'           => cleanvars($_POST['ques_marks'][$i])                       ,
                'id_clo'               => implode(',',cleanvars($_POST['ques_clo'][$i + 1]))        ,
                'ques_number'          => cleanvars($_POST['ques_number'][$i])                      ,
                'id_teacher'           => ID_TEACHER                                                ,
                'id_course'            => ID_COURSE                                                 ,
                'theory_paractical'    => COURSE_TYPE                                               ,
                'id_prg'               => ID_PRG                                                    ,
                'semester'             => SEMESTER                                                  ,
                'section'              => SECTION                                                   ,
                'timing'               => TIMING                                                    ,
                'academic_session'     => ACADEMIC_SESSION                                          ,
                'id_campus'            => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])       ,
                'id_added'             => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])         ,
                'date_added'           => date('Y-m-d H:i:s')                
            ];
            $queryInsertQues = $dblms->Insert(OBE_QUESTIONS, $quesData);

            $latest_id = $dblms->lastestid();
            $quesIds[] = $latest_id;

            if($queryInsertQues && cleanvars($_POST['ques_category'][$i]) === '2') {
                $mcqOptions =  cleanvars($_POST['option']);

                $mcqData = [
                    'id_ques'           => $latest_id
                    ,'option1'          => $mcqOptions[$i][1]
                    ,'option2'          => $mcqOptions[$i][2]
                    ,'option3'          => $mcqOptions[$i][3]
                    ,'option4'          => $mcqOptions[$i][4]
                    ,'option5'          => $mcqOptions[$i][5]                   
                ];
                $queryInsertMcq = $dblms->Insert(OBE_MCQS, $mcqData);        
            } 
        }
    }

    $quesids = implode(',', $quesIds);
    if (count($quesIds) > 1) {
        $quesids = implode(',', $quesIds);
    }

    $finaltermData = [
        'ft_status'                    => cleanvars($_POST['ft_status'])                        ,
        'ft_number'                    => cleanvars($_POST['number'])                           ,
        'ft_marks'                     => cleanvars($_POST['marks'])                            ,
        'ft_date'                      => cleanvars($_POST['date'])                             ,
        'id_ques'                      => $quesids                                              ,
        'id_teacher'                   => ID_TEACHER                                            ,
        'id_course'                    => ID_COURSE                                             ,
        'id_prg'                       => ID_PRG                                                ,
        'semester'                     => SEMESTER                                              ,
        'section'                      => SECTION                                               ,
        'timing'                       => TIMING                                                ,
        'academic_session'             => 'Spring 2023'                                         ,
        'id_campus'                    => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])   ,
        'id_added'                     => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])     ,
        'date_added'                   => date('Y-m-d H:i:s')                
    ];
    $queryInsertFinalterm = $dblms->Insert(OBE_FINALTERMS, $finaltermData);

    if($queryInsertFinalterm) { 
        $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been Inserted successfully.</div>';
        header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
        exit();
    }
}

if(isset($_POST['edit_finalterm'])) {
    $ft_id = cleanvars($_GET['id']); 
    $ques_ids = [];

    foreach (cleanvars($_POST['ques_number']) as $key => $value) {
        if(is_array($value)){
            $val = array_keys($value);

            if(isset($_POST['ques_statement'][$key][$val[0]])) {
                $quesStatement = cleanvars($_POST['ques_statement'][$key][$val[0]]);
            } else {
                $quesStatement = cleanvars($_POST['ques_statement'][$val[0]]);
            }

            $update_quesData = [
                'ques_status'          => '1'                                                   ,
                'ques_category'        => cleanvars($_POST['ques_category'][$key][$val[0]])     ,
                'ques_type'            => '3'                                                   ,
                'ques_number'          => cleanvars($_POST['ques_number'][$key][$val[0]])       ,
                'ques_statement'       => cleanvars($_POST['ques_statement'][$key][$val[0]])    ,
                'ques_marks'           => cleanvars($_POST['ques_marks'][$key][$val[0]])        ,
                'id_clo'               => implode(',',cleanvars($_POST['ques_clo'][$val[0]]))   ,
                'id_teacher'           => ID_TEACHER                                            ,
                'id_course'            => ID_COURSE                                             ,
                'theory_paractical'    => COURSE_TYPE                                           ,
                'id_prg'               => ID_PRG                                                ,
                'semester'             => SEMESTER                                              ,
                'section'              => SECTION                                               ,
                'timing'               => TIMING                                                ,
                'academic_session'     => ACADEMIC_SESSION                                      ,
                'id_campus'            => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])   ,
                'id_modify'            => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])     ,
                'date_modify'          => date('Y-m-d H:i:s')                
            ];
            $conditions = "WHERE ques_id = ".$val[0];
            $queryUpdateQues = $dblms->update(OBE_QUESTIONS, $update_quesData, $conditions);

            $ques_ids[] = $val[0];
            if($queryUpdateQues && cleanvars($_POST['ques_category'][$key][$val[0]]) == "2" && cleanvars($_POST['option'])) {
                $sqllmsmcq = $dblms->querylms("SELECT id_ques 
                                                    FROM ".OBE_MCQS." 
                                                    WHERE id_ques = ".$val[0]);

                $value_mcq = mysqli_fetch_assoc($sqllmsmcq);
               
                if(isset($value_mcq['id_ques'])) {
                    $mcqData = [
                        'option1'      => cleanvars($_POST['option'][$key][$val[0]][1])         ,
                        'option2'      => cleanvars($_POST['option'][$key][$val[0]][2])         ,
                        'option3'      => cleanvars($_POST['option'][$key][$val[0]][3])         ,
                        'option4'      => cleanvars($_POST['option'][$key][$val[0]][4])         ,
                        'option5'      => cleanvars($_POST['option'][$key][$val[0]][5])
                    ];
                    $conditions = "WHERE id_ques = $val[0]";
                    $queryUpdateOBE_MCQS = $dblms->update(OBE_MCQS, $mcqData, $conditions);
                } else {
                    $update_quesData = [
                        'ques_statement'   => cleanvars($_POST['ques_statement'][$val[0]])                  ,
                        'id_modify'        => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])             ,
                        'date_modify'      => date('Y-m-d H:i:s')                
                    ];
                    $conditions = "WHERE ques_id = ".$val[0];
                    $queryUpdateQues = $dblms->update(OBE_QUESTIONS, $update_quesData, $conditions);

                    $mcqData = [
                        'id_ques'          => $val[0]                                           ,
                        'option1'          => cleanvars($_POST['option'][$val[0]][1])           ,
                        'option2'          => cleanvars($_POST['option'][$val[0]][2])           ,
                        'option3'          => cleanvars($_POST['option'][$val[0]][3])           ,
                        'option4'          => cleanvars($_POST['option'][$val[0]][4])           ,
                        'option5'          => cleanvars($_POST['option'][$val[0]][5])              
                    ];
                    $queryInsertMcq = $dblms->Insert(OBE_MCQS, $mcqData);
                }
            } else {
                $sqllmsmcq = $dblms->querylms("DELETE FROM ".OBE_MCQS." WHERE id_ques IN (SELECT id_ques FROM ".OBE_MCQS." WHERE id_ques = ".$val[0].")");
            } 
        } else {
            $quesData = [
                'ques_status'          => '1'                                                   ,
                'ques_category'        => cleanvars($_POST['ques_category'][$key])              ,
                'ques_type'            => '3'                                                   ,
                'ques_statement'       => cleanvars($_POST['ques_statement'][$key])             ,
                'ques_marks'           => cleanvars($_POST['ques_marks'][$key])                 ,
                'id_clo'               => cleanvars($_POST['ques_clo'][$key])                   ,
                'ques_number'          => cleanvars($_POST['ques_number'][$key])                ,
                'id_teacher'           => ID_TEACHER                                            ,
                'id_course'            => ID_COURSE                                             ,
                'theory_paractical'    => COURSE_TYPE                                           ,
                'id_prg'               => ID_PRG                                                ,
                'semester'             => SEMESTER                                              ,
                'section'              => SECTION                                               ,
                'timing'               => TIMING                                                ,
                'academic_session'     => ACADEMIC_SESSION                                      ,
                'id_campus'            => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])   ,
                'id_added'             => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])     ,
                'date_added'           => date('Y-m-d H:i:s')                
            ];
            $queryInsertQues = $dblms->Insert(OBE_QUESTIONS, $quesData);

            $latest_id = $dblms->lastestid();
            $ques_ids[] = $latest_id;
            
            if($queryInsertQues && cleanvars($_POST['ques_category'][$key]) == "2") {
                $mcqData = [
                    'id_ques'          => $latest_id                                ,
                    'option1'          => cleanvars($_POST['option'][$key][1])      ,
                    'option2'          => cleanvars($_POST['option'][$key][2])      ,
                    'option3'          => cleanvars($_POST['option'][$key][3])      ,
                    'option4'          => cleanvars($_POST['option'][$key][4])      ,
                    'option5'          => cleanvars($_POST['option'][$key][5])              
                ];
                $queryInsertMcq = $dblms->Insert(OBE_MCQS, $mcqData);
            }
        }
    }

    $update_finaltermData = [
        'ft_status'            => cleanvars($_POST['ft_status'])                        ,
        'ft_number'            => cleanvars($_POST['ft_number'])                        ,
        'ft_marks'             => cleanvars($_POST['marks'])                            ,
        'ft_date'              => cleanvars($_POST['ft_date'])                          ,
        'id_ques'              => implode(',',$ques_ids)                                ,
        'id_teacher'           => ID_TEACHER                                            ,
        'id_course'            => ID_COURSE                                             ,
        'id_prg'               => ID_PRG                                                ,
        'semester'             => SEMESTER                                              ,
        'section'              => SECTION                                               ,
        'timing'               => TIMING                                                ,
        'academic_session'     => ACADEMIC_SESSION                                      ,
        'id_campus'            => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])   ,
        'id_added'             => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])     ,
        'date_added'           => date('Y-m-d H:i:s')                
    ];
    $conditions = "WHERE ft_id = ".cleanvars($_GET['id'])."";
    $queryUpdateFinalterm = $dblms->update(OBE_FINALTERMS, $update_finaltermData, $conditions);

    if($queryUpdateFinalterm) {
        $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been Updated successfully.</div>';
        header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
        exit();
    }      
}


if(isset($_POST['submit_result'])) {
    $resultData = [
        'result_status'        => cleanvars($_POST['result_status'])                    ,
        'result_number'        => 1                                                     ,
        'result_date'          => date('Y-m-d H:i:s')                                   ,
        'id_teacher'           => ID_TEACHER                                            ,
        'id_course'            => ID_COURSE                                             ,
        'theory_paractical'    => COURSE_TYPE                                           ,
        'id_prg'               => ID_PRG                                                ,
        'semester'             => SEMESTER                                              ,
        'section'              => SECTION                                               ,
        'timing'               => TIMING                                                ,
        'academic_session'     => ACADEMIC_SESSION                                      ,
        'id_campus'            => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])   ,
        'id_added'             => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])     ,
        'date_added'           => date('Y-m-d H:i:s')                
    ];
    $queryInsertQues = $dblms->Insert(OBE_RESULTS, $resultData);

    $latest_id = $dblms->lastestid();

    foreach (cleanvars($_POST['obt_marks']) as $stdid => $questions) {
        foreach ($questions as $quesnum => $obtmarks) {
            $resultData = [
                'id_result'            => $latest_id        ,
                'id_ques'              => $quesnum          ,
                'id_std'               => $stdid            ,
                'obt_marks'            => $obtmarks[0]
            ];
            $queryInsertQues = $dblms->Insert(OBE_QUESTIONS_RESULTS, $resultData);
        }
    }
    $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Result has been Inserted successfully.</div>';
    header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
    exit();
}

if(isset($_POST['edit_result'])) {
    $resultData = [
        'result_status'            => cleanvars($_POST['result_status'])                ,
        'result_number'            => 1                                                 ,
        'id_modify'                => cleanvars($_SESSION['userlogininfo']['LOGINIDA']) ,
        'date_modify'              => date('Y-m-d H:i:s')                
    ];
    $conditions = "WHERE result_id = ".cleanvars($_POST['result_id']."");
    $queryUpdateResult = $dblms->update(OBE_RESULTS , $resultData, $conditions);

    foreach (cleanvars($_POST['obt_marks']) as $stdid => $questions) {
        foreach ($questions as $quesid => $obtmarks) {
            $data = [
                'id_ques'          => $quesid           ,
                'id_std'           => $stdid            ,
                'obt_marks'        => $obtmarks[0] 
            ];
            $conditions = "WHERE id_ques = ".$quesid." && id_std = ".$stdid." && id_result = ".cleanvars($_POST['result_id'])." ";
            $queryUpdateResult = $dblms->update(OBE_QUESTIONS_RESULTS, $data, $conditions);
        }
    }
    $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been Updated successfully.</div>';
    header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
    exit();
}

if(isset($_GET['deleteresultId'])) {
    $resultrecordId = $_GET['deleteresultId'];

    $sqllms = $dblms->querylms("SELECT id_ques 
                                    FROM ".OBE_FINALTERMS." 
                                    WHERE ft_id =  ".$resultrecordId." ");
    if(mysqli_num_rows($sqllms) > 0) {
        $value_finalterm = mysqli_fetch_array($sqllms);
        if($value_finalterm['id_ques'] != "") {
            $sqllms = $dblms->querylms("SELECT id_ques,id_result 
                                       FROM ".OBE_QUESTIONS_RESULTS." 
                                       WHERE id_ques IN (".$value_finalterm['id_ques'].")");
            if(mysqli_num_rows($sqllms) > 0) {
                $value_sqllms = mysqli_fetch_array($sqllms);

                $deleteResultsqllms = $dblms->querylms("DELETE FROM ".OBE_QUESTIONS_RESULTS." WHERE id_ques IN (".$value_sqllms['id_ques'].")");
                $deletesqllms = $dblms->querylms("DELETE FROM ".OBE_RESULTS." WHERE result_id IN (".$value_sqllms['id_result'].")");

                if($deletesqllms) {
                    $_SESSION['msg']['status'] = '<div class="alert-box error"><span>Success: </span>Result has been deleted successfully.</div>';
                    header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
                    exit();
                } 
            }
        }
    }
}
?>