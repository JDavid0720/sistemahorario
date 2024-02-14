<?php
// Configuración de la conexión a la base de datos
$servername = "localhost"; // Cambia esto si tu servidor de base de datos está en otro lugar
$username = "root"; // Cambia esto por tu nombre de usuario de MySQL
$password = ""; // Cambia esto por tu contraseña de MySQL
$dbname = "utchorario"; // Cambia esto por el nombre de tu base de datos

// Crear la conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para borrar los datos de la tabla docente
$sql = "DELETE FROM asignaturaa";

if ($conn->query($sql) === TRUE) {
    echo "Datos de las asignaturas borrados exitosamente";
} else {
    echo "Error al borrar datos: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
