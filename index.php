<?php
include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Menú del Restaurante</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Menú del Restaurante</h1>
  </header>

  <main class="menu-grid">
    <?php
    $sql = "SELECT * FROM platos";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        while ($plato = $resultado->fetch_assoc()) {
            echo "<div class='plato'>";
            echo "<h2>" . htmlspecialchars($plato['nombre']) . "</h2>";
            echo "<p>" . htmlspecialchars($plato['descripcion']) . "</p>";
            echo "<span>" . number_format($plato['precio'], 2) . " €</span>";
            echo "<span class='categoria'>" . htmlspecialchars($plato['categoria']) . "</span>";
            echo "<button onclick=\"mostrarFormulario(".$plato['id'].")\">Obtener</button>";

            echo "<form class='formulario' id='form-".$plato['id']."' method='POST' action='registrar.php' style='display:none;'>";
            echo "<input type='hidden' name='plato_id' value='".$plato['id']."'>";
            echo "<input type='text' name='cliente' placeholder='Tu nombre' required>";
            echo "<button type='submit'>Confirmar</button>";
            echo "</form>";

            echo "</div>";
        }
    } else {
        echo "<p>No hay platos disponibles.</p>";
    }
    ?>
  </main>

  <section class="pedidos">
    <div class="pedidos">
      <h2>Pedidos realizados</h2>
      <?php
      // Consulta para obtener los pedidos
      $sql = "
        SELECT 
          pedidos.id AS pedido_id,
          cliente, 
          platos.nombre AS plato_nombre,
          platos.precio AS precio
        FROM pedidos 
        JOIN platos ON pedidos.plato_id = platos.id 
        ORDER BY cliente
      ";

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          // Agrupar pedidos por cliente
          $clientes = [];
          while ($row = $result->fetch_assoc()) {
              $clientes[$row['cliente']][] = $row;
          }

          // Mostrar pedidos agrupados por cliente
          foreach ($clientes as $cliente => $pedidos) {
              $total = 0;
              echo "<h3>" . htmlspecialchars($cliente) . "</h3>";
              echo "<ul>";
              foreach ($pedidos as $pedido) {
                  $total += $pedido['precio'];
                  echo "<li>" . htmlspecialchars($pedido['plato_nombre']) . " — " . number_format($pedido['precio'], 2) . " € 
                  <form method='POST' action='eliminar_pedidos.php' style='display:inline;'>
                      <input type='hidden' name='pedido_id' value='" . $pedido['pedido_id'] . "'>
                      <button type='submit' style='margin-left:10px; color:red;'>Eliminar</button>
                  </form>
                  </li>";
              }
              echo "</ul>";
              echo "<p><strong>Total: 💶 " . number_format($total, 2) . " €</strong></p>";
          }
      } else {
          // Mostrar mensaje si no hay pedidos
          echo "<p>No hay pedidos aún.</p>";
      }

      $conn->close();
      ?>
    </div>
  </section>

  <script>
    function mostrarFormulario(id) {
      let form = document.getElementById("form-" + id);
      form.style.display = form.style.display === "none" ? "block" : "none";
    }
  </script>
</body>
</html>