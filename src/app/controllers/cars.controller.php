<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../models/vehicle.model.php';

class CarsController
{
  private $renderManager;
  private $vehicleModel;

  public function __construct()
  {
    global $conn;
    $this->vehicleModel = new VehicleModel($conn);

    $this->renderManager = new RenderManager();
  }

  public function carsRouter()
  {
    $currentRoute = $_SERVER['REQUEST_URI'];
    $vehicles = $this->vehicleModel->getAllVehicles();

    $this->renderManager->render('/pages/cars.twig', ['currentRoute' => $currentRoute, 'vehicles' => $vehicles]);
  }
}
