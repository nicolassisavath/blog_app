<div class="updateThemeContainer">
	<h3>Modify the Theme.</h3>
	<form action="<?= updateTheme.$data['themeId'] ?>" method="POST">
		<input type="text" name="the_name" value="<?php if(!empty($data['the_name'])){echo $data['the_name'];} ?>">
		<input type="submit" value="Update">	
		<a href="<?= showManagerThemeMenu ?>">Return to Theme Menu</a>
	</form>
</div>