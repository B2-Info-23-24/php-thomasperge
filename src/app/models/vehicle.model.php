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
      $sql = "SELECT * FROM vehicle WHERE id_owner_garage = $garageId";
      $result = $this->conn->query($sql);
  
      $data = [];
      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data[] = $row;
        }
      }
      return $data;
    }
}
