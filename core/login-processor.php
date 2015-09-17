<?php
include($sc->rootURL.'inc/class-login.php');
include_once($sc->rootURL.'inc/db_conx.php');

if (isset($_POST['email'])){


	$e = mysqli_real_escape_string($db_conx, $_POST['email']);
	$p = $_POST['password'];
	$login->check_login($e);


	if($e == "" || $p == "") {
		echo "login failed";
		$login->failed_login($db_conx, $e);
		exit();
	} else {
		$row= $db->select_row("SELECT id, username, password, level FROM users WHERE email='$e' LIMIT 1");
		$db_id = $row[0];
		$db_username = $row[1];
		$db_pass_str = $row[2];
		if (!$login->check_pass($p, $db_pass_str)) {
			echo "login failed";
			$login->failed_login($db_conx, $e);
			exit();
		} else {
			$login->login_success($db_conx, $e);
			$_SESSION['userid'] = $db_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_pass_str;
			setcookie("id", $db_id, strtotime('+30 days'), "/", "", "", TRUE);
			setcookie("id", $db_username, strtotime('+30 days'), "/", "", "", TRUE);
			setcookie("id", $db_pass_str, strtotime('+30 days'), "/", "", "", TRUE);
			$sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE username='$db_username' LIMIT 1";
			$query = mysqli_query($db_conx, $sql);
			echo 'success';
			exit();
		}
	}
	exit();
}
