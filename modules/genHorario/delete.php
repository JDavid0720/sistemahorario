<?php
// Incluir el archivo de conexión
include '../conexion.php';

// Consulta SQL para borrar todos los datos de la tabla "horario"
$sql = "DELETE FROM horario";

// Ejecutar la consulta
if ($conexion->query($sql) === TRUE) {
   header("Location:index.php");
exit; // 
} else {
    echo "Error al borrar los datos: " . $conexion->error;
}

// Cierra la conexión a la base de datos
//$conn->close();
?>
