<?php
require 'vendor/autoload.php';
require_once __DIR__ . '/../models/vehicle.model.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class VehicleController
{
  private $twig;
  private $vehicleModel;

  public function __construct()
  {
    global $conn;
    $this->vehicleModel = new VehicleModel($conn);

    $loader = new FilesystemLoader(__DIR__ . '/../views');
    $this->twig = new Environment($loader);
  }

  public function vehicleRouter()
  {
    $vehicles = $this->vehicleModel->getAllVehicles();

    echo $this->twig->render('/pages/vehicle.twig', ['vehicle' => $vehicles]);
  }
}
