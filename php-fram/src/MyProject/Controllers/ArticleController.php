<?php
    namespace MyProject\Controllers;
    use MyProject\View\View;
    use MyProject\Models\Articles\Article;
    use MyProject\Models\Comments\Comment;
    use MyProject\Models\Users\User;

    class ArticleController{
        private $view;
        private $db;
        public function __construct(){
            $this->view = new View(__DIR__.'/../../../templates');
        }
        public function view(int $articleId){
            $article = Article::getById($articleId);
            //var_dump($article[0]);


            $comments = Comment::getByArticleId($articleId);

            $this->view->renderHtml('articles/article.php', ['article' => $article, 'comments'=>$comments]);


            // $authorName = $this->db->query('SELECT * FROM `users` WHERE id = :id;', [':id' => $article[0]->authorId], User::class);
            // var_dump($article);
            // $this->view->renderHtml('/articles/article.php', ['article' => $article]);
            // var_dump($authorName);
            // var_dump($authorName[0]->nickname);
            // $this->view->renderHtml('/articles/article.php', ['article' => $article[0], 'name' => $authorName[0]->nickname]);
        }

        public function form(){
            $this->view->renderHtml('/form/form.php');
        }
        // public function sayBye(string $name){
        //     echo 'Пока, '.$name;
        // }

        public function edit(int $articleId):void{
            $article = Article::getById($articleId);

            if($article === null){
                echo 'нет такой статьи';
                return;
            }
            $article->setName('new article');
            $article->setText('new text one');
            $article->save();

        }

        public function add():void{
            $author = User::getById(1);
            $article = new Article();

            $article->setName($_POST['artname']);
            $article->setText($_POST['arttext']);
            $article->setAuthor($author);
            $article->save();
            header('Location: ..');

        }

        public function delete(int $articleId){
            $article = Article::getById($articleId);
            if($article === null){
                echo 'нет такой статьи';
                return;
            }
            $article->delete();
        }

    }


?>