<?php
include($sc->rootURL.'core/inc/class-login.php');
include_once($sc->rootURL.'inc/db_conx.php');

if (isset($_POST['email'])){


	$e = mysqli_real_escape_string($db_conx, $_POST['email']);
	$p = $_POST['password'];
	$login->check_login($e);


	if($e == "" || $p == "") {
		$login->failed_login($e);
	} else {
		$row= $db->select_row("SELECT id, username, password, level FROM users WHERE email='$e' LIMIT 1");
		$db_id = $row[0];
		$db_username = $row[1];
		$db_pass_str = $row[2];
		if (!$login->check_pass($p, $db_pass_str)) {
			$login->failed_login($e);
		} else {
			$login->reset_attempts($e);
			$_SESSION['userid'] = $db_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_pass_str;
			setcookie("id", $db_id, strtotime('+30 days'), "/", "", "", TRUE);
			setcookie("id", $db_username, strtotime('+30 days'), "/", "", "", TRUE);
			setcookie("id", $db_pass_str, strtotime('+30 days'), "/", "", "", TRUE);
			$login->login_success($db_username);
		}
	}
	exit();
}
