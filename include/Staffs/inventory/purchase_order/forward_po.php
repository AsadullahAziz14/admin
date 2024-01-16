<?php
if(LMS_VIEW == 'forward_po') {
    $queryPO = $dblms->querylms("SELECT po_id, po_status, po_code, po_date, po_delivery_date, 
                                        ordered_by, date_ordered, forwarded_by, forwarded_to, date_forwarded
                                        FROM ".SMS_PO." 
                                        WHERE po_id != ''
                                        $sql2
                                        ");
    include ("include/page_title.php"); 
    echo'         
    <div class="table-responsive" style="overflow: auto;">
    <table class="footable table table-bordered table-hover table-with-avatar">
        <thead>
            <tr>
                <th style="vertical-align: middle;" nowrap="nowrap"> Sr.# </th>
                <th style="vertical-align: middle;" nowrap="nowrap"> PO Code </th>
                <th style="vertical-align: middle;" nowrap="nowrap"> PO Date </th>
                <th style="vertical-align: middle;" nowrap="nowrap"> Delivery Date </th>
                <th style="vertical-align: middle;" nowrap="nowrap"> Ordered By </th>
                <th style="vertical-align: middle;" nowrap="nowrap"> Date Ordered </th>
                <th style="vertical-align: middle;" nowrap="nowrap"> Forward By </th>
                <th style="vertical-align: middle;" nowrap="nowrap"> Date Forwarded </th>
                <th style="vertical-align: middle;" nowrap="nowrap"> Forward To </th>
                <th style="width:70px; text-align:center; font-size:14px;" nowrap="nowrap"><i class="icon-reorder" ></i> </th>
            </tr>
        </thead>
        <tbody>';
            $srno = 0;
            while($valuePO = mysqli_fetch_array($queryPO)) {
                $srno++;
                echo '
                <tr>
                    <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
                    <td style="vertical-align: middle;" nowrap="nowrap">'.$valuePO['po_code'].'</td>
                    <td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valuePO['po_date'])).'</td>
                    <td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valuePO['po_delivery_date'])).'</td>';
                    $emp_sqllms = $dblms->querylms("SELECT emply_name
                                                FROM ".EMPLOYEES."
                                                WHERE emply_id = ".$valuePO['ordered_by']."
                                                $sql2
                                            ");
                    $value_emp = mysqli_fetch_array($emp_sqllms);
                    echo '
                    <td style="vertical-align: middle;" nowrap="nowrap">'.$value_emp['emply_name'].'</td>
                    <td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valuePO['date_ordered'])).'</td>
                    ';
                    if($valuePO['forwarded_by'] != NULL) {
                        $emp_sqllms = $dblms->querylms("SELECT emply_name
                                                    FROM ".EMPLOYEES."
                                                    WHERE emply_id = ".$valuePO['forwarded_by']."
                                                    $sql2
                                                ");
                        $emp_sqllms = mysqli_fetch_array($emp_sqllms);
                        echo '<td style="vertical-align: middle;" nowrap="nowrap">'.$value_emp['emply_name'].'</td>';
                    } else {
                        echo '<td style="vertical-align: middle;" nowrap="nowrap"></td>';
                    }

                    if($valuePO['date_forwarded'] != NULL) {
                        echo '<td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valuePO['date_forwarded'])).'</td>';
                    } else {
                        echo '<td style="vertical-align: middle;" nowrap="nowrap"></td>';
                    }
                    echo '
                    <td style="vertical-align: middle;" nowrap="nowrap">';
                        if($valuePO['forwarded_to'] == NULL) {
                            echo'
                            <div class="">
                                <div class="form-sep" style=" width: 100%">
                                    <form class="form-horizontal" action="inventory-purchase_order.php" method="POST" enctype="multipart/form-data">
                                        <input class="form-control" type="hidden" value="'.$valuePO['po_id'].'" id="po_id" name="po_id" readonly>
                                        <select class="form-control col-sm-70" name="forwarded_to" id="forwarded_to">
                                            <option value="">Select</option>';
                                            $queryAdmin = $dblms->querylms("SELECT adm_id,adm_fullname
                                                                            FROM ".ADMINS."
                                                                            WHERE adm_id IN (1,2,3,4,5)
                                                                            $sql2
                                                                        ");
                                            while($valueAdmin = mysqli_fetch_array($queryAdmin)) {
                                                echo '<option value="'.$valueAdmin['adm_id'].'">'.$valueAdmin['adm_fullname'].'</option> ';
                                            }
                                            echo '
                                        </select>
                                        <input class="btn btn-primary" style="float: right;" type="submit" value="Forward" id="forward_po" name="forward_po">
                                    </form>
                                </div>
                            </div>
                        ';
                        } else {
                            $queryAdmin = $dblms->querylms("SELECT adm_id,adm_fullname
                                                                FROM ".ADMINS."
                                                                WHERE adm_id IN (".$valuePO['forwarded_to'].")
                                                                $sql2
                                                            ");
                            $valueAdmin = mysqli_fetch_array($queryAdmin);
                            echo ''.$valueAdmin['adm_fullname'].'';
                        }
                        echo '
                    </td>
                    <td nowrap="nowrap" style="text-align:center;">
                        <a class="btn btn-xs btn-info" href="inventory_print.php?print=po&id='.$valuePO['po_id'].'"><i class="icon-print"></i></a>
                    </td>
                </tr>
                ';
            }
            echo '
        </tbody>
    </table>
    </div>  
    '; 
}