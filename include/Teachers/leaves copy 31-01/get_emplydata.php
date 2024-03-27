<?php

require_once('../../../../../dbsetting/lms_vars_config.php');
require_once('../../../../../dbsetting/classdbconection.php');
$dblms = new dblms();
require_once('../../../../../functions/login_func.php');
require_once('../../../../../functions/functions.php');

if(isset($_POST['id'])) {

    $queryEmployee = $dblms->querylms("SELECT e.emply_id, e.emply_father, e.emply_cell, e.id_dept, d.dept_name 
                                        FROM ".SALARY_EMPLYS." e 
                                        INNER JOIN ".DEPTS." d ON e.id_dept = d.dept_id 
                                        WHERE e.emply_id = ".cleanvars($_POST['id'])."
                                        AND e.id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                        LIMIT 1");
    $valueEmployee = mysqli_fetch_array($queryEmployee);


    echo '
    <div class="col-sm-32">
        <label for="">Father Name</label>
        <input type="text" name="fathername" value="'.$valueEmployee['emply_father'].'" class="form-control" readonly>
    </div>

    <div class="col-sm-32">
        <label for="">Department</label>
        <input type="text" name="dept" value="'.$valueEmployee['dept_name'].'" class="form-control" readonly>
    </div>

    <div class="col-sm-32">
        <label for="">Mobile</label>
        <input type="text" name="mobile" value="'.$valueEmployee['emply_cell'].'" class="form-control" readonly>
    </div>

    <div style="clear:both;padding-bottom:5px;"></div>

    <div class="col-sm-32">
        <label class="req">Select Substitute</label>
        <select name="substitution" id="substitute" style="width: 100%;" required>
            <option value=""></option>';
            /*
            if(isset($_POST['lid'])) {
                $querySub = $dblms->querylms("SELECT substitution FROM ".LEAVES." WHERE id = ".$_POST['lid']."");
                $valueSub = mysqli_fetch_array($querySub);
            }
            */
            
            $querySubstitutes = $dblms->querylms("SELECT e.emply_id , e.emply_name, d.designation_name  
                                                        FROM ".SALARY_EMPLYS." e
                                                        INNER JOIN ".DESIGNATIONS." d ON d.designation_id = e.id_designation 
                                                        WHERE e.emply_id != '".$valueEmployee['emply_id']."'
                                                        AND e.emply_status = 1 AND e.id_dept = '".$valueEmployee['id_dept']."'
                                                        AND e.id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."");
            while($valueSubstitute = mysqli_fetch_array($querySubstitutes)) {
                echo ' <option value="'.$valueSubstitute['emply_id'].'">'.$valueSubstitute['emply_name'].' ('.$valueSubstitute['designation_name'].')</option>';
            }
            echo '
        </select>
    </div>

    <script>
        $("#substitute").select2({
            allowClear    :   true
        });
    </script>';

}


?>