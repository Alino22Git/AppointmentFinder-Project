<?php
// Verbindung zur Datenbank herstellen
$servername = "localhost";
$username = "bif2webscriptinguser";
$password = "bif2021";
$dbname = "appointment";

$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfen, ob die Verbindung erfolgreich war
if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}