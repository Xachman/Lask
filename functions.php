<?php

function crypt_pass($input, $rounds = 10) {
	$salt = "";
	$saltChars = array_merge(range('A','Z'), range('a','z'), range(0,9));
	for($i = 0; $i < 22; $i++){
		$salt .= $saltChars[array_rand($saltChars)];
	}
	return crypt($input, sprintf('$2y$%02d$', $rounds) . $salt);
}

function check_pass($input, $hp) {
	if(crypt($input, $hp) === $hp){
		return true;
	}else {
		return false;
	}
}

function failed_login($conx, $e, $ip) {
	$sql = "UPDATE login_attempts SET attempts=attempts + 1, username='$e' WHERE ip='$ip' LIMIT 1";
	$query = mysqli_query($conx, $sql);
}

function login_success($conx, $e, $ip) {
	$sql = "UPDATE login_attempts SET attempts=0, username='$e' WHERE ip='$ip' LIMIT 1";
	$query = mysqli_query($conx, $sql);
}
function set_throttle($conx, $e, $ip, $time) {
	if(!isset($time)){
		$time = strtotime('5 minutes');
	}
	$sql = "UPDATE login_attempts SET throttle='$time' WHERE ip='$ip' LIMIT 1";
	$query = mysqli_query($conx, $sql);
}
function adjust_attempts($conx, $e, $ip, $a) {
	$sql = "UPDATE login_attempts SET attempts=$a WHERE ip='$ip' LIMIT 1";
	$query = mysqli_query($conx, $sql);
}