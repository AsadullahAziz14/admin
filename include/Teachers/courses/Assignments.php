<?php 
//--------------------------------------------
	include_once("assignments/query.php");
//--------------------------------------------
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">';
//--------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
} 
if(isset($_GET['archive'])) { $captionh = 'Archive of Assignments'; } else { $captionh = 'Assignments '; }
//--------------------------------------
echo '

<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">'.$captionh.'</h3></span>
			<!-- <a class="btn btn-mid btn-success pull-right" href="courses.php?id='.$_GET['id'].'&view=Assignments&archive"><i class="icon-list"></i> Archive</a> 
			<a class="btn btn-mid btn-info pull-right" href="courses.php?id='.$_GET['id'].'&view=Assignments&add"><i class="icon-plus"></i> Add Assignment </a>
			<a class="btn btn-mid btn-purple pull-right" href="courses.php?id='.$_GET['id'].'&view=Assignments"><i class="icon-list"></i> List</a>  -->
			<div class="clearfix"></div>
		</div>
	</div>
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
					<td style="text-align:center;">
						<a class="btn btn-mid btn-purple " href="courses.php?id='.$_GET['id'].'&prg_id='.$rowrelted['id_prg'].'&view=Assignments"><i class="icon-list"></i> List</a> 
						<a class="btn btn-mid btn-info " href="courses.php?id='.$_GET['id'].'&prg_id='.$rowrelted['id_prg'].'&view=Assignments&add"><i class="icon-plus"></i> Add Assignment </a> 
						<a class="btn btn-mid btn-success " href="courses.php?id='.$_GET['id'].'&prg_id='.$rowrelted['id_prg'].'&view=Assignments&archive"><i class="icon-list"></i> Archive</a> 
					</td>
				</tr>
				';
			}
		}
		echo '
		</tbody>
	</table>
</div>
<!--WI_MILESTONES_NAVIGATION-->

<!--WI_MILESTONES_TABLE-->
<div class="row">
<div class="col-lg-12">
  
<div class="widget wtabs">
<div class="widget-content">';
	
//------------------------------------------------
	// include_once("assignments/listprograms.php");
	include_once("assignments/list.php");
	include_once("assignments/add.php");
	include_once("assignments/archive.php");
	include_once("assignments/edit.php");
//------------------------------------------------
echo '

</div>
</div>
</div>
</div>

<!--WI_MILESTONES_TABLE-->
<!--WI_TABS_NOTIFICATIONS-->

</div>
<div class="clearfix"></div>
</div>
</div>
</div>'; 

?>