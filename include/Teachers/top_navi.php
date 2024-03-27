<?php 
echo '
<div class="page-head">
	'.$toptitlename.'
<!-- menu -->
<div class="heading-menu pull-right responsive-heading-tabs">
<ul>
	<li style="background-color:#f00;">
		<div class="btn-group"> <a  href="https://library.mul.edu.pk/" target="_blank"> <i class="icon-book"></i> <span>Online Library</span></a> </div>
	</li>
	<li>
		<div class="btn-group"> <a '.$tbogmsgsclsactive.' href="bogmessages.php"> <i class="icon-envelope"></i> <span>BOG Messages</span></a> </div>
	</li>
	<li>
		<div class="btn-group dropup"> <a '.$tproclsactive.' href="profile.php"> <i class="icon-user"></i> <span>Profile</span></a></div>
	</li>
	<li>
		<div class="btn-group dropup"> <a '.$tpdrylsactive.' href="personaldiary.php"> <i class="icon-file-text"></i> <span>Diary</span></a></div>
	</li>
	<li>
		<div class="btn-group dropup"> <a '.$tstimelsactive.' href="weeklylectureschedule.php"> <i class="icon-time"></i><span>Lecture Schedule</span></a></div>
	</li>
	<li>
		<div class="btn-group dropup"> <a href="#"> <i class="icon-gears"></i> <span>Notice</span></a></div>
	</li>
	<li>
		<div class="btn-group dropup"> <a class="" href="index.php?logout"> <i class="icon-off"></i> <span>Logout</span></a> </div>
	</li>
</ul>
</div>
	<div class="clearfix"></div>
</div>';
?>