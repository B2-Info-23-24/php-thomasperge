<?php

require_once __DIR__ . '/../core/render.php';
require_once __DIR__ . '/../models/user.model.php';

class SignupController
{
  private $renderManager;
  private $userModel;

  public function __construct()
  {
    global $conn;
    $this->userModel = new UserModel($conn);

    $this->renderManager = new RenderManager();
  }

  public function signupRouter()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $firstname = $_POST['form'] ?? '';
      $lastname = $_POST['lastname'] ?? '';
      $email = $_POST['email'] ?? '';
      $phone = $_POST['phone'] ?? '';
      $password = $_POST['password'] ?? '';
      $isOwner = isset($_POST['isowner']) && $_POST['isowner'] == 'on' ? 1 : 0;
      $nameGarage = $_POST['nameGarage'] ?? null;
      $adressGarage = $_POST['adressGarage'] ?? null;

      $adduser = $this->userModel->addUser($firstname, $lastname, $email, $phone, $password, $isOwner, $nameGarage, $adressGarage);

      if ($adduser) {
        header('Location: /sucess');
        exit;
      } else {
        echo "Erreur dans le formulaire...";
      }
    } else {
      $this->renderManager->render('/pages/signup.twig');
    }
  }
}
