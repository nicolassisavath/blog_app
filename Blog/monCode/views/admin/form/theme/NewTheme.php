<div class="newThemeForm">
	<h3>Create a new theme : </h3>
	<form action="<?= postTheme ?>" method="POST">
		<input type="text" name="name" placeholder="Write the theme's name..." value="<?php if (!empty($data['name'])){echo $data['name'];} ?>"><br>
		<input type="submit" value="Create">
		<a href="<?= showManagerThemeMenu ?>">Return to Theme Menu</a>
	</form>
</div>