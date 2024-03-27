
<?php

if(!isset($_GET['add']) && isset($_GET['edit'])) {

    if(($_SESSION['userlogininfo']['LOGINIDA'] == 4) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '189', 'edit' => '1'))) { 

        $queryLeave = $dblms->querylms("SELECT * 
                                                FROM ".SALARY_EMPLYS_LEAVES." l 
                                                INNER JOIN ".SALARY_EMPLYS." e ON l.id_emply = e.emply_id 
                                                INNER JOIN ".DEPTS." d ON d.dept_id = e.id_dept 
                                                INNER JOIN ".SALARY_EMPLYS_LEAVES_CATS." c ON c.cat_id = l.id_cat 
                                                WHERE l.id = ".cleanvars($_GET['id'])." LIMIT 1");
        $valueLeave = mysqli_fetch_array($queryLeave);

        echo '
        <div class="row">
                <div class="modal-dialog" style="width:95%;">
                    <form class="form-horizontal" action="#" method="post" id="addNewRecord" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" onclick="location.href=\'leave_applications.php\'"><span>Close</span></button>
                                <h4 class="modal-title" style="font-weight:700;"> Edit Staff Application Performa </h4>
                            </div>
                            <div class="modal-body" style="height: ;">
                            
                                <div class="col-sm-32">
                                    <label for="">Employee</label>
                                    <select name="employee" id="employees" style="width: 100%;" onchange=get_emplydata()>';
                                        
                                        foreach($emplys as $emply) {
                                            echo '<option value="'.$emply['emply_id'].'"'; if($valueLeave['id_emply'] == $emply['emply_id']) { echo 'selected'; } echo '>'.$emply['emply_name'].'</option>';
                                        }
                                        echo '
                                    </select>
                                </div>

                                <div class="" id="emply_data">
                                    
                                </div>

                                <div class="col-sm-32">
                                    <label for="">Leave Category</label>
                                    <select name="leave_category" id="category" style="width: 100%;" onchange=get_emplyleavedata()>';
                                        foreach($categories as $category) {
                                            echo '<option value="'.$category['cat_id'].'"'; if($valueLeave['cat_name'] == $category['cat_name']) { echo 'selected'; } echo '>'.$category['cat_name'].'</option>';
                                        }
                                        echo '
                                    </select>
                                </div>

                                

                                <div class="col-sm-32">
                                    <label for="">From</label>
                                    <input type="text" name="leave_from" id="from" value="'.$valueLeave['leave_start_date'].'" class="form-control pickadate">
                                </div>

                                <div class="col-sm-32">
                                    <label for="">To</label>
                                    <input type="text" name="leave_to" id="to" value="'.$valueLeave['leave_end_date'].'" class="form-control pickadate">
                                </div>

                                <div class="col-sm-32">
                                    <label for="">Total Allowed (Days)</label>
                                    <input type="text" name="leave_total_allowed" id="allowed" value="'.$valueLeave['cat_leaves_allowed'].'" class="form-control" readonly>
                                </div>

                                <div class="col-sm-32">';
                                    $queryEmplyLeavesAvailed = $dblms->querylms("SELECT leave_applied_for as availed 
                                                                        FROM ".SALARY_EMPLYS_LEAVES." WHERE id_emply = ".$valueLeave['id_emply']." AND id_cat = ".$valueLeave['id_cat']."");
                                    $availed = 0;
                                    while($valueLeavesAvailed = mysqli_fetch_array($queryEmplyLeavesAvailed)) {
                                        $availed = $availed + $valueLeavesAvailed['availed'];
                                    }
                                    echo '
                                    <label for="">Leaves Already Availed (Days)</label>
                                    <input type="text" name="leave_already_availed" id="availed" value="'.$availed.'" class="form-control" readonly>
                                </div>

                                <div class="col-sm-32">
                                    <label for="">Leaves in Balance (Days)</label>
                                    <input type="text" name="leave_in_balance" id="balance" value="'.$valueLeave['cat_leaves_allowed'] - $availed.'" class="form-control" readonly>
                                </div>

                                <div class="col-sm-32">
                                    <label for="">Leave Applied For (Days)</label>
                                    <input type="text" name="leave_applied_for" id="applied_for" value="'.$valueLeave['leave_applied_for'].'" class="form-control" >
                                </div>

                                <div class="form-group">
                                    <label for="" class="col-lg-12"><h3><b>Reason</b></h3></label>
                                    <div class="col-lg-12">
                                        <textarea name="leave_reason" id="" cols="30" rows="20" class="" style="height: 100px;">'.$valueLeave['leave_reason'].'</textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="edit_application" class="btn btn-primary">Edit Performa</button>
                            </div>

                        </div>
                    </div>
                    <input type="hidden" name="lid" id="lid" value="'.$_GET['id'].'">
                </form>
            </div>
        </div>
        <script>
            $( document ).ready(function() {
                get_emplydata();
            });

            function get_emplydata() {
                var val = $("#employees").val();
                
                $.ajax({
                    type : "POST"                                                                       ,
                    url  : "include/Staffs/finance/salary/leave_applications/get_emplydata.php"         ,
                    data : "id="+val+"&lid="+$("#lid").val()                                            ,
                    success : function(data) {
                        $("#emply_data").html(data);
                        console.log(data);
                    }
                });
            }
        </script>';

    }

}

?>

<script>
    $('#to').change(function() {
        var date1 = new Date($('#from').val());
        var date2 = new Date($('#to').val());
        var Difference_In_Time = date2.getTime() - date1.getTime();
        var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
        $('#applied_for').val(Difference_In_Days);
    });
    
</script>
