<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="assets/css/style.css">
	<script>
		console.log('salut');
		var a = document.getElementsByTagName('a');
		a.onclick = function({
			return false;
		});
	</script>
</head>
<body>
	<header class="inline">
		<div class="logo">
			<p>LOGO</p>
		</div>
		<div class="menu_wrap inline">
			<ul class="menu inline">
				<li><a href="<?= get_home ?>">HOME</a></li>
				<li><a href="<?= get_articles ?>">ARTICLES</a></li>
				<li><a href="<?= getThemes ?>">FORUM</a></li>
				<li><a href="">CONTACT</a></li>
			</ul>
			<div class="authent">
			<?php 
				//Si le user est connecté, on affiche son nom 
				//et le bouton de deconnexion
				if(($user = $this->getConnectedUser())!==false){
					echo $user['use_login'] . ' - connected<br>';
					echo '<a href="'.deconnexion.'">Deconnexion</a>';
				}
				//Sinon on affiche les boutons de connexions
				else{
			?>
				<form action="<?= connexion ?>" method="POST">
					<input type="text" name="login" placeholder="login">
					<input type="password" name="password" placeholder="password"><br />
					<input type="submit" value="connexion">
				</form>
				<a href="<?= showRegisterForm ?>"> - Inscription</a>
			<?php 
				}
			?>
			</div>
		</div>
		<!-- TODO: formulaires de connexion et d'enregistrement -->
	</header>
	<main class="inline-flex">
		<div class="main_content">
			<?php echo $view ?>
		</div>
		<div class="main_sidebar">
			Sidebar

			<?php
			if ($this->hasRole('ROLE_MANAGER')) 
				include('admin/adminMenu.php'); 
			if (!empty($data['messages'])) {
				foreach ($data['messages'] as $value) {
					echo '<br>'.$value;
				}
			}
			?>
		</div>
	</main>
	<footer>
		<p>Tous droits Reserves</p>
	</footer>
	<?php 
	// if (isset($data)) {
	// 	echo '$data<br>';
	// 	var_dump($data);
	// }

	?>
</body>
</html>