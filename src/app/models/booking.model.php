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

    // Vérifier si les dates du nouveau booking chevauchent avec des bookings existants
    if ($this->isBookingOverlap($idVehicle, $startDate, $endDate)) {
      header("Location: /profil");
      exit();
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

  private function isBookingOverlap($idVehicle, $newStartDate, $newEndDate)
  {
    $stmt = $this->conn->prepare('SELECT * FROM booking WHERE id_vehicle = ? AND ((start_date <= ? AND end_date >= ?) OR (start_date <= ? AND end_date >= ?) OR (start_date >= ? AND end_date <= ?))');

    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
      return false;
    }

    $stmt->bind_param('ississi', $idVehicle, $newStartDate, $newStartDate, $newEndDate, $newEndDate, $newStartDate, $newEndDate);

    $stmt->execute();
    $result = $stmt->get_result();
    $bookingExists = $result->num_rows > 0;

    $stmt->close();

    return $bookingExists;
  }


  public function getAllBookingFromGarage($idGarage)
  {
    $stmt = $this->conn->prepare('
        SELECT
            b.id AS booking_id,
            b.start_date,
            b.end_date,
            b.price AS booking_price,
            v.id AS vehicle_id,
            v.brand,
            v.model,
            v.url_picture,
            v.brand_logo,
            u.firstname,
            u.lastname
        FROM
            booking b
        JOIN
            vehicle v ON b.id_vehicle = v.id
        JOIN
            users u ON b.id_user = u.id
        WHERE
            v.id_garage = ?
    ');

    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
    }

    $stmt->bind_param('s', $idGarage);

    if (!$stmt->execute()) {
      throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
    }

    $result = $stmt->get_result();
    $bookingData = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();

    return $bookingData;
  }

  public function getAllBookingFromUserId($userId)
  {
    $stmt = $this->conn->prepare('
        SELECT
            b.id AS booking_id,
            b.start_date,
            b.end_date,
            b.price AS booking_price,
            v.id AS vehicle_id,
            v.brand,
            v.model,
            v.url_picture,
            v.brand_logo
        FROM
            booking b
        JOIN
            vehicle v ON b.id_vehicle = v.id
        WHERE
            b.id_user = ?
    ');

    if ($stmt === false) {
      throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
    }

    $stmt->bind_param('s', $userId);

    if (!$stmt->execute()) {
      throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
    }

    $result = $stmt->get_result();
    $bookingData = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();

    return $bookingData;
  }
}
