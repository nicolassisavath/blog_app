<div class="deleteThemeFormContainer">
	<h3>Are you Sure to delete this theme? This action is not reversible</h3>
	<p><?= $data['the_name'] ?></p><br>
	<a href="<?= deleteTheme.$data['themeId'] ?>">Yes Delete</a>
	<a href="<?= showManagerThemeMenu ?>">No return to Theme menu</a>
</div>