<?php
session_start();

// Verifica si el usuario está autenticado
if (isset($_SESSION['esAdmin']) && $_SESSION['esAdmin'] == 1) {
  // Conexión a la base de datos
  $host = "localhost";
  $username = "eventario_juan";
  $password = "juan$2023";
  $database = "eventario_db";

  $conn = new mysqli($host, $username, $password, $database);

  if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
  }

  $IDorganizador = $_SESSION['IDorganizador'];

  // Consulta para obtener los eventos del organizador
  $query = "SELECT e.IDeventos, e.evento, e.fecha, e.lugar, e.descripcion, e.hora, e.hora_fin, e.limite_inscritos, e.imagen
            FROM eventos AS e
            INNER JOIN eventosorganizador AS eo ON e.IDeventos = eo.IDeventos
            WHERE eo.IDorganizador = $IDorganizador";

  $result = $conn->query($query);

  $eventos = array();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $eventos[] = $row;
    }
  }

  // Devuelve los eventos en formato JSON
  echo json_encode($eventos);

  $conn->close();
} else {
  // El usuario no está autenticado
  echo json_encode(array());
}
