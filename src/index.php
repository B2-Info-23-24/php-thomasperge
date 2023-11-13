<?php
// Twig
// require_once __DIR__ . '../vendor/autoload.php';

// $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/views/partials');
// $twig = new \Twig\Environment($loader);

// Router
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
  case '/':
    require __DIR__ . '/views/home.php';
    break;
  case '/home':
    require __DIR__ . '/views/home.php';
    break;
  case '/dashboard':
    require __DIR__ . '/views/dashboard.php';
    break;
  case '/signin':
    require __DIR__ . '/views/signin.php';
    break;
  case '/submit':
    require __DIR__ . '/views/submit.php';
    break;
  case '/signup':
    require __DIR__ . '/views/signup.php';
    break;
  case '/post':
    require __DIR__ . '/views/post.php';
    break;
  case '/book':
    require __DIR__ . '/views/book.php';
    break;
  case '/profil':
    require __DIR__ . '/views/profil.php';
    break;
  default:
    http_response_code(404);
    require __DIR__ . '/views/404.php';
    break;
}
