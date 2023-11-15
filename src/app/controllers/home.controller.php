<?php

require_once __DIR__ . '/../core/render.php';

class HomeController
{
  private $renderManager;

  public function __construct()
  {
      $this->renderManager = new RenderManager();
  }

  public function homeRouter()
  {
    $currentRoute = $_SERVER['REQUEST_URI'];

    $this->renderManager->render('/pages/home.twig', ['currentRoute' => $currentRoute]);
  }
}
