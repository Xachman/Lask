<!DOCTYPE html>
<html>
	<head>
		<title> App Template </title>
		<meta charset="utf-8">
		<?php echo $sc->displayCss(); ?>
		<?php echo $sc->displayJsTop(); ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<header>
			<div class="title">App Template</div>
			<?php if($user_ok){ ?>
			<nav>
				<ul>
					<?php
						foreach ($sc->menu as $menu) {
							echo '<li><a href="'.$menu[0].'">'.$menu[1].'</a></li>';
						}
					?>
				<ul>
				<?php
				if($is_admin && isset($sc->adminMenu)){
					echo '<ul>';
							foreach ($sc->adminMenu as $menu) {
								echo '<li><a href="'.$menu[0].'">'.$menu[1].'</a></li>';
							}
					echo'</ul>';
				}
				?>
			</nav>
			<?php } ?>
		</header>