<?php

require_once __DIR__ . '/../core/render.php';

class SucessController
{
  private $renderManager;

  public function __construct()
  {
    $this->renderManager = new RenderManager();
  }

  public function sucessRouter()
  {
    $this->renderManager->render('/pages/sucess.twig');
  }
}
