<?php
include($sc->rootURL.'core/inc/db_conx.php');
class Login {
  private $db;
  private $ip;
  function __construct($db) {
      $this->db = $db;
      $this->ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
  }
  public function failed_login($e) {
  	if(!$this->db->query_row("UPDATE login_attempts SET attempts=attempts + 1, username='$e', last_attempt=NOW() WHERE ip='$this->ip' LIMIT 1")){
      $this->db->insert_row("INSERT INTO login_attempts (ip, attempts, username, last_attempt) VALUES ('$this->ip', 1, '$e', NOW())");
    }
    echo 'login failed';
    die;
  }
  public function check_login($e) {
    $row = $this->db->select_row("SELECT attempts, throttle FROM login_attempts WHERE ip='$this->ip' LIMIT 1");
    if($row[1] > time()) {
      die('You must wait '.date('i',  $row[1] - time()).' minutes before logging in again.');
    }elseif($row[0] > 4){
      $time = strtotime('+ 5 minutes');
      $this->db->query_row("UPDATE login_attempts SET throttle='$time', username='$e', attempts=0 WHERE ip='$this->ip'  LIMIT 1");
      die('You must wait 5 minutes before logging in again.');
    }
  }
  public function reset_attempts($e) {
  	$this->db->query_row("UPDATE login_attempts SET attempts=0, username='$e' WHERE ip='$this->ip' LIMIT 1");
  }
  public function login_success($db_username) {
    $this->db->query_row("UPDATE users SET ip='$this->ip', last_login=now() WHERE username='$db_username' LIMIT 1");
    echo 'success';
    exit();
  }
  public function set_throttle($conx, $e, $time) {
  	if(!isset($time)){
  		$time = strtotime('5 minutes');
  	}
  	$this->db->query_row("UPDATE login_attempts SET throttle='$time' WHERE ip='$this->ip' LIMIT 1");
  }
  public function adjust_attempts($conx, $e, $a) {
  	$this->db->query_row("UPDATE login_attempts SET attempts=$a WHERE ip='$this->ip' LIMIT 1");
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
