<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../core/admin.php';

class FailedController
{
  private $adminManager;
  private $renderManager;

  public function __construct()
  {
    $this->adminManager = new AdminManager();
    $this->renderManager = new RenderManager();
  }

  public function failedRouter()
  {
    $isAdmin = $this->adminManager->isAdmin();
    
    $this->renderManager->render('/pages/failed.twig', ['isAdmin' => $isAdmin]);
  }
}
