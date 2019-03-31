<?php 
class ArticleModel extends CoreModel
{
	public function getArticles(int $enabled=NULL, string $order=NULL)
	{
		$sql = 
		'
		SELECT article.*, user.use_login FROM `article`
		LEFT JOIN `user` ON article.use_id = user.use_id 
		';

		if (is_null($enabled)) 
			$sql .= 'WHERE art_enabled=1';

		$sql .= ($order=='ASC') ? ' ORDER BY art_id ASC ': ' ORDER BY art_id DESC ';

		return $this->makeSelect($sql);
	}

	public function showArticlesByTag(int $tagId)
	{
		$sql = '
			SELECT * FROM `article`
			LEFT JOIN `user` ON article.use_id = user.use_id
			LEFT JOIN `article_tag` ON article.art_id = article_tag.art_id
			WHERE article.art_enabled=1 AND article_tag.tag_id=:tagId
			ORDER BY article.art_id DESC;
				';

		$param = [ 'tagId' => $tagId ];

		return $this->MakeSelect($sql, $param);
	}

	public function getArticle(int $id)
	{
		// $sql = 
		// '
		// SELECT `article`.*, `user`.use_login, `comment`.*, `commenter`.use_login AS `commenteur` FROM `article`
		// LEFT JOIN `user` ON article.use_id=user.use_id
		// LEFT JOIN `comment` ON article.art_id = comment.art_id
		// LEFT JOIN `user` AS commenter ON comment.use_id = user.use_id
		// WHERE (article.art_id=:article_id AND comment.art_id=:article_id);
		// ';

		$sql = 
		'
		SELECT `article`.*, `user`.use_login FROM `article`
		LEFT JOIN `user` ON article.use_id=user.use_id
		WHERE article.art_id=:article_id;
		';

		$param = [ 'article_id' => $id];

		return ($article = $this->makeSelect($sql, $param)[0]) ? $article : false;
	}

	public function createArticle(array $data)
	{
		$sql = '
				INSERT INTO `article`
				(`art_title`, `art_content`, `art_created`, `art_enabled`, `use_id`)
				VALUES (:title, :content, :created, :enabled, :id);
				';

		$param = [
			'title'		=> $data['title'],
			'content'	=> $data['content'],
			'created'	=> $data['created'],
			'enabled'	=> $data['enabled'],
			'id'		=> $data['userId']
		];

		return $this->MakeStatement($sql, $param);
	}

	public function getLastArticleId()
	{
		$sql = '
				SELECT * FROM `article`
				ORDER BY `art_id` DESC
				LIMIT 1;
				';

		return $this->MakeSelect($sql)[0]['art_id'];
	}

	/**
	 * Execute a query that links an article to a tag in article_tag table
	 * @param  int    $artId id of article
	 * @param  int    $tagId id of tag
	 * @return [type]        [description]
	 */
	public function linkArticleToTag(int $artId, int $tagId)
	{
		$sql = '
				INSERT INTO article_tag
				(art_id, tag_id)
				VALUES (:artId, :tagId);
				';

		$param = [
			'artId'=>$artId,
			'tagId'=>$tagId
		];

		return $this->MakeStatement($sql, $param);
	}

	public function unlinkArticleToTags(int $id)
	{
		$sql = '
				DELETE FROM `article_tag`
				WHERE art_id=:id;
				';

		$param = ['id' => $id];

		return $this->MakeStatement($sql, $param);
	}

	/**
	 * Verify if the article has tags
	 * @param  int    $id [description]
	 * @return [type]     [description]
	 */
	public function articleHasTags(int $id)
	{
		$sql = '
				SELECT * FROM `article_tag`
				WHERE art_id = :id;
				';

		$param = [ 'id' => $id ];

		return (empty($this->MakeSelect($sql, $param)))? false : true;
	}

	public function updateArticle(int $artId, array $data)
	{
		$sql = '
			UPDATE `article`
			SET art_title=:title, art_content=:content, 
			art_enabled=:enabled, use_id=:id
			WHERE art_id=:artId
				';

		$param = [
			'title' => $data['title'], 
			'content' => $data['content'], 
			'enabled' => $data['enabled'], 
			'id' => $data['userId'],	
			'artId' => $artId	
				];

		return $this->MakeStatement($sql, $param);
	}

	public function deleteArticle(int $id)
	{
		$sql = '
			DELETE FROM `article`
			WHERE art_id=:id;
				';

		$param = [
			'id' => $id
		];

		$this->MakeStatement($sql, $param);
	}
}



?>