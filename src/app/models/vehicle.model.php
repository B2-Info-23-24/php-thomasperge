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
    $user_id = $_COOKIE['userId'] ?? null;

    $sql = "SELECT vehicle.*, favorite.id AS favorite_id FROM vehicle";

    if ($user_id !== null) {
      $sql .= " LEFT JOIN favorite ON vehicle.id = favorite.id_vehicle AND favorite.id_user = '$user_id'";
    }

    $sql .= " WHERE vehicle.id = $vehicle_id";

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
      return false;
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

  // Filter
  public function filterVehiclePerSeats($nbSeats)
  {

    $sql = "SELECT * FROM vehicle WHERE nb_seats = $nbSeats";
    $result = $this->conn->query($sql);

    $data = [];
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
    }
    return $data;
  }

  public function filterVehiclePerPetrol($fuel)
  {
    $fuel = mysqli_real_escape_string($this->conn, $fuel);
    $sql = "SELECT * FROM vehicle WHERE LOWER(petrol) = LOWER('$fuel')";
    $result = $this->conn->query($sql);

    $vehicles = [];
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $vehicles[] = $row;
      }
    }

    return $vehicles;
  }

  public function filterVehiclePerColors($color)
  {
    $color = mysqli_real_escape_string($this->conn, $color);
    $sql = "SELECT * FROM vehicle WHERE LOWER(colors) = LOWER('$color')";
    $result = $this->conn->query($sql);

    $vehicles = [];
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $vehicles[] = $row;
      }
    }

    return $vehicles;
  }

  public function filterVehiclePerGearbox($gearbox)
  {
    $gearbox = mysqli_real_escape_string($this->conn, $gearbox);
    $sql = "SELECT * FROM vehicle WHERE LOWER(gearbox) = LOWER('$gearbox')";
    $result = $this->conn->query($sql);

    $vehicles = [];
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $vehicles[] = $row;
      }
    }

    return $vehicles;
  }

  public function filterVehiclePerPrice($startPrice, $endPrice)
  {
    $sql = "SELECT * FROM vehicle WHERE price BETWEEN ? AND ?";
    $stmt = $this->conn->prepare($sql);

    if ($stmt === false) {
      return [];
    }

    $stmt->bind_param("ii", $startPrice, $endPrice);

    $stmt->execute();

    $result = $stmt->get_result();
    $vehicles = [];

    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $vehicles[] = $row;
      }
    }

    $stmt->close();
    return $vehicles;
  }
}
