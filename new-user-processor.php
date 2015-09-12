<?php
if(isset( $_POST['user'])){
	include_once('inc/db_conx.php');
	$f = preg_replace('#[^a-z ]#i', '', $_POST['first_name']);
	$l = preg_replace('#[^a-z ]#i', '', $_POST['last_name']);
	$u = preg_replace('#[^a-z0-9]#i', '', $_POST['user']);
	$p1 = $_POST['addpass'];
	$p = $_POST['checkpass'];
	$e = mysqli_real_escape_string($db_conx, $_POST['email']);
	$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// duplicate data checks for username and email
	$e = strtolower($e);
	$u_check = $db->select_row("SELECT id FROM users WHERE username='$u' LIMIT 1");
	// --------------------------------
	$e_check = $db->select_row("SELECT id FROM users WHERE email='$e' LIMIT 1");

		if($u == "" || $f == "" || $l == "" || $p == "" || $e == "" ) {
			echo "Plese fill the entire form";
			exit();
		}else if ($u_check > 0) {
			echo "The username is taken";
			exit();
		}else if ($e_check > 0) {
			echo "The email is already being used";
			exit();
		}else if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $e)){
		    echo"E-mail address not valid. ";
			exit();
		}else if (strlen($u) < 3 || strlen($u) > 16) {
			echo "Username must be between 3 and 16 characters";
			exit();
		}else if (is_numeric($u[0])) {
			echo 'The username must start with a letter.';
			exit();
		}else if(strlen($p1) < 8) {
			echo "Your password must be at least 8 characters long.";
			exit();
		}else if ($p1 != $p){
			echo "Your passwords are not the same.";
			exit();
		} else {
			//password hash
			$generatedKey = sha1(mt_rand(10000,99999).time().$e);
			$p_hash = crypt_pass($p);			
			$sql = "INSERT INTO users (first_name, last_name, username, email, password, signup, last_login, ip, activation_key)
					VALUES ('$f', '$l', '$u', '$e', '$p_hash', now(), now(), '$ip', '$generatedKey')";
			$query = mysqli_query($db_conx, $sql);
			$uid = mysqli_insert_id($db_conx);
			// establish their row	in useroptions
			$plays = 5;
			$sql = "INSERT INTO user_globals (id, plays) VALUES ('$uid', '$plays')";
			$query = mysqli_query($db_conx, $sql);
			// Email the user their email activation link
			$to = "$e";
			$from = "auto_responder@gtigames.com";
			$from_user = "auto_responder";
			$subject = 'Your email comfirmation';
			$message = 'Click this link to activate your account. <br><a href="http://gtigames.com?d=activation&key='.$generatedKey.'&u='.$u.'">Click Here to Activate</a>';
			$headers = 'From: '.$from."\r\n";
			$headers .= 'MIME-Version: 1.0'. "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1';
			if(mail($to, $subject, $message, $headers)){
				echo "signup_success";
			}else{
				echo 'There was an error sending your activation email. <a href="/login">Click here</a> to login and you can resend the email.';
			}
			exit();
		}
	}
	if($isUsers){
		exit();
	}
