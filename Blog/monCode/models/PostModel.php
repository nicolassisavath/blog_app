<?php 

class PostModel extends CoreModel
{

	public function GetPostsByTopic(int $topId)
	{
		$sql = 
		'
			SELECT post.*, topic.top_id, topic.top_title, user.use_id, user.use_login 
			FROM `post`
			LEFT JOIN `topic` ON post.top_id=topic.top_id
			LEFT JOIN `user` ON post.use_id=user.use_id
			WHERE post.top_id=:topId AND post.pos_enabled=1;
		';

		$param = ['topId' => $topId];

		return $this->MakeSelect($sql, $param);
	}

	public function createPost(array $data)
	{
		$sql = 
		'
			INSERT INTO `post`
			(`pos_content`, `pos_created`, `pos_enabled`, `use_id`, `top_id`)
			VALUES (:content, :pos_created, :enabled, :useId, :topId)
		';

		$param = [
			'content' => $data['content'],
			'pos_created' => $data['created'],
			'enabled' => $data['enabled'],
			'useId' => $data['userId'],
			'topId' => $data['topId']

		];

		return $this->MakeStatement($sql, $param);
	}
}





?>