<?php  
if(LMS_VIEW == 'hod_forward' && isset($_GET['id'])) { 

    if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '190', 'edit' => '1'))) { 

        $sqllmsEdit  = $dblms->querylms("SELECT sa.*, std.std_id, std.std_name, std.std_regno, std.std_photo, std.std_session, std.std_semester, std.std_timing, prg.id_cat
                                                FROM ".DSA_APPLICATIONS." sa
                                                INNER JOIN ".STUDENTS." std ON std.std_id = sa.id_std
                                                INNER JOIN ".PROGRAMS." prg ON prg.prg_id = std.id_prg
                                                WHERE sa.id = '".cleanvars($_GET['id'])."'
                                                AND sa.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                                AND sa.is_deleted != '1'
                                                LIMIT 1");
        $valueEdit = mysqli_fetch_array($sqllmsEdit);

        if($valueEdit['comprehensive_year'] == '0000'){
            $comprehensiveYear = date('Y');
        } else{
            $comprehensiveYear = $valueEdit['comprehensive_year'];
        }

        if($valueEdit['gat_year'] == '0000'){
            $gatYear = date('Y');
        } else{
            $gatYear = $valueEdit['gat_year'];
        }

        if($valueEdit['thesis_submission_date'] == '0000-00-00'){
            $thesisSubmissionDate = date('Y-m-d');
        } else{
            $thesisSubmissionDate = $valueEdit['thesis_submission_date'];
        }

        if($valueEdit['thesis_submission_date_islrc'] == '0000-00-00'){
            $thesisSubmissionDateISLRC = date('Y-m-d');
        } else{
            $thesisSubmissionDateISLRC = $valueEdit['thesis_submission_date_islrc'];
        }

        echo '
        <!--WI_ADD_NEW_TASK_MODAL-->
        <div class="row">
        <div class="modal-dialog" style="width:90%;">
        <form class="form-horizontal" action="#" method="post" id="editStudentInternshipDetail" enctype="multipart/form-data">
        <input type="hidden" name="id_edit" value="'.$valueEdit['id'].'">
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
                    <select id="normal_urgent" name="normal_urgent" style="width:100%" autocomplete="off" required disabled>
                        <option value="">Select Option</option>';
                        foreach($regular_urgent as $regularUrgent){
                            echo '<option value="'.$regularUrgent['id'].'"'; if($regularUrgent['id'] == $valueEdit['normal_urgent']){echo ' selected';} echo '>'.$regularUrgent['name'].'</option>';
                        }
                    echo'
                    </select>
                </div> 
            </div>

            <div class="col-sm-41">
                <div class="form_sep">
                    <label class="req">Original/Duplicate</label>
                    <select id="original_duplicate" name="original_duplicate" style="width:100%" autocomplete="off" required disabled>
                        <option value="">Select Option</option>';
                        foreach ($original_duplicate as $originalDuplicate)  {
                            echo '<option value="'.$originalDuplicate['id'].'"'; if($originalDuplicate['id'] == $valueEdit['original_duplicate']){echo ' selected';} echo '>'.$originalDuplicate['name'].'</option>';
                        }
                    echo'
                    </select>
                </div> 
            </div>

            <div style="clear:both; padding-bottom:5px;"></div>';
            
            if($valueEdit['id_cat'] == '4' || $valueEdit['id_cat'] == '5'){

                echo '<div class="col-lg-12 heading-modal bg-info" style="margin-top:5px; margin-bottom:5px; color:#fff;"">HoD Remarks</div>';

                if($valueEdit['id_cat'] == '5'){

                    echo '
                    <div class="col-sm-41">
                        <div class="form_sep">
                            <label class="req">Comprehensive Examination Passed?</label>
                            <select id="comprehensive_exam" name="comprehensive_exam" style="width:100%" autocomplete="off" required>
                                <option value="">Select Option</option>';
                                foreach ($yesno as $yn)  {
                                    echo '<option value="'.$yn['id'].'"'; if($yn['id'] == $valueEdit['comprehensive_exam']){echo ' selected';} echo '>'.$yn['name'].'</option>';
                                }
                            echo'
                            </select>
                        </div> 
                    </div>
                    
                    <div class="col-sm-41">
                        <div class="form_sep">
                            <label class="req">Year</label>
                            <input type="text" class="form-control pickayear" name="comprehensive_year" id="comprehensive_year" value="'.$comprehensiveYear.'" required>
                        </div> 
                    </div>
                    
                    <div class="col-sm-41">
                        <div class="form_sep">
                            <label class="req">Marks</label>
                            <input type="text" class="form-control" name="comprehensive_marks" id="comprehensive_marks" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" value="'.$valueEdit['comprehensive_marks'].'" required>
                        </div> 
                    </div>';
    
                }  

                echo '
                <div style="clear:both; padding-bottom:5px;"></div>
                <div class="col-sm-41">
                    <div class="form_sep">
                        <label class="req">GAT/Equivalent Test (Passed)?</label>
                        <select id="gat_test" name="gat_test" style="width:100%" autocomplete="off" required>
                            <option value="">Select Option</option>';
                            foreach ($gatequivalenttests as $gatTest)  {
                                echo '<option value="'.$gatTest['id'].'"'; if($gatTest['id'] == $valueEdit['gat_test']){echo ' selected';} echo '>'.$gatTest['name'].'</option>';
                            }
                        echo'
                        </select>
                    </div> 
                </div>
                
                <div class="col-sm-41">
                    <div class="form_sep">
                        <label class="req">Year</label>
                        <input type="text" class="form-control pickayear" name="gat_year" id="gat_year" value="'.$gatYear.'" required>
                    </div> 
                </div>
                
                <div class="col-sm-41">
                    <div class="form_sep">
                        <label class="req">Marks</label>
                        <input type="text" class="form-control" name="gat_marks" id="gat_marks" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" value="'.$valueEdit['gat_marks'].'" required>
                    </div> 
                </div>
                
                <div style="clear:both; padding-bottom:5px;"></div>
                
                <div class="col-sm-41">
                    <div class="form_sep">
                        <label class="req">Degree completed with</label>
                        <select id="coursework_thesis" name="coursework_thesis" style="width:100%" autocomplete="off" required>
                            <option value="">Select Option</option>';
                            foreach ($cwthesis as $cwThesis)  {
                                echo '<option value="'.$cwThesis['id'].'"'; if($cwThesis['id'] == $valueEdit['coursework_thesis']){echo ' selected';} echo '>'.$cwThesis['name'].'</option>';
                            }
                        echo'
                        </select>
                    </div> 
                </div>
                
                <div class="col-sm-41">
                    <div class="form_sep">
                        <label class="req">Thesis submission date (if applicable)</label>
                        <input type="text" class="form-control pickadate" name="thesis_submission_date" id="thesis_submission_date" value="'.$thesisSubmissionDate.'" required>
                    </div> 
                </div>
                
                <div class="col-sm-41">
                    <div class="form_sep">
                        <label class="req">Date of thesis submission to ISLRC (if applicable)</label>
                        <input type="text" class="form-control pickadate" name="thesis_submission_date_islrc" id="thesis_submission_date_islrc" value="'.$thesisSubmissionDateISLRC.'" required>
                    </div> 
                </div>
                
                <div style="clear:both; padding-bottom:5px;"></div>
                
                <div class="form-group">
                    <label class="control-label req col-lg-12" style="width:300px;"><b> Title of the Thesis</b></label>
                    <div class="col-lg-12">
                        <input type="text" class="form-control" name="thesis_title" id="thesis_title" value="'.$valueEdit['thesis_title'].'" required>
                    </div>
                </div>';

            } 

            echo '
            <div style="clear:both; padding-bottom:5px;"></div>

            <div class="form-group">
                <label class="control-label req col-lg-12" style="width:150px;"> <b>Remarks</b></label>
                <div class="col-lg-12">
                    <textarea class="form-control" id="remarks_edit" name="remarks_edit" style="height:70px!important;" required autocomplete="off"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-12 req" style="width:450px;"> <b>Forward To</b></label>
                <div class="col-lg-12">
                    <select id="cclist" name="cclist[]" multiple required style="width:100%; height:auto!important;">';
                        $sqllmsAdmins  = $dblms->querylms("SELECT adm.adm_id, adm.adm_username, adm.adm_fullname, dept.dept_name
                                                                FROM ".ADMINS." adm 
                                                                LEFT JOIN ".DEPTS." dept ON dept.dept_id = adm.id_dept 
                                                                WHERE adm.adm_status = '1' AND adm.adm_logintype = '1'
                                                                AND adm.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                                                ORDER BY adm.adm_username ASC");
                        while($valueAdmin = mysqli_fetch_array($sqllmsAdmins)){

                            $departmentName = '';
                            if($valueAdmin['dept_name']){
                                $departmentName = ' ('.$valueAdmin['dept_name'].')';
                            }

                            echo '<option value="'.$valueAdmin['adm_id'].'">'.$valueAdmin['adm_fullname'].' - '.$valueAdmin['adm_username'].''.$departmentName.'</option>';
                        }
                        echo '
                    </select>
                </div>
            </div>

            <div style="clear:both;"></div>
            
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="location.href=\'dsadegreetranscript.php\'">Close</button>
                <input class="btn btn-primary" type="submit" value="Save Changes" id="forward_application" name="forward_application">
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
            $("#normal_urgent").select2({
                allowClear: true
            });
            $("#original_duplicate").select2({
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
        </script>';
    }
}