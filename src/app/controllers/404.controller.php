<?php

require_once __DIR__ . '/../core/render.php';

class ErrorController
{
  private $renderManager;

  public function __construct()
  {
    $this->renderManager = new RenderManager();
  }

  public function errorRouter()
  {
    $this->renderManager->render('/pages/404.twig');
  }
}
