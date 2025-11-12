<?php
include("../config/db.php");
header("Content-Type: application/json");

$accion = $_GET['accion'] ?? '';

switch($accion){
    case 'listar':
        $sql = "SELECT * FROM inventario";
        $result = $conn->query($sql);
        $data = [];
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        echo json_encode($data);
    break;

    case 'agregar':
        $nombre = $_POST['nombre'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $sql = "INSERT INTO inventario (nombre,cantidad,precio) VALUES ('$nombre','$cantidad','$precio')";
        echo $conn->query($sql) ? json_encode(["msg"=>"Producto agregado"]) : json_encode(["error"=>$conn->error]);
    break;

    case 'actualizar':
        $id = $_POST['id'];
        $cantidad = $_POST['cantidad'];
        $sql = "UPDATE inventario SET cantidad='$cantidad' WHERE id='$id'";
        echo $conn->query($sql) ? json_encode(["msg"=>"Inventario actualizado"]) : json_encode(["error"=>$conn->error]);
    break;

    case 'eliminar':
        $id = $_POST['id'];
        $sql = "DELETE FROM inventario WHERE id='$id'";
        echo $conn->query($sql) ? json_encode(["msg"=>"Producto eliminado"]) : json_encode(["error"=>$conn->error]);
    break;
}
?>
