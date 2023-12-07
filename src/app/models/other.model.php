<?php

require_once 'vendor/autoload.php';

use Ramsey\Uuid\Uuid;

class OtherModel
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

  public function getAllColors()
  {
    $sql = "SELECT * FROM colors";
    $result = $this->conn->query($sql);

    $data = [];
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
    }
    return $data;
  }

  public function deleteColors($colorId)
  {
    $stmt = $this->conn->prepare('DELETE FROM colors WHERE id=?');

    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
      return false;
    }

    $stmt->bind_param('s', $colorId);

    if (!$stmt->execute()) {
      throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
      return false;
    }

    $stmt->close();
    return true;
  }

  public function deleteBrands($brandId)
  {
    $stmt = $this->conn->prepare('DELETE FROM brands WHERE id=?');

    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
      return false;
    }

    $stmt->bind_param('s', $brandId);

    if (!$stmt->execute()) {
      throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
      return false;
    }

    $stmt->close();
    return true;
  }

  public function getAllBrands()
  {
    $sql = "SELECT * FROM brands";
    $result = $this->conn->query($sql);

    $data = [];
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
    }
    return $data;
  }

  public function updateColor($colorId, $color, $create_at)
  {
    if (empty($colorId) || empty($color)) {
      throw new Exception("Tous les champs sont obligatoires.");
    }

    $stmt = $this->conn->prepare('UPDATE colors SET color=?, created_at=? WHERE id=?');

    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
      return false;
    }

    $stmt->bind_param('sss', $color, $create_at, $colorId);

    if (!$stmt->execute()) {
      throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
      return false;
    }

    $stmt->close();
    return true;
  }

  public function updateBrand($brandId, $brand, $create_at)
  {
    if (empty($brandId) || empty($brand)) {
      throw new Exception("Tous les champs sont obligatoires.");
    }


    $stmt = $this->conn->prepare('UPDATE brands SET brand=?, created_at=? WHERE id=?');

    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
      return false;
    }

    $stmt->bind_param('sss', $brand, $create_at, $brandId);

    if (!$stmt->execute()) {
      throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
      return false;
    }

    $stmt->close();
    return true;
  }

  public function addColors($newcolor)
  {
    if (empty($newcolor)) {
      throw new Exception("Tous les champs sont obligatoires.");
    }

    $id = $this->generateUUID16();

    $stmt = $this->conn->prepare('INSERT INTO colors (id, color) VALUES (?, ?)');

    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
      return false;
    }

    $stmt->bind_param('ss', $id, $newcolor);

    if (!$stmt->execute()) {
      throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
      return false;
    }

    $stmt->close();
    return true;
  }

  public function addBrand($newbrand)
  {
    if (empty($newbrand)) {
      throw new Exception("Tous les champs sont obligatoires.");
    }

    $id = $this->generateUUID16();

    $stmt = $this->conn->prepare('INSERT INTO brands (id, brand) VALUES (?, ?)');

    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
      return false;
    }

    $stmt->bind_param('ss', $id, $newbrand);

    if (!$stmt->execute()) {
      throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
      return false;
    }

    $stmt->close();
    return true;
  }
}
