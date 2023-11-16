<?php

require_once __DIR__ . '/../core/render.php';

class ProfilController
{
  private $renderManager;

  public function __construct()
  {
    $this->renderManager = new RenderManager();
  }

  public function profilRouter()
  {
    $this->renderManager->render('/pages/profil.twig');
  }
}
