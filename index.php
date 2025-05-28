<?php
// Configuración de la base de datos
$host = 'l51infra-server.mysql.database.azure.com';
$db = 'calificaciones';
$user = 'rootits';
$pass = 'Its_2022'; // <-- Cambia esto por tu contraseña real
$charset = 'utf8mb4';

// Cadena de conexión
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Opciones de conexión
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$mensaje = "";

try {
    // Crear conexión PDO (sin SSL para fines de prueba)
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Verifica si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST["nombre"];
        $materia = $_POST["materia"];
        $calificacion = $_POST["calificacion"];

        // Inserta los datos
        $stmt = $pdo->prepare("INSERT INTO registros (nombre, materia, calificacion) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $materia, $calificacion]);
        $mensaje = "✅ Registro guardado correctamente.";
    }

} catch (PDOException $e) {
    $mensaje = "❌ Error de conexión: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Calificaciones</title>
</head>
<body>
    <h2>Registrar Calificación</h2>

    <?php if ($mensaje): ?>
        <p><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Materia:</label><br>
        <input type="text" name="materia" required><br><br>

        <label>Calificación:</label><br>
        <input type="number" name="calificacion" required><br><br>

        <input type="submit" value="Guardar">
    </form>
</body>
</html>
