
<form action="<?= postArticle ?>" method="POST">
	<h3>NEW ARTICLE</h3>
	<input type="text" name="title" placeholder="Write thte title" value="<?php if(isset($data['title'])){echo $data['title'];} ?>"><br>
	<textarea name="content" rows="10" cols="50" placeholder="Write the content"><?php if(isset($data['content'])){echo nl2br($data['content']);} ?></textarea><br>
	Select Tags:<br>
	<select name="tags[]" size="4" multiple>
		<?php 
		foreach ($data['tags'] as $tag) {
			echo '<option value="'.$tag['tag_id'].'">'.$tag['tag_name'].'</option>';
		}
		?>
	</select><br>
	Publish :
	<select name="enabled">
		<option value="0">NOT NOW</option>
		<option value="1">YES</option>
	</select><br>
	<input type="submit">
</form>
	<a href="<?= showManagerArticleMenu ?>">Retour</a>

	<?php 
	// if(isset($data))
	// 	var_dump($data);
	?>