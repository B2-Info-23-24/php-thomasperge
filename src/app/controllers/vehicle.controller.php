<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../models/vehicle.model.php';
require_once __DIR__ . '/../models/garage.model.php';
require_once __DIR__ . '/../models/rating.model.php';

class VehicleController
{
  private $renderManager;
  private $vehicleModel;
  private $garageModel;
  private $ratingModel;

  public function __construct()
  {
    global $conn;
    $this->vehicleModel = new VehicleModel($conn);
    $this->garageModel = new GarageModel($conn);
    $this->ratingModel = new RatingModel($conn);

    $this->renderManager = new RenderManager();
  }

  public function vehicleRouter($params)
  {
    $vehicles = $this->vehicleModel->getUniqueVehicle($params['id'] ?? null);
    $garage = $this->garageModel->getGarageDataFromId($vehicles[0]['id_owner_garage'] ?? null);
    $rating = $this->ratingModel->getAllRatingFromVehicleId($params['id'] ?? null);

    if ($vehicles) {
      $this->renderManager->render('/pages/vehicle.twig', ['params' => $params['id'] ?? null, 'vehicle' => $vehicles, 'garage' => $garage, 'rating' => $rating]);
    } else {
      $this->renderManager->render('/pages/404.twig');

    }
  }
}
