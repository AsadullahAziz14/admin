<?php
if(isset($_GET['deleteId'])) {
    $queryDelete  = $dblms->querylms("DELETE FROM ".SMS_SUB_CATEGORY." WHERE id_category = '".cleanvars($_GET['deleteId'])."'");
    $queryDelete  = $dblms->querylms("DELETE FROM ".SMS_CATEGORY." WHERE category_id = '".cleanvars($_GET['deleteId'])."'");

    if($queryDelete) {
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                         => date('Y-m-d H:i:s')                                               ,
            'action'                           => "Delete"                                                          ,
            'affected_table'                   => SMS_CATEGORY.', '.SMS_SUB_CATEGORY                                ,
            'action_detail'                    =>  'category_id: '.cleanvars($_GET['deleteId'])                     ,
            'path'                             =>  end($filePath)                                                   ,
            'login_session_start_time'         => $_SESSION['login_time']                                           ,
            'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']       ,
            'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        $_SESSION['msg']['status'] = '<div class="alert-box danger"><span>Success: </span>Record has been deleted successfully.</div>';
        header("Location: inventory-category.php");
        exit();
    }
}

if(isset($_POST['submit_category'])) { 
    $data = [
        'category_name'                        => cleanvars($_POST['category_name'])                        ,
        'category_description'                 => cleanvars($_POST['category_description'])                 ,
        'category_status'                      => cleanvars($_POST['category_status'])                      ,
        'id_added'                             => cleanvars($_SESSION['LOGINIDA_SSS'])                      ,
        'date_added'                           => date('Y-m-d H:i:s')
    ];
    $queryInsert = $dblms->Insert(SMS_CATEGORY, $data);

    if($queryInsert) {
        $latest_id = $dblms->lastestid();
        $id_category = cleanvars($latest_id);
        $data = [
            'category_code' => 'CAT'.str_pad($id_category, 5, '0', STR_PAD_LEFT)
        ];
        $conditions = "WHERE category_id  = ".$id_category."";
        $queryUpdate = $dblms->Update(SMS_CATEGORY, $data, $conditions);

        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                         => date('Y-m-d H:i:s')                                                               ,
            'action'                           => "Create"                                                                          ,
            'affected_table'                   => SMS_CATEGORY                                                                    ,
            'action_detail'                    =>  'category_id: '.$id_category.
                                                    PHP_EOL.'category_code: '.'CAT'.str_pad($id_category, 5, '0', STR_PAD_LEFT).
                                                    PHP_EOL.'category_name: '.cleanvars($_POST['category_name']).
                                                    PHP_EOL.'category_description: '.cleanvars($_POST['category_description']).
                                                    PHP_EOL.'category_status: '.cleanvars($_POST['category_status']).
                                                    PHP_EOL.'id_added: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                    PHP_EOL.'date_added: '.date('Y-m-d H:i:s')                                      ,
            'path'                             =>  end($filePath)                                                                   ,
            'login_session_start_time'         => $_SESSION['login_time']                                                           ,
            'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']                       ,
            'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been added successfully.</div>';
        header("Location: inventory-category.php", true, 301);
        exit();
    } 
}

if(isset($_POST['edit_category'])){ 
    $data = [
        'category_name'                        => cleanvars($_POST['category_name'])                        ,
        'category_description'                 => cleanvars($_POST['category_description'])                 ,
        'category_status'                      => cleanvars($_POST['category_status'])                      ,
        'id_modify'                            => cleanvars($_SESSION['LOGINIDA_SSS'])         ,
        'date_modify'                          => date('Y-m-d H:i:s')                
    ];
    $conditions = "WHERE category_id = ".cleanvars($_GET['id'])."";
    $queryUpdate = $dblms->Update(SMS_CATEGORY, $data, $conditions);

    if($queryUpdate) {   
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                         => date('Y-m-d H:i:s')                                                               ,
            'action'                           => "Update"                                                                          ,
            'affected_table'                   => SMS_CATEGORY                                                                    ,
            'action_detail'                    =>  'category_id: '.cleanvars($_GET['id']).
                                                    PHP_EOL.'category_name: '.cleanvars($_POST['category_name']).
                                                    PHP_EOL.'category_description: '.cleanvars($_POST['category_description']).
                                                    PHP_EOL.'category_status: '.cleanvars($_POST['category_status']).
                                                    PHP_EOL.'id_modify: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                    PHP_EOL.'date_modify: '.date('Y-m-d H:i:s')                                     ,
            'path'                             =>  end($filePath)                                                                   ,
            'login_session_start_time'         => $_SESSION['login_time']                                                           ,
            'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']                       ,
            'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Record has been updated successfully.</div>';
        header("Location: inventory-category.php", true, 301);
        exit();
    }
}