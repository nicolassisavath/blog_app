<?php 
if (!$this->hasRole('ROLE_USER'))
	echo 'Connect to post a comment.<br>';
else {
	include(VIEW_PATH.DS.'form/postForm.php');
}
if (empty($data['posts']))
	echo 'No post in this topic.<br>';
else{
?>
	<div class="postsContainer">
		<table class="conversation" border="1">
			<thead>
				<tr>
					<th class="firstCol"></th>
					<th><?= $data['posts'][0]['top_title'] ?></th>
				</tr>
			</thead>
			<tbody>
				

<?php	
	foreach ($data['posts'] as $post) {
		$postView = 
		'
		<tr>
			<td class="firstCol">'.$post['use_login']. ' posted the <br>'.
				$post['pos_created'].'
			</td>
			<td>'.nl2br($post['pos_content']).'</td>
		</tr>
		';
		echo $postView;
	}
}
?>
			</tbody>
		</table>
	</div>