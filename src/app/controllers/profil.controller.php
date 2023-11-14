<?php
require 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ProfilController
{
  private $twig;

  public function profilRouter()
  {
    $loader = new FilesystemLoader(__DIR__ . '/../views');
    $this->twig = new Environment($loader);

    echo $this->twig->render('/pages/profil.twig');
  }
}
