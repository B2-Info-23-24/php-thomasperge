<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../models/vehicle.model.php';

class HomeController
{
  private $renderManager;
  private $vehicleModel;

  public function __construct()
  {
    global $conn;
    $this->vehicleModel = new VehicleModel($conn);

    $this->renderManager = new RenderManager();
  }

  public function homeRouter()
  {
    $currentRoute = $_SERVER['REQUEST_URI'];
    $vehicles = $this->vehicleModel->getAllVehicles();

    $this->renderManager->render('/pages/home.twig', ['currentRoute' => $currentRoute, 'vehicles' => $vehicles]);
  }
}
