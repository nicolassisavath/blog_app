<?php 

class TopicModel extends CoreModel
{

	public function getTopicsByTheme(int $theId)
	{
		$sql = '
			SELECT topic.*, top_author.use_login AS top_author, post_author.use_login AS post_author, post.pos_created AS last_comment FROM `topic`
			LEFT JOIN `theme` ON theme.the_id=topic.top_id
			LEFT JOIN `user` AS top_author ON top_author.use_id=topic.use_id
			LEFT JOIN `post` ON topic.top_id=post.top_id
			LEFT JOIN `user` AS post_author ON post.use_id=post_author.use_id
			WHERE topic.the_id=:theId
			ORDER BY post.pos_id DESC 
			-- LIMIT 1
				';

			$param = [ 'theId' => $theId];	

			return $this->MakeSelect($sql, $param);
	}

	public function postTopic(array $data)
	{
		$sql = 
		'
			INSERT INTO `topic`
			(`top_title`, `top_created`, `top_enabled`, `use_id`, `the_id`)
			VALUES
			(:title, :created, :enabled, :userId, :themeId)
		';

		$param = [
			'title'	=> $data['title'],
			'created'	=> $data['created'],
			'enabled'	=> $data['enabled'],
			'userId'	=> $data['userId'],
			'themeId'	=> $data['themeId']
		];

		return $this->MakeStatement($sql, $param);
	}

	public function getLastTopicId()
	{
		$sql =
		'
			SELECT * FROM `topic`
			ORDER BY `top_id` DESC
			LIMIT 1
		';

		return $this->MakeSelect($sql)[0];
	}
}
?>