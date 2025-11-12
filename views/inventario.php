<?php include("../config/db.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Inventario</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f8f9fa;
            padding: 30px;
            color: #2C3E50;
        }

        h1 {
            text-align: center;
            color: #C8A951;
        }

        .formulario {
            text-align: center;
            margin-bottom: 25px;
            background: white;
            padding: 15px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        input, button {
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
            margin-top: 20px;
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

        .stock-bajo {
            background-color: #fce4e4;
        }

        a {
            text-decoration: none;
            color: #C8A951;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .acciones form {
            display: inline-block;
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
    </style>
</head>
<body>
    <h1>Gestión de Inventario</h1>

    <div class="formulario">
        <form method="POST" action="">
            <input type="text" name="nombre" placeholder="Nombre del producto" required>
            <input type="number" name="cantidad" placeholder="Cantidad" required>
            <input type="number" step="0.01" name="precio" placeholder="Precio" required>
            <button type="submit" name="agregar">Agregar Producto</button>
        </form>
    </div>

    <?php
    if(isset($_POST['agregar'])){
        $nombre = $_POST['nombre'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $conn->query("INSERT INTO inventario (nombre,cantidad,precio) VALUES ('$nombre','$cantidad','$precio')");
        header("Location: inventario.php"); exit;
    }

    if(isset($_GET['eliminar'])){
        $id = $_GET['eliminar'];
        $conn->query("DELETE FROM inventario WHERE id=$id");
        header("Location: inventario.php"); exit;
    }

    if(isset($_POST['usar'])){
        $id = $_POST['id_usar'];
        $res = $conn->query("SELECT cantidad FROM inventario WHERE id=$id");
        $row = $res->fetch_assoc();
        if($row['cantidad'] > 0){
            $conn->query("UPDATE inventario SET cantidad = cantidad - 1 WHERE id=$id");
        }
        header("Location: inventario.php"); exit;
    }

    $resaltar_bajo = isset($_GET['stock_bajo']) ? true : false;
    $result = $conn->query("SELECT * FROM inventario");

    echo "<table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>";
    
    while($row = $result->fetch_assoc()){
        $clase = ($resaltar_bajo && $row['cantidad'] <= 5) ? 'stock-bajo' : '';
        echo "<tr class='{$clase}'>
                <td>{$row['id']}</td>
                <td>{$row['nombre']}</td>
                <td>{$row['cantidad']}</td>
                <td>\${$row['precio']}</td>
                <td class='acciones'>
                    <a href='?eliminar={$row['id']}' onclick='return confirm(\"¿Eliminar este producto?\")'>🗑 Eliminar</a>
                    &nbsp;|&nbsp;
                    <form method='POST'>
                        <input type='hidden' name='id_usar' value='{$row['id']}'>
                        <button type='submit' name='usar'>Usar 1</button>
                    </form>
                </td>
            </tr>";
    }
    echo "</table>";
    ?>

    <a class="volver" href="../index.php">⬅ Volver al menú</a>
</body>
</html>
