<?php  
if(LMS_VIEW == 'forward' && isset($_GET['id'])) { 

    if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '190')) { 

        $sqllmsEdit  = $dblms->querylms("SELECT sa.*, std.std_id, std.std_name, std.std_regno, std.std_photo, std.std_session, std.std_semester, std.std_timing, prg.id_cat
                                                FROM ".DSA_APPLICATIONS." sa
                                                INNER JOIN ".STUDENTS." std ON std.std_id = sa.id_std
                                                INNER JOIN ".PROGRAMS." prg ON prg.prg_id = std.id_prg
                                                WHERE sa.id = '".cleanvars($_GET['id'])."'
                                                AND sa.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                                AND sa.is_deleted != '1'
                                                LIMIT 1");
        $valueEdit = mysqli_fetch_array($sqllmsEdit);

        $completePartialTranscript = '';
        if($valueEdit['degree_transcript'] == 1){
            if($valueEdit['complete_partial'] == 1){
                $completePartialTranscript = 'Final ';
            } elseif($valueEdit['complete_partial'] == 2){
                $completePartialTranscript = 'Partial ';
            }
        }

        if(isset($_SERVER['HTTP_REFERER'])){
            $redirectURL = $_SERVER['HTTP_REFERER'];
        } else{
            $redirectURL = 'dsadegreetranscript.php';
        }

        echo '
        <!--WI_ADD_NEW_TASK_MODAL-->
        <div class="row">
        <div class="modal-dialog" style="width:90%;">
        <form class="form-horizontal" action="#" method="post" id="editStudentInternshipDetail" enctype="multipart/form-data">
        <input type="hidden" name="id_edit" value="'.$valueEdit['id'].'">
        <input type="hidden" name="reference_no" value="'.$valueEdit['reference_no'].'">
        <input type="hidden" name="redirect_url" value="'.$redirectURL.'">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" onclick="location.href=\'dsadegreetranscript.php\'"><span>Close</span></button>
            <h4 class="modal-title" style="font-weight:700;">Forward Student Degree/Transcript Application</h4>
        </div>

        <div class="modal-body">

            <div class="col-sm-41">
                <div class="form_sep">
                    <label>Student Registration #</label>
                    <input type="text" class="form-control" id="stdregno_edit" name="stdregno_edit" autocomplete="off" value="'.$valueEdit['std_regno'].'" readonly>
                </div> 
            </div>
            
            <div class="col-sm-41">
                <div class="form_sep">
                    <label>Student Name</label>
                    <input type="text" class="form-control" id="stdname_edit" name="stdname_edit" autocomplete="off" value="'.$valueEdit['full_name'].'" readonly>
                </div> 
            </div>

            <div class="col-sm-35">
                <div class="form_sep">
                    <label>Semester</label>
                    <input type="text" class="form-control" id="semester_edit" name="semester_edit" autocomplete="off" value="'.$valueEdit['std_semester'].'" readonly>
                </div> 
            </div>

            <div class="col-sm-35">
                <div class="form_sep">
                    <label>Timing</label>
                    <input type="text" class="form-control" id="semester_edit" name="semester_edit" autocomplete="off" value="'.get_programtiming($valueEdit['std_timing']).'" readonly>
                </div> 
            </div>

            <div style="clear:both;padding:5px;"></div>

            <div class="col-sm-41">
                <div class="form_sep">
                    <label class="req">Application For</label>
                    <select id="degree_transcript" name="degree_transcript" style="width:100%" autocomplete="off" required disabled>
                        <option value="">Select Option</option>';
                        $i = 0;
                        foreach($stdaffairstypes as $degreeTranscript){
                            echo '<option value="'.$degreeTranscript['id'].'"'; if($degreeTranscript['id'] == $valueEdit['degree_transcript']){echo ' selected';} echo '>'.$degreeTranscript['name'].'</option>';
                            $i++;
                            if($i == 2) break;
                        }
                    echo'
                    </select>
                </div> 
            </div>

            <div class="col-sm-41">
                <div class="form_sep">
                    <label class="req">Normal/Urgent</label>
                    <select id="normal_urgent1" name="normal_urgent" style="width:100%" autocomplete="off" required disabled>
                        <option value="">Select Option</option>';
                        foreach($regularUrgentArray as $regularUrgent){
                            echo '<option value="'.$regularUrgent['id'].'"'; if($regularUrgent['id'] == $valueEdit['normal_urgent']){echo ' selected';} echo '>'.$regularUrgent['name'].'</option>';
                        }
                    echo'
                    </select>
                </div> 
            </div>

            <div class="col-sm-41">
                <div class="form_sep">
                    <label class="req">Original/Duplicate</label>
                    <select id="original_duplicate1" name="original_duplicate" style="width:100%" autocomplete="off" required disabled>
                        <option value="">Select Option</option>';
                        foreach ($originalDuplicateArray as $originalDuplicate)  {
                            echo '<option value="'.$originalDuplicate['id'].'"'; if($originalDuplicate['id'] == $valueEdit['original_duplicate']){echo ' selected';} echo '>'.$originalDuplicate['name'].'</option>';
                        }
                    echo'
                    </select>
                </div> 
            </div>';

            if($valueEdit['degree_transcript'] == 1){

                echo '
                <div style="clear:both; padding-bottom:5px;"></div>
                <div class="col-sm-61">
                    <div class="form_sep">
                        <!-- 13-03-2024 Start -->
                        <label class="req">Incomplete/Final</label>
                        <!-- 13-03-2024 End -->
                        <input type="text" class="form-control" id="cp_edit" name="cp_edit" autocomplete="off" value="'.$completePartialTranscript.'" readonly>
                    </div> 
                </div>
                
                <div class="col-sm-61">
                    <div class="form_sep">
                        <label class="req">Till Semester(s)</label>
                        <input type="text" class="form-control" id="till_semester_edit" name="till_semester_edit" autocomplete="off" value="'.addOrdinalNumberSuffix($valueEdit['till_semester']).'" readonly>
                    </div> 
                </div>';
            }

            echo '    
            <div style="clear:both; padding-bottom:5px;"></div>';

            $valueForward['id_added'] = 0;

            $sqllmsForward  = $dblms->querylms("SELECT af.remarks, af.forwaded_to, af.id_added, af.attachment, af.date_added, ad.adm_fullname, ad.adm_username
                                                    FROM ".DSA_APPLICATIONS_FORWARD." af
                                                    INNER JOIN ".ADMINS." ad ON ad.adm_id = af.id_added
                                                    WHERE af.id_application = '".cleanvars($_GET['id'])."'
                                                    ORDER BY af.id DESC
                                                    LIMIT 1");
            if(mysqli_num_rows($sqllmsForward) > 0){

                $valueForward = mysqli_fetch_array($sqllmsForward);

                //<span style="float:right;">Attachment <br><a class="btn btn-sm btn-warning" href="https://admission.mul.edu.pk/documents/Spring-2023/MUL-54436_Intermediate.jpg" target="_blank"><i class="icon-eye-open"></i></a></span>

                echo '<div class="col-lg-12 heading-modal bg-info" style="margin-top:5px; margin-bottom:5px; color:#fff;""> Last Remarks</div>
                    <div style="clear:both;"></div>
                    <div style="font-weight:600;margin-bottom:0px;">From: <span style="font-weight:normal;">'.$valueForward['adm_fullname'].' ('.$valueForward['adm_username'].')</span></div>
                    <div style="font-weight:600;margin-bottom:0px;">To: <span style="font-weight:normal;">';

                    $queryForwadedAdmins = $dblms->querylms("SELECT adm.adm_fullname, adm.adm_email, adm.adm_username
                                                                FROM ".ADMINS." adm
                                                                WHERE adm.adm_id IN (".$valueForward['forwaded_to'].")
                                                                ORDER BY adm.adm_id ASC");
                    while($valueAdmin = mysqli_fetch_array($queryForwadedAdmins)){

                        echo '<span style="font-weight:normal;">'.$valueAdmin['adm_fullname'].' ('.$valueAdmin['adm_username'].'), </span>';
                    }
                    
                    echo '
                    </span></div>
                    <div style="margin-bottom:5px;"><small><i class="icon-time"></i> '.date("D d M, Y", strtotime($valueForward['date_added'])).'</small></div>
                    <div>'.html_entity_decode($valueForward['remarks']).'</div>';

            }

            echo '
            <div class="form-group">
                <label class="control-label req col-lg-12" style="width:150px;"> <b>Remarks</b></label>
                <div class="col-lg-12">
                    <textarea class="form-control" id="remarks_edit" name="remarks_edit" style="height:70px!important;" required autocomplete="off"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-12" style="width:150px;"> <b>Attachment</b></label>
                <div class="col-lg-12">
                    <input id="attachment" name="attachment" class="btn btn-mid btn-primary clearfix" type="file">
                    <div style="color:#f00;">Max allowed file size is 200KB in (jpg, jpeg, png, pdf) format.</div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-12 req" style="width:450px;"> <b>Forward To</b></label>
                <div class="col-lg-12">
                    <select id="cclist" name="cclist[]" multiple required style="width:100%; height:auto!important;">';
                        $queryAdmins = $dblms->querylms("SELECT adm.adm_id, adm.adm_username, adm.adm_fullname, dept.dept_name
                                                                FROM ".ADMINS." adm 
                                                                LEFT JOIN ".DEPTS." dept ON dept.dept_id = adm.id_dept 
                                                                WHERE adm.adm_id != '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'
                                                                AND adm.adm_status = '1' AND adm.adm_logintype = '1'
                                                                AND adm.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                                                ORDER BY adm.adm_username ASC");
                        while($valueAdmin = mysqli_fetch_array($queryAdmins)){

                            $departmentName = '';
                            if($valueAdmin['dept_name']){
                                $departmentName = ' ('.$valueAdmin['dept_name'].')';
                            }

                            echo '<option value="'.$valueAdmin['adm_id'].'"'; if($valueAdmin['adm_id'] == $valueForward['id_added']){echo ' selected';} echo '>'.$valueAdmin['adm_fullname'].' - '.$valueAdmin['adm_username'].''.$departmentName.'</option>';
                        }
                        echo '
                    </select>
                </div>
            </div>

            <div style="clear:both;"></div>
            
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="location.href=\'dsadegreetranscript.php\'">Close</button>
                <input class="btn btn-primary" type="submit" value="Forward Application" id="forward_application" name="forward_application">
            </button>
        </div>

        </div>
        </form>
        </div>
        </div>
        <!--WI_ADD_NEW_TASK_MODAL-->
        <!--JS_ADD_NEW_TASK_MODAL-->
        <script type="text/javascript">
            $().ready(function() {
                //USED BY: WI_ADD_NEW_TASK_MODAL
                //ACTIONS: validates the form and submits it
                //REQUIRES: jquery.validate.js
                $("#editStudentInternshipDetail").validate({
                    rules: {
                        regno			: "required",
                        id_cat			: "required",
                        joining_date	: "required",
                        curs_credit_hours	: "required"
                    },
                    messages: {
                        regno			: "This field is required",
                        id_cat			: "This field is required",
                        joining_date	: "This field is required",
                        curs_credit_hours	: "This field is required"
                    },
                    submitHandler: function(form) {
                    //alert("form submitted");
                    form.submit();
                    }
                });
            });
        </script>
        <!--JS_ADD_NEW_TASK_MODAL-->
        <script>
            $("#degree_transcript").select2({
                allowClear: true
            });
            $("#normal_urgent1").select2({
                allowClear: true
            });
            $("#original_duplicate1").select2({
                allowClear: true
            });
            $("#comprehensive_exam").select2({
                allowClear: true
            });
            $("#gat_test").select2({
                allowClear: true
            });
            $("#coursework_thesis").select2({
                allowClear: true
            });
            $("#status").select2({
                allowClear: true
            });
            $("#cclist").select2({
                allowClear: true
            });
        </script>';
    }
}