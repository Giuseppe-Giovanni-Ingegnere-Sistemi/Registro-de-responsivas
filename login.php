<?php
session_start();
require_once 'conexion.php';

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

// Preparar consulta segura
$sql = "SELECT contrasena FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $hash_db = $row['contrasena'];

    // Verificar la contraseña ingresada con el hash de la BD
    if (hash('sha256', $contrasena) === $hash_db) {
        $_SESSION['usuario'] = $usuario;
        header("Location: index.php"); // Página principal protegida
        exit;
    } else {
        echo "⚠️ Contraseña incorrecta.";
    }
} else {
    echo "⚠️ Usuario no encontrado.";
}

$stmt->close();
$conn->close();
?>
