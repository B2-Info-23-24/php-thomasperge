<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../core/admin.php';
require_once __DIR__ . '/../models/vehicle.model.php';

class CarsController
{
  private $renderManager;
  private $vehicleModel;
  private $adminManager;

  public function __construct()
  {
    global $conn;
    $this->vehicleModel = new VehicleModel($conn);

    $this->adminManager = new AdminManager();
    $this->renderManager = new RenderManager();
  }

  public function carsRouter($params)
  {
    $currentRoute = $_SERVER['REQUEST_URI'];
    $brand = $params['brand'] ?? null;
    $fuel = $params['fuel'] ?? null;
    $seats = $params['seats'] ?? null;
    $color = $params['color'] ?? null;
    $gearbox = $params['gearbox'] ?? null;

    $pricestart = $params['pricestart'] ?? null;
    $priceend = $params['priceend'] ?? null;


    $vehicles = $this->vehicleModel->getAllVehicles();
    $vehiclesFilterByBrand = $this->vehicleModel->getAllVehicleFromBrand($brand) ?? null;
    $vehiclesFilterBySeats = $this->vehicleModel->filterVehiclePerSeats($seats) ?? null;
    $vehiclesFilterByFuel = $this->vehicleModel->filterVehiclePerPetrol($fuel) ?? null;
    $vehiclesFilterByColor = $this->vehicleModel->filterVehiclePerColors($color) ?? null;
    $vehiclesFilterByGearbox = $this->vehicleModel->filterVehiclePerGearbox($gearbox) ?? null;
    $vehiclesFilterByPrice = $this->vehicleModel->filterVehiclePerPrice($pricestart, $priceend) ?? null;
    $isAdmin = $this->adminManager->isAdmin();


    if ($vehicles !== null && $brand === null && $fuel === null && $seats === null && $color === null && $pricestart == null && $priceend == null) {
      $this->renderManager->render('/pages/cars.twig', ['currentRoute' => $currentRoute, 'vehicles' => $vehicles, 'isAdmin' => $isAdmin]);
    } elseif ($vehiclesFilterByBrand !== null && $brand !== null) {
      $this->renderManager->render('/pages/cars.twig', ['currentRoute' => $currentRoute, 'vehicles' => $vehiclesFilterByBrand, 'isAdmin' => $isAdmin]);
    } elseif ($vehiclesFilterBySeats !== null && $seats !== null) {
      $this->renderManager->render('/pages/cars.twig', ['currentRoute' => $currentRoute, 'vehicles' => $vehiclesFilterBySeats, 'isAdmin' => $isAdmin]);
    } elseif ($vehiclesFilterByFuel !== null && $fuel !== null) {
      $this->renderManager->render('/pages/cars.twig', ['currentRoute' => $currentRoute, 'vehicles' => $vehiclesFilterByFuel, 'isAdmin' => $isAdmin]);
    } elseif ($vehiclesFilterByColor !== null && $color !== null) {
      $this->renderManager->render('/pages/cars.twig', ['currentRoute' => $currentRoute, 'vehicles' => $vehiclesFilterByColor, 'isAdmin' => $isAdmin]);
    } elseif ($vehiclesFilterByGearbox !== null && $gearbox !== null) {
      $this->renderManager->render('/pages/cars.twig', ['currentRoute' => $currentRoute, 'vehicles' => $vehiclesFilterByGearbox, 'isAdmin' => $isAdmin]);
    } elseif ($vehiclesFilterByPrice !== null && $pricestart !== null && $priceend !== null) {
      $this->renderManager->render('/pages/cars.twig', ['currentRoute' => $currentRoute, 'vehicles' => $vehiclesFilterByPrice, 'isAdmin' => $isAdmin]);
    } else {
      $this->renderManager->render('/pages/404.twig', ['currentRoute' => $currentRoute]);
    }
  }
}
