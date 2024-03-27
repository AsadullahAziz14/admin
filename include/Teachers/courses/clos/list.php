<?php
if(!isset($_GET['editid']) && !isset($_GET['add'])) { 

	$queryCLOs = $dblms->querylms("SELECT clo_id, clo_status, clo_number, clo_statement, id_domain_level, id_plo  
										FROM ".OBE_CLOS." 
										WHERE id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND id_course = '".cleanvars($_GET['id'])."'
										AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										ORDER BY clo_id DESC");
	if(mysqli_num_rows($queryCLOs) > 0) {

		echo '
		<div style=" float:right; text-align:right; font-weight:700; color:#00f; margin:0 10px 0 0;">
			Total Records: ('.number_format(mysqli_num_rows($queryCLOs)).')
		</div>
		<table class="footable table table-bordered table-hover">
		<thead>
		<tr>
			<th style="font-weight:600;text-align:center;">Sr.&nbsp;#</th>
			<th style="font-weight:600;text-align:center;">CLO #</th>
			<th style="font-weight:600;">CLO Statement</th>
			<th style="font-weight:600;text-align:center;">Status</th>
			<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i></th>
		</tr>
		</thead>
		<tbody>';
		$srbk = 0;
		while($valueCLO = mysqli_fetch_assoc($queryCLOs)) { 

			$srbk++;

			echo '
			<tr>
				<td style="width:40px;text-align:center;">'.$srbk.'</td>
				
				<td style="text-align:center; width:90px;">'.$valueCLO['clo_number'].'</td>
				<td>'.$valueCLO['clo_statement'].'</td>
				<td style="width:60px; text-align:center;">'.get_status($valueCLO['clo_status']).'</td>
				<td style="width:70px; text-align:center;">
					<a class="btn btn-xs btn-info" href="courses.php?id='.cleanvars($_GET['id']).'&view=CLOs&editid='.$valueCLO['clo_id'].'"><i class="icon-edit"></i></a>
				</td>
			</tr>

			<tr>
				<td colspan="4">';
			$queryCLOPrograms = $dblms->querylms("SELECT DISTINCT(clp.id_prg), clp.id, clp.id_clo, clp.semester, clp.section, clp.timing, p.prg_id, p.prg_code, p.prg_name
														FROM ".OBE_CLO_PROGRAMS." clp 
														LEFT JOIN ".PROGRAMS." p ON p.prg_id = clp.id_prg  
														WHERE clp.id_clo = '".cleanvars($valueCLO['clo_id'])."'
														ORDER BY clp.id ASC");
			while($valueCLOProgram = mysqli_fetch_assoc($queryCLOPrograms)) { 
				
				if($valueCLOProgram['prg_code']) {
					$prgcode = strtoupper($valueCLOProgram['prg_code']).' Semester: '.addOrdinalNumberSuffix($valueCLOProgram['semester']).' '.$valueCLOProgram['section'].' ( '.get_programtiming($valueCLOProgram['timing']).')';
				} else {
					$prgcode = 'LA: Section: '.$valueCLOProgram['section'].' ( '.get_programtiming($valueCLOProgram['timing']).')';
				}
				echo '<span style="font-weight:600; margin-right:20px; font-size:12px; color:blue;">'.$prgcode.'</span>';
			}
			echo '
				</td>
				<td style="width:50px; text-align:center;">
					<!--<a class="btn btn-xs btn-purple iframeModal"data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>'.$valueCLO['clo_statement'].'</b>" data-src="courseassignmentview.php?id='.$valueCLO['clo_id'].'" href="#"><i class="icon-zoom-in"></i></a>-->
				</td>
			</tr>';
		}
		echo '
		</tbody>
		</table>';
	} else {
		echo '
		<div class="col-lg-12">
			<div class="widget-tabs-notification">No Result Found</div>
		</div>';
	}
}