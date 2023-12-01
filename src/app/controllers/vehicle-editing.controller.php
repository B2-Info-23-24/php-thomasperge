<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../core/admin.php';
require_once __DIR__ . '/../models/vehicle.model.php';
require_once __DIR__ . '/../models/garage.model.php';
require_once __DIR__ . '/../models/rating.model.php';

class VehicleEditingController
{
  private $renderManager;
  private $adminManager;
  private $vehicleModel;
  private $garageModel;
  private $ratingModel;

  public function __construct()
  {
    global $conn;
    $this->vehicleModel = new VehicleModel($conn);
    $this->garageModel = new GarageModel($conn);
    $this->ratingModel = new RatingModel($conn);

    $this->adminManager = new AdminManager();
    $this->renderManager = new RenderManager();
  }

  public function vehicleEditingRouter($params)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST['edit-vehicle'])) {
        // Form 1 - Change Informations
        $brand = $_POST['brand'] ?? '';
        $model = $_POST['model'] ?? '';
        $price = $_POST['price'] ?? '';
        $image = $_POST['image'] ?? '';
        $petrol = $_POST['petrol'] ?? '';
        $nb_seats = $_POST['nb_seats'] ?? '';
        $color = $_POST['color'] ?? '';
        $gearbox = $_POST['gearbox'] ?? '';
        $brandlogo = $_POST['brandlogo'] ?? '';
        $information = $_POST['information'] ?? '';
  
        $updateVehicle = $this->vehicleModel->editVehicle($brand, $model, $price, $image, $petrol, $nb_seats, $color, $gearbox, $brandlogo, $information, $params['id']);
  
        if ($updateVehicle) {
          header('Location: /dashboard');
          exit;
        } else {
          header('Location: /failed');
          exit;
        }
      } elseif (isset($_POST['edit-review'])) {
        // Form 2 - Change reviews
        $newDesc = $_POST['review_input'] ?? '';
        $id_vehicle = $_POST['id_vehicle'] ?? '';
        $userId = $_POST['user_id_review'] ?? '';

        $updateVehicle = $this->ratingModel->updateRating($userId, $id_vehicle, $newDesc);

        if ($updateVehicle) {
          header("Location: /vehicle-editing?id=" . $id_vehicle);
          exit;
        }
      }
    } else {
      $idUrl = $params['id'] ?? null;

      if ($idUrl === null) {
        header('Location: /dashboard');
        exit;
      }

      $vehicles = $this->vehicleModel->getUniqueVehicle($idUrl ?? null);
      $garage = $this->garageModel->getGarageDataFromId($vehicles[0]['id_garage'] ?? null);
      $rating = $this->ratingModel->getAllRatingFromVehicleId($idUrl ?? null);

      $isAdmin = $this->adminManager->isAdmin();

      if ($vehicles) {
        $this->renderManager->render('/pages/vehicle-editing.twig', ['params' => $idUrl ?? null, 'vehicle' => $vehicles, 'garage' => $garage, 'rating' => $rating, 'isAdmin' => $isAdmin]);
      } else {
        $this->renderManager->render('/pages/404.twig');
      }
    }
  }
}
