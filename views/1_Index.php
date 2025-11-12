<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Empacado - Mercado Libre</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #007bff;
      color: white;
      text-align: center;
      padding: 15px 0;
      font-size: 22px;
      font-weight: bold;
    }
    main {
      width: 80%;
      margin: 30px auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    h2 {
      color: #333;
      border-bottom: 2px solid #007bff;
      padding-bottom: 5px;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    label {
      font-weight: bold;
    }
    input, select, button {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }
    button {
      background-color: #007bff;
      color: white;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    button:hover {
      background-color: #0056b3;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
    th {
      background-color: #007bff;
      color: white;
    }
  </style>
</head>
<body>
  <header>Sistema de Control de Empacado</header>

  <main>
    <h2>Registrar Pedido</h2>
    <form action="registrar_pedido.php" method="POST">
      <label for="producto">Producto:</label>
      <input type="text" id="producto" name="producto" placeholder="Nombre del producto" required>

      <label for="cantidad">Cantidad:</label>
      <input type="number" id="cantidad" name="cantidad" min="1" required>

      <button type="submit">Registrar Pedido</button>
    </form>

    <h2>Pedidos Pendientes</h2>
    <table>
      <thead>
        <tr>
          <th>ID Pedido</th>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>101</td>
          <td>Mouse Inalámbrico</td>
          <td>2</td>
          <td>Pendiente</td>
        </tr>
        <tr>
          <td>102</td>
          <td>Teclado Mecánico</td>
          <td>1</td>
          <td>Pendiente</td>
        </tr>
      </tbody>
    </table>
  </main>
</body>
</html>
