<?php
require_once __DIR__ . '/controllers/home.controller.php';
require_once __DIR__ . '/controllers/dashboard.controller.php';
require_once __DIR__ . '/controllers/signin.controller.php';
require_once __DIR__ . '/controllers/signup.controller.php';
require_once __DIR__ . '/controllers/vehicle.controller.php';
require_once __DIR__ . '/controllers/submit.controller.php';
require_once __DIR__ . '/controllers/book.controller.php';
require_once __DIR__ . '/controllers/profil.controller.php';
require_once __DIR__ . '/controllers/404.controller.php';

// Router
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
  case '/':
    $homeController = new HomeController();
    $homeController->homeRouter();
    break;
  case '/home':
    $homeController = new HomeController();
    $homeController->homeRouter();
    break;
  case '/dashboard':
    $dashboardController = new DashboardController();
    $dashboardController->dashboardRouter();
    break;
  case '/signin':
    $signinController = new SigninController();
    $signinController->signinRouter();
    break;
  case '/submit':
    $submitController = new SubmitController();
    $submitController->submitRouter();
    break;
  case '/signup':
    $signupController = new SignupController();
    $signupController->signupRouter();
    break;
  case '/vehicle':
    $vehicleController = new VehicleController();
    $vehicleController->vehicleRouter();
    break;
  case '/book':
    $bookController = new BookController();
    $bookController->bookRouter();
    break;
  case '/profil':
    $profilController = new ProfilController();
    $profilController->profilRouter();
    break;
  default:
    http_response_code(404);
    $errorController = new ErrorController();
    $errorController->errorRouter();
    break;
}
