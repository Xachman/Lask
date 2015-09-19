<?php
include 'config.php';
include 'inc/site-controler.php';
$sc->checkLogin($sc);
include 'inc/check-login.php';
$sc->load_init($sc);

//add css and js here
$sc->css('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
$sc->css($sc->siteURL.'css/sasscompiler?p=sass.scss');
$sc->css('http://fonts.googleapis.com/css?family=Droid+Serif:400,700|Roboto:400,700');
$sc->js('//code.jquery.com/jquery-1.11.3.min.js');
$sc->js('//code.jquery.com/ui/1.11.4/jquery-ui.js');



//Check if there is a user
if($db->tableExists('users')){
	$sc->isUsers = $db->select_row("SELECT id FROM users LIMIT 1");
	if(!$sc->isUsers) {
		include $sc->rootURL.'new-user-processor.php';
	}
}
