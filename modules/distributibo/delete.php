<?php
include_once '../security.php';
include_once '../conexion.php';


// Verifica si se ha proporcionado un ID válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Realiza las validaciones y medidas de seguridad necesarias aquí

    // Conexión a la base de datos

    // Consulta para borrar el registro
    $sql_delete = "DELETE FROM actividad WHERE Id_actividad = $id";

    if ($conexion->query($sql_delete) === TRUE) {
        
		$mensaje = "Registro eliminado exitosamente.";
		echo "<script>
				  alert('$mensaje');
				  window.location.href = '../distributibo';
			  </script>";
		exit;
    } else {
        echo "Error al eliminar el registro: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
} else {
    echo "ID no válido.";
}
?>

