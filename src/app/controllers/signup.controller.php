<?php
require 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class SignupController
{
  private $twig;

  public function signupRouter()
  {
    $loader = new FilesystemLoader(__DIR__ . '/../views');
    $this->twig = new Environment($loader);

    echo $this->twig->render('/pages/signup.twig');
  }
}
