<?php
require 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class SigninController
{
  private $twig;

  public function signinRouter()
  {
    $loader = new FilesystemLoader(__DIR__ . '/../views');
    $this->twig = new Environment($loader);

    echo $this->twig->render('/pages/signin.twig');
  }
}
