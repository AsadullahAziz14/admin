<?php

if($view == 'delete') {
	if(isset($_GET['id'])) { 

        $queryDelete  = $dblms->querylms("DELETE FROM ".OBE_DOMAINS." WHERE domain_level_id = '".cleanvars($_GET['id'])."'");

        $_SESSION['msg']['status']  = '<div class="alert-box error"><span>Success: </span>Record has been deleted successfully.</div>';
        header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
        exit();
	}
}


if(isset($_POST['submit_domain_level'])) 
{
    $queryCheck = $dblms->querylms("SELECT domain_level_id 
										FROM ".OBE_DOMAINS." 
										WHERE domain_name_code = '".cleanvars($_POST['domain_name_code'])."'
										AND domain_level_name = '".cleanvars($_POST['domain_level_name'])."'
										AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' LIMIT 1");
	if(mysqli_num_rows($queryCheck)>0) 
    { 
		$_SESSION['msg']['status']  = '<div class="alert-box error"><span>Error:</span>Record already exists.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	}
    else
    {
        $queryDomainLevel = $dblms->querylms("SELECT max(domain_level_number) as last_domain_level_number
                                            FROM ".OBE_DOMAINS." 
                                            WHERE domain_name_code = '".cleanvars($_POST['domain_name_code'])."'
                                            LIMIT 1");
        $valuequeryDomainLevel = mysqli_fetch_array($queryDomainLevel);

        if(count($valuequeryDomainLevel) > 0)
        {
            if(cleanvars($_POST['domain_name_code']) == 1)
            {
                $domain_level_number = ($valuequeryDomainLevel['last_domain_level_number'] + 1);
                $domain_level_code = 'C'.($valuequeryDomainLevel['last_domain_level_number'] + 1);
            } elseif (cleanvars($_POST['domain_name_code']) == 2) {
                $domain_level_number = ($valuequeryDomainLevel['last_domain_level_number'] + 1);
                $domain_level_code = 'P'.($valuequeryDomainLevel['last_domain_level_number'] + 1);
            } elseif (cleanvars($_POST['domain_name_code']) == 3) {
                $domain_level_number = ($valuequeryDomainLevel['last_domain_level_number'] + 1);
                $domain_level_code = 'A'.($valuequeryDomainLevel['last_domain_level_number'] + 1);
            }
        }
        echo $valuequeryDomainLevel['last_domain_level_number'];

        $domainLevelData = [
            'domain_level_status'       => cleanvars($_POST['domain_level_status'])         ,
            'domain_name_code'          => cleanvars($_POST['domain_name_code'])            ,
            'domain_level_number'       => $domain_level_number                             ,
            'domain_level_name'         => cleanvars($_POST['domain_level_name'])           ,
            'domain_level_code'         => $domain_level_code                               ,
            'id_campus'                 => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])                                        ,
            'id_added'                  => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])                          ,
            'date_added'                => date('Y-m-d H:i:s')
        ];
        $queryInsert = $dblms->Insert(OBE_DOMAINS , $domainLevelData);
        
        if($queryInsert) 
        {               
            // Set Success MSG in Session & Exit
            $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been added successfully.</div>';
            header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
            exit();
        }
    }
}

if(isset($_POST['submit_changes'])) 
{
    $domainLevelData = [
        'domain_level_status'       => cleanvars($_POST['domain_level_status_edit'])        ,
        'domain_name_code'          => cleanvars($_POST['domain_name_code_edit'])           ,
        'domain_level_name'         => cleanvars($_POST['domain_level_name_edit'])          ,
        'id_modify'                 => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])                              ,
        'date_modify'               => date('Y-m-d H:i:s')
    ];
    $conditions = "WHERE  domain_level_id  = ".cleanvars($_POST['domain_level_id_edit'])."";
    $queryUpdate = $dblms->Update(OBE_DOMAINS, $domainLevelData,$conditions);

    if($queryUpdate) 
    {
        //Set Success MSG in Session & Exit
        $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been updated successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
    }

}