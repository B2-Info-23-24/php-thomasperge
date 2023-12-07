<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../core/admin.php';
require_once __DIR__ . '/../models/vehicle.model.php';
require_once __DIR__ . '/../models/garage.model.php';
require_once __DIR__ . '/../models/user.model.php';
require_once __DIR__ . '/../models/booking.model.php';
require_once __DIR__ . '/../models/other.model.php';

class DashboardController
{
  private $renderManager;
  private $vehicleModel;
  private $garageModel;
  private $userModel;
  private $bookingModel;
  private $otherModel;
  private $adminManager;

  public function __construct()
  {
    global $conn;
    $this->userModel = new UserModel($conn);
    $this->garageModel = new GarageModel($conn);
    $this->vehicleModel = new VehicleModel($conn);
    $this->bookingModel = new BookingModel($conn);
    $this->otherModel = new OtherModel($conn);

    $this->adminManager = new AdminManager();
    $this->renderManager = new RenderManager();
  }

  public function dashboardRouter()
  {
    $userId = $_COOKIE['userId'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST['update-user'])) {
        // Change profile
        $id = $_POST['id'] ?? '';
        $created_at = $_POST['created_at'] ?? '';
        $firstname = $_POST['firstname'] ?? '';
        $lastname = $_POST['lastname'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $is_garage_owner = $_POST['is_garage_owner'] ?? '';

        if (empty($id) || empty($created_at) || empty($firstname) || empty($lastname) || empty($email) || empty($phone) || !isset($is_garage_owner)) {
          header('Location: /failed');
          exit;
        } else {
          $updateUsers = $this->userModel->updateUserForAdmin($id, $created_at, $firstname, $lastname, $email, $phone, $is_garage_owner);

          if ($updateUsers) {
            header('Location: /dashboard');
            exit;
          } else {
            header('Location: /failed');
            exit;
          }
        }
      } else if (isset($_POST['update-color'])) {
        // Change profile
        $id = $_POST['id'] ?? '';
        $color = $_POST['color'] ?? '';
        $created_at = $_POST['created_at'] ?? '';

        if (empty($color) || empty($created_at) || empty($id)) {
          header('Location: /failed');
          exit;
        } else {
          $updateUsers = $this->otherModel->updateColor($id, $color, $created_at);

          if ($updateUsers) {
            header('Location: /dashboard');
            exit;
          } else {
            header('Location: /failed');
            exit;
          }
        }
      } else if (isset($_POST['update-brand'])) {
        // Change profile
        $id = $_POST['id'] ?? '';
        $brand = $_POST['brand'] ?? '';
        $created_at = $_POST['created_at'] ?? '';

        if (empty($brand) || empty($created_at) || empty($id)) {
          header('Location: /failed');
          exit;
        } else {
          $updateUsers = $this->otherModel->updateBrand($id, $brand, $created_at);

          if ($updateUsers) {
            header('Location: /dashboard');
            exit;
          } else {
            header('Location: /failed');
            exit;
          }
        }
      } else if (isset($_POST['delete-user'])) {
        // Change profile
        $id = $_POST['id'] ?? '';

        if (empty($id)) {
          header('Location: /failed');
          exit;
        } else {
          $deleteUsers = $this->userModel->deleteUser($id);

          if ($deleteUsers) {
            header('Location: /dashboard');
            exit;
          } else {
            header('Location: /failed');
            exit;
          }
        }
      } else if (isset($_POST['delete-color'])) {
        // Change profile
        $id = $_POST['id'] ?? '';

        if (empty($id)) {
          header('Location: /failed');
          exit;
        } else {
          $deleteUsers = $this->otherModel->deleteColors($id);

          if ($deleteUsers) {
            header('Location: /dashboard');
            exit;
          } else {
            header('Location: /failed');
            exit;
          }
        }
      } else if (isset($_POST['delete-brand'])) {
        // Change profile
        $id = $_POST['id'] ?? '';

        if (empty($id)) {
          header('Location: /failed');
          exit;
        } else {
          $deleteUsers = $this->otherModel->deleteBrands($id);

          if ($deleteUsers) {
            header('Location: /dashboard');
            exit;
          } else {
            header('Location: /failed');
            exit;
          }
        }
      }
    } else {
      $userData = $this->userModel->getUserDataFromId($userId);
      $garageData = $this->garageModel->getGarageDataFromUserId($userId);
      $allVehicleFromGarage = $this->vehicleModel->getAllVehicleFromGarageID($garageData[0]['id']);
      $allBooking = $this->bookingModel->getAllBookingFromGarage($garageData[0]['id']);
      $allUsers = $this->userModel->getAllUsers();
      $allColors = $this->otherModel->getAllColors();
      $allBrands = $this->otherModel->getAllBrands();

      $isAdmin = $this->adminManager->isAdmin();

      $this->renderManager->render('/pages/dashboard.twig', ['userData' => $userData, 'garageData' => $garageData, 'vehicles' => $allVehicleFromGarage, 'allBooking' => $allBooking, 'isAdmin' => $isAdmin, 'allUsers' => $allUsers, 'allColors' => $allColors, 'allBrands' => $allBrands]);
    }
  }
}
