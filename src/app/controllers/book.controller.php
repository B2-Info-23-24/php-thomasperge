<?php

require_once __DIR__ . '/../core/render.php';

class BookController
{
  private $renderManager;

  public function __construct()
  {
    $this->renderManager = new RenderManager();
  }

  public function bookRouter($params)
  {
    $this->renderManager->render('/pages/book.twig');
  }
}
