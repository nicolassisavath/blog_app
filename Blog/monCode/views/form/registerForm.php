<form action="<?= registration ?>" method="POST">
	<input type="text" name="login" placeholder="login"><br>
	<input type="password" name="password" placeholder="mot de passe"><br>
	<input type="password" name="passwordConf" placeholder="confirmez votre mot de passe"><br>
	<!-- Gerer les roles si user=ADMIN -->
	<?php 
	if ($this->hasRole('ROLE_MANAGER')) {

		$selectView = '<select name="role" id="roles">';
		$selectView .= '<option value=""></option>';
		foreach ($data['roles'] as $role) {
			$selectView .= '<option value="'.$role.'">'.$role.'</option>';
		}
		$selectView .= '</select><br>';

		echo $selectView;
	}
	?>
	<input type="submit">

</form>