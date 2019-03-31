<?php 
foreach ($data['themes'] as $theme) {
	echo 
	'
		<p class="themeLink">
			<a href="'.getTopicsByTheme.$theme['the_id'].'">'.$theme['the_name'].'</a>
		</p>
	';
}



?>
