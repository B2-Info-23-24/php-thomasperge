<?php
// config.php
$servername = "mysql";
$username = "my_user";
$password = "my_password";
$dbname = "my_database";

// Connexion bdd
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
