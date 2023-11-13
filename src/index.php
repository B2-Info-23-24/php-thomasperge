<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
  case '/':
    require __DIR__ . '/views/index.php';
    break;
  case '/signin':
    require __DIR__ . '/views/signin.php';
    break;
  case '/home':
    require __DIR__ . '/views/home.php';
    break;
  default:
    http_response_code(404);
    require __DIR__ . '/views/404.php';
    break;
}
