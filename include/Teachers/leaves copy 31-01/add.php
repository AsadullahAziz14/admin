
<?php

if(isset($_GET['add'])) {

    if(($_SESSION['userlogininfo']['LOGINIDA'] == 4) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '189', 'add' => '1'))) { 

        echo '
        <div class="row">
            <div class="modal-dialog" style="width:95%;">
                <form class="form-horizontal" action="#" method="post" id="addNewRecord" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" onclick="location.href=\'salaryleaves.php\'"><span>Close</span></button>
                            <h4 class="modal-title" style="font-weight:700;"> Add Staff Application Performa </h4>
                        </div>
                        <div class="modal-body">

                            <div class="col-sm-32">
                                <div class="form-sep">
                                    <label class="req">Employee</label>
                                    <select name="employee" id="employees" style="width: 100%;" onchange=get_emplydata() required>
                                        <option value=""></option>';                                        
                                        foreach($emplys as $emply) {
                                            echo '
                                            <option value="'.$emply['emply_id'].'">'.$emply['emply_name'].' ('.$emply['designation_name'].')</option>';
                                        }
                                        echo '
                                    </select>
                                </div>
                            </div>

                            <div id="emply_data"></div>

                            <div class="col-sm-32">
                                <div class="form-sep">
                                    <label class="req">Leave Category</label>
                                    <select name="leave_category" id="category" style="width: 100%;" onchange=get_emplyleavedata() required>
                                        <option value=""></option>';
                                        foreach($categories as $category) {
                                            echo '<option value="'.$category['cat_id'].'">'.$category['cat_name'].'</option>';
                                        }
                                        echo '
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-32">
                                <div class="form-sep">
                                    <label class="req">From</label>
                                    <input type="text" name="leave_from" id="from" class="pickadate form-control" required autocomplete="off">
                                </div>
                            </div>

                            <div class="col-sm-32">
                                <div class="form-sep">
                                    <label class="req">To</label>
                                    <input type="text" name="leave_to" id="to" class="pickadate form-control" required autocomplete="off">
                                </div>
                            </div>

                            <div style="clear:both;padding-bottom:5px;"></div>
                            
                            <div class="col-sm-32">
                                <div class="form-sep">
                                    <label for="">Total Allowed (Days)</label>
                                    <input type="text" name="leave_total_allowed" id="allowed" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-sm-32">
                                <div class="form-sep">
                                    <label for="">Leaves Already Availed (Days)</label>
                                    <input type="text" name="leave_already_availed" id="availed" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-sm-32">
                                <div class="form-sep">
                                    <label for="">Leaves in Balance (Days)</label>
                                    <input type="text" name="leave_in_balance" id="balance" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-sm-32">
                                <div class="form-sep">
                                    <label for="">Leave Applied For (Days)</label>
                                    <input type="text" name="leave_applied_for" id="applied_for" class="form-control" readonly>
                                </div>
                            </div>

                            <div style="clear:both;padding-bottom:5px;"></div>

                            <div class="form-group">
                                <label class="col-lg-12 req"><b>Reason</b></label>
                                <div class="col-lg-12">
                                    <textarea  id="leave_reason" name="leave_reason" style="height: 100px;" required></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
							<button type="submit" name="submit_application" class="btn btn-primary">Add Leave</button>
						</div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            function get_emplydata() {
                var val = $("#employees").val();
                
                $.ajax({
                    type : "POST"                                                                       ,
                    url  : "include/Staffs/finance/salary/leaves/get_emplydata.php"       ,
                    data : "id="+val                                                                    ,
                    success : function(data) {
                        $("#emply_data").html(data);
                        console.log(data);
                    }
                });
            }
        </script>
        <script type="text/javascript">
            $().ready(function() {
                $("#addNewRecord").validate({
                    rules: {
                            employees		: "required"
                        },
                messages: {
                            employees		: "This field is required"
                        },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            });
        </script>';
        
    }

}

?>
