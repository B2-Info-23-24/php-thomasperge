<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../core/admin.php';
require_once __DIR__ . '/../models/user.model.php';
require_once __DIR__ . '/../models/booking.model.php';
require_once __DIR__ . '/../models/rating.model.php';
require_once __DIR__ . '/../models/favorite.model.php';

class ProfilController
{
  private $renderManager;
  private $userModel;
  private $bookingModel;
  private $ratingModel;
  private $favoriteModel;
  private $adminManager;

  public function __construct()
  {
    global $conn;
    $this->bookingModel = new BookingModel($conn);
    $this->userModel = new UserModel($conn);
    $this->ratingModel = new RatingModel($conn);
    $this->favoriteModel = new FavoriteModel($conn);

    $this->renderManager = new RenderManager();
    $this->adminManager = new AdminManager();
  }

  public function profilRouter($params)
  {
    $userId = $_COOKIE['userId'];

    $now = new DateTime();
    $formattedDate = $now->format("Y-m-d H:i:s");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Change profile
      $firstname = $_POST['firstname'] ?? '';
      $lastname = $_POST['lastname'] ?? '';
      $email = $_POST['email'] ?? '';
      $phone = $_POST['phone'] ?? '';
      $password = $_POST['password'] ?? '';

      if($firstname && $lastname && $email && $phone && $password) {
        $updateUser = $this->userModel->updateUser($userId, $firstname, $lastname, $email, $phone, $password);

        if ($updateUser) {
          header('Location: /profil');
          exit;
        } else {
          header('Location: /failed');
        }
      }

      // Set feedback
      $score = $_POST['score'] ?? '';
      $description = $_POST['description'] ?? '';

      if ($score && $description) {
        $newrating = $this->ratingModel->setNewRating($userId, $params['vehicle_id'], $score, $description);

        if ($newrating) {
          header('Location: /profil');
          exit;
        } else {
          header('Location: /failed');
        }
      }
    } else {
      $userData = $this->userModel->getUserDataFromId($userId);
      $bookingData = $this->bookingModel->getAllBookingFromUserId($userId);
      $favoriteData = $this->favoriteModel->getFavoriteVehiclesFromUserId($userId);

      $isAdmin = $this->adminManager->isAdmin();

      $this->renderManager->render('/pages/profil.twig', ['userData' => $userData, 'bookingData' => $bookingData, 'currentDate' => $formattedDate, 'isAdmin' => $isAdmin, 'favoriteData' => $favoriteData]);
    }
  }
}
