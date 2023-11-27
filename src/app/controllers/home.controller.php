<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../models/vehicle.model.php';
require_once __DIR__ . '/../models/user.model.php';
require_once __DIR__ . '/../core/admin.php';

class HomeController
{
  private $renderManager;
  private $adminManager;
  private $vehicleModel;

  public function __construct()
  {
    global $conn;
    $this->vehicleModel = new VehicleModel($conn);

    $this->adminManager = new AdminManager();
    $this->renderManager = new RenderManager();
  }

  public function homeRouter()
  {
    $currentRoute = $_SERVER['REQUEST_URI'];
    $vehicles = $this->vehicleModel->getAllVehicles();

    $isAdmin = $this->adminManager->isAdmin();

    $this->renderManager->render('/pages/home.twig', ['currentRoute' => $currentRoute, 'vehicles' => $vehicles, 'isAdmin' => $isAdmin]);
  }
}
