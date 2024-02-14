<?php
// Archivo guardar_datos.php

// Obtener los datos enviados por AJAX
$id = $_POST['id'];
$tipo = $_POST['tipo'];
$nombre = $_POST['nombre'];
$jornada = $_POST['jornada'];
$nuevoDia = $_POST['nuevoDia'];
$nuevaHora = $_POST['nuevaHora'];

// Mostrar los datos recibidos por pantalla
echo "<h2>Datos recibidos:</h2>";
echo "<p><strong>ID:</strong> " . $id . "</p>";
echo "<p><strong>Tipo:</strong> " . $tipo . "</p>";
echo "<p><strong>Nombre:</strong> " . $nombre . "</p>";
echo "<p><strong>Jornada:</strong> " . $jornada . "</p>";
echo "<p><strong>Nuevo Día:</strong> " . $nuevoDia . "</p>";
echo "<p><strong>Nueva Hora:</strong> " . $nuevaHora . "</p>";

// Aquí puedes realizar la lógica para guardar los datos en la base de datos
// Por ejemplo, utilizando consultas SQL con PDO o MySQLi

// Si todo se ha guardado correctamente, puedes enviar una respuesta de éxito al cliente
$response = array(
    'status' => 'success',
    'message' => 'Datos guardados correctamente: ' . $nuevoDia . ' ' . $nuevaHora
);

echo json_encode($response);
?>
