<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../core/admin.php';

class BookController
{
  private $renderManager;
  private $adminManager;

  public function __construct()
  {
    $this->adminManager = new AdminManager();
    $this->renderManager = new RenderManager();
  }

  public function bookRouter($params)
  {
    $isAdmin = $this->adminManager->isAdmin();

    $this->renderManager->render('/pages/book.twig', ['isAdmin' => $isAdmin]);
  }
}
