<?php

class ArticleController extends CoreController
{

    /**
     * Get all the articles
     * @return [type] [description]
     */
    public function getArticlesAction(array $errors=[])
    {
        $data = $this->getModel()->getArticles();

        if (!empty($errors))
            $data['messages']= $errors;

        $this->render('articles', $data);
    }

    public function showArticlesByTagAction()
    {
        $tagId = $this->secureData($this->getParam())['tagId'];

        $data['articles'] = $this->getModel()->showArticlesByTag($tagId);

        $this->render('articlesByTag', $data);
    }

    /**
     * [get a selected article with the comments, tags, errors and reply to comments ]
     * Can be called from index
     * Can be called from CommentController, after posting or replying to a comment
     * @param  int|null $id     [description]
     * @param  array    $errors [description]
     * @param  array    $reply  [description]
     * @return [type]           [description]
     */
    public function getArticleAction(int $id=NULL, array $errors=[], array $reply=[])
    {
    	if (is_null($id))
        	$id = $this->getParam()['id'];

        // Get the content of the article in key ['article']
        if ($data['article'] = $this->getModel()->getArticle($id)) {
            // Get the list of tags in the key ['tags']
            $tagModel = new TagModel();
            $data['tags'] = $tagModel->getTagsByArticle($id);

            // Get the list of comments in the key ['comments']
            $data['comments'] = $this->getCommentsAndResponsesByArticle($id);

            if (!empty($errors))
                $data['messages'] = $errors;
            if (!empty($reply))
                $data['reply']=$reply;
            $this->render('article', $data);
        } 
        else {
            $this->renderUnknownPage();
        }
    }

    /**
     * Get the comments and the responses for a selected article
     * @param  [int] $id  id of article
     * @return [type]     [description]
     */
    private function getCommentsAndResponsesByArticle(int $id)
    {
        $commentModel = new CommentModel();
        // Get the list of comments without responses for an article
        if ($comments = $commentModel->getCommentsByArticle($id)) {
            foreach ($comments as $key => $comment) {
                $comment_id = $comment['com_id'];
                //Get the list of responses for a comment
                if ( ($responses = $commentModel->getResponsesByComment($comment_id)) !== false) {
                    $comments[$key]['responses'] = $responses;
                }
            }
            return $comments;
        }
        else{
            return false;
        }
    }

    /**
     * Display the menu and actions to manage Articles.
     * @return [type] [description]
     */
    public function showManagerArticleMenuAction(array $errors=[])
    {
        // Parameter 1 of getArticles indicates we want all articles 
        // Even the one not published yet
        $data['articles'] = $this->getModel()->getArticles(1, 'ASC');

        if (count($errors)!==0)
            $data['messages'] = $errors;

        $this->render('admin/form/article/managerArticleMenu', $data);
    }

    public function selectManagerArticleFormAction()
    {
        $postedData = $this->secureData($this->getData());

        if ($postedData['action']=='new') {
            $this->showPostArticleFormAction();
        } // If no  article selected for display|edit|delete action
        // Redirection to managerArticleMenu View
        elseif (empty($postedData['artId'])) {
            if ($postedData['action']=='display' || 
                $postedData['action']=='edit' || 
                $postedData['action']=='delete') {
                
                $errors[] = 'You have to choose an article for this action.';
                $this->showManagerArticleMenuAction($errors);
            }
        }
        elseif (!empty($postedData['artId'])){
            $id = $postedData['artId'];

            switch ($postedData['action']) {
                case 'display':
                    $this->getArticleAction($id);
                    break;
                case 'edit':
                    $this->showUpdateForm($id);
                    break;
                case 'delete':
                    $this->showDeleteArticleConfirmationAction($id);
                    break;
                default:
                    $errors[] = 'This action is not available.';
                    $this->showManagerArticleMenuAction($errors);
                    break;
            }
        }
    }

    /**
     * Display the form submission for new Article.
     * Called from ArticleManagerMenu View
     * Called from postArticleAction for resubmission in error case.
     * @param  array  $resendData data of first submitted not validated form.
     * @return [type] [description]
     */
    public function showPostArticleFormAction(array $resendData=[])
    {
        if (!empty($resendData))
            $data = $resendData;

        // If user doesn't have ROLE_MANAGER
        // Redirection to articles Menu
        if ($this->hasRole('ROLE_MANAGER')) {
            $tagModel = new TagModel();
            try {
                $data['tags'] = $tagModel->getTags();
                $this->render('admin/form/article/postArticleForm', $data);
            }
            catch (Exception $e) {
                $errors[] = $e->getMessage();
                $this->getArticlesAction($errors);
            }
        }
        else {
            $errors[] = 'You are not authorized.';
            $this->getArticlesAction($errors);
        }
    }

    /**
     * Treat the post of new Article.
     * Called from postArticleForm View.
     * @return [type] [description]
     */
    public function postArticleAction()
    {
        $postData = $this->secureData($this->getData());

        $data['title']      = $postData['title'];
        $data['content']    = $postData['content'];
        $data['enabled']    = $postData['enabled'];

        // If user not autorized, redirected to ArticlesMenu
        if ($this->hasRole('ROLE_MANAGER')) {
            // If form not valid, data form redisplayed into the form
            if ($this->isPostArticleFormValid($postData)===true) {
                $data['created']    = date('Y-m-d H:i:s');
                $data['userId']     = $this->getConnectedUser()['use_id'];

                try {
                    $this->getModel()->createArticle($data);
                    // Link article to tags
                    if (count($postData['tags'])!==0) {
                        $data['tags'] = $postData['tags'];
                        $artId = $this->getModel()->getLastArticleId();
                        foreach ($data['tags'] as $tag) {
                            $this->getModel()->linkArticleToTag($artId, $tag[0]);
                        };
                    }

                    $data['messages'][] = 'Article has been created.';
                    $this->showManagerArticleMenuAction($data['messages']);
                }
                catch (Exception $e) {
                    $data['messages'][] = $e->getMessage();
                    $this->render('admin/form/article/postArticleForm', $data);
                }
            }
            else {
                $data['messages'] = $this->isPostArticleFormValid($postData);
                $this->showPostArticleFormAction($data);
            }
        }
        else {
            $errors[] = 'You are not authorized';
            $this->getArticlesAction($errors);
        }
    }

