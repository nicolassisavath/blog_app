<div class="articles_wrap">
	<?php 
	if (!empty($data['articles'])) {
		foreach ($data['articles'] as $article) {
			$article_view = 
			'
			<div class="article_card">
				<a href="'.get_article.$article['art_id'].'">
					<h2 class="article_title">'.$article['art_title'].'</h2>
					<p>By '.$article['use_login'].' the '.$article['art_created'].' :</p>
					<div class="article_image">'.$article['art_image'].'</div>
					<div class="article_content">'.$article['art_content'].'</div>
				</a>
				<hr />
			</div>
			';
			echo $article_view;
		}
	}
	?>
</div>