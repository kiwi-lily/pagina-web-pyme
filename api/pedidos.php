<?php
include("../config/db.php");
header("Content-Type: application/json");

$accion = $_GET['accion'] ?? '';

switch($accion){
    case 'listar':
        $sql = "SELECT * FROM pedidos";
        $result = $conn->query($sql);
        $data = [];
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        echo json_encode($data);
    break;

    case 'crear':
        $cliente = $_POST['cliente'];
        $producto = $_POST['producto'];
        $cantidad = $_POST['cantidad'];
        $sql = "INSERT INTO pedidos (cliente, producto, cantidad) VALUES ('$cliente','$producto','$cantidad')";
        echo $conn->query($sql) ? json_encode(["msg"=>"Pedido creado"]) : json_encode(["error"=>$conn->error]);
    break;

    case 'cambiarEstado':
        $id = $_POST['id'];
        $estado = $_POST['estado'];
        $sql = "UPDATE pedidos SET estado='$estado' WHERE id='$id'";
        echo $conn->query($sql) ? json_encode(["msg"=>"Estado actualizado"]) : json_encode(["error"=>$conn->error]);
    break;
}
?>
