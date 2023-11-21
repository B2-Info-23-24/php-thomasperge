<?php

class UserModel
{
  private $conn;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  public function addUser($firstname, $lastname, $email, $phone, $password, $isOwner, $garageName, $garageAdress)
  {
    if (empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($password)) {
      throw new Exception("Tous les champs sont obligatoires.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new Exception("Adresse e-mail non valide.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $this->conn->prepare('INSERT INTO users (firstname, lastname, email, phone, password, is_garage_owner) VALUES (?, ?, ?, ?, ?, ?)');

    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
      return false;
    }

    $stmt->bind_param('sssssi', $firstname, $lastname, $email, $phone, $hashedPassword, $isOwner);

    if (!$stmt->execute()) {
      throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
      return false;
    }
    
    $newUserId = $stmt->insert_id;

    setcookie('userId', $newUserId, time() + (86400 * 30), "/");
    setcookie('admin', $isOwner ? 'true' : 'false', time() + (86400 * 30), "/");
    
    if ($isOwner) {
      $this->addGarage($newUserId, $garageName, $garageAdress);
    }
    
    $stmt->close();
    return true;
  }

  public function addGarage($id_owner, $name, $adress)
  {
    if (empty($id_owner) || empty($name) || empty($adress)) {
      throw new Exception("Tous les champs sont obligatoires.");
    }

    $stmt = $this->conn->prepare('INSERT INTO garage (id_owner, name, adress) VALUES (?, ?, ?)');

    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
      return false;
    }

    $stmt->bind_param('sss', $id_owner, $name, $adress);

    if (!$stmt->execute()) {
      throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
      return false;
    }

    $stmt->close();
    return true;
  }
}
