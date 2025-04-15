<?php
// Configuración DB
$host = 'localhost';
$dbname = 'empleados';
$username = 'root';
$password = '';
$port = 3307;

try {
    // Conectar a la base
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $archivoTmp = $_FILES['archivo']['tmp_name'];
        $fila = 0;
        $insertados = 0;

        if (($gestor = fopen($archivoTmp, 'r')) !== false) {
            $encabezados = fgetcsv($gestor, 1000, ',');

            while (($datos = fgetcsv($gestor, 1000, ',')) !== false) {
                $fila++;

                // Asegurar que hay al menos 25 columnas
                if (count($datos) >= 25) {
                    $datos = array_slice($datos, 0, 25); // cortar a 25 columnas

                    $sql = "INSERT INTO dispositivos_empleados (
                        clave, apellidos_nombre, puesto, departamento, ceco, nomina, empresa,
                        ciudad_estado, tipo_dispositivo, propio_arrendamiento, codigo_aldesa,
                        marca, modelo, serie, imei, telefono, username, correo, contrasena,
                        resguardo, responsiva_correo, activo, observaciones, ubicacion_maps, direccion_impresoras
                    ) VALUES (" . str_repeat("?,", 24) . "?)";

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($datos);
                    $insertados++;
                } else {
                    echo "⚠️ Fila $fila con columnas insuficientes. Se esperaban al menos 25 y llegaron " . count($datos) . "<br>";
                }
            }

            fclose($gestor);
            echo "<strong>✅ Se importaron $insertados registros correctamente.</strong><br><br>";
        } else {
            echo "❌ Error al abrir el archivo.";
        }
    } else {
        echo "❌ Error en la carga del archivo.";
    }

    // Mostrar últimos registros insertados
    $stmt = $pdo->query("SELECT * FROM dispositivos_empleados ORDER BY id DESC LIMIT 10");

    echo "<h3>📋 Últimos registros:</h3>";
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>";
    foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $key => $value) {
        echo "<th>" . htmlspecialchars($key) . "</th>";
    }
    echo "</tr>";

    // Reiniciar cursor para volver a recorrer
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        foreach ($row as $col) {
            echo "<td>" . htmlspecialchars($col) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";

} catch (PDOException $e) {
    echo "❌ Error de conexión o ejecución: " . $e->getMessage();
}
?>
