<?php 
error_reporting(0);
session_start();
	include "../../dbsetting/lms_vars_config.php";
	include "../../dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "../../functions/login_func.php";
	include "../../functions/functions.php";
//--------------------------------------------
if(isset($_GET['id_block'])) {
	$id_block = $_GET['id_block']; 
//--------------------------------------------
//echo $id_prg.'abd ahahda dahda had a';
echo ' 
	<select id="id_halqa" name="id_halqa" style="width:100%" autocomplete="off" required>
				
				<option value="">Select Halqa</option>';
				 $sqllmshalqa	= $dblms->querylms("SELECT halqa_id, halqa_no 
				 											FROM ".HALQAS." WHERE halqa_status = '1' 
															AND id_block = '".cleanvars($id_block)."' ORDER BY halqa_no ASC");
			while($valuehalqa 	= mysql_fetch_array($sqllmshalqa)) { 
				echo '<option value="'.$valuehalqa['halqa_id'].'">'.$valuehalqa['halqa_no'].'</option>';
			}
	echo'
	</select>';
}
//--------------------------------------------
if(isset($_GET['id_block_edit'])) {
	$id_block_edit = $_GET['id_block_edit']; 
//--------------------------------------------
//echo $id_prg.'abd ahahda dahda had a';
echo ' 
	<select id="id_halqa_edit" name="id_halqa_edit" style="width:100%" autocomplete="off" required>
				
				<option value="">Select Halqa</option>';
				 $sqllmshalqa	= $dblms->querylms("SELECT halqa_id, halqa_no 
				 											FROM ".HALQAS." WHERE halqa_status = '1' 
															AND id_block = '".cleanvars($id_block_edit)."' ORDER BY halqa_no ASC");
			while($valuehalqa 	= mysql_fetch_array($sqllmshalqa)) { 
				echo '<option value="'.$valuehalqa['halqa_id'].'">'.$valuehalqa['halqa_no'].'</option>';
			}
	echo'
	</select>';
}

?>
<!--JS_SELECT_LISTS-->
<script>
	$("#id_halqa").select2({
		allowClear: true
	});

	$("#id_halqa_edit").select2({
		allowClear: true
	});
</script>