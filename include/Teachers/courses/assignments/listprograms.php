<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && !isset($_GET['archive'])) { 
	echo '
	<table class="footable table table-bordered table-hover">
		<thead>
			<tr>
				<th style="font-weight:600;text-align:center; ">Sr.#</th>
				<th style="font-weight:600;">Programs</th>
				<th style="font-weight:600;text-align:center; ">Action</th>
			</tr>
		</thead>
		<tbody>
		';
		$sqllmscursrelated  = $dblms->querylms("SELECT DISTINCT(t.id_prg), d.id_curs,
										p.prg_id, p.prg_name, p.prg_code, t.timing , c.is_obe 
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup  
										INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs   
										LEFT JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND d.id_curs = '".cleanvars($_GET['id'])."' AND t.status =  '1'");
		$countrelted = mysqli_num_rows($sqllmscursrelated);
		$relsr =0 ;

		while($rowrelted = mysqli_fetch_array($sqllmscursrelated)){ 
			$relsr++;
			
			if(isset($rowrelted['prg_name'])) {
				$prgname = $rowrelted['prg_name'].' ('.get_programtiming($rowrelted['timing']).')';
			} else {
				$prgname = 'LA: '.get_programtiming($rowrelted['timing']).$sectionrel;
			}
			if($countrelted>0) { 
			echo '
				<tr>
					<td style="text-align:center;">'.$relsr.'</td>
					<td style="">	
						<div style="font-weight:normal; color:blue;"> 
							'.$prgname.'
						</div>
					</td>
					<td style="text-align:center;"></td>
				</tr>
				';
			}
		}
		echo '
		</tbody>
	</table>
';
}