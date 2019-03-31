<?php 

if(empty($data['topics']))
	echo "there is no topic in this theme.";
else {
	foreach ($data['topics'] as $topic) {
		echo 
		'
		<p class="topicLink">
		<a href="'.getPosts.$topic['top_id'].'">'.$topic['top_title'].'</a>
		</p>
		';
	}
}

?>