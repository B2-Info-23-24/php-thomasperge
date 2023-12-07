<?php

require_once 'vendor/autoload.php';

use Ramsey\Uuid\Uuid;

class FavoriteModel
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

  public function addFavorite($user_id, $vehicle_id)
  {
    $existingFavorite = $this->conn->prepare("SELECT * FROM favorite WHERE id_user = ? AND id_vehicle = ?");
    $existingFavorite->bind_param("ss", $user_id, $vehicle_id);
    $existingFavorite->execute();

    $result = $existingFavorite->get_result();
    $favoriteExists = $result && $result->num_rows > 0;

    $existingFavorite->close();

    if ($favoriteExists) {
      $deleteFavorite = $this->conn->prepare("DELETE FROM favorite WHERE id_user = ? AND id_vehicle = ?");
      $deleteFavorite->bind_param("ss", $user_id, $vehicle_id);
      $success = $deleteFavorite->execute();
      $deleteFavorite->close();
    } else {
      $sql = "INSERT INTO favorite (id, id_vehicle, id_user) VALUES (?, ?, ?)";
      $stmt = $this->conn->prepare($sql);
      $id = $this->generateUUID16();
      $stmt->bind_param("sss", $id, $vehicle_id, $user_id);
      $success = $stmt->execute();
      $stmt->close();
    }

    return $success ? true : false;
  }

  public function getFavoriteVehiclesFromUserId($userId)
  {
    global $conn;

    // Requête SQL pour obtenir les véhicules favoris d'un utilisateur
    $sql = "SELECT vehicle.* FROM favorite
            INNER JOIN vehicle ON favorite.id_vehicle = vehicle.id
            WHERE favorite.id_user = ?";

    // Préparer la requête
    $stmt = $conn->prepare($sql);

    // Vérifier si la préparation a échoué
    if (!$stmt) {
      die("Échec de la préparation de la requête : " . $conn->error);
    }

    // Lier les paramètres
    $stmt->bind_param("s", $userId);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer le résultat
    $result = $stmt->get_result();

    // Vérifier s'il y a des résultats
    if ($result->num_rows > 0) {
      // Retourner tous les véhicules favoris sous forme de tableau associatif
      return $result->fetch_all(MYSQLI_ASSOC);
    } else {
      // Aucun véhicule favori trouvé
      return [];
    }
  }
}
