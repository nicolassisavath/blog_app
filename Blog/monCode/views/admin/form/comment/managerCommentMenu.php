<div class="commentManager">
	<table style="border-collapse:collapse;">
		<thead>
			<tr>
				<th>
					<a href="<?= showCommentsById ?>">Id</a>
				</th>
				<th>
					<a href="<?= showCommentsByAuthor ?>">Author</a>
				</th>
				<th>
					<a href="<?= showCommentsByContent ?>">Content</a>
				</th>
				<th>
					<a href="<?= showCommentsByArtTitle ?>">Art-Title</a>
				</th>
				<th>
					<a href="<?= showCommentsByPublished ?>">Published</a>
				</th>
				<th>
					<a href="<?= showCommentsByAlert ?>">Alert</a>
				</th>
				<th>
					Action
				</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			if (!empty($data['comments']))
			{
				foreach ($data['comments'] as $comment) {
					$commentView = 
					'
				<tr>
					<td>'.$comment['com_id'].'</td>
					<td>'.$comment['use_login'].'</td>
					<td>'.substr($comment['com_content'], 0, 15).'</td>
					<td>'.$comment['art_title'].'</td>
					<td>'.$comment['com_enabled'].'</td>
					<td>'.$comment['com_alert'].'</td>
					<td>
						<a href="'.displayComment.'">Display</a><br>
						<a href="'.showUpdateCommentForm.'">Edit</a><br>
						<a href="'.showDeleteCommentForm.'">Delete</a>
					</td>
					
				</tr>
					';
					echo $commentView;
				}
			}
			?>
		</tbody>
	</table>
</div>