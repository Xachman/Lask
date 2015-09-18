<?php
session_start();
class SiteControl {
	public $rootURL; //= $_SERVER['DOCUMENT_ROOT'].'\taskmanager';
	public $urls = array();
	public $page;
	public $menu;
	public $post;
	public $data;
	public $game;
	public $shop;
	public $debug = true;
	private $css = array();
	private $js = array();
	public function __construct() {
		$args = func_get_args();
		foreach ($args[0] as $key => $val) {
			$this->{$key} = $val;
		}
		$this->sanitizeData();
		$this->processMenus();
	}

	public function filterURLS () {
		$args = func_get_args();

	}
	public function getTemplateFile($file){
		if(file_exists($this->rootURL.'/template/'.$file)){
			return $this->rootURL.'/template/'.$file;
		}elseif(file_exists($this->rootURL.'/core/'.$file)){
			return $this->rootURL.'/core/'.$file;
		}
	}
	private function sanitizeData() {
		if(isset($_GET['p'])) {
			$this->page = preg_replace('#[^a-zA-Z-]#', '', $_GET['p']);
		}
		if(isset($_GET['d'])) {
			$this->data = preg_replace('#[^a-zA-Z-_]#', '', $_GET['d']);
		}
	}
	public function displayJsonData($sc) {
		global $db, $log_id, $user_ok;
		if(isset($_GET['d'])){
			return include($this->rootURL.'/data/'.$this->data.'.php');
		}
	}
	private function getRequestURL() {
		$siteurl = preg_replace('#^http(s)?://#', '', $this->siteURL);
		$siteurl = chop($siteurl, '/');
		$url = str_replace($siteurl, '', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		return $url;
	}
	public function selectPage($sc) {
		global $db, $log_id, $log_username, $user_ok, $db;
		if($this->getRequestURL() == '/') return false;
		$url_ex = explode('/', $this->getRequestURL());

		$this->page = $url_ex[1];
		if(file_exists($this->rootURL.'/template/'.$this->getRequestURL().'.php')){
			return include($this->rootURL.'/template/'.$this->getRequestURL().'.php');
		}elseif(file_exists($this->rootURL.'/core/'.$this->getRequestURL().'.php')){
			return include($this->rootURL.'/core/'.$this->getRequestURL().'.php');
		}else{
			$this->page404();
		}

	}
	public function checkLogin($sc) {
		$url = explode('/', $this->getRequestURL());
		if($url[1] == 'login-processor') {
			if(file_exists($this->rootURL.'/template/'.$url[1] .'.php'))
				return include($this->rootURL.'/template/'.$url[1] .'.php');
			else if(file_exists($this->rootURL.'/core/'.$url[1] .'.php'))
				return include($this->rootURL.'/core/'.$url[1] .'.php');
			die;
		}
	}
	function processAssets($sc) {
		$url = explode('/',$this->getRequestURL());
		//var_dump($this->getRequestURL());
		if($url[1] == 'css' || $url[1] == 'js') {
			$this->processAssetRequest($url, $sc);
			die;
		}
	}
	private function processAssetRequest($url, $sc) {
		$count = count($url) - 1;
		if(strstr($url[$count], '?', true)) $url[$count] = strstr($url[$count], '?', true);
		$php_check = explode('.',end($url));

		//var_dump($url);
		if(!isset($php_check[1]) && $php_check[0]){
			if(file_exists($this->rootURL.'/template/css/'.$url[2].'.php')){
				return include($this->rootURL.'/template/css/'.$url[2].'.php');
			}else{
				//var_dump($url);
				return include($this->rootURL.'/core/css/'.$url[2].'.php');
			}
		}else{
		//	var_dump($url);
			if(file_exists ($this->rootURL.'/template/'.$url[1].'/'.$url[2]))
				return include($this->rootURL.'/template/'.$url[1].'/'.$url[2]);
			elseif(file_exists ($this->rootURL.'/core/'.$url[1].'/'.$url[2]))
				return include($this->rootURL.'/template/'.$url[1].'/'.$url[2]);
			else
				$this->page404();
		}
	}
	public function page404() {
		if(file_exists($this->rootURL.'/template/404.php'))
			return include($this->rootURL.'/template/404.php');
		else
			return include($this->rootURL.'/core/404.php');
	}
	public function message($message, $link, $link_text) {
		$_SESSION['message'] = $message;
		$_SESSION['link'] = $link;
		$_SESSION['link_text'] = $link_text;
		header('location: '.$this->siteURL.'?p=message');
	}
	public function checkDbf() {
		global $db, $log_id, $log_username, $user_ok, $db;
		$url = explode('/', $this->getRequestURL());
		if($url[1] == 'dbf') {
			return include($this->rootURL.'/dbf/'.$url[2].'.php');
		}else{
			return false;
		}
	}
	public function displayCss() {

		$html = '';
		foreach ($this->css as $url) {
			if(substr($url, 0) == '/' && substr($url, 1) != '/'){
				$url = substr_replace($url, '', 0, 1);
			}
			$html .= '<link rel="stylesheet" href="'.$url.'">';
		}
		//var_dump($html);
		return $html;
	}
	public function css($url) {
		$this->css[] = $url;
	}
	public function displayJsTop() {
		$html = '';
		foreach ($this->js as $url => $top) {
			if($top) $html .= '<script src="'.$url.'" type="text/javascript"></script>';
		}
		return $html;
	}
	public function displayJsBottom() {
		$html = '';
		foreach ($this->js as $url => $top) {
			if(!$top) $html .= '<script src="'.$url.'" type="text/javascript"></script>';
		}
		return $html;
	}
	public function js($url, $top = true) {
		$this->js[$url] = $top;
	}
}
// for server $sc = new SiteControl(array('rootURL' => $_SERVER['DOCUMENT_ROOT'].'/', 'siteURL' => '/'));
$sc = new SiteControl(array('rootURL' => ROOT_URL, 'siteURL' => SITE_URL));
//var_dump($sc->rootURL);
if ($sc->debug) {
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
}
