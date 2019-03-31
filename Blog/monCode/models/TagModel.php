<?php 
class TagModel extends CoreModel
{

	public function getTags()
	{
		$sql = '
				SELECT * FROM `tag`;
				';

		return $this->MakeSelect($sql);
	}

	public function getTagsByArticle($id)
	{
		$sql = 
		'
		SELECT `tag`.* FROM `article_tag`
		LEFT JOIN `article` ON article_tag.art_id = article.art_id
		LEFT JOIN `tag` ON article_tag.tag_id = tag.tag_id
		WHERE article_tag.art_id = :article_id;
		';

		$param = ['article_id' => $id];

		return ($tags = $this->MakeSelect($sql, $param)) ? $tags : false;
	}

	/**
	 * [getArticlesByTag description]
	 * @param  [type] $id id of the selected tag
	 * @return [type]     [description]
	 */
	public function getArticlesByTag($id)
	{

	}
}



?>