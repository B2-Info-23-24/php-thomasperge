<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../models/vehicle.model.php';
require_once __DIR__ . '/../models/garage.model.php';
require_once __DIR__ . '/../models/user.model.php';
require_once __DIR__ . '/../models/booking.model.php';

class DashboardController
{
  private $renderManager;
  private $vehicleModel;
  private $garageModel;
  private $userModel;
  private $bookingModel;

  public function __construct()
  {
    global $conn;
    $this->userModel = new UserModel($conn);
    $this->garageModel = new GarageModel($conn);
    $this->vehicleModel = new VehicleModel($conn);
    $this->bookingModel = new BookingModel($conn);

    $this->renderManager = new RenderManager();
  }

  public function dashboardRouter()
  {
    $userId = $_COOKIE['userId'];

    $userData = $this->userModel->getUserDataFromId($userId);
    $garageData = $this->garageModel->getGarageDataFromUserId($userId);
    $allVehicleFromGarage = $this->vehicleModel->getAllVehicleFromGarageID($garageData[0]['id']);
    $allBooking = $this->bookingModel->getAllBookingFromGarage($garageData[0]['id']);

    $this->renderManager->render('/pages/dashboard.twig', ['userData' => $userData, 'garageData' => $garageData, 'vehicles' => $allVehicleFromGarage, 'allBooking' => $allBooking]);
  }
}
