<?php
include 'config.php';
include 'inc/site-controler.php';
$sc->checkLogin($sc);
include 'inc/check-login.php';
include 'init.php';
if(file_exists ($sc->rootURL.'inc/init/db-init.php')) {
	include($sc->rootURL.'inc/init/db-init.php');
	die;
}

if($user_ok){
	$sc->displayJsonData($sc);
}
$sc->processAssets($sc);
//This is currently how Im adding my menus This will have to change
$sc->menu = array();
$sc->menu[] = array( $sc->siteURL, 'Home');
$sc->menu[] = array( $sc->siteURL.'logout', 'Logout');



include 'header.php';
if($user_ok){
	if($sc->selectPage($sc)) {
	}else{
	}
}else{
	if(!$isUsers) {
		include($sc->rootURL.'inc/init/add-first-user.php');
	}else{
		if(file_exists($sc->rootURL.'template/login.php'))
			include($sc->rootURL.'template/login.php');
		else
			include($sc->rootURL.'login.php');
	}
}
include 'footer.php'; ?>
