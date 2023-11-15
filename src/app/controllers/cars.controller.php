<?php

require_once __DIR__ . '/../core/render.php';

class CarsController
{
  private $renderManager;

  public function __construct()
  {
      $this->renderManager = new RenderManager();
  }

  public function carsRouter()
  {
    $currentRoute = $_SERVER['REQUEST_URI'];

    $this->renderManager->render('/pages/cars.twig', ['currentRoute' => $currentRoute]);
  }
}
