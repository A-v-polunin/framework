<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мой блог</title>
    <link rel="stylesheet" href="../../www/style.css">
</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">
            Мой блог
        </td>
    </tr>
    <tr>
    <td>



<h2><?= $article->getName(); ?></h2>
<p><?= $article->getText(); ?></p>


<form method="post" action="/frame/www/articles/<?=$article->getId()?>/comments">
    <label for="comment">Комментарий</label>
    <br>
    <textarea name="comment" id="comment" cols="30" rows="5"></textarea>
    <button type="submit">Отправить</button>
</form>
<p></p>
<span>Комментарии</span>
<ul>
<?php
foreach($comments as $comment){
    echo "<li id='comment".$comment->getId()."'>".$comment->getText()."<br>Автор: ".$comment->getAuthor()->getNickname()."<a href='/frame/www/comments/".$comment->getId()."/edit'>Редактировать</a><a href='/frame/www/comments/".$comment->getId()."/delete'>Удалить</a></li>";
}
?>
</ul>

<?php include __DIR__.'/../footer.html';?>


