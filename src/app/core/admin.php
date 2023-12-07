<?php
require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/user.model.php';

class AdminManager
{
    private $userModel;

    public function __construct()
    {
      global $conn;
      $this->userModel = new UserModel($conn);
    }

    public function isAdmin()
    {
      $userId = $_COOKIE['userId'] ?? null;
      $isAdmin = $this->userModel->isUserAdmin($userId);

      return $isAdmin;
    }
}
