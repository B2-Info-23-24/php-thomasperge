<?php

class RatingModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllRatingFromVehicleId($id)
    {
        $sql = "SELECT * FROM rating WHERE id_vehicle = $id";
        $result = $this->conn->query($sql);

        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function setNewRating($userId, $id_vehicle, $rating, $description)
    {
        if (empty($userId) || empty($id_vehicle) || empty($rating) || empty($description)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }

        $stmt = $this->conn->prepare('INSERT INTO rating (id_user, id_vehicle, rating, description) VALUES (?, ?, ?, ?)');

        if ($stmt === false) {
            throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
            return false;
        }

        $stmt->bind_param('iiis', $userId, $id_vehicle, $rating, $description);

        if (!$stmt->execute()) {
            throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
            return false;
        }

        $stmt->close();
        return true;
    }
}
