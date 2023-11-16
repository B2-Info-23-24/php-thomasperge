<?php

require_once __DIR__ . '/../core/render.php';

class DashboardController
{
  private $renderManager;

  public function __construct()
  {
    $this->renderManager = new RenderManager();
  }

  public function dashboardRouter()
  {
    $this->renderManager->render('/pages/dashboard.twig');
  }
}
