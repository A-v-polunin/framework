<?php

namespace MyProject\Controllers;
use MyProject\View\View;
use MyProject\Models\Users\User;
use MyProject\Models\Comments\Comment;

class CommentController
{
  private $view;

  public function __construct()
  {
    $this->view = new View(__DIR__.'/../../../templates');
  }

  public function view(int $articleId)
  {
    $comment = Comment::getByArticleId($articleId);

    $this->view->renderHtml('articles/article.php', ['comments'=>$comment]);
  }

  public function edit(int $commentId): void
  {
    $comment = Comment::getById($commentId);

    if (isset($_POST['comment'])) {
      $comment->setText($_POST['comment']);
      $comment->save();
      header('Location: /../frame/www/article/'.$comment->getArticleId());
    } else {
      $this->view->renderHtml('comments/edit.php', ['comment'=>$comment]);
    }
  }

  public function add($articleId)
  {
    if (!empty($_POST)) {
      $author = User::getById(1);
      $comment = new Comment();
      $comment->setAuthor($author);
      $comment->setArticleId($articleId);
      $comment->setText($_POST['comment']);
      $comment->save();
    }
    header('Location: /../frame/www/article/'.$comment->getArticleId().'#comment'.$comment->getId());


  }

  public function delete(int $articleId): void
  {
    $comment = Comment::getById($articleId);
    $comment->delete();
  }
}
?>