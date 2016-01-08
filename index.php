<?php
include 'core/init.php';

if(file_exists($sc->rootURL.'core/inc/init/db-init.php')) {
	include($sc->rootURL.'core/inc/init/db-init.php');
}
if($sc->load_template_init()){
  include $sc->load_template_init();
}

if($user_ok || isset($_GET['d']) && $_GET['d'] == 'status'){
	$sc->displayJsonData($sc);
}
$sc->processAssets($sc);
include $sc->getTemplateFile('header.php');
if($user_ok){
	$sc->selectPage($sc);
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
