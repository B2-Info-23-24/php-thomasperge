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
        } else {
            echo "No vehicles found or error in query: " . $this->conn->error;
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
        } else {
            echo "No vehicles found or error in query: " . $this->conn->error;
        }
        return $vehicles;
    }
}
