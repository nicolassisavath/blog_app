<div class="ManagerThemeMenuContainer">
	<form action="<?= selectThemeEvent ?>" method="POST">
		<select name="themeId" size="5">
		<?php 
		foreach ($data['themes'] as $theme) {
			echo 
			'
			<option value="'.$theme['the_id'].'"> '.$theme['the_name'].' - '.$theme['the_created'].' </option>
			';
		}

		?>
		</select><br>
		<input type="submit" name="action" value="New">
		<input type="submit" name="action" value="Update">
		<input type="submit" name="action" value="DisplayTopics">
		<input type="submit" name="action" value="Delete"><br>
	</form>
</div>