<?php
if(LMS_VIEW == 'forward_requisition') {
    $queryRequisition = $dblms->querylms("SELECT requisition_id, requisition_status, requisition_code, requisition_date, 
                                                id_requester, forwarded_by, forwarded_to, date_forwarded
                                            FROM ".SMS_REQUISITION." 
                                            WHERE requisition_id != ''
                                            $sql2
                                        ");
    include ("include/page_title.php"); 
    echo'         
    <div class="table-responsive" style="overflow: auto;">
        <table class="footable table table-bordered table-hover table-with-avatar">
            <thead>
                <tr>
                    <th style="vertical-align: middle;" nowrap="nowrap"> Sr.# </th>
                    <th style="vertical-align: middle;" nowrap="nowrap"> Requisition Code </th>
                    <th style="vertical-align: middle;" nowrap="nowrap"> Requisition Date </th>
                    <th style="vertical-align: middle;" nowrap="nowrap"> Forward By </th>
                    <th style="vertical-align: middle;" nowrap="nowrap"> Date Forwarded </th>
                    <th style="vertical-align: middle;" nowrap="nowrap"> Forward To </th>
                    <th style="width:70px; text-align:center; font-size:14px;" nowrap="nowrap"><i class="icon-reorder"></i> </th>
                </tr>
            </thead>
            <tbody>';
                $srno = 0;
                while($valueRequisition = mysqli_fetch_array($queryRequisition)) {
                    $srno++;
                    echo '
                    <tr>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.$valueRequisition['requisition_code'].'</td>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valueRequisition['requisition_date'])).'</td>';
                        if($valueRequisition['forwarded_by'] != NULL) {
                            $queryEmployee = $dblms->querylms("SELECT emply_name
                                                        FROM ".EMPLOYEES."
                                                        WHERE emply_id = ".$valueRequisition['forwarded_by']."
                                                        $sql2
                                                    ");
                            $valueEmployee = mysqli_fetch_array($queryEmployee);
                            echo '<td style="vertical-align: middle;" nowrap="nowrap">'.$valueEmployee['emply_name'].'</td>';
                        } else {
                            echo '<td style="vertical-align: middle;" nowrap="nowrap"></td>';
                        }

                        if($valueRequisition['date_forwarded'] != NULL) {
                            echo '<td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valueRequisition['date_forwarded'])).'</td>';
                        } else {
                            echo '<td style="vertical-align: middle;" nowrap="nowrap"></td>';
                        }
                        echo '
                        <td style="vertical-align: middle;" nowrap="nowrap">';
                            if($valueRequisition['forwarded_to'] == NULL) {
                                echo'
                                <div class="">
                                    <div class="form-sep" style=" width: 100%">
                                        <form class="form-horizontal" action="inventory-requisition.php" method="POST" enctype="multipart/form-data">
                                            <input class="form-control" type="hidden" value="'.$valueRequisition['requisition_id'].'" id="requisition_id" name="requisition_id" readonly>
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
                                            <input class="btn btn-primary" style="float: right;" type="submit" value="Forward" id="forward_requisition" name="forward_requisition">
                                        </form>
                                    </div>
                                </div>
                            ';
                            } else {
                                $queryAdmin = $dblms->querylms("SELECT adm_id,adm_fullname
                                                                    FROM ".ADMINS."
                                                                    WHERE adm_id IN (".$valueRequisition['forwarded_to'].")
                                                                    $sql2
                                                                ");
                                $valueAdmin = mysqli_fetch_array($queryAdmin);
                                echo ''.$valueAdmin['adm_fullname'].'';
                            }
                            echo '
                        </td>
                        <!-- <td nowrap="nowrap" style="text-align:center;">
                            <a class="btn btn-xs btn-info" href="inventory_print.php?print=requisition&id='.$valueRequisition['requisition_id'].'"><i class="icon-print"></i></a>
                        </td> -->
                    </tr>
                    ';
                }
                echo '
            </tbody>
        </table>
    </div>  
    '; 
}