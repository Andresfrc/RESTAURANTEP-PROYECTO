<?php
require_once __DIR__ . "/conexion.php";

$db = Database::connect();

// Limpiar mesas existentes (opcional)
// $db->exec("DELETE FROM mesa");

// Insertar mesas de prueba
$mesas = [
    [2, 4, "Junto a la ventana"],
    [3, 4, "Rincón tranquilo"],
    [4, 6, "Centro del restaurante"],
    [5, 2, "Barra lateral"],
    [6, 8, "Área VIP"],
    [7, 4, "Entrada"],
];

$query = "INSERT INTO mesa (Numero_Mesa, Capacidad, Ubicacion, Estado) VALUES (?, ?, ?, 'Libre')";
$stmt = $db->prepare($query);

foreach ($mesas as $mesa) {
    try {
        $stmt->execute($mesa);
        echo "Mesa {$mesa[0]} insertada correctamente.<br>";
    } catch (Exception $e) {
        echo "Error al insertar mesa {$mesa[0]}: " . $e->getMessage() . "<br>";
    }
}

echo "<br>✅ Datos insertados. Ahora verifica las mesas en el formulario.";

// Mostrar mesas existentes
echo "<h3>Mesas en la base de datos:</h3>";
$result = $db->query("SELECT * FROM mesa");
$mesas_existentes = $result->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
print_r($mesas_existentes);
echo "</pre>";
?>
