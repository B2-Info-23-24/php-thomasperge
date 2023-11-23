<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../models/vehicle.model.php';
require_once __DIR__ . '/../models/garage.model.php';
require_once __DIR__ . '/../models/rating.model.php';
require_once __DIR__ . '/../models/booking.model.php';

class VehicleController
{
  private $renderManager;
  private $vehicleModel;
  private $garageModel;
  private $ratingModel;
  private $bookingModel;

  public function __construct()
  {
    global $conn;
    $this->vehicleModel = new VehicleModel($conn);
    $this->garageModel = new GarageModel($conn);
    $this->ratingModel = new RatingModel($conn);
    $this->bookingModel = new BookingModel($conn);

    $this->renderManager = new RenderManager();
  }

  public function vehicleRouter($params)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $params['id'] !== null) {
      $startDate = $_POST['startDate'] ?? '';
      $endDate = $_POST['returnDate'] ?? '';
      $price = $_POST['price'] ?? 0;

      $addBooking = $this->bookingModel->addBooking($params['id'], $_COOKIE['userId'], $startDate, $endDate, $price);

      if ($addBooking) {
        header('Location: /sucess');
        exit;
      } else {
        echo "Erreur dans le formulaire...";
      }
    } else {
      $vehicles = $this->vehicleModel->getUniqueVehicle($params['id'] ?? null);
      $garage = $this->garageModel->getGarageDataFromId($vehicles[0]['id_garage'] ?? null);
      $rating = $this->ratingModel->getAllRatingFromVehicleId($params['id'] ?? null);

      if ($vehicles) {
        $this->renderManager->render('/pages/vehicle.twig', ['params' => $params['id'] ?? null, 'vehicle' => $vehicles, 'garage' => $garage, 'rating' => $rating]);
      } else {
        $this->renderManager->render('/pages/404.twig');
      }
    }
  }
}
