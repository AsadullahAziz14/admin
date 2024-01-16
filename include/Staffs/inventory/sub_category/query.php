<?php
if(isset($_GET['deleteId'])) {
    $queryDelete  = $dblms->querylms("DELETE FROM ".SMS_SUB_CATEGORIE." WHERE sub_category_id = '".cleanvars($_GET['deleteId'])."'");
    
    if($queryDelete) {
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                         => date('Y-m-d H:i:s')                                           ,
            'action'                           => "Delete"                                                      ,
            'affected_table'                   => SMS_SUB_CATEGORIE                                            ,
            'action_detail'                    =>  'sub_category_id: '.cleanvars($_GET['deleteId'])             ,
            'path'                             =>  end($filePath)                                               ,
            'login_session_start_time'         => $_SESSION['login_time']                                       ,
            'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']   ,
            'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        $_SESSION['msg']['status'] = '<div class="alert-box danger"><span>Success: </span>Record has been deleted successfully.</div>';
        header("Location: inventory-sub_category.php");
        exit();
    }
}

if(isset($_POST['submit_sub_category'])) { 
    $data = [
        'sub_category_name'                        => cleanvars($_POST['sub_category_name'])                        ,
        'sub_category_description'                 => cleanvars($_POST['sub_category_description'])                 ,
        'sub_category_status'                      => cleanvars($_POST['sub_category_status'])                      ,
        'id_category'                              => cleanvars($_POST['id_category'])                              ,
        'id_added'                                 => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])             ,
        'date_added'                               => date('Y-m-d H:i:s')
    ];
    $queryInsert = $dblms->Insert(SMS_SUB_CATEGORIE, $data);
    $latest_id = $dblms->lastestid();
    
    if($queryInsert) {
        $data = [
            'sub_category_code' => 'SUB-CAT-'.str_pad(cleanvars($latest_id), 5, '0', STR_PAD_LEFT)
        ];
        
        $conditions = "WHERE sub_category_id  = ".cleanvars($latest_id)."";
        $queryUpdate = $dblms->Update(SMS_SUB_CATEGORIE, $data, $conditions);

        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Create"
            ,'affected_table'                   => SMS_SUB_CATEGORIE
            ,'action_detail'                    =>  'sub_category_id: '.cleanvars($latest_id).
                                                    PHP_EOL.'sub_category_code: '.'SUB-CAT-' .str_pad(cleanvars($latest_id), 5, '0', STR_PAD_LEFT).
                                                    PHP_EOL.'sub_category_name: '.cleanvars($_POST['sub_category_name']).
                                                    PHP_EOL.'sub_category_description: '.cleanvars($_POST['sub_category_description']).
                                                    PHP_EOL.'sub_category_status: '.cleanvars($_POST['sub_category_status']).
                                                    PHP_EOL.'id_category: '.cleanvars($_POST['id_category']).
                                                    PHP_EOL.'id_added: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                    PHP_EOL.'date_added: '.date('Y-m-d H:i:s')
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been added successfully.</div>';
        header("Location: inventory-sub_category.php", true, 301);
        exit(); 
    }
}

if(isset($_POST['edit_sub_category'])) {    
    $data = [
        'sub_category_name'                        => cleanvars($_POST['sub_category_name'])                ,
        'sub_category_description'                 => cleanvars($_POST['sub_category_description'])         ,
        'sub_category_status'                      => cleanvars($_POST['sub_category_status'])              ,
        'id_category'                              => cleanvars($_POST['id_category'])                      ,
        'id_modify'                                => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])     ,
        'date_modify'                              => date('Y-m-d H:i:s')
    ];
    $conditions = "WHERE  sub_category_id  = ".cleanvars($_GET['id'])."";
    $queryUpdate = $dblms->Update(SMS_SUB_CATEGORIE, $data, $conditions);

    if($queryUpdate) { 
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Update"
            ,'affected_table'                   => SMS_SUB_CATEGORIE
            ,'action_detail'                    =>  'sub_category_id: '.cleanvars($_GET['id']).
                                                    PHP_EOL.'sub_category_name: '.cleanvars($_POST['sub_category_name']).
                                                    PHP_EOL.'sub_category_description: '.cleanvars($_POST['sub_category_description']).
                                                    PHP_EOL.'sub_category_status: '.cleanvars($_POST['sub_category_status']).
                                                    PHP_EOL.'id_category: '.cleanvars($_POST['id_category']).
                                                    PHP_EOL.'id_modify: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                    PHP_EOL.'date_modify: '.date('Y-m-d H:i:s')
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Record has been updated successfully.</div>';
        header("Location: inventory-sub_category.php", true, 301);
        exit();
    }
}