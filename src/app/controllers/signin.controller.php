<?php

require_once __DIR__ . '/../core/render.php';

class SigninController
{
  private $renderManager;

  public function __construct()
  {
    $this->renderManager = new RenderManager();
  }

  public function signinRouter()
  {
    $this->renderManager->render('/pages/signin.twig');
  }
}
