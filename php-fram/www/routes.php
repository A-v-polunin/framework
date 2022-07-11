<?php
    return [
        '~^hello/(.*)$~' => [MyProject\Controllers\MainController::class, 'sayHello'],
        '~^$~' => [MyProject\Controllers\MainController::class, 'main'],
        '~^bye/(.*)$~' => [MyProject\Controllers\MainController::class, 'sayBye'],
        '~^article/(\d*)/edit$~' => [MyProject\Controllers\ArticleController::class, 'edit'],
        '~^article/(\d*)$~' => [MyProject\Controllers\ArticleController::class, 'view'],
        '~^article/(\d*)/delete$~' => [MyProject\Controllers\ArticleController::class, 'delete'],
        '~^addarticle/$~' => [MyProject\Controllers\ArticleController::class, 'form'],
        '~^article/add$~' => [MyProject\Controllers\ArticleController::class, 'add'],
        '~^articles/(\d+)/comments$~' => [MyProject\Controllers\CommentController::class, 'add'],
        '~^comments/(\d+)/edit$~' => [MyProject\Controllers\CommentController::class, 'edit'],
        '~^comments/(\d+)/delete$~' => [MyProject\Controllers\CommentController::class, 'delete'],

    ];
?>