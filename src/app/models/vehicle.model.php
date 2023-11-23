<?php

class VehicleModel
{
  private $conn;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  public function getAllVehicles()
  {
    $sql = "SELECT * FROM vehicle";
    $result = $this->conn->query($sql);

    $vehicles = [];
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $vehicles[] = $row;
      }
    }
    return $vehicles;
  }

  public function getUniqueVehicle($vehicle_id)
  {
    $sql = "SELECT * FROM vehicle WHERE id = $vehicle_id";
    $result = $this->conn->query($sql);

    $vehicles = [];
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $vehicles[] = $row;
      }
    }

    return $vehicles;
  }

  public function getAllVehicleFromBrand($brand)
  {
    $brand = mysqli_real_escape_string($this->conn, $brand);
    $sql = "SELECT * FROM vehicle WHERE LOWER(brand) = LOWER('$brand')";
    $result = $this->conn->query($sql);

    $vehicles = [];
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $vehicles[] = $row;
      }
    }

    return $vehicles;
  }

  public function getAllVehicleFromGarageID($garageId)
  {
    $sql = "SELECT * FROM vehicle WHERE id_garage = CAST('$garageId' AS CHAR)";
    $result = $this->conn->query($sql);

    $data = [];
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
    }
    return $data;
  }

  public function editVehicle($brand, $model, $price, $url_picture, $petrol, $nb_seats, $color, $gearbox, $brand_logo, $information, $vehicleId)
  {
    if (empty($vehicleId)) {
      throw new Exception("ID du véhicule non valide.");
    }

    $stmt = $this->conn->prepare('UPDATE vehicle SET brand=?, model=?, price=?, url_picture=?, petrol=?, nb_seats=?, colors=?, gearbox=?, brand_logo=?, information=? WHERE id=?');
    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
      return false;
    }

    $stmt->bind_param('ssississssi', $brand, $model, $price, $url_picture, $petrol, $nb_seats, $color, $gearbox, $brand_logo, $information, $vehicleId);

    if (!$stmt->execute()) {
      throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
      return false;
    }

    $stmt->close();
    return true;
  }


  public function addVehicle($id_garage, $brand, $model, $price, $url_picture, $petrol, $nb_seats, $color, $gearbox, $brand_logo, $information)
  {
    $stmt = $this->conn->prepare('INSERT INTO vehicle (id_garage, brand, model, price, url_picture, petrol, nb_seats, colors, gearbox, brand_logo, information) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
      return false;
    }

    $stmt->bind_param('sssssssssss', $id_garage, $brand, $model, $price, $url_picture, $petrol, $nb_seats, $color, $gearbox, $brand_logo, $information);

    if (!$stmt->execute()) {
      throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
      return false;
    }

    $stmt->close();
    return true;
  }
}
