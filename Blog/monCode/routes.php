<?php 

define('BASE_URL', 'index.php');
define('get_home', BASE_URL);

// ARTICLES
define('get_articles', BASE_URL.'?c=article&a=getArticles');
define('get_article', BASE_URL.'?c=article&a=getArticle&id=');
define('showPostArticleForm', BASE_URL.'?c=article&a=showPostArticleForm');
define('postArticle', BASE_URL.'?c=article&a=postArticle');

define('showArticlesByTag', BASE_URL.'?c=article&a=showArticlesByTag&tagId=');



// USERS
define('connexion', BASE_URL.'?c=user&a=connexion');
define('deconnexion', BASE_URL.'?c=user&a=deconnexion');
define('showRegisterForm', BASE_URL.'?c=user&a=showRegisterForm');
define('registration', BASE_URL.'?c=user&a=register');

// COMMENTS
define('postComment', BASE_URL.'?c=comment&a=postComment&artId=');
define('showReplyCommentForm', BASE_URL.'?c=comment&a=showReplyCommentForm&artId=');
define('replyComment', BASE_URL.'?c=comment&a=replyComment&artId=');
define('showManagerCommentMenu', BASE_URL.'?c=comment&a=showManagerCommentMenu');
define('displayComment', BASE_URL.'?c=comment&a=displayComment&comId=');
define('showUpdateCommentForm', BASE_URL.'?c=comment&a=showUpdateCommentForm&comId=');
define('showDeleteCommentForm', BASE_URL.'?c=comment&a=showDeleteCommentForm&comId=');
// Request to display CommentManagerMenu order
define('showCommentsById', BASE_URL.'?c=comment&a=showCommentsById');
define('showCommentsByAuthor', BASE_URL.'?c=comment&a=showCommentsByAuthor');
define('showCommentsByContent', BASE_URL.'?c=comment&a=showCommentsByContent');
define('showCommentsByArtTitle', BASE_URL.'?c=comment&a=showCommentsByArtTitle');
define('showCommentsByPublished', BASE_URL.'?c=comment&a=showCommentsByPublished');
define('showCommentsByAlert', BASE_URL.'?c=comment&a=showCommentsByAlert');


define('showManagerArticleMenu', BASE_URL.'?c=article&a=showManagerArticleMenu');
define('selectManagerArticleForm', BASE_URL.'?c=article&a=selectManagerArticleForm');
define('updateArticle', BASE_URL.'?c=article&a=updateArticle');
define('deleteArticle', BASE_URL.'?c=article&a=deleteArticle');

// THEMES
define('getThemes', BASE_URL.'?c=theme&a=getThemes');
define('showManagerThemeMenu', BASE_URL.'?c=theme&a=showManagerThemeMenu');
define('selectThemeEvent', BASE_URL.'?c=theme&a=selectThemeEvent');
define('postTheme', BASE_URL.'?c=theme&a=postTheme');
define('deleteTheme', BASE_URL.'?c=theme&a=deleteTheme&id=');
define('updateTheme', BASE_URL.'?c=theme&a=updateTheme&themeId=');

// TOPICS
define('getTopicsByTheme', BASE_URL.'?c=topic&a=getTopicsByTheme&theId=');
define('showManagerTopicMenu', BASE_URL.'?c=topic&a=showManagerTopicMenu');
define('selectTopicEvent', BASE_URL.'?c=topic&a=selectTopicEvent&themeId=');
define('postTopic', BASE_URL.'?c=topic&a=postTopic&themeId=');


// POSTS
define('getPosts', BASE_URL.'?c=post&a=getPostsByTopic&topId=');
define('postPost', BASE_URL.'?c=post&a=createPost&topId=');



?>