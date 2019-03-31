<?php 
function autoload($classname)
{
	$folder = CLASSE_PATH;

	if (strpos($classname, 'Controller')!==false) {
		$folder = CONTROLLER_PATH;
	}
	elseif (strpos($classname, 'Model')!==false) {
		$folder = MODEL_PATH;
	}

	$file = $folder . DS . $classname . '.php';

	if (file_exists($file)) {
		require_once($file);
	} 
}
?>