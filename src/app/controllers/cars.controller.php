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

  public function carsRouter($params)
  {
    $currentRoute = $_SERVER['REQUEST_URI'];
    $brand = $params['brand'] ?? null;

    $vehicles = $this->vehicleModel->getAllVehicles();
    $vehiclesFilterByBrand = $this->vehicleModel->getAllVehicleFromBrand($brand);

    if ($vehicles !== null && $brand === null) {
        $this->renderManager->render('/pages/cars.twig', ['currentRoute' => $currentRoute, 'vehicles' => $vehicles]);
    } elseif ($vehiclesFilterByBrand !== null) {
        $this->renderManager->render('/pages/cars.twig', ['currentRoute' => $currentRoute, 'vehicles' => $vehiclesFilterByBrand]);
    } else {
        $this->renderManager->render('/pages/404.twig', ['currentRoute' => $currentRoute]);
    }
  }
}
