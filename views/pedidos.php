<?php include("../config/db.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Pedidos</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #ffffff;
            padding: 30px;
            color: #2C3E50;
        }

        h1 {
            text-align: center;
            color: #C8A951;
        }

        .busqueda {
            text-align: center;
            margin-bottom: 20px;
        }

        input, select, button {
            padding: 8px 12px;
            margin: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #C8A951;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #b1913f;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        th {
            background-color: #C8A951;
            color: white;
            padding: 12px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        .pendiente {
            background-color: #fff3cd;
        }

        a {
            text-decoration: none;
            color: #C8A951;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .volver {
            display: inline-block;
            margin-top: 20px;
            background: #2C3E50;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .volver:hover {
            background: #1f2d3b;
        }

        .eliminar-btn {
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin-left: 5px;
            transition: 0.3s;
        }

        .eliminar-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <h1>Gestión de Pedidos</h1>

    <div class="busqueda">
        <form method="GET" action="">
            <input type="text" name="buscar_cliente" placeholder="Buscar por cliente" value="<?= $_GET['buscar_cliente'] ?? '' ?>">
            <input type="text" name="buscar_producto" placeholder="Buscar por producto" value="<?= $_GET['buscar_producto'] ?? '' ?>">
            <select name="filtro_estado">
                <option value="">-- Estado --</option>
                <option value="Pendiente" <?= (($_GET['filtro_estado'] ?? '') == 'Pendiente') ? 'selected' : '' ?>>Pendiente</option>
                <option value="En Proceso" <?= (($_GET['filtro_estado'] ?? '') == 'En Proceso') ? 'selected' : '' ?>>En Proceso</option>
                <option value="Entregado" <?= (($_GET['filtro_estado'] ?? '') == 'Entregado') ? 'selected' : '' ?>>Entregado</option>
            </select>
            <button type="submit">Buscar</button>
            <a href="pedidos.php"><button type="button">Limpiar</button></a>
        </form>
    </div>

    <form method="POST" action="">
        <input type="text" name="cliente" placeholder="Cliente" required>
        <input type="text" name="producto" placeholder="Producto" required>
        <input type="number" name="cantidad" placeholder="Cantidad" required>
        <button type="submit" name="crear">Crear Pedido</button>
    </form>

    <?php
    if(isset($_POST['crear'])){
        $cliente = $_POST['cliente'];
        $producto = $_POST['producto'];
        $cantidad = $_POST['cantidad'];
        $conn->query("INSERT INTO pedidos (cliente,producto,cantidad,estado) VALUES ('$cliente','$producto','$cantidad','Pendiente')");
        header("Location: pedidos.php"); exit;
    }

    if(isset($_POST['cambiarEstado'])){
        $id = $_POST['id'];
        $estado = $_POST['estado'];
        $conn->query("UPDATE pedidos SET estado='$estado' WHERE id=$id");
        header("Location: pedidos.php"); exit;
    }

    if(isset($_GET['eliminar'])){
        $id = $_GET['eliminar'];
        $conn->query("DELETE FROM pedidos WHERE id=$id");
        header("Location: pedidos.php"); exit;
    }

    $where = [];
    if(!empty($_GET['buscar_cliente'])) $where[] = "cliente LIKE '%".$_GET['buscar_cliente']."%'";
    if(!empty($_GET['buscar_producto'])) $where[] = "producto LIKE '%".$_GET['buscar_producto']."%'";
    if(!empty($_GET['filtro_estado'])) $where[] = "estado='".$_GET['filtro_estado']."'";

    $sql = "SELECT * FROM pedidos";
    if(count($where) > 0) $sql .= " WHERE " . implode(" AND ", $where);
    $result = $conn->query($sql);

    echo "<table>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>";

    while($row = $result->fetch_assoc()){
        $clase = ($row['estado'] === 'Pendiente') ? 'pendiente' : '';
        echo "<tr class='{$clase}'>
                <td>{$row['id']}</td>
                <td>{$row['cliente']}</td>
                <td>{$row['producto']}</td>
                <td>{$row['cantidad']}</td>
                <td>{$row['estado']}</td>
                <td>
                    <form method='POST' action='' style='display:inline;'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <select name='estado'>
                            <option ".($row['estado']=='Pendiente'?'selected':'').">Pendiente</option>
                            <option ".($row['estado']=='En Proceso'?'selected':'').">En Proceso</option>
                            <option ".($row['estado']=='Entregado'?'selected':'').">Entregado</option>
                        </select>
                        <button type='submit' name='cambiarEstado'>Actualizar</button>
                    </form>
                    <a href='?eliminar={$row['id']}' onclick=\"return confirm('¿Eliminar pedido #{$row['id']}?');\">
                        <button class='eliminar-btn' type='button'>Eliminar</button>
                    </a>
                </td>
              </tr>";
    }
    echo "</table>";
    ?>

    <a class="volver" href="../index.php">⬅ Volver al menú</a>
</body>
</html>
