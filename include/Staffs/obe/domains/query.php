<?php

if($view == 'delete') {
	if(isset($_GET['id'])) { 

        $queryDelete  = $dblms->querylms("DELETE FROM ".OBE_DOMAINS." WHERE domain_id = '".cleanvars($_GET['id'])."'");

        $_SESSION['msg']['status']  = '<div class="alert-box error"><span>Success: </span>Record has been deleted successfully.</div>';
        header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
        exit();
	}
}


if(isset($_POST['submit_domain'])) {
    $queryCheck = $dblms->querylms("SELECT domain_id 
										FROM ".OBE_DOMAINS." 
										WHERE domain_name = '".cleanvars($_POST['domain_name'])."'
									");
	if(mysqli_num_rows($queryCheck)>0) { 
		$_SESSION['msg']['status']  = '<div class="alert-box error"><span>Error:</span>Record already exists.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	} else {
        $prgs = implode(",",$_POST['id_prg']);
        $domainData = [
            'domain_status'             => cleanvars($_POST['domain_status'])                   ,
            'domain_name'               => cleanvars($_POST['domain_name'])                     ,
            'id_prg'                    => $prgs                                                ,
            'id_added'                  => cleanvars($_SESSION['LOGINIDA_SSS'])                 ,
            'date_added'                => date('Y-m-d H:i:s')
        ];
        $queryInsert = $dblms->Insert(OBE_DOMAINS, $domainData);
        
        if($queryInsert) {               
            // Set Success MSG in Session & Exit
            $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been added successfully.</div>';
            header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
            exit();
        }
    }
}

if(isset($_POST['submit_changes'])) {
    $prgs = implode(",",$_POST['id_prg']);
    $domainData = [
        'domain_status'             => cleanvars($_POST['domain_status'])                   ,
        'domain_name'               => cleanvars($_POST['domain_name'])                     ,
        'id_prg'                    => $prgs                                                ,
        'id_modify'                 => cleanvars($_SESSION['LOGINIDA_SSS'])                 ,
        'date_modify'               => date('Y-m-d H:i:s')
    ];
    $conditions = "WHERE domain_id  = ".cleanvars($_GET['id'])."";
    $queryUpdate = $dblms->Update(OBE_DOMAINS, $domainData,$conditions);

    if($queryUpdate) {
        //Set Success MSG in Session & Exit
        $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been updated successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
    }
}