<?php

require_once __DIR__ . '/../core/render.php';

class SubmitController
{
  private $renderManager;

  public function __construct()
  {
    $this->renderManager = new RenderManager();
  }

  public function submitRouter()
  {
    $this->renderManager->render('/pages/submit.twig');
  }
}
