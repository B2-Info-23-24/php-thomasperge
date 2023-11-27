<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../core/admin.php';

class SucessController
{
  private $adminManager;
  private $renderManager;

  public function __construct()
  {
    $this->adminManager = new AdminManager();
    $this->renderManager = new RenderManager();
  }

  public function sucessRouter()
  {
    $isAdmin = $this->adminManager->isAdmin();
    
    $this->renderManager->render('/pages/sucess.twig', ['isAdmin' => $isAdmin]);
  }
}
