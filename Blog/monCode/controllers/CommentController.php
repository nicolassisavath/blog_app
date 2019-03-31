<?php 

class CommentController extends CoreController
{

	/**
	 * Post a new Comment
	 */
	public function PostCommentAction(int $replyId = NULL)
	{
		$data = $this->getData();
		//Instanciation of articleController because the result returns to 
		//getArticleAction()
		$articleController = new ArticleController();

		if (!$this->hasRole('ROLE_USER')) {
			$error[] = 'You don\'t have permission';
			$articleController->getArticleAction($this->getParam()['artId'], $error);
		}			
		else {
			//If form is Valid
			if ($this->isCommentFormValid($data) === true) {
				$data['use_id']		 = $this->getConnectedUser()['use_id'];
				$data['art_id']		 = $this->getParam()['artId'];
				$data['com_created'] = date('Y-m-d H:i:s');
				$data['com_enabled'] = 1;
				$data['com_id_1'] 	 = $replyId;

				try {
					$this->getModel()->createComment($data);
					$articleController->getArticleAction($this->getParam()['artId']);
				} //Catch the sql Exception
				catch (Exception $e) {
					$data['messages'][]=$e->getMessage();
				}
			} //If the form is not valid
			else {
				$data['messages'] = $this->isCommentFormValid($data);
			}
			$articleController->getArticleAction($this->getParam()['artId'], $data['messages']);
		}
	}

	private function isCommentFormValid(array $data)
	{
		$errors = array();
		$contentPattern = "@^[a-zA-Zéàèé \d.,;:!?()\s']{5,500}$@";
		if (!preg_match($contentPattern, $data['content'])) {
			$errors[] = 'Votre commentaire doit avoir entre 5 et 500 caracteres!';
		}
		return (count($errors)==0) ? true : $errors;
	}

	/**
	 * [showReplyCommentFormAction description]
	 * Called from article view. Send the id of article ($_GET['artId']) and 
	 * the id of the comment to reply to ($_GET['id']) 
	 * @return [type] [description]
	 */
	public function showReplyCommentFormAction()
	{
		$securedData = $this->secureData($this->getParam());
		$articleController = new ArticleController();

		if (!$this->hasRole('ROLE_USER')) {
			$errors[] = "you don't have the permission";
			$articleController->getArticleAction($securedData['artId'], $errors);
		}
		else {
			$reply['com_id'] = $securedData['comId'];
			$articleController->getArticleAction($securedData['artId'], $errors=[], $reply);
		}
	}

	public function replyCommentAction()
	{
		$articleController = new ArticleController();

		if (!$this->hasRole('ROLE_USER')) {
			$errors[] = "you don't have the permission";
			$articleController->getArticleAction($securedData['artId'], $errors);
		}
		else {
			$replyId = $this->secureData($this->getParam())['comId'];
			$this->PostCommentAction($replyId);
		}
	}

	public function showManagerCommentMenuAction()
	{
		$data['comments'] = $this->getModel()->getComments();

		$this->render('admin/form/comment/managerCommentMenu', $data);
	}

}



?>