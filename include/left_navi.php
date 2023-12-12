<?php 
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "dashboard")) {
	$lhomeclsactive = 'class="open"';
	$thomeclsactive = 'class="heading-menu-active"';
} else { 
	$lhomeclsactive 	= '';
	$thomeclsactive = '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "gallery")) {
	$lgalclsactive  = 'class="open"';
	$tgalclsactive  = 'class="heading-menu-active"';
} else { 
	$lgalclsactive  = '';
	$tgalclsactive	= '';
}

//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "users") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "userfiles")) {
	$luserclsactive 	= 'class="open"';
	$luserlvis			= 'style="display:block; visibility:visible;"';
	$tgallclsactive 	= 'class="heading-menu-active"';
} else { 
	$luserclsactive 	= '';
	$luserlvis			= '';
	$tgallclsactive 	= '';
}
//----------------------------------------
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "administrators") || (strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "postcategory")) {
	$lsetclsactive 	= 'class="open"';
	$lsetvis		= 'style="display:block; visibility:visible;"';
	$tsetclsactive 	= 'class="heading-menu-active"';
} else { 
	$lsetclsactive 	= '';
	$lsetvis		= '';
	$tsetclsactive 	= '';
	
}



//----------------------------------------
$lefttitlename = "";
if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "dashboard")) { 
	$lefttitlename 	= 'Dashboard';
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-home"></i> Dashboard</h2>';
}  else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "gallery")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-camera"></i> Manage Gallery</h2>';
	$lefttitlename 	= 'Manage Gallery';
}  else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "users")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-user"></i> Manage Users</h2>';
	$lefttitlename 	= 'Manage Users';
}  else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "userfiles")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-file-alt"></i> Manage User Files</h2>';
	$lefttitlename 	= 'Manage User Files';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "domains")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-file-alt"></i> Manage Domain Level</h2>';
	$lefttitlename 	= 'Manage Domain Level';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "plo")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-file-alt"></i> Manage PLOs</h2>';
	$lefttitlename 	= 'Manage PLOs';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "obehome")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-file-alt"></i> OBE Home</h2>';
	$lefttitlename 	= 'OBE Home';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "items")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-file-alt"></i>Items</h2>';
	$lefttitlename 	= 'Items';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "categories")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-file-alt"></i>Categories</h2>';
	$lefttitlename 	= 'Categories';
}else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "sub-categories")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-file-alt"></i>Sub Categories</h2>';
	$lefttitlename 	= 'Categories';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "vendors")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-file-alt"></i>Vendors</h2>';
	$lefttitlename 	= 'Vendors';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "issuance")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-file-alt"></i>Issuance</h2>';
	$lefttitlename 	= 'Issuance';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "demand")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-file-alt"></i>Demand</h2>';
	$lefttitlename 	= 'Demand';
} else if((strstr(basename($_SERVER['REQUEST_URI']), '.php', true) == "purchase_order")) { 
	$toptitlename 	= '<h2 class="pull-left responsive-heading-title"><i class="icon-file-alt"></i>Purchase Order</h2>';
	$lefttitlename 	= 'Demand';
}

//----------------------------------------
echo '
<!-- Sidebar -->
<div class="sidebar">
<!--SIDE MENU - ONLOAD -->
<div class="sidebar-dropdown"><a href="#">'.$lefttitlename.'</a></div>
<ul id="nav" class="main-nav">
	<div class="nav_logo"> <img class="img-responsive" src="images/logo.png" alt="Minhaj University Lahore"> </div>
	<li class="nav_alternative">  
		<ul class="nav_alternative_controls" tabindex="-1" data-reactid=".1.0.1.0">
			<li class="url-link" data-link=""><i class="icon-file-text"></i></li>
			<li class="url-link" data-link=""><i class="icon-list-ul"></i> </li>
			<li class="url-link" data-link=""><i class="icon-time"></i></li>
			<li class="url-link" data-link=""><i class="icon-sitemap"></i></li>
			<li class="url-link" data-link=""><i class="icon-wrench"></i></li>
		</ul>
	</li>
	<li> <a href="dashboard.php" '.$lhomeclsactive.'> <i class="icon-home"></i> Dashboard<span class="pull-right"></span></a> </li>
	<li> <a href="gallery.php" '.$lgalclsactive.'> <i class="icon-camera"></i> Manage Gallery<span class="pull-right"></span></a> </li>

	<li class="has_sub"> <a href="javascript:void(0)"> <i class="icon-file-text"></i> OBE System<span class="pull-right"><i class="icon-chevron-right" style="font-size:12px"></i></span></a>
		<ul>
			<li> <a href="obe/obedomainlevels.php"> <i class="icon-file-text"></i> Manage Domains<span class="pull-right"></span></a> </li>
			<li> <a href="obeplos.php"> <i class="icon-file-text"></i> Manage PLOs<span class="pull-right"></span></a> </li>
			<li> <a href="obehome.php"> <i class="icon-file-text"></i> OBE Home<span class="pull-right"></span></a> </li>		
		</ul>
	</li>
	<li class="has_sub"> <a href="javascript:void(0)"> <i class="icon-file-text"></i> SMS System<span class="pull-right"><i class="icon-chevron-right" style="font-size:12px"></i></span></a>
		<ul>
			<li> <a href="items.php"> <i class="icon-file-text"></i>Items<span class="pull-right"></span></a> </li>
			<li> <a href="categories.php"> <i class="icon-file-text"></i>Categories<span class="pull-right"></span></a> </li>
			<li> <a href="sub_categories.php"> <i class="icon-file-text"></i>Sub Categories<span class="pull-right"></span></a> </li>
			<li> <a href="vendors.php"> <i class="icon-file-text"></i>Vendors<span class="pull-right"></span></a> </li>
			<li> <a href="issuance.php"> <i class="icon-file-text"></i>Item Issuance<span class="pull-right"></span></a> </li>
			<li> <a href="demand.php"> <i class="icon-file-text"></i>Demand<span class="pull-right"></span></a> </li>
			<li> <a href="purchase_order.php"> <i class="icon-file-text"></i>PO<span class="pull-right"></span></a> </li>
		</ul>
	</li>

	
	';
//-------------------------------------------------
if($_SESSION['userlogininfo']['LOGINIDA_SSS'] == 1 || $_SESSION['userlogininfo']['LOGINIDA_SSS'] == 2) {
echo '
	<li class="has_sub"> <a href="javascript:void(0)" '.$lsetclsactive.'> <i class="icon-gears"></i> Settings<span class="pull-right"><i class="icon-chevron-right" style="font-size:12px"></i></span></a>
		<ul '.$lsetvis.'>
			<li><a href="administrators.php">Manage Admins</a></li>
		</ul>
	</li>';
//-------------------------------------------------
}
//-------------------------------------------------
echo '	
</ul>
<!--SIDE MENU - ONLOAD -->
</div>
<!-- Sidebar ends -->';
?>