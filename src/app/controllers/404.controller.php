<?php
require 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ErrorController
{
  private $twig;

  public function errorRouter()
  {
    $loader = new FilesystemLoader(__DIR__ . '/../views');
    $this->twig = new Environment($loader);

    echo $this->twig->render('/pages/404.twig');
  }
}
