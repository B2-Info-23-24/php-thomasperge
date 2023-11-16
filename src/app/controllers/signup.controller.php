<?php

require_once __DIR__ . '/../core/render.php';

class SignupController
{
  private $renderManager;

  public function __construct()
  {
    $this->renderManager = new RenderManager();
  }

  public function signupRouter()
  {
    $this->renderManager->render('/pages/signup.twig');
  }
}
