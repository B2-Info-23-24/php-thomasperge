<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../core/admin.php';

class ErrorController
{
  private $renderManager;
  private $adminManager;

  public function __construct()
  {
    $this->renderManager = new RenderManager();
    $this->adminManager = new AdminManager();
  }

  public function errorRouter()
  {
    $isAdmin = $this->adminManager->isAdmin();

    $this->renderManager->render('/pages/404.twig', ['isAdmin' => $isAdmin]);
  }
}
