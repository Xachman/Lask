<?php
include 'core/init.php';

if(file_exists($sc->rootURL.'core/inc/init/db-init.php')) {
	include($sc->rootURL.'core/inc/init/db-init.php');
}
include $sc->load_template_init();
if($user_ok){
	$sc->displayJsonData($sc);
}
$sc->processAssets($sc);
//This is currently how Im adding my menus This will have to change
$sc->menu = array();
$sc->menu[] = array( $sc->siteURL, 'Home');
$sc->menu[] = array( $sc->siteURL.'logout', 'Logout');



include $sc->getTemplateFile('header.php');
if($user_ok){
	if($sc->selectPage($sc)) {
	}else{
	}
}else{
	if(!$sc->isUsers) {
		include($sc->rootURL.'inc/init/add-first-user.php');
	}else{
		if(file_exists($sc->rootURL.'template/login.php'))
			include($sc->rootURL.'template/login.php');
		else
			include($sc->rootURL.'login.php');
	}
}
include $sc->getTemplateFile('footer.php'); ?>
