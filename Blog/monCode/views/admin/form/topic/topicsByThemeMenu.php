<div class="topicMenuContainer">	
	<form action="<?= selectTopicEvent.$data['themeId'] ?>" method="POST">
		<select name="topicId" size="5">
			<?php 
			foreach ($data['topics'] as $topic) {
				$published = ($topic['top_enabled']==1) ? 'published': 'unpublished';
				$topicView = '
				<option value="'.$topic['top_id'].'">'.$topic['top_id'].' - '.$topic['top_title'].' - '.$topic['top_author'].' - '.$published.' - '.$topic['top_created'].'</option>
				';
				echo $topicView;
			}
			?>
		</select><br>
		<input type="submit" name="action" value="New">			
		<input type="submit" name="action" value="Display">			
		<input type="submit" name="action" value="Update">			
		<input type="submit" name="action" value="Delete">					
	</form>

</div>