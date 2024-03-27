<?php 
//Add Students Appointment Group
if(isset($_POST['add_group'])) { 

	$data = array(
		'group_status'	        	=> cleanvars($_POST['group_status'])						, 
		'group_name'	        	=> cleanvars($_POST['group_name'])							, 
		'group_date'	       		=> date('Y-m-d', strtotime(cleanvars($_POST['group_date']))), 
		'group_timeduration'	    => cleanvars($_POST['group_timeduration'])					, 
		'group_agenda'	    		=> cleanvars($_POST['group_agenda'])						, 
		'id_advisor'	       		=> cleanvars($_POST['id_advisor'])							, 
		'academic_session'	       	=> cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])	, 
		'id_campus'	       			=> cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])		, 
		'id_added'	        		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])		, 
		'date_added'		        => date("Y-m-d H:i:s")		            					, 
	);

	$sqllmsInsert = $dblms->Insert(LA_ADVISORAPPOINTMENTS_GROUP, $data);

	if($sqllmsInsert) { 

		//Latest PK of Main Table
		$idLatest = $dblms->lastestid();

		//Iterate over Students Array
		for($i=1; $i<=sizeof($_POST['id_std']); $i++){

			//Check if ID STD is not empty
			if(!empty($_POST['status'][$i])) {
						
				$dataDetail = array(
					'id_group'				=> cleanvars($idLatest)						, 
					'id_std'				=> cleanvars($_POST['id_std'][$i])			, 
					'semester'				=> cleanvars($_POST['semester'][$i])			, 
					'section'				=> cleanvars($_POST['section'][$i])			, 
					'timing'				=> cleanvars($_POST['timing'][$i])
				);

				$sqllmsInsertDetail  = $dblms->Insert(LA_ADVISORAPPOINTMENTS_GROUP_DETAIL, $dataDetail);

				unset($sqllmsInsertDetail);
			}

		}

		//Set Success MSG in Session & Exit
		$_SESSION['msg']['status']  = '<div id="infoupdated" class="alert-box notice"><span>Success: </span>Record added successfully.</div>';
		header("Location: lateacherappointmentsgroup.php", true, 301);
		exit();

	}
}

//Update Students Appointment Group
if(isset($_POST['edit_group'])) { 

	$data = array(
		'group_status'	        	=> cleanvars($_POST['group_status'])						, 
		'group_name'	        	=> cleanvars($_POST['group_name'])							, 
		'group_date'	       		=> date('Y-m-d', strtotime(cleanvars($_POST['group_date']))), 
		'group_timeduration'	    => cleanvars($_POST['group_timeduration'])					, 
		'group_agenda'	    		=> cleanvars($_POST['group_agenda'])						, 
		'group_meetingminutes'	    => cleanvars($_POST['group_meetingminutes'])				, 
		'id_modify'	        		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])		, 
		'date_modify'		        => date("Y-m-d H:i:s")		            					, 
	);

	$sqllmsUpdate = $dblms->Update(LA_ADVISORAPPOINTMENTS_GROUP, $data, "WHERE group_id = '".cleanvars($_POST['id_group'])."'");

	if($sqllmsUpdate) {

		//Iterate over Students Array
		for($i=1; $i<=sizeof($_POST['id_std']); $i++){

			//Check Student Record
			$sqllmsStudent = $dblms->querylms("SELECT id
													FROM ".LA_ADVISORAPPOINTMENTS_GROUP_DETAIL." ag
													WHERE id_group = '".cleanvars($_POST['id_group'])."'
													AND id_std = '".cleanvars($_POST['id_std'][$i])."'");

			//Check if Status is not empty
			if(!empty($_POST['status'][$i])) {
				
				if(mysqli_num_rows($sqllmsStudent) == 0){
							
					$dataDetail = array(
						'id_group'				=> cleanvars($_POST['id_group'])			, 
						'id_std'				=> cleanvars($_POST['id_std'][$i])			, 
						'semester'				=> cleanvars($_POST['semester'][$i])		, 
						'section'				=> cleanvars($_POST['section'][$i])			, 
						'timing'				=> cleanvars($_POST['timing'][$i])
					);

					$sqllmsInsertDetail  = $dblms->Insert(LA_ADVISORAPPOINTMENTS_GROUP_DETAIL, $dataDetail);

					unset($sqllmsInsertDetail);	
					
				}

			} else{

				//Delete Record if Exit but need to be removed while update
				if(mysqli_num_rows($sqllmsStudent) == 1){

					$valueStudent = mysqli_fetch_array($sqllmsStudent);

					$sqllmsDelete  = $dblms->querylms("DELETE FROM ".LA_ADVISORAPPOINTMENTS_GROUP_DETAIL." WHERE id ='".$valueStudent['id']."'");

				}

			}

		}

		//Set Success MSG in Session & Exit
		$_SESSION['msg']['status']  = '<div id="infoupdated" class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
		header("Location: lateacherappointmentsgroup.php", true, 301);
		exit();

	}
}

//Update Students Appointment Group Attendance
if(isset($_POST['add_attendance'])) { 


	//Iterate over Students Array
	for($i=1; $i<=sizeof($_POST['id_detail']); $i++){

		//Check if Detail ID is not empty
		if(!empty($_POST['id_detail'][$i])) {
			
			//Attendance Status
			if(!empty($_POST['status'][$i])) {
				$attendanceStatus = 1;
			} else{
				$attendanceStatus = 2;
			}
						
			$dataDetail = array(
				'attendance'			=> $attendanceStatus											, 
				'attendance_date'		=> date("Y-m-d H:i:s")
			);

			$sqllmsUpdateDetail  = $dblms->Update(LA_ADVISORAPPOINTMENTS_GROUP_DETAIL, $dataDetail, "WHERE id = '".cleanvars($_POST['id_detail'][$i])."'");

		}

	}

	if($sqllmsUpdateDetail) {

		//Set Success MSG in Session & Exit
		$_SESSION['msg']['status']  = '<div id="infoupdated" class="alert-box notice"><span>Success: </span>Record updated successfully.</div>';
		header("Location: lateacherappointmentsgroup.php", true, 301);
		exit();

	}
}