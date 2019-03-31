<?php 
class CommentModel extends CoreModel
{

	public function getComments()
	{
		$sql = '
			SELECT comment.*, user.use_login, article.art_title FROM `comment`
			LEFT JOIN user ON comment.use_id = user.use_id
			LEFT JOIN article ON comment.art_id = article.art_id
				';

		return $this->MakeSelect($sql);
	}
	/**
	 * Get the comments without responses for the selected article
	 * @param  [type] $id id of selected article
	 * @return [type]     [description]
	 */
	public function getCommentsByArticle(int $id)
	{
		$sql = 
		'
		SELECT `comment`.*, `user`.use_login AS com_poster FROM `comment`
		LEFT JOIN `user` ON comment.use_id = user.use_id 
		WHERE (comment.art_id=:article_id AND comment.com_id_1 IS NULL AND comment.com_enabled IS TRUE)
		ORDER BY comment.com_created ASC;
		';

		$param = ['article_id' => $id];

		return ($comments = $this->makeSelect($sql, $param)) ? $comments : false;
	}

	/**
	 * Get the responses for a selected comment
	 * @param  [int] $id [id of the comment]
	 * @return [type]     [description]
	 */
	public function getResponsesByComment(int $id)
	{
		$sql = 
		'
		SELECT `comment`.*, `user`.use_login AS resp_poster FROM `comment`
		LEFT JOIN `user` ON comment.use_id = user.use_id
		WHERE (comment.com_id_1 = :comment_id AND comment.com_enabled IS TRUE)
		ORDER BY comment.com_created ASC;
		';

		$param = ['comment_id' => $id];

		return ($responses = $this->makeSelect($sql, $param)) ? $responses : false;
	}

	public function createComment(array $data)
	{
		$sql = '
				INSERT INTO `comment`
				(com_content, com_created, art_id, use_id, com_enabled, com_id_1)
				VALUES(:content, :created, :art_id, :use_id, :enabled, :com_reply)
				';

		$param = [
			'content'	=> $data['content'],
			'created'	=> $data['com_created'],
			'enabled'	=> $data['com_enabled'],
			'art_id'	=> $data['art_id'],
			'use_id'	=> $data['use_id'],
			'com_reply' => $data['com_id_1']
		];

		return $this->MakeStatement($sql, $param);
	}

	public function deleteCommentsByArticle(int $artId)
	{
		$sql = '
				SET FOREIGN_KEY_CHECKS = 0; 
				DELETE FROM `comment`
				WHERE comment.art_id=:artId;
				SET FOREIGN_KEY_CHECKS = 1; 
				';

		$param = [ 'artId' => $artId ];

		return $this->MakeStatement($sql, $param);
	}
}


?>