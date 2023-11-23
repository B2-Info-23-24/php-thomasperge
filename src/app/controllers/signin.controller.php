<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../models/user.model.php';

class SigninController
{
  private $renderManager;
  private $userModel;

  public function __construct()
  {
    global $conn;
    $this->userModel = new UserModel($conn);

    $this->renderManager = new RenderManager();
  }

  public function signinRouter()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = $_POST['email'] ?? '';
      $password = $_POST['password'] ?? '';

      $signinUser = $this->userModel->signinUser($email, $password);

      if ($signinUser) {
        header('Location: /home');
        exit;
      } else {
        echo "Erreur dans le formulaire...";
      }
    } else {
      $this->renderManager->render('/pages/signin.twig');
    }
  }
}
