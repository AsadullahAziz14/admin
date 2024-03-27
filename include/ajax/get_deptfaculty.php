<?php 
error_reporting(0);
session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
//--------------------------------------------
if(isset($_GET['idfaculty'])) {
	$id_faculty = $_GET['idfaculty']; 
//--------------------------------------------
//echo $id_prg.'abd ahahda dahda had a';
echo ' 
	<div class="col-sm-41">
		<div class="form-sep" style="margin-top:5px;">
			<label class="req">Department</label>
			<select id="id_dept" name="id_dept" style="width:100%" autocomplete="off" required>
				<option value="">Select Department</option>';
				 $sqllmsdept	= $dblms->querylms("SELECT dept_id, dept_name FROM ".DEPTS." WHERE dept_status = '1' AND id_faculty = '".$id_faculty."'ORDER BY dept_name ASC");
				while($valuedept = mysqli_fetch_array($sqllmsdept)) { 
				echo '<option value="'.$valuedept['dept_id'].'">'.$valuedept['dept_name'].'</option>';
				}
	echo'
			</select>
		</div> 
	</div>';
}

?>
<!--JS_SELECT_LISTS-->
<script>
	$("#id_dept").select2({
		allowClear: true
	});

	$("#id_city_edit").select2({
		allowClear: true
	});
</script>