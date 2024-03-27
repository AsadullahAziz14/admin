<?php  
if(LMS_VIEW == 'hod_forward' && isset($_GET['id'])) { 

    if($_SESSION['userlogininfo']['LOGINTYPE'] == 1 || $_SESSION['userlogininfo']['LOGINTYPE'] == 2  || $_SESSION['userlogininfo']['LOGINTYPE'] == 8 || $_SESSION['userlogininfo']['LOGINTYPE'] == 9) { 

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
            
            if($valueEdit['id_cat'] == '4' || $valueEdit['id_cat'] == '5'){

                echo '<div class="col-lg-12 heading-modal bg-info" style="margin-top:5px; margin-bottom:5px; color:#fff;"">HoD Remarks</div>';

                if($valueEdit['id_cat'] == '5'){

                    echo '
                    <div class="col-sm-41">
                        <div class="form_sep">
                            <label class="req">Comprehensive Examination Taken?</label>
                            <select id="comprehensive_exam" name="comprehensive_exam" style="width:100%" autocomplete="off" required>
                                <option value="">Select Option</option>';
                                foreach ($statusyesno as $yn)  {
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
                            <label class="req">Is passed?</label>
                            <select id="comprehensive_passed" name="comprehensive_passed" style="width:100%" autocomplete="off" required>
                                <option value="">Select Option</option>';
                                foreach ($statusyesno as $yn)  {
                                    echo '<option value="'.$yn['id'].'"'; if($yn['id'] == $valueEdit['comprehensive_passed']){echo ' selected';} echo '>'.$yn['name'].'</option>';
                                }
                            echo'
                            </select>
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
                            foreach ($dsaTranscriptTestsArray as $gatTest)  {
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
                        <label class="req">Is passed?</label>
                        <select id="gat_passed" name="gat_passed" style="width:100%" autocomplete="off" required>
                            <option value="">Select Option</option>';
                            foreach ($statusyesno as $yn)  {
                                echo '<option value="'.$yn['id'].'"'; if($yn['id'] == $valueEdit['gat_passed']){echo ' selected';} echo '>'.$yn['name'].'</option>';
                            }
                        echo'
                        </select>
                    </div> 
                </div>
                
                <div style="clear:both; padding-bottom:5px;"></div>';

                if($valueEdit['coursework_thesis'] != 0){
                
                    echo '
                    <div class="col-sm-41">
                        <div class="form_sep">
                            <label class="req">Degree completed with</label>
                            <select id="coursework_thesis" name="coursework_thesis" disabled style="width:100%" autocomplete="off" required>
                                <option value="">Select Option</option>';
                                foreach ($cwthesis as $cwThesis)  {
                                    echo '<option value="'.$cwThesis['id'].'"'; if($cwThesis['id'] == $valueEdit['coursework_thesis']){echo ' selected';} echo '>'.$cwThesis['name'].'</option>';
                                }
                            echo'
                            </select>
                        </div> 
                    </div>';
                }

                if($valueEdit['coursework_thesis'] == 2){

                    echo '
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
            } 

            echo '
            <div style="clear:both; padding-bottom:5px;"></div>';

            //Picture / Docuemnts 
            $picture            = '';
            $cnicPhoto          = '';
            $matricResultCard   = '';
            $transcript         = '';
            $thesisFile         = '';
            $gatTestProof       = '';
            $fir                 = '';

            if($valueEdit['photo']){
                $picture = ' <a href="/downloads/dsa/pictures/'.$valueEdit['photo'].'" target="_blank"><image class="avatar-large image-boardered" src="/downloads/dsa/pictures/'.$valueEdit['photo'].'" alt="Picture"></a>';
            }

            if($valueEdit['cnic_photo']){

                $cnicPathInfo = pathinfo($valueEdit['cnic_photo']);
                $cnicExtension = $cnicPathInfo['extension'];

                if($cnicExtension == 'pdf'){
                    $cnicPath = '/images/icons/v2/Adobe Acrobat Reader.png';
                } else {
                    $cnicPath = '/downloads/dsa/documents/'.$valueEdit['cnic_photo'].'';
                }
                
                $cnicPhoto = ' <a href="/downloads/dsa/documents/'.$valueEdit['cnic_photo'].'" target="_blank"><image class="avatar-large image-boardered" src="'.$cnicPath.'" alt="CNIC"></a>';
            }

            if($valueEdit['matric_result_card']){

                $matricPathInfo = pathinfo($valueEdit['matric_result_card']);
                $matricExtension = $matricPathInfo['extension'];
        
                if($matricExtension == 'pdf'){
                    $matricPath = '/images/icons/v2/Adobe Acrobat Reader.png';
                } else {
                    $matricPath = '/downloads/dsa/documents/'.$valueEdit['matric_result_card'].'';
                }

                $matricResultCard = ' <a href="/downloads/dsa/documents/'.$valueEdit['matric_result_card'].'" target="_blank"><image class="avatar-large image-boardered" src="'.$matricPath.'" alt="Matric Result Card"></a>';
            }

            if($valueEdit['transcript']){

                $transcriptPathInfo = pathinfo($valueEdit['transcript']);
                $transcriptExtension = $transcriptPathInfo['extension'];

                if($transcriptExtension == 'pdf'){
                    $transcriptPath = '/images/icons/v2/Adobe Acrobat Reader.png';
                } else {
                    $transcriptPath = '/downloads/dsa/documents/'.$valueEdit['transcript'].'';
                }
                
                $transcript = ' <a href="/downloads/dsa/documents/'.$valueEdit['transcript'].'" target="_blank"><image class="avatar-large image-boardered" src="'.$transcriptPath.'" alt="Transcript"></a>';
            }

            if($valueEdit['thesis_title_photo']){

                $thesisPathInfo = pathinfo($valueEdit['thesis_title_photo']);
                $thesisExtension = $thesisPathInfo['extension'];

                if($thesisExtension == 'pdf'){
                    $thesisPath = '/images/icons/v2/Adobe Acrobat Reader.png';
                } else {
                    $thesisPath = '/downloads/dsa/documents/'.$valueEdit['thesis_title_photo'].'';
                }
                
                $thesisFile = ' <a href="/downloads/dsa/documents/'.$valueEdit['thesis_title_photo'].'" target="_blank"><image class="avatar-large image-boardered" src="'.$thesisPath.'" alt="Thesis"></a>';
            }

            if($valueEdit['gat_test_proof']){

                $gatPathInfo = pathinfo($valueEdit['gat_test_proof']);
                $gatExtension = $gatPathInfo['extension'];

                if($gatExtension == 'pdf'){
                    $gatPath = '/images/icons/v2/Adobe Acrobat Reader.png';
                } else {
                    $gatPath = '/downloads/dsa/documents/'.$valueEdit['gat_test_proof'].'';
                }

                $gatTestProof = ' <a href="/downloads/dsa/documents/'.$valueEdit['gat_test_proof'].'" target="_blank"><image class="avatar-large image-boardered" src="'.$gatPath.'" alt="GAT Test"></a>';
            }

            if($valueEdit['fir_photo']){

                $firPathInfo = pathinfo($valueEdit['fir_photo']);
                $firExtension = $firPathInfo['extension'];

                if($firExtension == 'pdf'){
                    $firPath = '/images/icons/v2/Adobe Acrobat Reader.png';
                } else {
                    $firPath = '/downloads/dsa/documents/'.$valueEdit['fir_photo'].'';
                }

                $fir = ' <a href="/downloads/dsa/documents/'.$valueEdit['fir_photo'].'" target="_blank"><image class="avatar-large image-boardered" src="'.$firPath.'" alt="FIR"></a>';
            }

            echo '<div class="col-lg-12 heading-modal bg-info" style="margin-top:5px; margin-bottom:0px; color:#fff;"">Documents</div>

            <div class="col-sm-41">
                <div class="form_sep">
                    <label>Picture</label>
                </div>
                '.$picture.'
            </div>

            <div class="col-sm-41">
                <div class="form_sep">
                    <label>CNIC</label>
                </div>
                '.$cnicPhoto.'
            </div>

            <div class="col-sm-41">
                <div class="form_sep">
                    <label>Matric Result Card</label>
                </div>
                '.$matricResultCard.'
            </div>
            
            <div style="clear:both; margin-bottom:10px;"></div>';
            
            if(cleanvars($valueEdit['degree_transcript']) == 2) {
                echo '
                <div class="col-sm-41">
                    <div class="form_sep">
                        <label>Transcript</label>
                    </div>
                    '.$transcript.'
                </div>';
            }

            if(cleanvars($valueEdit['degree_transcript']) == 1 && cleanvars($valueEdit['id_cat']) == 5) {

                echo '
                <div class="col-sm-41">
                    <div class="form_sep">
                        <label>Image of Thesis Title Page</label>
                    </div>
                    '.$thesisFile.'
                </div>';
            }

            if(cleanvars($valueEdit['degree_transcript']) == 1 && (cleanvars($valueEdit['id_cat']) == 4 || cleanvars($valueEdit['id_cat']) == 5)) {

                echo '
                <div class="col-sm-41">
                    <div class="form_sep">
                        <label>GAT Test Proof</label>
                    </div>
                    '.$gatTestProof.'
                </div>';

            }

            if(cleanvars($valueEdit['original_duplicate']) == 2) {
                echo '
                <div class="col-sm-41">
                    <div class="form_sep">
                        <label>FIR Picture</label>
                    </div>
                    '.$fir.'
                </div>';
            }

            echo '<div style="clear:both;"></div>';

            $valueForward['id_added'] = 0;
            $sqllmsForward  = $dblms->querylms("SELECT af.remarks, af.forwaded_to, af.attachment, af.id_added, af.date_added, ad.adm_fullname, ad.adm_username
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
                <label class="control-label col-lg-12 req" style="width:450px;"> <b>Forward To</b></label>
                <div class="col-lg-12">
                    <select id="cclist" name="cclist[]" multiple required style="width:100%; height:auto!important;">';
                        $sqllmsAdmins  = $dblms->querylms("SELECT adm.adm_id, adm.adm_username, adm.adm_fullname, dept.dept_name
                                                                FROM ".ADMINS." adm 
                                                                LEFT JOIN ".DEPTS." dept ON dept.dept_id = adm.id_dept 
                                                                WHERE adm.adm_id != '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
                                                                AND adm.adm_status = '1' AND adm.adm_logintype = '1'
                                                                AND adm.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                                                ORDER BY adm.adm_username ASC");
                        while($valueAdmin = mysqli_fetch_array($sqllmsAdmins)){

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
            $("#normal_urgent1").select2({
                allowClear: true
            });
            $("#original_duplicate1").select2({
                allowClear: true
            });
            $("#comprehensive_exam").select2({
                allowClear: true
            });
            $("#comprehensive_passed").select2({
                allowClear: true
            });
            $("#gat_test").select2({
                allowClear: true
            });
            $("#gat_passed").select2({
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