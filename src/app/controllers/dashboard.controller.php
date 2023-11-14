<?php
require 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class DashboardController
{
  private $twig;

  public function dashboardRouter()
  {
    $loader = new FilesystemLoader(__DIR__ . '/../views');
    $this->twig = new Environment($loader);

    echo $this->twig->render('/pages/dashboard.twig');
  }
}
