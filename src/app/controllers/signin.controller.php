<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../core/admin.php';
require_once __DIR__ . '/../models/user.model.php';

class SigninController
{
  private $renderManager;
  private $userModel;
  private $adminManager;

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
      $isAdmin = $this->adminManager->isAdmin();

      $this->renderManager->render('/pages/signin.twig', ['isAdmin' => $isAdmin]);
      }
  }
}
