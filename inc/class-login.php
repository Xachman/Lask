<?php
class login {
  public function failed_login($conx, $e, $ip) {
  	$sql = "UPDATE login_attempts SET attempts=attempts + 1, username='$e' WHERE ip='$ip' LIMIT 1";
  	$query = mysqli_query($conx, $sql);
  }

  public function login_success($conx, $e, $ip) {
  	$sql = "UPDATE login_attempts SET attempts=0, username='$e' WHERE ip='$ip' LIMIT 1";
  	$query = mysqli_query($conx, $sql);
  }
  public function set_throttle($conx, $e, $ip, $time) {
  	if(!isset($time)){
  		$time = strtotime('5 minutes');
  	}
  	$sql = "UPDATE login_attempts SET throttle='$time' WHERE ip='$ip' LIMIT 1";
  	$query = mysqli_query($conx, $sql);
  }
  public function adjust_attempts($conx, $e, $ip, $a) {
  	$sql = "UPDATE login_attempts SET attempts=$a WHERE ip='$ip' LIMIT 1";
  	$query = mysqli_query($conx, $sql);
  }
}
