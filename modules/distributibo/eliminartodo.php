<?php
include_once '../conexion.php';

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para eliminar los datos de la tabla
$sql = "DELETE FROM actividad";

if ($conexion->query($sql) === TRUE) {
    echo '<script type="text/javascript">';
echo 'alert("Datos de la tabla actividad eliminados correctamente.");';
echo 'window.location.href = "index.php";'; // Redirigir al usuario a index.php
echo '</script>';
exit(); // Asegurarse de que el script termine aquí
} else {
    echo '<script type="text/javascript">';
    echo 'alert("Error al eliminar datos: ' . $conexion->error . '");';
    echo 'window.location.href = "index.php";'; // Redirigir al usuario a index.php
    echo '</script>';
    exit(); // Asegurarse de que el script termine aquí
}


?>
