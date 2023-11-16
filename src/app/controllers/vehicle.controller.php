<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../models/vehicle.model.php';

class VehicleController
{
  private $renderManager;
  private $vehicleModel;

  public function __construct()
  {
    global $conn;
    $this->vehicleModel = new VehicleModel($conn);

    $this->renderManager = new RenderManager();
  }

  public function vehicleRouter($params)
  {
    $vehicles = $this->vehicleModel->getUniqueVehicle($params['id']);

    $this->renderManager->render('/pages/vehicle.twig', ['params' => $params['id'] ?? null, 'vehicle' => $vehicles]);
  }
}
