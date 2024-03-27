<?php
if(isset($_POST['submit_clo'])) {

	if(!isset($_POST['idprg']) || empty(sizeof($_POST['idprg']))) {

		$_SESSION['msg']['status']  = '<div class="alert-box error"><span>Error:</span> One or more Program(s) must be selected.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	}

    $queryCheck = $dblms->querylms("SELECT clo_id 
										FROM ".OBE_CLOS." 
										WHERE clo_statement = '".cleanvars($_POST['clo_statement'])."'
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."'
										AND id_course = '".cleanvars($_GET['id'])."'
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
										AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' LIMIT 1");
	if(mysqli_num_rows($queryCheck)>0) { 

		$_SESSION['msg']['status']  = '<div class="alert-box error"><span>Error:</span>Record already exists.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();

	} else {

        $plos = implode(",",cleanvars($_POST['id_plo']));

        $dataCLO = [
            'clo_status'            => cleanvars($_POST['clo_status'])          			,
            'clo_number'            => cleanvars($_POST['clo_number'])          			,
            'clo_statement'         => cleanvars($_POST['clo_statement'])       			,
            'id_plo'                => $plos                                    			,
            'id_domain_level'       => cleanvars($_POST['id_domain_level'])    		 		,
            'id_teacher'            => cleanvars($rowsstd['emply_id'])                      ,
            'id_course'             => cleanvars($_GET['id'])                                ,
            'academic_session'      => cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR']),
            'id_campus'             => cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])   ,
            'id_added'              => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])     ,
            'date_added'            => date('Y-m-d H:i:s')                
        ];
        $queryInsert = $dblms->Insert(OBE_CLOS, $dataCLO);
        
        if($queryInsert) {

            $latestID = $dblms->lastestid();

			if(!empty(sizeof($_POST['idprg']))) {

				for($ichk=0; $ichk<count($_POST['idprg']); $ichk++){

					$arr 		= cleanvars($_POST['idprg'][$ichk]);
					$splitted 	= explode(",",trim($arr));  
				
					$idProgram 	= $splitted[0];
					$semester 	= $splitted[1];
					$timing 	= $splitted[2];
					$section 	= $splitted[3];
					
					$dataDetail = array(
										'id_clo'		    => cleanvars($latestID)			, 
										'id_prg'	       	=> cleanvars($idProgram)	    , 
										'semester'	       	=> cleanvars($semester)	        , 
										'section'	       	=> cleanvars($section)	        , 
										'timing'	        => cleanvars($timing)			, 
									);
			
					$queryInsertPrograms = $dblms->Insert(OBE_CLO_PROGRAMS, $dataDetail);
			
				}
			}

            // Set Success MSG in Session & Exit
            $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been added successfully.</div>';
            header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
            exit();
        }
    }
}

if(isset($_POST['submit_clo_changes'])) { 

	if(!isset($_POST['idprg']) || empty(sizeof($_POST['idprg']))) {

		$_SESSION['msg']['status']  = '<div class="alert-box error"><span>Error:</span> One or more Program(s) must be selected.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
	}

	$plos = implode(",",cleanvars($_POST['id_plo']));
	$dataCLO = [
		'clo_status'            => cleanvars($_POST['clo_status'])          			,
		'clo_number'            => cleanvars($_POST['clo_number'])          			,
		'clo_statement'         => cleanvars($_POST['clo_statement'])       			,
		'id_plo'                => $plos                                    			,
		'id_domain_level'       => cleanvars($_POST['id_domain_level'])    		 		,
		'id_modify'             => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])    ,
		'date_modify'            => date('Y-m-d H:i:s')                
	];
	$queryUpdate = $dblms->Update(OBE_CLOS, $dataCLO, "WHERE clo_id = '".cleanvars($_POST['editid'])."'");

	if($queryUpdate) {

		if(!empty(sizeof($_POST['idprg']))) {

			$queryDeletePrograms = $dblms->querylms("DELETE FROM ".OBE_CLO_PROGRAMS." WHERE id_clo = '".cleanvars($_POST['editid'])."'");

			for($ichk=0; $ichk<count($_POST['idprg']); $ichk++){

				$arr 		= cleanvars($_POST['idprg'][$ichk]);
				$splitted 	= explode(",",trim($arr));  
			
				$idProgram 	= $splitted[0];
				$semester 	= $splitted[1];
				$timing 	= $splitted[2];
				$section 	= $splitted[3];
				
				$dataDetail = array(
									'id_clo'		    => cleanvars($_POST['editid'])	, 
									'id_prg'	       	=> cleanvars($idProgram)	    , 
									'semester'	       	=> cleanvars($semester)	        , 
									'section'	       	=> cleanvars($section)	        , 
									'timing'	        => cleanvars($timing)			, 
								);
		
				$queryInsertPrograms = $dblms->Insert(OBE_CLO_PROGRAMS, $dataDetail);
		
			}
		}
			
		$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record has been updated successfully.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=CLOs", true, 301);
		exit();
	}
}