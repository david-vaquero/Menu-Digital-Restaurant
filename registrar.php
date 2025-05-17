<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cliente = $_POST['cliente'];
    $plato_id = intval($_POST['plato_id']);

    if (!empty($cliente) && $plato_id > 0) {
        $stmt = $conn->prepare("INSERT INTO pedidos (cliente, plato_id) VALUES (?, ?)");
        $stmt->bind_param("si", $cliente, $plato_id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
header("Location: index.php");
exit;
?>
