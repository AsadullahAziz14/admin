<?php

if($view == 'delete') {
	if(isset($_GET['id'])) {
        $queryDelete  = $dblms->querylms("DELETE FROM ".OBE_CLOS." WHERE clo_id = '".cleanvars($_GET['id'])."'");
        $queryDeleteCloPrg = $dblms->querylms("DELETE FROM ".OBE_CLOS_PROGRAMS." WHERE id_clo = '".cleanvars($_GET['id'])."'");

        $_SESSION['msg']['status']  = '<div class="alert-box error"><span>Success: </span>Record has been deleted successfully.</div>';
        header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
        exit();
	}
}

if(isset($_POST['submit_clo'])) {
    $queryCheck = $dblms->querylms("SELECT clo_id 
										FROM ".OBE_CLOS." 
										WHERE clo_statement = '".cleanvars($_POST['clo_statement'])."'
										AND id_domain_level = '".cleanvars($_POST['id_domain_level'])."'
										AND id_teacher = '".cleanvars($_POST['id_teacher'])."'
										AND id_course = '".cleanvars($_POST['id_course'])."'
										AND academic_session = '".cleanvars($_POST['academic_session'])."'
										AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' LIMIT 1");
	if(mysqli_num_rows($queryCheck)>0) { 
		$_SESSION['msg']['status']  = '<div class="alert-box error"><span>Error:</span>Record already exists.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	} else {
        $plos = implode(",",$_POST['id_plo']);

        $cloData = [
            'clo_status'            => cleanvars($_POST['clo_status'])          ,
            'clo_number'            => cleanvars($_POST['clo_number'])          ,
            'clo_statement'         => cleanvars($_POST['clo_statement'])       ,
            'id_plo'                => $plos                                    ,
            'id_domain_level'       => cleanvars($_POST['id_domain_level'])     ,
            'id_teacher'            => ID_TEACHER                               ,
            'id_course'             => ID_COURSE                                ,
            'academic_session'      => ACADEMIC_SESSION                         ,
            'id_campus'             => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])                                ,
            'id_added'              => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])                  ,
            'date_added'            => date('Y-m-d H:i:s')                
        ];
        $queryInsert = $dblms->Insert(OBE_CLOS , $cloData);
        
        if($queryInsert) {
            $latest_id = $dblms->lastestid();

            // Check for liberal arts
            if(isset($_POST['sections'])) {
                foreach (cleanvars($_POST['sections']) as $key => $itemsections) {
                    $cloPrgData = [
                        'id_clo'                => $latest_id               ,
                        'section'               => $itemsections            ,
                        'timing'                => TIMING          
                    ];
                    $queryInsertCloPrg = $dblms->Insert(OBE_CLOS_PROGRAMS, $cloPrgData);
                }            
            } else {
                $cloPrgData = [
                    'id_clo'              => $latest_id         ,
                    'id_prg'              => ID_PRG             ,
                    'section'             => SECTION            ,
                    'semester'            => SEMESTER           ,
                    'timing'              => TIMING            
                ];
                $queryInsertCloPrg = $dblms->Insert(OBE_CLOS_PROGRAMS, $cloPrgData);
            }
            // Set Success MSG in Session & Exit
            $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been added successfully.</div>';
            header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
            exit();
        }
    }
}

if(isset($_POST['submit_changes'])) { 
    $plos = implode(",",cleanvars($_POST['id_plo_edit']));

    $cloData = [
        'clo_status'            => cleanvars($_POST['clo_status_edit'])         ,
        'clo_number'           => cleanvars($_POST['clo_number_edit'])          ,
        'clo_statement'        => cleanvars($_POST['clo_statement_edit'])       ,
        'id_domain_level'      => cleanvars($_POST['id_domain_level_edit'])     ,
        'id_plo'               => $plos                                         ,
        'id_modify'            => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])                       ,
        'date_modify'          => date('Y-m-d H:i:s')              
    ];
    $conditions = "WHERE  clo_id  = ".cleanvars($_POST['clo_id_edit'])."";
    $queryUpdate = $dblms->Update(OBE_CLOS, $cloData,$conditions);

    if($queryUpdate) {
        //Set Success MSG in Session & Exit
        $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been updated successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
    }

}