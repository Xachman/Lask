<?php
include($sc->rootURL.'inc/db_conx.php');
class Login {
  private $db;
  function __construct($db) {
      $this->db = $db;
  }
  public function failed_login($conx, $e, $ip) {
    //var_dump($this->db->query_row("UPDATE login_attempts SET attempts=attempts + 1, username='$e' WHERE ip='$ip' LIMIT 1"));
  	if(!$this->db->query_row("UPDATE login_attempts SET attempts=attempts + 1, username='$e' WHERE ip='$ip' LIMIT 1")){
      $this->db->insert_row("INSERT INTO login_attempts (ip, attempts, username) VALUES ('$ip', 1, '$e')");
    }

  }

  public function login_success($conx, $e, $ip) {
  	$this->db->query_row("UPDATE login_attempts SET attempts=0, username='$e' WHERE ip='$ip' LIMIT 1");
  }
  public function set_throttle($conx, $e, $ip, $time) {
  	if(!isset($time)){
  		$time = strtotime('5 minutes');
  	}
  	$this->db->query_row("UPDATE login_attempts SET throttle='$time' WHERE ip='$ip' LIMIT 1");
  }
  public function adjust_attempts($conx, $e, $ip, $a) {
  	$this->db->query_row("UPDATE login_attempts SET attempts=$a WHERE ip='$ip' LIMIT 1");
  }
  public function crypt_pass($input, $rounds = 10) {
  	$salt = "";
  	$saltChars = array_merge(range('A','Z'), range('a','z'), range(0,9));
  	for($i = 0; $i < 22; $i++){
  		$salt .= $saltChars[array_rand($saltChars)];
  	}
  	return crypt($input, sprintf('$2y$%02d$', $rounds) . $salt);
  }

  public function check_pass($input, $hp) {
  	if(crypt($input, $hp) === $hp){
  		return true;
  	}else {
  		return false;
  	}
  }
}
$login = new Login($db);