    /**
     * Verify if the data for new article are valid
     * @param  array   $data [description]
     * @return boolean       [description]
     */
    private function isPostArticleFormValid(array $data)
    {
        $errors = array();

        $titlePattern = '@^[a-zA-Z\d éèêà,.?!;:\']{3,255}$@';
        $contentPattern = "@^[a-zA-Z\d éèêà,.?!;:'\s]{3,3000}$@";
        $enabledPattern = '@^[0-1]{1}$@';

        if (!preg_match($titlePattern, $data['title'])) 
            $errors[] = 'Votre titre n\'est pas valide';
        if (!preg_match($contentPattern, $data['content']))
            $errors[] = 'Votre texte n\'est pas valide.';
        if (!preg_match($enabledPattern, $data['enabled']))
            $errors[] = 'Hé !! T\'es pas en train de pirater le site??!!';

        return (count($errors)==0) ? true: $errors;
    }

    // *
    //  * Link an article to a tag
    //  * @param  int    $artId [description]
    //  * @param  int    $tagId [description]
    //  * @return [type]        [description]
     
    // public function linkArticleToTag(int $artId, int $tagId)
    // {
    //     return $this->getModel()->linkArticleToTag($artId, $tagId);
    // }

    /**
     * Display  the form to modify a selected article.
     * Called from selectManagerArticleFormAction()
     * @param  int    $id [description]
     * @return [type]     [description]
     */
    public function showUpdateForm(int $id)
    {
        // Get the article data
        $data['article'] = $this->getModel()->getArticle($id);
        
        // Get the current tags of the article
        $tagModel = new TagModel();
        $currentTags = $tagModel->getTagsByArticle($id);
        $data['currentTagsId'] = array();
        if (!empty($currentTags)) {
            foreach ($currentTags as $currentTag) {
                $data['currentTagsId'][] = $currentTag['tag_id'];
            }
        }

        // Get all tags
        $data['tags'] = $tagModel->getTags();

        // Get all users
        $userModel = new UserModel();
        try {
            $data['users'] = $userModel->getUsers('ROLE_MANAGER');
        }
        catch (Exception $e) {
            $data['messages'][] = $e->getMessage();
        }

        $this->render('admin/form/article/updateArticleForm', $data);
    }

    public function updateArticleAction()
    {
        $data['id'] = $this->secureData($this->getParam())['artId'];
        $postData = $this->secureData($this->getData());

        $data['title']  = $postData['title']; 
        $data['userId']  = $postData['user']; 
        $data['content']  = $postData['content']; 
        $data['enabled']  = $postData['enabled']; 

        if ($this->hasRole('ROLE_MANAGER')) {
            if($this->isPostArticleFormValid($postData)) {
                if($this->getModel()->updateArticle($data['id'], $data))
                    echo 'updated';
                else
                    echo 'Not updated';

                if ($this->getModel()->articleHasTags($data['id'])){
                    $this->getModel()->unlinkArticleToTags($data['id']);
                }
                if (!empty($postData['tags'])) {
                    foreach ($postData['tags'] as $tagId) {
                        $this->getModel()->linkArticleToTag($data['id'], $tagId);
                    }
                }
                $data['messages'][] = 'Article modified successfully.';
                $this->showManagerArticleMenuAction($data);
            } //A modifier pour renvoyer les donnees bien formatees
              // au formulaire
            else {
                $this->showUpdateForm($data['id']);
            }
        }
        else {
            $errors[] = 'You are not authorized';
            $this->getArticlesAction($errors);
        }
    }

    /**
     * [showDeleteArticleConfirmation description]
     * Called from ManagerArticleMenu View
     * @param  int    $id id of article
     * @return [type]     [description]
     */
    public function showDeleteArticleConfirmationAction(int $id)
    {
        try {
            $article = $this->getModel()->getArticle($id);
            $this->render('admin/form/article/deleteConfirmationForm', $article);
        }
        catch ( Exception $e) {
            $errors[] = $e->getMessage();
            $this->showManagerArticleMenuAction($errors);
        }
    }

    /**
     * [deleteArticleAction description]
     * Called from deleteConfirmationForm View
     * @param  int    $id id of article
     * @return [type]     [description]
     */
    public function deleteArticleAction()
    {
        $id = $this->secureData($this->getParam())['artId'];

        try {
            $article = $this->getModel()->getArticle($id);

            //If article has tags, delete the link with tags
            if ($this->getModel()->articleHasTags($id)){
                $this->getModel()->unlinkArticleToTags($id);
            }
            //If article has comments, delete these comments
            $commentModel = new CommentModel();
            if (!empty($commentModel->getCommentsByArticle($id))) {
                $commentModel->deleteCommentsByArticle($id);
            }
            $this->getModel()->deleteArticle($id);
            $errors[] = 'Article deleted successfully';
        }
        catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
        $this->showManagerArticleMenuAction($errors);
    }
}

?>