<?php

use app\forms\LoginForm;
use app\forms\RegisterForm;
use app\repositories\contracts\AuthorBookRepositoryInterface;
use app\repositories\contracts\AuthorRepositoryInterface;
use app\repositories\contracts\AuthorStatRepositoryInterface;
use app\repositories\contracts\BookRepositoryInterface;
use app\repositories\contracts\UserRepositoryInterface;
use app\repositories\database\AuthorBookRepository;
use app\repositories\database\AuthorRepository;
use app\repositories\database\AuthorStatRepository;
use app\repositories\database\BookRepository;
use app\repositories\database\UserRepository;

return [
    'definitions' => [
        LoginForm::class => LoginForm::class,
        RegisterForm::class => RegisterForm::class
    ],
    'singletons' => [
        AuthorRepositoryInterface::class => AuthorRepository::class,
        AuthorBookRepositoryInterface::class => AuthorBookRepository::class,
        AuthorStatRepositoryInterface::class => AuthorStatRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
        BookRepositoryInterface::class => BookRepository::class,
    ]
];