<?php
require_once __DIR__ . '/app/controllers/home.controller.php';
require_once __DIR__ . '/app/controllers/dashboard.controller.php';
require_once __DIR__ . '/app/controllers/signin.controller.php';
require_once __DIR__ . '/app/controllers/signup.controller.php';
require_once __DIR__ . '/app/controllers/vehicle.controller.php';
require_once __DIR__ . '/app/controllers/submit.controller.php';
require_once __DIR__ . '/app/controllers/book.controller.php';
require_once __DIR__ . '/app/controllers/profil.controller.php';
require_once __DIR__ . '/app/controllers/404.controller.php';
require_once __DIR__ . '/app/controllers/cars.controller.php';

// Définir les routes
$routes = [
  '/'         => ['controller' => 'HomeController', 'method' => 'homeRouter'],
  '/home'     => ['controller' => 'HomeController', 'method' => 'homeRouter'],
  '/dashboard' => ['controller' => 'DashboardController', 'method' => 'dashboardRouter'],
  '/signin'   => ['controller' => 'SigninController', 'method' => 'signinRouter'],
  '/submit'   => ['controller' => 'SubmitController', 'method' => 'submitRouter'],
  '/signup'   => ['controller' => 'SignupController', 'method' => 'signupRouter'],
  '/vehicle'  => ['controller' => 'VehicleController', 'method' => 'vehicleRouter'],
  '/cars'     => ['controller' => 'CarsController', 'method' => 'carsRouter'],
  '/book'     => ['controller' => 'BookController', 'method' => 'bookRouter'],
  '/profil'   => ['controller' => 'ProfilController', 'method' => 'profilRouter'],
];

// Router
$request = $_SERVER['REQUEST_URI'];

// Vérifier si la route existe dans le tableau
if (array_key_exists($request, $routes)) {
  $route = $routes[$request];
  $controller = new $route['controller']();
  $method = $route['method'];
  $controller->$method();
} else {
  // Route existe pas = envoyer une erreur 404
  http_response_code(404);
  $errorController = new ErrorController();
  $errorController->errorRouter();
}
