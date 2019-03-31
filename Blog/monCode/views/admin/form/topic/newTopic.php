<div class="newTopic">
	<form action="<?= postTopic.$data['themeId'] ?>" method="POST">
		<input type="text" name="title" placeholder="Write an explicite name for your topic"><br>
		<textarea name="content" cols="30" rows="10" placeholder="Write your post..."></textarea><br>
		
		<input type="submit" value="Send">
	</form>
</div>