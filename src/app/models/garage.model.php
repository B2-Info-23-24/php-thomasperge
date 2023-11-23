<?php

class GarageModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getGarageDataFromId($id)
    {
        $sql = "SELECT * FROM garage WHERE id = CAST('$id' AS CHAR)";
        $result = $this->conn->query($sql);

        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getGarageDataFromUserId($userIdOwner)
    {
        $sql = "SELECT * FROM garage WHERE id_owner = CAST('$userIdOwner' AS CHAR)";
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
