<?php
//include('site-controler.php');
include('db_conx.php');
include($sc->rootURL.'/functions.php');

$user_ok = false;
$log_id = '';
$log_username = '';
$log_password = '';
$is_admin = false;
function evalUser($conx, $id, $u, $p) {
	$sql = "SELECT ip FROM users WHERE id='$id' AND username='$u' AND password='$p' LIMIT 1";
	$query = mysqli_query($conx, $sql);
	$numrows = mysqli_num_rows($query);
	if($numrows > 0){
		return true;
	}
}
function checkAdmin($db, $log_id) {
	//global $db, $log_id;
	$row = $db->select_row("SELECT level FROM users WHERE id='$log_id'");
	
	if($row[0] == 10){
		//var_dump($is_admin);
		return true;
	}
}
if(isset($_SESSION['userid']) && isset($_SESSION['username']) && isset($_SESSION['password'])) {
	$log_id = preg_replace('#[^0-9]#i', '', $_SESSION['userid']);
	$log_username = preg_replace('#[^a-z0-9]#i', '', $_SESSION['username']);
	$log_password = preg_replace('#[^a-z0-9/$.]#i', '', $_SESSION['password']);
	$user_ok = evalUser($db_conx, $log_id, $log_username, $log_password);
}else if(isset($_COOKIE['id']) && isset($_COOKIE['user']) && isset($_COOKIE['pass'])) {
	// $_SESSION['userid'] = preg_replace('#[^0-9]#i', '', $_COOKIE['id']);
	// $_SESSION['username'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['user']);
	// $_SESSION['password'] = preg_replace('#[^a-z0-9/$.]#i', '', $_COOKIE['passw']);
	// $log_id = $_SESSION['userid'];
	// $log_username = $_SESSION['username'];
	// $log_password = $_SESSION['password'];
	// $user_ok = evalUser($db_conx, $log_id, $log_username, $log_password);
	// if($user_ok == true) {
	// 	$sql = "UPDATE user SET lastlogin=now() WHERE id='$log_id' LIMIT 1";
	// 	$query = mysqli_query($conx, $sql);
	// }
}
if($user_ok){
	$is_admin = checkAdmin($db, $log_id, $is_admin);
	//var_dump($is_admin);
}