<?php 

class ThemeController extends CoreController
{

	public function getThemesAction()
	{
		$data['themes'] = $this->getModel()->getThemes();

		$this->render('theme', $data);
	}

	public function showManagerThemeMenuAction(array $errors=[])
	{
		$data['themes'] = $this->getModel()->getThemes();

		if (!empty($errors))
			$data['messages'] = $errors;

		$this->render('admin/form/theme/ManagerThemeMenu', $data);
	}

	public function selectThemeEventAction()
	{
		$gotData = $this->secureData($this->getData());

		if (!$this->hasRole('ROLE_MANAGER')) {
			$errors[] = 'You don\'t have permission.<br>';
			$this->showHomeAction($errors);
		}
		elseif ($gotData['action'] == 'New') {
			$this->render('admin/form/theme/NewTheme');
		}
		elseif (empty($gotData['themeId'])) {
			if ($gotData['action'] == 'Update' ||
				$gotData['action'] == 'DisplayTopics' ||
				$gotData['action'] == 'Delete') {

				$errors[] = 'You must choose a theme for this action.<br>';
				$this->showManagerThemeMenuAction($errors);
			}
		}
		else {
			$gotData['the_name'] = $this->getModel()->getTheme($gotData['themeId'])['the_name'];
			switch ($gotData['action']) {
				case 'Update':
					$this->render('admin/form/theme/updateTheme', $gotData);
					break;
				case 'DisplayTopics':
					$topicController = new TopicController();
					$topicController->showManagerTopicsByThemeAction($gotData['themeId']);
					break;
				case 'Delete':
					$this->render('admin/form/theme/deleteThemeForm', $gotData);
					break;
				default:
					$errors[] = 'Action not found.<br>';
					$this->showManagerThemeMenuAction($errors);
					break;
			}
		}
	}

	public function postThemeAction()
	{
		$postData = $this->secureData($this->getData());

		if (!$this->hasRole('ROLE_MANAGER')) {
			$errors[] = 'You don\'t have permission.<br>';
			$this->showHomeAction($errors);
			exit();
		}
		elseif ($this->isPostThemeFormValid($postData)===true) {
			try {
				$postData['created'] = date('Y-m-d H:i:s');
				$this->getModel()->postTheme($postData);
			}
			catch (Exception $e) {
				$postData['messages'][] = $e->getMessage();
				$this->render('admin/form/theme/NewTheme', $postData); 
				exit();
			}
			$postData['messages'] = 'The theme has been created.<br>';
			$this->showManagerThemeMenuAction($postData);
		}
		else {
			$postData['messages'] = $this->isPostThemeFormValid($postData);
			$this->render('admin/form/theme/NewTheme', $postData); 
		}
	}

	public function isPostThemeFormValid(array $data)
	{
		$errors = array();
		$namePattern = '#[a-zA-Z\d\séèêà,.\'"]{3,50}#';
		if (!preg_match($namePattern, $data['name']))
			$errors[] = 'The name must conatin 3 to 50 characters alphanumeric.<br>';

		return (empty($errors)) ? true : $errors;
	}

	public function deleteThemeAction()
	{
		$id = $this->secureData($this->getParam())['id'];
		try {
			$this->getModel()->deleteTheme($id);
			$errors[] = 'Theme deleted.<br>';
		}
		catch (Exception $e)
		{
			$errors[] = $e->getMessage();
		}
		$this->showManagerThemeMenuAction($errors);
	}

	public function updateThemeAction()
	{
		$postData = $this->secureData($this->getData());
		$postData['themeId'] = $this->secureData($this->getParam())['themeId'];

		if (!$this->hasRole('ROLE_MANAGER')) {
			$errors[] = 'You don\'t have permission.<br>';
			$this->showHomeAction($errors);
			exit();
		}
		elseif ($this->isUpdateThemeFormValid($postData)===true) {
			try {
				$this->getModel()->updateTheme($postData);
			}
			catch (Exception $e) {
				$errors[] = $e->getMessage();
				$this->render('admin/form/theme/UpdateTheme', $postData); 
				exit();
			}
			$errors[] = 'The theme has been modified.<br>';
			$this->showManagerThemeMenuAction($errors);
			exit();
		}
		else {
			$postData['messages'] = $this->isUpdateThemeFormValid($postData);
			$this->render('admin/form/theme/UpdateTheme', $postData); 
		}
	}


	public function isUpdateThemeFormValid(array $data)
	{
		$errors = array();
		$namePattern = '#[a-zA-Z\d\séèêà,.\'"]{3,50}#';
		if (!preg_match($namePattern, $data['the_name'])) {
			$errors[] = 'The name must contain 3 to 50 characters alphanumeric.<br>';
		}

		return (empty($errors)) ? true : $errors;
	}
}

?>