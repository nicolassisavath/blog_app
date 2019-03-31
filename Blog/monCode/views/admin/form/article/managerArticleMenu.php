
<div class="articleManager">
	<form action="<?= selectManagerArticleForm ?>" method="POST">
		<select name="artId" size="10">
		<?php 
		foreach ($data['articles'] as $article) {
			$published = ($article['art_enabled']==0) ? 'not published': 'published';
			$class = ($article['art_enabled']==0) ? 'not_published' : '';

			echo '<option value="'.$article['art_id'].'" class="'.$class.'">'.$article['art_id'].' - '.$article['art_title'].' - '.$article['use_login'].' - '.$published.' - '.$article['art_created'].'</option>';
		}
		?>
		</select><br>
		<input type="submit" name="action" value="new">
		<input type="submit" name="action" value="display">
		<input type="submit" name="action" value="edit">
		<input type="submit" name="action" value="delete">
	</form>
</div>