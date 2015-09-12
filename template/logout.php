<?php
session_start();

$_SESSION = array();

if(isset($_COOKIE['id']) && isset($_COOKIE['user']) && isset($_COOKIE['pass'])) {
	setcookie('id', '', strtotime('-5 days'), '/');
	setcookie('user', '', strtotime('-5 days'), '/');
	setcookie('pass', '', strtotime('-5 days'), '/');
}


session_destroy();

header('location: '.$sc->siteURL);