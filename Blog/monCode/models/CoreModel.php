<?php 

abstract class CoreModel
{
	protected static $pdo;

	public function __construct()
	{
		if(self::$pdo==null){
			self::$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8;', DB_USER, DB_PASS, 
				[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
		}
	}

	protected function getPdo()
	{
		return self::$pdo;
	}

	protected function makeStatement(string $sql, array $params=[])
	{
		$rqt = self::$pdo->prepare($sql);

		foreach ($params as $placeholder => $value)
        {
            switch(gettype($value))
            {
                case "integer":
                    $type = PDO::PARAM_INT;
                    break;
                case "boolean":
                    $type = PDO::PARAM_BOOL;
                    break;
                case "NULL":
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
            if($rqt->bindValue($placeholder, $value, $type) === false)
                return false;
        }

        return $rqt->execute() ? $rqt : false;
	}

	protected function makeSelect(string $sql, array $params=[])
	{
		$rqt = $this->makeStatement($sql, $params);

		return ($data = $rqt->fetchAll(PDO::FETCH_ASSOC)) ? $data : false;
	}

}





?>