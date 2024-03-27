<?php
//Update Multiple Course Registration Records
if(isset($_POST['multiple_submit'])) { 
	
    if($_POST['multiple_submit'] == 'approved_all') {
        
        $confirmstatus = 2;
        
    } elseif($_POST['multiple_submit'] == 'rejected_all') {
        
        $confirmstatus = 3;
        
    }
        
    for($i=0;$i<count($_POST['cur_update']);$i++) {

        $registrationID = cleanvars($_POST['cur_update'][$i]);
    
        $data = array(
            'confirm_status'	=>  cleanvars($confirmstatus)							, 
            'confirm_date'		=> date("Y-m-d H:i:s")									, 
            'id_confirm'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])	, 
        );
    
        $sqllmsUpdate = $dblms->Update(LA_STUDENT_REGISTRATION_DETAIL, $data, " WHERE id = '".$registrationID."'");
                    
        $detailPrams  = "";
        $detailPrams .= '"ID"		'.'=> '.'"'.$registrationID.'",'."\n";
        $detailPrams .= '"Status"	'.'=> '.'"'.$confirmstatus.'"'."\n";
    
        //Query Insert Log
        $logRemarks = 'Updated Course Registeration Detail ID: '.$registrationID;
        $sqllmsLog  = $dblms->querylms("INSERT INTO ".LA_LOGFILE." (
                                                            id_user										, 
                                                            filename									, 
                                                            id_record									, 
                                                            action										,
                                                            dated										,
                                                            ip											,
                                                            remarks										,
                                                            details										,
                                                            sess_id										,
                                                            device_details								,
                                                            id_campus				
                                                        )
        
                                                    VALUES(
                                                            '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	,
                                                            '".basename($_SERVER['REQUEST_URI'])."'		, 
                                                            '".$registrationID."'						, 
                                                            '2'											, 
                                                            NOW()										,
                                                            '".$ip.':'.$_SERVER['REMOTE_PORT']."'		,
                                                            '".cleanvars($logRemarks)."'				,
                                                            '".cleanvars($detailPrams)."'				,
                                                            '".cleanvars(session_id())."'				,
                                                            '".cleanvars($devicedetails)."'				,
                                                            '".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'
                                                        )
                                    ");				
    }
        
        
    if($sqllmsUpdate) { 	
    
        //Set Success MSG in Session & Exit
        $_SESSION['msg']['status']  = '<div class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
        header("Location: laadvisees.php?std_id=".cleanvars($_GET['std_id'])."", true, 301);
        exit();

    }
}