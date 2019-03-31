<form action="<?= updateArticle.'&artId='.$data['article']['art_id'] ?>" method="POST">
	Title:
	<input type="text" name="title" value="<?= $data['article']['art_title'] ?>"><br>
	<!-- Select the author -->
	Author:
	<select name="user">
		<?php 
		foreach ($data['users'] as $user) {
			$selected=($user['use_id'] == $data['article']['use_id']) ? 'selected' :'';
			echo '<option value="'.$user['use_id'].'" '.$selected.'>'.$user['use_login'].'</option>' ;
		}
		?>
	</select><br>
	<!-- Content -->
	<textarea name="content" rows="15" cols="50"><?= $data['article']['art_content']?></textarea><br>
	<!-- Tags -->
	Tags : <br>
	<select name="tags[]" multiple size="4">
		<?php 
		foreach ($data['tags'] as $tag) {
			$selected = (in_array($tag['tag_id'], $data['currentTagsId']))?'selected':'';
			echo '<option value="'.$tag['tag_id'].'" '.$selected.'>'.$tag['tag_name'].'</option>';
		}
		?>
	</select><br>
	<!-- Published status -->
	<select name="enabled">
		<?php 
			$selectedPublished = ($data['article']['art_enabled']==1)?'selected':'';
			$selectedNotPublished = ($data['article']['art_enabled']==0)?'selected':'';
		?>
		<option value="1" <?= $selectedPublished ?>>PUBLISHED</option>
		<option value="0" <?= $selectedNotPublished ?>>NOT PUBLISHED</option>
	</select>
	<input type="submit">
</form>
	<a href="<?= showManagerArticleMenu ?>">Retour</a>
