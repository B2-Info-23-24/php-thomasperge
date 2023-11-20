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

        $this->addUser("test", "test", "test@test.com", "test", "test");

        return $vehicles;
    }

    public function addUser($name, $last_name, $email, $phone, $password)
    {
        // Vérifier la validité des paramètres
        if (empty($name) || empty($last_name) || empty($email) || empty($phone) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Adresse e-mail non valide.");
        }

        // Hasher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Définir une variable intermédiaire pour le paramètre de type booléen
        $isGarageOwner = true;

        // Préparer la requête SQL
        $stmt = $this->conn->prepare('INSERT INTO users (firstname, lastname, email, phone, password, is_garage_owner) VALUES (?, ?, ?, ?, ?, ?)');

        // Vérifier s'il y a une erreur lors de la préparation de la requête
        if ($stmt === false) {
            throw new Exception('Erreur de préparation de la requête : ' . $this->conn->error);
        }

        // Binder les paramètres
        $stmt->bind_param('sssssi', $name, $last_name, $email, $phone, $hashedPassword, $isGarageOwner);

        // Exécuter la requête
        if (!$stmt->execute()) {
            throw new Exception('Erreur lors de l\'exécution de la requête : ' . $stmt->error);
        }

        // Fermer le statement
        $stmt->close();
    }
}
