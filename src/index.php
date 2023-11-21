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
require_once __DIR__ . '/config.php';

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

// Manage coockies
$isAdmin = isset($_COOKIE['admin']) ? filter_var($_COOKIE['admin'], FILTER_VALIDATE_BOOLEAN) : false;
$currentRoute = $_SERVER['REQUEST_URI'];

if ($isAdmin) {
    $restrictedRoutes = ['/home', '/vehicle', '/cars', '/book', '/profil'];

    if (in_array($currentRoute, $restrictedRoutes)) {
        header('Location: /dashboard');
        exit;
    }
} else {
    $restrictedRoutes = ['/dashboard', '/submit'];

    if (in_array($currentRoute, $restrictedRoutes)) {
        header('Location: /home');
        exit;
    }
}

// Router
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (array_key_exists($request, $routes)) {
  $route = $routes[$request];
  $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
  $params = [];
  parse_str($query, $params);
  $controller = new $route['controller']();
  $method = $route['method'];
  $controller->$method($params);
} else {
  http_response_code(404);
  $errorController = new ErrorController();
  $errorController->errorRouter();
}
