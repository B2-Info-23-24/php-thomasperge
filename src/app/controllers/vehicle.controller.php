<?php
require_once __DIR__ . '/../core/render.php';

class VehicleController
{
  private $renderManager;

  public function __construct()
  {
    $this->renderManager = new RenderManager();
  }

  public function vehicleRouter($params)
  {
    $this->renderManager->render('/pages/vehicle.twig', ['params' => $params['id'] ?? null]);
  }
}
