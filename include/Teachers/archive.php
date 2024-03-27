<?php 

if(isset($_GET['id'])) { 
	include_once("archivecourses.php");
} else { 
	include_once("archivedashboard.php");
}

?>