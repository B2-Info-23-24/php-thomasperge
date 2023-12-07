<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../core/admin.php';
require_once __DIR__ . '/../models/vehicle.model.php';
require_once __DIR__ . '/../models/garage.model.php';
require_once __DIR__ . '/../models/rating.model.php';
require_once __DIR__ . '/../models/booking.model.php';
require_once __DIR__ . '/../models/favorite.model.php';

class VehicleController
{
  private $adminManager;
  private $renderManager;
  private $vehicleModel;
  private $garageModel;
  private $ratingModel;
  private $bookingModel;
  private $favoriteModel;

  public function __construct()
  {
    global $conn;
    $this->vehicleModel = new VehicleModel($conn);
    $this->garageModel = new GarageModel($conn);
    $this->ratingModel = new RatingModel($conn);
    $this->bookingModel = new BookingModel($conn);
    $this->favoriteModel = new FavoriteModel($conn);

    $this->adminManager = new AdminManager();
    $this->renderManager = new RenderManager();
  }

  public function vehicleRouter($params)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $params['id'] !== null) {
      // Booking reserve
      $startDate = $_POST['startDate'] ?? null;
      $endDate = $_POST['returnDate'] ?? null;
      $price = $_POST['price'] ?? 0;

      // Id vehicle favorite
      $id_vehicle = $_POST['id_vehicle'] ?? null;

      if ($startDate && $endDate && $price && $id_vehicle === null && $startDate < $endDate) {
        $addBooking = $this->bookingModel->addBooking($params['id'], $_COOKIE['userId'], $startDate, $endDate, $price);

        if ($addBooking) {
          header('Location: /sucess');
          exit;
        } else {
          header('Location: /failed');
          exit;
        }
      } elseif ($id_vehicle !== null) {
        $addFavorite = $this->favoriteModel->addFavorite($_COOKIE['userId'], $params['id']);

        if ($addFavorite) {
          header("Location: /vehicle?id=" . $params['id']);
          exit;
        } else {
          header('Location: /failed');
          exit;
        }
      } else {
        header('Location: /failed');
        exit;
      }
    } else {
      $userId = $_COOKIE['userId'] ?? null;

      $vehicles = $this->vehicleModel->getUniqueVehicle($params['id'] ?? null, $userId);
      $garage = $this->garageModel->getGarageDataFromId($vehicles[0]['id_garage'] ?? null);
      $rating = $this->ratingModel->getAllRatingFromVehicleId($params['id'] ?? null);

      $isAdmin = $this->adminManager->isAdmin();

      if ($vehicles) {
        $isAdmin = $this->adminManager->isAdmin();
        $userLiked = !empty($vehicles) && !empty($vehicles[0]['favorite_id']);

        $this->renderManager->render('/pages/vehicle.twig', ['params' => $params['id'] ?? null, 'vehicle' => $vehicles, 'garage' => $garage, 'rating' => $rating, 'isAdmin' => $isAdmin, 'userLiked' => $userLiked,]);
      } else {
        $this->renderManager->render('/pages/signin.twig');
      }
    }
  }
}
