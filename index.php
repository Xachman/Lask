<?php
include 'config.php';
include 'inc/site-controler.php';
$sc->checkLogin($sc);
include 'inc/check-login.php';
include 'init.php';
if(file_exists ($sc->rootURL.'inc/init/db-init.php')) {
	include($sc->rootURL.'inc/init/db-init.php');
	die;
}

if($user_ok){
	$sc->displayJsonData($sc);
}
$sc->processAssets($sc);
//This is currently how Im adding my menus This will have to change
$sc->menu = array();
$sc->menu[] = array( $sc->siteURL, 'Home');
$sc->menu[] = array( $sc->siteURL.'logout', 'Logout');



include 'header.php';
if($user_ok){
	if($sc->selectPage($sc)) {
	}else{
	}
}else{
	if(!$isUsers) {
		include($sc->rootURL.'inc/init/add-first-user.php');
	}else{
	 ?>
		<div class="wrapper row">
			<form id="login" action="login-processor" method="post">
			  <div class="">
			   <div class="medium-4 columns">
			   &nbsp;
			   </div>
			    <div class="medium-4 columns">
			    <br><br><br>
			      <div id="error"></div>
			      <label>Email</label>
			      <input type="text" name="email" placeholder="Username" />
			      <label>Password</label>
			      <input type="password" name="password" placeholder="Password" />
			      <div class="row">
			      <div class="small-6 columns">
			      <button id="submit" type="submit" class="tiny">Login</button>
			      </div>
			      <div style="text-align: right;" class="small-6 columns">
			      </div>
			      </div>
			    </div>
			    <div class="medium-4 columns">
			    &nbsp;
			   </div>
			  </div>
			</form>
			<div id="status"></div>
	    </div>
	        	<script type="text/javascript">
		$('#submit').click(function(e){
			e.preventDefault();
			console.log($('#login').serialize);
			$.post('login-processor', $('#login').serialize(), function(data){
				console.log(data);
				if(data == 'success'){
					window.location = '<?php echo $sc->siteURL; ?>';
				}else{
					$('#error').html(data);
				}
			});
		})
		</script>
	<?php
	}
}
include 'footer.php'; ?>
