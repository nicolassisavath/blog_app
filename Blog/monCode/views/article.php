<?php 
	$article = $data['article'];
	$tags = $data['tags'];
	$comments = $data['comments'];
?>
<!-- Display the article -->
<div class="article_wrap">
	<?php 
	$article_view = 
	'
	<h2>'.$article['art_title'].'</h2>
	<p>By <span class="article_author">'.$article['use_login'].'</span> the <span class="article_date">'.$article['art_created'].'</span> :</p>
	<p class="article_content">'.$article['art_content'].'</p>
	';
	echo nl2br($article_view);
	?>
</div>

<!-- Display the tags -->
<div class="tags_wrap">
	<?php 
	if ($tags) {
		foreach ($tags as $tag) {
			$tag_view = '<a href="'.showArticlesByTag.$tag['tag_id'].'" class="tags">'.$tag['tag_name'].'</a>';
			echo nl2br($tag_view);
		}
	}
	?>
</div>

<!-- Display the comments -->
<div class="comments_wrap">
	<h3>Comments</h3>
	<?php 
	// If there are comments, we display them
	if ($comments) {
		foreach ($comments as $comment) {
			$comment_view = 
			'
		<div class="comment_wrap"><br>
			<p><span class="comment_author">'.$comment['com_poster'].'</span> posted the <span class="comment_date">'.$comment['com_created'].'</span> : 
			</p>
			<p class="comment_content">'.$comment['com_content'].
			'<a href="'.showReplyCommentForm.$article['art_id'].'&comId='.$comment['com_id'].'"> Reply to the comment</a>
			</p>
		</div>
			';
			// Display the responses of the comments
			if(!empty($comment['responses'])){
				$responses = $comment['responses'];

				foreach ($responses as $resp) {
					$resp_view = 
					'
				<div  class="resp_wrap"><br>
					<p><span class="resp_author">'.$resp['resp_poster'].'</span> replied the <span class="resp_date">'.$resp['com_created'].'</span> : </p>
					<p class="resp_content">'.$resp['com_content'].'</p>
				</div>
					';
					$comment_view .= $resp_view;
				}
			}
		$comment_view .= '<hr />';
		echo $comment_view;
		}
	}
	else {
		echo 'Soyez le premier à poster un commentaire.';
	}

	if (isset($_SESSION['blog']['user']) && !empty($_SESSION['blog']['user'])) {
		if (isset($data['reply']['com_id']) && !empty($data['reply']['com_id'])) {
			include('form/replyCommentForm.php');
		}
		else {
			include('form/commentForm.php');
		}
	}
	else {
		echo "<br>Connectez vous pour pouvoir poster un commentaire !";
	}
	?>
</div>