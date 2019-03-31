<?php 

class TopicController extends CoreController
{

	public function getTopicsByThemeAction()
	{
		$themeId = $this->secureData($this->getParam())['theId'];

		$data['topics'] = $this->getModel()->getTopicsByTheme($themeId);

		$this->render('topics', $data);
	}

	public function showManagerTopicsByThemeAction(int $themeId, array $errors=[])
	{
		if (!$this->hasRole('ROLE_MANAGER')) {
				$errors[] = 'You don\'t have the permission.<br>';
				$this->showHomeAction($errors);
				exit();
		}
		else {
			$data['themeId'] = $themeId;
			$data['topics'] = $this->getModel()->getTopicsByTheme($themeId);
			if (!empty($errors))
				$data['messages'] = $errors;

			$this->render('admin/form/topic/topicsByThemeMenu', $data);
		}
	}

	/**
	 * Called from topicsByThemeMenu View
	 * @return [type] [description]
	 */
	public function selectTopicEventAction()
	{
		$postData = $this->secureData($this->getData());
		$postData['themeId'] = $this->secureData($this->getParam())['themeId'];
		var_dump($postData);

		if (!$this->hasRole('ROLE_MANAGER')) {
			$errors[] = 'You don\'t have the permission.<br>';
			$this->showHomeAction($errors);
			exit();
		}
		elseif ($postData['action'] == 'New') {
			$this->render('admin/form/topic/newTopic', $postData);
		}
		elseif (empty($postData['top_id'])) {
			if ($postData['action']=='Display' ||
				$postData['action']=='Update' ||
				$postData['action']=='Delete' ) {
					$errors[] = 'You must choose a topic for this action.<br>';
					$this->showManagerTopicsByThemeAction($themeId);
			}
		}
		else {
			switch ($postData['action']) {
				case 'Display':
					# code...
					break;
				case 'Update':
					# code...
					break;
				case 'Delete':
					# code...
					break;
				default:
					# code...
					break;
			}
		}
	}

	/**
	 * Called from newTopic View
	 * @return [type] [description]
	 */
	public function postTopicAction()
	{
		$postData = $this->secureData($this->getData());
		if (empty($postData['themeId']))
			$postData['themeId'] = $this->secureData($this->getParam())['themeId'];

		if (!$this->hasRole('ROLE_MANAGER')) {
			$errors[] = 'You don\'t have the permission.<br>';
			$this->showHomeAction($errors);
			exit();
		}
		else {
			if ($this->isPostTopicValid($postData)===true) {
				try {
					//Create a topic
					var_dump('ok');
					$postData['created'] = date('Y-m-d H:i:s');
					$postData['enabled'] = 1;
					$postData['userId'] = $this->getConnectedUser()['use_id'];
					var_dump($postData);
					$this->getModel()->postTopic($postData);

					$postData['topId'] = $this->getModel()->getLastTopicId()['top_id'];

					//Create the post
					$postModel = new PostModel();
					$postModel->createPost($postData);
				}
				catch (Exception $e) {
					$postData['messages'][] = $e->getMessage();
					$this->render('admin/form/topic/newTopic', $postData);
					exit();
				}
				$errors[] = 'Topic was added successfully.<br>';
				$this->showManagerTopicsByThemeAction($postData['themeId'], $errors);
			}
			else {
				$postData['messages'] = $this->isPostTopicValid($postData);
				$this->render('admin/form/topic/newTopic', $postData);
			}
		}
	}

	public function isPostTopicValid(array $data)
	{
		$errors = array();
		$titlePattern = '#[a-zA-Z\d\séèêà\'",.]{5,125}#';
		$contentPattern = '#[a-zA-Z\d\séèêà\'",.]{5,3000}#';

		if (!preg_match($titlePattern, $data['title']))
			$errors[] = 'The title must contain between 5 and 125 alphanumeric characters.';
		if (!preg_match($contentPattern, $data['content']))
			$errors[] = 'The post must contain between 5 and 3000 alphanumeric characters.';

		return (empty($errors)) ? true : $errors;
	}
}
?>