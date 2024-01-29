    <?php

if(isset($_GET['deleteId'])) {
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_REQUISITION_DEMAND_ITEM_JUNCTION." WHERE id_requisition = '".cleanvars($_GET['deleteId'])."'");
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_REQUISITION." WHERE requisition_id  = '".cleanvars($_GET['deleteId'])."'");

    if($sqllms) {
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                         => date('Y-m-d H:i:s')                                           ,
            'action'                           => "Delete"                                                      ,
            'affected_table'                   => SMS_REQUISITION_DEMAND_ITEM_JUNCTION.', '.SMS_REQUISITION     ,
            'action_detail'                    => 'requisition_id: '.cleanvars($_GET['deleteId'])               ,
            'path'                             =>  end($filePath)                                               ,
            'login_session_start_time'         => $_SESSION['login_time']                                       ,
            'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']   ,
            'id_user'                          => cleanvars(cleanvars($_SESSION['LOGINIDA_SSS']))
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);
    }
    $_SESSION['msg']['status'] = '<div class="alert-box danger"><span>Success: </span>Record has been deleted successfully.</div>';
    header("Location: inventory-requisition.php");
    exit();
}

if(isset($_POST['submit_requisition'])) {
    $data = [
        'requisition_date'                          => date('Y-m-d H:i:s')                                      ,
        'requisition_type'                          => cleanvars($_POST['requisition_type'])                    ,
        'requisition_purpose'                       => cleanvars($_POST['requisition_purpose'])                 ,
        'requisition_remarks'                       => cleanvars($_POST['requisition_remarks'])                 ,
        'requisition_status'                        => 1                                                        ,
        'id_department'                             => cleanvars($_POST['id_department'])                       ,
        'id_requester'                              => cleanvars(cleanvars($_SESSION['LOGINIDA_SSS']))        ,
        'id_added'                                  => cleanvars(cleanvars($_SESSION['LOGINIDA_SSS']))        ,
        'date_added'                                => date('Y-m-d H:i:s')
    ];
    $queryInsert = $dblms->Insert(SMS_REQUISITION, $data);
 
    if($queryInsert) {
        $id_requisition = $dblms->lastestid();
         
        $data = [
            'requisition_code'                       => 'REQ'.str_pad($id_requisition, 5, '0', STR_PAD_LEFT)
        ];
        $conditions = "WHERE requisition_id  = ".$id_requisition."";
        $queryUpdate = $dblms->Update(SMS_REQUISITION, $data, $conditions);

        foreach (cleanvars($_POST['id_item']) as $id_demand => $id_itemArray) {
            $queryDemand = $dblms->querylms("SELECT demand_id, demand_code
                                                FROM ".SMS_DEMAND."
                                                Where demand_code = '".$id_demand."'
                                            ");
            $valueDemand = mysqli_fetch_array($queryDemand);
            foreach ($id_itemArray as $id_item => $itemTitle) {
                $data = [
                    'id_requisition'                => $id_requisition                                      ,
                    'id_demand'                     => $valueDemand['demand_id']                            ,
                    'id_item'                       => $id_item                                             ,
                    'quantity_requested'            => $_POST['quantity_requested'][$id_demand][$id_item]   ,
                ];
                $queryInsert = $dblms->Insert(SMS_REQUISITION_DEMAND_ITEM_JUNCTION, $data);
            }
        }
	}
    $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been added successfully.</div>';
    header("Location: inventory-requisition.php", true, 301);
    exit();
}

if(isset($_POST['update_requisition'])) {
    $id_requisition = cleanvars($_GET['id']);

    $data = [
        'requisition_type'                          => cleanvars($_POST['requisition_type'])                    ,
        'requisition_purpose'                       => cleanvars($_POST['requisition_purpose'])                 ,
        'requisition_remarks'                       => cleanvars($_POST['requisition_remarks'])                 ,
        'requisition_status'                        => cleanvars($_POST['requisition_status'])                  ,
        'id_location'                               => cleanvars($_POST['id_location'])                         ,
        'id_department'                             => cleanvars($_POST['id_department'])                       ,
        'id_modify'                                 => cleanvars(cleanvars($_SESSION['LOGINIDA_SSS']))        ,
        'date_modify'                               => date('Y-m-d H:i:s')
    ];
    $conditions = "WHERE  requisition_id  = ".$id_requisition."";
    $queryUpdate = $dblms->Update(SMS_REQUISITION, $data, $conditions);

    if($queryUpdate) {
        foreach (cleanvars($_POST['id_item']) as $key => $id_itemArray) {
            if($key == "u") {
                foreach ($id_itemArray as $id_demand => $id_itemArray) {
                    foreach ($id_itemArray as $id_item => $item_title) {
                        $data = [
                            'quantity_requested'             => $_POST['quantity_requested'][$id_demand][$id_item]     ,
                        ];
                        $conditions = "Where id_requisition = ".$id_requisition." AND id_demand = ".$id_demand." AND id_item = ".$id_item."";
                        $queryUpdate = $dblms->Update(SMS_REQUISITION_DEMAND_ITEM_JUNCTION, $data, $conditions);
                    }   
                }
            } else {
                $id_demand = $key;
                foreach ($id_itemArray as $id_item => $itemTitle) {
                    $data = [
                        'id_requisition'                    => $id_requisition                              ,
                        'id_demand'                         => $id_demand                                   ,
                        'id_item'                           => $id_item                                     ,
                        'quantity_requested'                => $_POST['quantity_requested'][$id_demand][$id_item]
                    ];
                    $queryInsert = $dblms->Insert(SMS_REQUISITION_DEMAND_ITEM_JUNCTION , $data);   
                }
            } 
        }
    }
    $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Record has been updated successfully.</div>';
    header("Location: inventory-requisition.php", true, 301);
    exit();
}

if(isset($_POST["forward_requisition"])) {
    $data = [
        'forwarded_to'      => $_POST['forwarded_to']              ,
        'forwarded_by'      => $_SESSION['LOGINIDA_SSS']           ,
        'date_forwarded'    => date('Y-m-d H:i:s')
    ];
    $conditions = " Where requisition_id = ".$_POST['requisition_id']."";
    $queryUpdate = $dblms->Update(SMS_REQUISITION, $data, $conditions);

    $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Forwarded successfully.</div>';
    header("Location: inventory-requisition.php", true, 301);
    exit();
}

if(isset($_POST["approve_requisition"])) {
    $data = [
        'id_approved_rejected'          => cleanvars(cleanvars($_SESSION['LOGINIDA_SSS']))                    ,
        'requisition_status'            => 3                                                                ,
        'date_approved_rejected'        => date('Y-m-d H:i:s')
    ];
    $conditions = " Where requisition_id = ".$_POST['requisition_id']."";
    $queryUpdate = $dblms->Update(SMS_PO, $data, $conditions);

    $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Forwarded successfully.</div>';
    header("Location: inventory-purchase_order.php", true, 301);
    exit();
}

if(isset($_POST["reject_requisition"])) {
    $data = [
        'id_approved_rejected'          => cleanvars(cleanvars($_SESSION['LOGINIDA_SSS']))            ,
        'requisition_status'            => 4                                                            ,
        'date_approved_rejected'        => date('Y-m-d H:i:s')
    ];
    $conditions = " Where requisition_id = ".$_POST['requisition_id']."";
    $queryUpdate = $dblms->Update(SMS_PO, $data, $conditions);

    $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Forwarded successfully.</div>';
    header("Location: inventory-purchase_order.php", true, 301);
    exit();
}
