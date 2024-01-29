<?php 
if($view == 'delete') {
	if(isset($_GET['id'])) { 
		$queryDelete = $dblms->querylms("DELETE FROM ".OBE_PLOS." WHERE plo_id = '".cleanvars($_GET['id'])."'");
	
		$_SESSION['msg']['status']  = '<div class="alert-box error"><span>Success: </span>Record has been deleted successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	}
}

if(isset($_POST['submit_plo'])) { 

	$queryCheck = $dblms->querylms("SELECT plo_id 
										FROM ".OBE_PLOS." 
										WHERE plo_statement = '".cleanvars($_POST['plo_statement'])."'
										AND id_prg = '".cleanvars($_POST['id_prg'])."'
										AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' LIMIT 1");
	if(mysqli_num_rows($queryCheck)>0) { 
		
		$_SESSION['msg']['status']  = '<div class="alert-box error"><span>Error:</span>Record already exists.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();

	} else { 
		$ploData = array(
			'plo_number'		=> cleanvars($_POST['plo_number'])		            	, 
			'plo_statement'		=> cleanvars($_POST['plo_statement'])		           	, 
			'plo_status'		=> cleanvars($_POST['plo_status'])		            	, 
			'id_prg'			=> cleanvars($_POST['id_prg'])		            		, 
			'id_campus'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])	, 
			'id_added'	    	=> cleanvars($_SESSION['LOGINIDA_SSS'])	,
			'date_added'		=> date("Y-m-d H:i:s")		            				, 
		);
		$queryInsert = $dblms->Insert(OBE_PLOS, $ploData);
		
		if($queryInsert) {
			// Set Success MSG in Session & Exit
			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been added successfully.</div>';
			header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
			exit();
		}
	}
}

if(isset($_POST['submit_changes'])) { 
	
	$ploData = array(
		'plo_number'		=> cleanvars($_POST['plo_number_edit'])		            , 
		'plo_statement'		=> cleanvars($_POST['plo_statement_edit'])		        , 
		'plo_status'		=> cleanvars($_POST['plo_status_edit'])		            , 
		'id_prg'			=> cleanvars($_POST['id_prg_edit'])		            	, 
		'id_modify'	    	=> cleanvars($_SESSION['LOGINIDA_SSS'])	,
		'date_modify'		=> date("Y-m-d H:i:s")		            				, 
	);
	$queryUpdate = $dblms->Update(OBE_PLOS, $ploData, "WHERE plo_id = '".cleanvars($_POST['plo_id'])."'");

    if($queryUpdate) {

		//Set Success MSG in Session & Exit
		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been updated successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
    }
}