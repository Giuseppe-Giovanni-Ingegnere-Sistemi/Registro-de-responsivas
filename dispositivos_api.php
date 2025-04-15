<?php
// Encabezados para CORS y JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Configuración DB
$host = 'localhost';
$dbname = 'empleados';
$username = 'root';
$password = '';

// Detectar acción
$action = $_GET['action'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;port=3307;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Error de conexión: ' . $e->getMessage()]);
    exit;
}

switch ($action) {
    case 'getAll':
        $stmt = $pdo->query("SELECT * FROM dispositivos_empleados ORDER BY id DESC");
        $data = $stmt->fetchAll();
        echo json_encode(['success' => true, 'data' => $data, 'tableName' => 'dispositivos_empleados']);
        break;

    case 'getById':
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Falta ID']);
            break;
        }
        $stmt = $pdo->prepare("SELECT * FROM dispositivos_empleados WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $row = $stmt->fetch();
        if ($row) {
            echo json_encode(['success' => true, 'data' => $row]);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Registro no encontrado']);
        }
        break;

    case 'create':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
            break;
        }
        $columns = array_keys($input);
        $sql = "INSERT INTO dispositivos_empleados (" . implode(',', $columns) . ")
                VALUES (" . rtrim(str_repeat('?,', count($columns)), ',') . ")";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($input));
        echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
        break;

    case 'update':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input || !isset($input['id'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Datos inválidos o falta ID']);
            break;
        }
        $id = $input['id'];
        unset($input['id']);
        $set = implode(' = ?, ', array_keys($input)) . ' = ?';
        $stmt = $pdo->prepare("UPDATE dispositivos_empleados SET $set WHERE id = ?");
        $stmt->execute([...array_values($input), $id]);
        echo json_encode(['success' => true, 'rowsAffected' => $stmt->rowCount()]);
        break;

    case 'delete':
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Falta ID']);
            break;
        }
        $stmt = $pdo->prepare("DELETE FROM dispositivos_empleados WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        echo json_encode(['success' => true, 'rowsAffected' => $stmt->rowCount()]);
        break;

    case 'search':
        if (!isset($_GET['term'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Falta término de búsqueda']);
            break;
        }
        $term = '%' . $_GET['term'] . '%';
        $stmt = $pdo->prepare("SELECT * FROM dispositivos_empleados
                               WHERE clave LIKE ? OR apellidos_nombre LIKE ? OR departamento LIKE ? 
                               OR puesto LIKE ? OR correo LIKE ? ORDER BY id DESC");
        $stmt->execute([$term, $term, $term, $term, $term]);
        $rows = $stmt->fetchAll();
        echo json_encode(['success' => true, 'data' => $rows]);
        break;

    case 'debug':
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        $info = [];
        foreach ($tables as $t) {
            $desc = $pdo->query("DESCRIBE $t")->fetchAll();
            $count = $pdo->query("SELECT COUNT(*) AS total FROM $t")->fetch();
            $info[$t] = ['columns' => $desc, 'count' => $count['total']];
        }
        echo json_encode(['success' => true, 'tables' => $tables, 'tableInfo' => $info, 'currentTable' => 'dispositivos_empleados']);
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Acción inválida']);
}
