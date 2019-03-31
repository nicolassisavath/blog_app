<?php 

class PostController extends CoreController
{

	public function getPostsByTopicAction(array $errors=[])
	{
		$topId = $this->secureData($this->getParam())['topId'];

		$data['posts'] = $this->getModel()->getPostsByTopic($topId);

		if(!empty($errors))
			$data['messages']=$errors;

		$this->render('posts', $data);
	}

	public function createPostAction()
	{
		$gotData = $this->secureData($this->getData());//Get post content
		$gotData['userId'] = $this->getConnectedUser()['use_id'];
		$gotData['topId'] = $this->secureData($this->getParam())['topId'];


		if (!$this->hasRole('ROLE_USER')) {
			$errors[] = 'You don\'t have the authorization.<br>';
			$this->getPostsByTopicAction($errors);
			exit();
		}
		else {
			if ($this->isPostFormValid($gotData)==true) {
				try {
					$gotData['created'] = date('Y-m-d H:i:s');
					$gotData['enabled'] = 1;
					$this->getModel()->createPost($gotData);
					$errors[] = 'Post added.<br>';
					$this->getPostsByTopicAction($errors);
				}
				catch (Exception $e) {
					$errors[] = $e->getMessage();
					$this->getPostsByTopicAction($errors);
				}
			}
			else {
				$errors = $this->isPostFormValid($gotData);
				$this->getPostsByTopicAction($errors);
			}
		}
	}

	public function isPostFormValid(array $data)
	{
		$errors = array();
		$contentPattern = '#[a-zA-Zéèêà\s\d\',.]{5,3000}#';
		if (!is_int($data['userId']))
			$errors[] = 'The user is not found.<br>';
		if (!is_int($data['topId']))
			$errors[] = 'The topic is not found.<br>';
		if(!preg_match($contentPattern, $data['content']))
			$errors[] = 'Your post is not valid.<br>';

		return (empty($errors)) ? true : $errors;

	}
}



?>