<?php

class BookingModel
{
  private $conn;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  public function addBooking($idVehicle, $idUser, $startDate, $endDate, $price)
  {
    if (empty($idVehicle) || empty($idUser) || empty($startDate) || empty($endDate) || empty($price)) {
      throw new Exception("Tous les champs sont obligatoires.");
    }

    $stmt = $this->conn->prepare('INSERT INTO booking (id_vehicle, id_user, start_date, end_date, price) VALUES (?, ?, ?, ?, ?)');

    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
      return false;
    }

    $stmt->bind_param('iissi', $idVehicle, $idUser, $startDate, $endDate, $price);

    if (!$stmt->execute()) {
      throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
      return false;
    }

    $stmt->close();
    return true;
  }
}
