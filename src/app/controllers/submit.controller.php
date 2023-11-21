<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../models/vehicle.model.php';
require_once __DIR__ . '/../models/garage.model.php';

class SubmitController
{
  private $renderManager;
  private $garageModel;
  private $vehicleModel;

  public function __construct()
  {
    global $conn;
    $this->garageModel = new GarageModel($conn);
    $this->vehicleModel = new VehicleModel($conn);

    $this->renderManager = new RenderManager();
  }

  public function submitRouter($params)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $brand = $_POST['brand'] ?? '';
      $model = $_POST['model'] ?? '';
      $price = $_POST['price'] ?? '';
      $image = $_POST['image'] ?? '';
      $petrol = $_POST['petrol'] ?? '';
      $nb_seats = $_POST['seats'] ?? '';
      $color = $_POST['color'] ?? '';
      $gearbox = $_POST['gearbox'] ?? '';
      $brandlogo = $_POST['brandlogo'] ?? '';
      $information = $_POST['information'] ?? '';

      $garageData = $this->garageModel->getGarageDataFromUserId($_COOKIE['userId']);
      $updateVehicle = $this->vehicleModel->addVehicle($garageData[0]['id'], $brand, $model, $price, $image, $petrol, $nb_seats, $color, $gearbox, $brandlogo, $information);

      if ($updateVehicle) {
        header('Location: /dashboard');
        exit;
      } else {
        echo "Erreur dans le formulaire...";
      }
    } else {
      $this->renderManager->render('/pages/submit.twig');
    }
  }
}
