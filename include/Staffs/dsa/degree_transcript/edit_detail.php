<?php  
if(!isset($_GET['view']) && isset($_GET['id'])) { 

    if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '190', 'edit' => '1'))) { 

        $sqllmsEdit  = $dblms->querylms("SELECT sa.*, std.std_id, std.std_name, std.std_regno, std.std_photo, std.std_session, std.std_semester, std.std_timing, prg.prg_name, prg.id_cat
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

        if(isset($_SERVER['HTTP_REFERER'])){
            $redirectURL = $_SERVER['HTTP_REFERER'];
        } else{
            $redirectURL = 'dsadegreetranscript.php';
        }

        echo '
        <!--WI_ADD_NEW_TASK_MODAL-->
        <div class="row">
        <div class="modal-dialog" style="width:90%;">
        <form class="form-horizontal" action="#" method="post" id="editApplicationDetail" enctype="multipart/form-data">
        <input type="hidden" name="reference_no" value="'.$valueEdit['reference_no'].'">
        <input type="hidden" name="app_degree_transcript" value="'.$valueEdit['degree_transcript'].'">
        <input type="hidden" name="redirect_url" value="'.$redirectURL.'">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" onclick="location.href=\'dsadegreetranscript.php\'"><span>Close</span></button>
            <h4 class="modal-title" style="font-weight:700;"> Edit Student Degree/Transcript Detail</h4>
        </div>

        <div class="modal-body">

            <div class="col-lg-12 heading-modal bg-info" style="margin-top:5px; margin-bottom:0px; color:#fff;""> Student Information & Application Details</div>

            <div class="col-sm-41">
                <div class="form_sep">
                    <label>Student Registration #</label>
                    <input type="text" class="form-control" id="stdregno_edit" name="stdregno_edit" autocomplete="off" value="'.$valueEdit['std_regno'].'" readonly>
                </div> 
            </div>';

            $readOnly = 'readonly';
            
            if($_SESSION['userlogininfo']['LOGINTYPE'] == 1 || $_SESSION['userlogininfo']['LOGINTYPE'] == 2 || $_SESSION['userlogininfo']['LOGINIDA'] == 22099) {
                $readOnly = '';
            }

            echo '
            <div class="col-sm-41">
                <div class="form_sep">
                    <label>Student Name</label>
                    <input type="text" class="form-control" id="stdname_edit" name="stdname_edit" autocomplete="off" value="'.$valueEdit['full_name'].'" '.$readOnly.'>
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
                    ';
                    // value="'.get_programtiming($valueEdit['std_timing']).'"
                    echo '
                    <input type="text" class="form-control" id="semester_edit" name="semester_edit" autocomplete="off"  readonly>
                </div> 
            </div>

            <div style="clear:both;padding:5px;"></div>

            <div class="col-sm-41">
                <div class="form_sep">
                    <label>Program</label>
                    <input type="text" class="form-control" id="prg_name_edit" name="prg_name_edit" autocomplete="off" value="'.$valueEdit['prg_name'].'" readonly>
                </div> 
            </div>

            <div class="col-sm-41">
                <div class="form_sep">
                    <label class="req">Cell #</label>
                    <input type="text" class="form-control" id="mobile_edit" name="mobile_edit" autocomplete="off" value="'.$valueEdit['mobile'].'" required>
                </div> 
            </div>

            <div class="col-sm-41">
                <div class="form_sep">
                    <label class="req">Email Address</label>
                    <input type="email" class="form-control" id="email_edit" name="email_edit" autocomplete="off" value="'.$valueEdit['email'].'" required>
                </div> 
            </div>

            <div class="form-group">
                <label class="control-label req col-lg-12" style="width:300px;"><b> Postal Address</b></label>
                <div class="col-lg-12">
                    <input type="text" class="form-control" name="postal_address_edit" id="postal_address_edit" value="'.$valueEdit['postal_address'].'" required>
                </div>
            </div>';

            if($valueEdit['id_cat'] == '5'){

                echo '
                <div class="form-group">
                    <label class="control-label req col-lg-12" style="width:300px;"><b> Tehsil / District</b></label>
                    <div class="col-lg-12">
                        <input type="text" class="form-control" name="tehsil_district_edit" id="tehsil_district_edit" value="'.$valueEdit['tehsil_district'].'" required>
                    </div>
                </div>';
            
            }

            echo '
            <div style="clear:both;padding:5px;"></div>

            <div class="col-sm-32">
                <div class="form_sep">
                    <label>Application For</label>
                    <select id="degree_transcript" name="degree_transcript" style="width:100%" disabled autocomplete="off" required>
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

            <div class="col-sm-32">
                <div class="form_sep">
                    <label>Normal/Urgent</label>
                    <select id="normal_urgent1" name="normal_urgent" style="width:100%" disabled autocomplete="off" required>
                        <option value="">Select Option</option>';
                        foreach($regularUrgentArray as $regularUrgent){
                            echo '<option value="'.$regularUrgent['id'].'"'; if($regularUrgent['id'] == $valueEdit['normal_urgent']){echo ' selected';} echo '>'.$regularUrgent['name'].'</option>';
                        }
                    echo'
                    </select>
                </div> 
            </div>

            <div class="col-sm-32">
                <div class="form_sep">
                    <label>Original/Duplicate</label>
                    <select id="original_duplicate1" name="original_duplicate" style="width:100%" disabled autocomplete="off" required>
                        <option value="">Select Option</option>';
                        foreach ($originalDuplicateArray as $originalDuplicate)  {
                            echo '<option value="'.$originalDuplicate['id'].'"'; if($originalDuplicate['id'] == $valueEdit['original_duplicate']){echo ' selected';} echo '>'.$originalDuplicate['name'].'</option>';
                        }
                    echo'
                    </select>
                </div> 
            </div>

            <div class="col-sm-32">
                <div class="form_sep">
                    <label>Till Semester(s)</label>
                    <input type="text" class="form-control" id="till_semester" name="till_semester" autocomplete="off" value="'.$valueEdit['till_semester'].'" readonly>
                </div> 
            </div>

            <div style="clear:both; padding-bottom:5px;"></div>';

            //Picture / Docuemnts		
            //if($valueEdit['photo'] || $valueEdit['cnic_photo'] || $valueEdit['matric_result_card']) {  

                $picture            = '';
                $cnicPhoto          = '';
                $matricResultCard   = '';
                $transcript         = '';
                $thesisFile         = '';
                $gatTestProof       = '';
                $fir                 = '';

                if($valueEdit['photo']){
                    $picture = ' <a href="/downloads/dsa/pictures/'.$valueEdit['photo'].'" target="_blank"><image class="avatar-large image-boardered" src="/downloads/dsa/pictures/'.$valueEdit['photo'].'" alt="Picture"></a>
                                <div style="clear:both;"></div>
                                <form class="form-vertical" action="dsadegreetranscript.php" method="POST">
                                    <input type="hidden" name="id_application" value="'.$valueEdit['id'].'">
                                    <button class="btn btn-xs btn-danger" type="submit" id="delete_picture" name="delete_picture" onclick="return confirm(\'Are you sure want to remove this file?\')">Remove</button>
                                </form>';
                }

                if($valueEdit['cnic_photo']){

                    $cnicPathInfo = pathinfo($valueEdit['cnic_photo']);
                    $cnicExtension = $cnicPathInfo['extension'];

                    if($cnicExtension == 'pdf'){
                        $cnicPath = '/images/icons/v2/Adobe Acrobat Reader.png';
                    } else {
                        $cnicPath = '/downloads/dsa/documents/'.$valueEdit['cnic_photo'].'';
                    }
                    
                    $cnicPhoto = ' <a href="/downloads/dsa/documents/'.$valueEdit['cnic_photo'].'" target="_blank"><image class="avatar-large image-boardered" src="'.$cnicPath.'" alt="CNIC"></a>
                                    <div style="clear:both;"></div>
                                    <form class="form-vertical" action="dsadegreetranscript.php" method="POST">
                                        <input type="hidden" name="id_application" value="'.$valueEdit['id'].'">
                                        <button class="btn btn-xs btn-danger" type="submit" id="delete_cnic" name="delete_cnic" onclick="return confirm(\'Are you sure want to remove this file?\')">Remove</button>
                                    </form>';
                }

                if($valueEdit['matric_result_card']){

                    $matricPathInfo = pathinfo($valueEdit['matric_result_card']);
                    $matricExtension = $matricPathInfo['extension'];
            
                    if($matricExtension == 'pdf'){
                        $matricPath = '/images/icons/v2/Adobe Acrobat Reader.png';
                    } else {
                        $matricPath = '/downloads/dsa/documents/'.$valueEdit['matric_result_card'].'';
                    }

                    $matricResultCard = ' <a href="/downloads/dsa/documents/'.$valueEdit['matric_result_card'].'" target="_blank"><image class="avatar-large image-boardered" src="'.$matricPath.'" alt="Matric Result Card"></a>
                                            <div style="clear:both;"></div>
                                            <form class="form-vertical" action="dsadegreetranscript.php" method="POST">
                                                <input type="hidden" name="id_application" value="'.$valueEdit['id'].'">
                                                <button class="btn btn-xs btn-danger" type="submit" id="delete_matric_result" name="delete_matric_result" onclick="return confirm(\'Are you sure want to remove this file?\')">Remove</button>
                                            </form>';
                }

                if($valueEdit['transcript']){

                    $transcriptPathInfo = pathinfo($valueEdit['transcript']);
                    $transcriptExtension = $transcriptPathInfo['extension'];

                    if($transcriptExtension == 'pdf'){
                        $transcriptPath = '/images/icons/v2/Adobe Acrobat Reader.png';
                    } else {
                        $transcriptPath = '/downloads/dsa/documents/'.$valueEdit['transcript'].'';
                    }
                    
                    $transcript = ' <a href="/downloads/dsa/documents/'.$valueEdit['transcript'].'" target="_blank"><image class="avatar-large image-boardered" src="'.$transcriptPath.'" alt="Transcript"></a>
                                    <div style="clear:both;"></div>
                                    <form class="form-vertical" action="dsadegreetranscript.php" method="POST">
                                        <input type="hidden" name="id_application" value="'.$valueEdit['id'].'">
                                        <button class="btn btn-xs btn-danger" type="submit" id="delete_transcript" name="delete_transcript" onclick="return confirm(\'Are you sure want to remove this file?\')">Remove</button>
                                    </form>';
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
                        <input id="picture" name="picture" class="btn btn-mid btn-primary clearfix" type="file">
                        <div style="color:#f00;">Max allowed size is 200KB in (jpg, jpeg, png, pdf) format.</div>
                    </div>
                   '.$picture.'
                </div>

                <div class="col-sm-41">
                    <div class="form_sep">
                        <label>CNIC</label>
                        <input id="cnic_picture" name="cnic_picture" class="btn btn-mid btn-primary clearfix" type="file">
                        <div style="color:#f00;">Max allowed size is 200KB in (jpg, jpeg, png, pdf) format.</div>
                    </div>
                    '.$cnicPhoto.'
                </div>

                <div class="col-sm-41">
                    <div class="form_sep">
                        <label>Matric Result Card</label>
                        <input id="matric_result_card" name="matric_result_card" class="btn btn-mid btn-primary clearfix" type="file">
                        <div style="color:#f00;">Max allowed size is 200KB in (jpg, jpeg, png, pdf) format.</div>
                    </div>
                    '.$matricResultCard.'
                </div>
                
                <div style="clear:both; margin-bottom:10px;"></div>';
                
                if(cleanvars($valueEdit['degree_transcript']) == 2) {
                    echo '
                    <div class="col-sm-41">
                        <div class="form_sep">
                            <label>Transcript</label>
                            <input id="transcript_picture" name="transcript_picture" class="btn btn-mid btn-primary clearfix" type="file">
                            <div style="color:#f00;">Max allowed size is 200KB in (jpg, jpeg, png, pdf) format.</div>
                        </div>
                        '.$transcript.'
                    </div>';
                }

                if(cleanvars($valueEdit['degree_transcript']) == 1 && cleanvars($valueEdit['id_cat']) == 5) {

                    echo '
                    <div class="col-sm-41">
                        <div class="form_sep">
                            <label>Image of Thesis Title Page</label>
                            <input id="thesis_title_image" name="thesis_title_image" class="btn btn-mid btn-primary clearfix" type="file">
                            <div style="color:#f00;">Max allowed size is 200KB in (jpg, jpeg, png, pdf) format.</div>
                        </div>
                        '.$thesisFile.'
                    </div>';
                }

                if(cleanvars($valueEdit['degree_transcript']) == 1 && (cleanvars($valueEdit['id_cat']) == 4 || cleanvars($valueEdit['id_cat']) == 5)) {

                    echo '
                    <div class="col-sm-41">
                        <div class="form_sep">
                            <label>GAT Test Proof</label>
                            <input id="gat_test_photo" name="gat_test_photo" class="btn btn-mid btn-primary clearfix" type="file">
                            <div style="color:#f00;">Max allowed size is 200KB in (jpg, jpeg, png, pdf) format.</div>
                        </div>
                        '.$gatTestProof.'
                    </div>';

                }

                if(cleanvars($valueEdit['original_duplicate']) == 2) {
                    echo '
                    <div class="col-sm-41">
                        <div class="form_sep">
                            <label>FIR Picture</label>
                            <input id="fir_picture" name="fir_picture" class="btn btn-mid btn-primary clearfix" type="file">
                            <div style="color:#f00;">Max allowed size is 200KB in (jpg, jpeg, png, pdf) format.</div>
                        </div>
                        '.$fir.'
                    </div>';
                }

                echo '<div style="clear:both;"></div>';
            //}

            $queryRepeatCourses = $dblms->querylms("SELECT rc.offered_semester, rc.repeat_semester, cr.curs_code, cr.curs_name
                                                        FROM ".DSA_APPLICATIONS_REPEAT_COURSES." rc
                                                        INNER JOIN ".COURSES." cr ON cr.curs_id = rc.id_course
                                                        WHERE rc.id_setup = '".cleanvars($_GET['id'])."'
                                                        ORDER BY rc.id ASC");
            if(mysqli_num_rows($queryRepeatCourses)>0) {

                echo '
                <div class="col-lg-12 heading-modal bg-info" style="margin-top:5px; margin-bottom:0px; color:#fff;"">Repeat Courses</div>
                <table class="table table-bordered invE_tableed" >
                    <thead>
                    <tr class="heading-modal">
                        <th style="font-weight:600;"> Sr. #</th>
                        <th style="font-weight:600;"> Course</th>
                        <th style="font-weight:600; width:150px;"> Semester Offered In</th>
                        <th style="font-weight:600; width:150px;"> Semester Repeat In</th>
                    </tr>
                    </thead>
                    <tbody>';
                    $sr = 0;
    
                    while($valueRepeatCourse = mysqli_fetch_array($queryRepeatCourses)) {

                        $sr ++;
    
                        echo '
                        <tr>
                            <td style="vertical-align:middle;width:50px!important;text-align:center;">'.$sr.'</td>
                            <td style="vertical-align:middle;"><span style="font-weight:600; color:#666; font-size:12px;">'.$valueRepeatCourse['curs_code'].' - '.$valueRepeatCourse['curs_name'].'</span></td>
                            <td style="vertical-align:middle;text-align:center;"><span style="font-weight:600; color:#666; font-size:12px;">'.$valueRepeatCourse['offered_semester'].'</span></td>
                            <td style="vertical-align:middle;text-align:center;"><span style="font-weight:600; color:#666; font-size:12px;">'.$valueRepeatCourse['repeat_semester'].'</span></td>
                        </tr>';

                    }//End While Loop
                    echo '
                    <tr class="last_rowed"></tr>
                    </tbody>
                </table>';
            }

            echo '
            <div style="clear:both; padding-bottom:5px;"></div>';
            
            if($valueEdit['id_cat'] == '4' || $valueEdit['id_cat'] == '5'){

                if($valueEdit['id_cat'] == '5'){

                    echo '
                    <div class="col-sm-41">
                        <div class="form_sep">
                            <label class="req">Comprehensive Examination Passed?</label>
                            <select id="comprehensive_exam" name="comprehensive_exam" style="width:100%" autocomplete="off" required disabled>
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
                            <input type="text" class="form-control pickayear" name="comprehensive_year" id="comprehensive_year" value="'.$comprehensiveYear.'" readonly>
                        </div> 
                    </div>
                    
                    <div class="col-sm-41">
                        <div class="form_sep">
                            <label class="req">Is passed?</label>
                            <select id="comprehensive_passed" name="comprehensive_passed" style="width:100%" autocomplete="off" disabled required>
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
                        <select id="gat_test" name="gat_test" style="width:100%" autocomplete="off" required disabled>
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
                        <input type="text" class="form-control pickayear" name="gat_year" id="gat_year" value="'.$gatYear.'" readonly>
                    </div> 
                </div>
                
                <div class="col-sm-41">
                    <div class="form_sep">
                        <label class="req">Is passed?</label>
                        <select id="gat_passed" name="gat_passed" style="width:100%" autocomplete="off" disabled required>
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

                    echo '<div class="col-lg-12 heading-modal bg-info" style="margin-top:5px; margin-bottom:5px; color:#fff;"">Course Work / Thesis Details</div>';

                    echo '
                    <div class="col-sm-41">
                        <div class="form_sep">
                            <label class="req">Degree completed with</label>
                            <select id="coursework_thesis" name="coursework_thesis" style="width:100%" autocomplete="off" required disabled>
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
                            <input type="text" class="form-control pickadate" name="thesis_submission_date" id="thesis_submission_date" value="'.$thesisSubmissionDate.'" readonly>
                        </div> 
                    </div>
                    
                    <div class="col-sm-41">
                        <div class="form_sep">
                            <label class="req">Date of thesis submission to ISLRC (if applicable)</label>
                            <input type="text" class="form-control pickadate" name="thesis_submission_date_islrc" id="thesis_submission_date_islrc" value="'.$thesisSubmissionDateISLRC.'" readonly>
                        </div> 
                    </div>
                    
                    <div style="clear:both;"></div>
                    
                    <div class="form-group">
                        <label class="control-label req col-lg-12" style="width:300px;"><b> Title of the Thesis</b></label>
                        <div class="col-lg-12">
                            <input type="text" class="form-control" name="thesis_title" id="thesis_title" value="'.$valueEdit['thesis_title'].'" readonly>
                        </div>
                    </div>';
                }

            } 

            echo '

            <div style="clear:both;"></div>
            <div class="col-lg-12 heading-modal bg-info" style="margin-top:5px; margin-bottom:0px; color:#fff;""> Remarks</div>
            <div style="clear:both;padding-bottom:5px;"></div>

            <div class="col-sm-61">
                <div class="form_sep">
                    <label class="req">Is HoD Verified?</label>
                    <select id="hod_verified" name="hod_verified" style="width:100%" autocomplete="off" required>
                        <option value="">Select Option</option>';
                        foreach ($yesno as $yN)  {
                            echo '<option value="'.$yN['id'].'"'; if($yN['id'] == $valueEdit['hod_verified']){echo ' selected';} echo '>'.$yN['name'].'</option>';
                        }
                        echo'
                    </select>
                </div> 
            </div>

            <div class="col-sm-61">
                <div class="form_sep">
                    <label class="req">Is Account Office Verified?</label>
                    <select id="accounts_verified" name="accounts_verified" style="width:100%" autocomplete="off" required>
                        <option value="">Select Option</option>';
                        foreach ($yesno as $yN)  {
                            echo '<option value="'.$yN['id'].'"'; if($yN['id'] == $valueEdit['accounts_verified']){echo ' selected';} echo '>'.$yN['name'].'</option>';
                        }
                        echo'
                    </select>
                </div> 
            </div>

            <div style="clear:both;"></div>

            <div class="form-group">
                <label class="control-label req col-lg-12" style="width:300px;"><b> Remarks by DSA</b></label>
                <div class="col-lg-12">
                    <input type="text" class="form-control" name="remarks_dsa" id="remarks_dsa" value="'.$valueEdit['remarks_dsa'].'" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label req col-lg-12"><b> Status</b></label>
                <div class="col-lg-12">
                    <select id="status" name="status" onChange="get_dsa_application_status_details(this.value)" style="width:100%; height:30px;" required>
                        <option></option>';
                        foreach($dsaStatus as $status) {
                            echo '<option value="'.$status['id'].'"'; if($status['id'] == $valueEdit['status']){echo ' selected';} echo '>'.$status['name'].'</option>';
                        }
                    echo '	
                    </select>
                </div>
            </div>

            <div style="clear:both;"></div>

            <div id="getdsaapplicationstatusdetails">';

            if($valueEdit['status'] == 5){

                echo '
                <div style="clear:both;padding-bottom:5px;"></div>
                <div class="col-sm-61">
                    <div class="form_sep">
                        <label class="req">Recipient</label>
                        <select id="recipient" name="recipient" onChange="get_recipient_relation(this.value)" style="width:100%" autocomplete="off" required>
                            <option value="">Select Option</option>';
                            foreach($dsaRecipientsArray as $dsaRecipient){
                                echo '<option value="'.$dsaRecipient['id'].'"'; if($dsaRecipient['id'] == $valueEdit['recipient']){echo ' selected';} echo '>'.$dsaRecipient['name'].'</option>';
                            }
                            echo'
                        </select>
                    </div> 
                </div>
                <div class="col-sm-61">
                    <div class="form_sep">
                        <label class="req">Full Name</label>
                        <input type="text" class="form-control" id="recipient_full_name" name="recipient_full_name" value="'.$valueEdit['recipient_full_name'].'" required>
                    </div> 
                </div>
                <div style="clear:both;padding-bottom:5px;"></div>';

                if($valueEdit['recipient'] == 2){
                    echo '
                    <div id="getdsarecipientrelation">
                        <div class="col-sm-61">
                            <div class="form_sep">
                                <label class="req">Relationship with the student</label>
                                <input type="text" class="form-control" id="recipient_relationship" name="recipient_relationship" value="'.$valueEdit['recipient_relationship'].'" required>
                            </div> 
                        </div>
                    </div>';
                }
                
                echo '
                <div class="col-sm-61">
                    <div class="form_sep">
                        <label class="req">Recipient CNIC</label>
                        <input type="text" class="form-control" id="recipient_cnic" name="recipient_cnic" value="'.$valueEdit['recipient_cnic'].'" required>
                    </div> 
                </div>';

            }
            
            echo '
            </div>
            <div id="loading"></div>

            <div style="clear:both;"></div>
            
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="location.href=\'dsadegreetranscript.php\'">Close</button>
                <input class="btn btn-primary" type="submit" value="Save Changes" id="save_changes" name="save_changes">
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
                $("#editApplicationDetail").validate({
                    rules: {
                        regno			: "required"
                    },
                    messages: {
                        regno			: "This field is required"
                    },
                    submitHandler: function(form) {
                    //alert("form submitted");
                    form.submit();
                    }
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                // Trigger the calculation when any input field changes
                var status = document.getElementById("status").val()
                get_dsa_application_status_details(status);
            });

            function get_dsa_application_status_details(status) {  
                $("#loading").html(\'<img src="images/ajax-loader-horizintal.gif"> Loading...\');  
                $.ajax({  
                    type: "POST",  
                    url: "include/ajax/studentservices/get_dsa_application_status_details.php",  
                    data: "status="+status, 
                    success: function(msg){  
                        $("#getdsaapplicationstatusdetails").html(msg); 
                        $("#loading").html(\'\'); 
                    }
                });  
            }
            function get_recipient_relation(recipient) {  
                $("#loading1").html(\'<img src="images/ajax-loader-horizintal.gif"> Loading...\');  
                $.ajax({  
                    type: "POST",  
                    url: "include/ajax/studentservices/get_recipient_relation.php",  
                    data: "recipient="+recipient, 
                    success: function(msg){  
                        $("#getdsarecipientrelation").html(msg); 
                        $("#loading1").html(\'\'); 
                    }
                });  
            }
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
            $("#hod_verified").select2({
                allowClear: true
            });
            $("#accounts_verified").select2({
                allowClear: true
            });
            $("#status").select2({
                allowClear: true
            });
            $("#recipient").select2({
                allowClear: true
            });
        </script>';
    }
}