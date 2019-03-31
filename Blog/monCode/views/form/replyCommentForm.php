<form action="<?= replyComment.$article['art_id'].'&comId='.$data['reply']['com_id']  ?>" method="POST">
	<h3>Reply to the selected comment</h3>
	<textarea name="content" placeholder="Reply to the comment"></textarea><br>
	<input type="submit">
</form>