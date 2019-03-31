<?php 

class ThemeModel extends CoreModel
{

	public function getThemes()
	{
		$sql = 'SELECT * FROM `theme`';

		return $this->MakeSelect($sql);
	}

	public function getTheme(int $id)
	{
		$sql = 'SELECT * FROM `theme` WHERE the_id = :id';

		$param = [ 'id' => $id];

		return $this->MakeSelect($sql, $param)[0];
	}

	public function postTheme(array $data)
	{
		$sql = 
		'
			INSERT INTO `theme`
			(`the_name`, `the_created`)
			VALUES (:name, :created);
		';

		$param = [
			'name' => $data['name'],
			'created' => $data['created']
		];

		return $this->MakeStatement($sql, $param);	
	}

	public function deleteTheme(int $id)
	{
		$sql = 'DELETE FROM `theme` WHERE the_id=:id';

		$param = ['id' => $id];

		return $this->MakeStatement($sql, $param);
	}

	public function updateTheme(array $data)
	{
		$sql = 
		'
			UPDATE `theme`
			SET the_name = :name
			WHERE the_id = :id;
		';

		$param = [
			'name' => $data['the_name'],
			'id' => $data['themeId']
		];

		return $this->MakeStatement($sql, $param);
	}
}


?>