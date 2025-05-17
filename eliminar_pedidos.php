<?php
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se recibió el ID del pedido
    if (isset($_POST['pedido_id'])) {
        $pedido_id = intval($_POST['pedido_id']);

        // Preparar la consulta para eliminar el pedido
        $sql = "DELETE FROM pedidos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $pedido_id);

        if ($stmt->execute()) {
            // Redirigir de vuelta a la página principal después de eliminar
            header("Location: index.php");
            exit();
        } else {
            echo "Error al eliminar el pedido: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "ID del pedido no proporcionado.";
    }
} else {
    echo "Método no permitido.";
}

$conn->close();
?>
