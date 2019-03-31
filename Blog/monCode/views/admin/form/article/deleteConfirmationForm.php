<div class="deleteConfirmation">
	<p>Are you sure you want to delete the article :</p>
	<p><?= $data['art_title']  ?></p>
	<p>This action is not reversible.</p>
	<a href="<?= deleteArticle.'&artId='.$data['art_id']?>">Yes</a>
	<a href="<?= showManagerArticleMenu ?>">No return to the menu</a>
</div>