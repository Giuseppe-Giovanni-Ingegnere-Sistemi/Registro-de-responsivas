<?php
$host = "localhost";
$usuario = "root";
$contrasena = ""; // pon tu contraseña si tiene
$basededatos = "sistema_login";

$conn = new mysqli('localhost', 'root', '', 'sistema_login', 3307); // ejemplo si es 3307


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
