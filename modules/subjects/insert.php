<?php
include_once '../security.php';
include_once '../conexion.php';


require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id_asignatura = $_POST['txtCI'];
    $carrera = $_POST['selecCarrera'];
    $ciclo = $_POST['selecCiclo'];
    $malla = $_POST['selecMalla'];
    $nombre_asignatura = $_POST['asignatura'];

    // Realizar la inserción en la base de datos (asumiendo que tienes una conexión válida)
    $sql = "INSERT INTO asignaturaa (Id_asignatura, Id_carrera, Id_cilco, Id_malla, Nom_asignatura) VALUES ('$id_asignatura', '$carrera', '$ciclo', '$malla', '$nombre_asignatura')";

    // Ejecutar la consulta
    if ($conexion->query($sql) === TRUE) {
        // La inserción se realizó con éxito
        // Puedes realizar alguna acción adicional si lo necesitas
		$_SESSION['msgbox_error'] = 0;
		$_SESSION['msgbox_info'] = 1;
		$_SESSION['text_msgbox_info'] = 'Asignatura agregada.';
    } else {
        // Si ocurrió un error durante la inserción, puedes manejarlo aquí
        $_SESSION['msgbox_info'] = 0;
			$_SESSION['msgbox_error'] = 1;
			$_SESSION['text_msgbox_error'] = 'Error al guardar.';
    }
	
	header('Location:../subjects');
}
?>
