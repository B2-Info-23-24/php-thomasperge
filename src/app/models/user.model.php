<?php

require_once 'vendor/autoload.php';

use Ramsey\Uuid\Uuid;

class UserModel
{
  private $conn;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  public function generateUUID16()
  {
    $uuid = Uuid::uuid4();
    $uuid16 = str_replace('-', '', $uuid->toString());
    return substr($uuid16, 0, 16);
  }

  public function signinUser($email, $password)
  {
    $userId = null;
    $hashedPassword = '';
    $isOwner = null;

    $stmt = $this->conn->prepare('SELECT id, password, is_garage_owner FROM users WHERE email = ?');

    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
      return false;
    }

    $stmt->bind_param('s', $email);

    if (!$stmt->execute()) {
      throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
      return false;
    }

    $stmt->store_result();

    if ($stmt->num_rows === 0) {
      $stmt->close();
      return false;
    }

    $stmt->bind_result($userId, $hashedPassword, $isOwner);

    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $hashedPassword)) {
      setcookie('userId', $userId);

      if ($isOwner) {
        header('Location: /dashboard');
        exit;
      } else {
        header('Location: /home');
        exit;
      }
    } else {
      return false;
    }
  }



  public function addUser($firstname, $lastname, $email, $phone, $password, $isOwner, $garageName, $garageAdress)
  {
    $id = $this->generateUUID16();

    if (empty($id) || empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($password)) {
      throw new Exception("Tous les champs sont obligatoires.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new Exception("Adresse e-mail non valide.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $this->conn->prepare('INSERT INTO users (id, firstname, lastname, email, phone, password, is_garage_owner) VALUES (?, ?, ?, ?, ?, ?, ?)');

    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
      return false;
    }

    $stmt->bind_param('ssssssi', $id, $firstname, $lastname, $email, $phone, $hashedPassword, $isOwner);

    if (!$stmt->execute()) {
      throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
      return false;
    }

    setcookie('userId', $id);

    if ($isOwner) {
      $this->addGarage($id, $garageName, $garageAdress);
    }

    $stmt->close();
    return true;
  }

  public function updateUser($userId, $firstname, $lastname, $email, $phone, $password)
  {
    if (empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($password)) {
      throw new Exception("Tous les champs sont obligatoires.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $this->conn->prepare('UPDATE users SET id=?, firstname=?, lastname=?, email=?, phone=?, password=? WHERE id=?');

    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
      return false;
    }

    $stmt->bind_param('sssssss', $userId, $firstname, $lastname, $email, $phone, $hashedPassword, $userId);

    if (!$stmt->execute()) {
      throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
      return false;
    }

    $stmt->close();
    return true;
  }

  public function addGarage($id_owner, $name, $adress)
  {
    if (empty($id_owner) || empty($name) || empty($adress)) {
      throw new Exception("Tous les champs sont obligatoires.");
    }

    $id = $this->generateUUID16();

    $stmt = $this->conn->prepare('INSERT INTO garage (id, id_owner, name, adress) VALUES (?, ?, ?, ?)');

    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
      return false;
    }

    $stmt->bind_param('ssss', $id, $id_owner, $name, $adress);

    if (!$stmt->execute()) {
      throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
      return false;
    }

    $stmt->close();
    return true;
  }

  public function getUserDataFromId($userId)
  {
    $sql = "SELECT * FROM users WHERE id = CAST('$userId' AS CHAR)";
    $result = $this->conn->query($sql);

    $data = [];
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
    }
    return $data;
  }

  public function isUserAdmin($userId)
  {
    $sql = "SELECT is_garage_owner FROM users WHERE id = CAST('$userId' AS CHAR)";
    $result = $this->conn->query($sql);

    if ($userId == null || $userId == '') {
      return null;
    } else if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row['is_garage_owner'] == 1;
    }

    return null;
  }
}
