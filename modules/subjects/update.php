<?php
include_once '../security.php';
include_once '../conexion.php';


require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');


if (isset($_POST['update'])) {
    // Realizas aquí el código para actualizar la asignatura en la base de datos
    // Puedes obtener los datos actualizados desde $_POST y ejecutar la consulta de actualización correspondiente
    // Por ejemplo, si los campos son: Nombre, Semestre, Carrera, Malla y Paralelo, la consulta sería algo como:
    
    $updateSql = "UPDATE asignaturaa 
                SET  Id_carrera='{$_POST['carrera']}',
				Id_cilco='{$_POST['semestre']}',
				Id_malla='{$_POST['malla']}',
				Nom_asignatura='{$_POST['nombre']}' 
                    
                WHERE Id_asignatura='{$_SESSION['subject'][0]}'";
    $resultUpdate = mysqli_query($conexion, $updateSql);
    if ($resultUpdate){
		$_SESSION['msgbox_error'] = 0;
		$_SESSION['msgbox_info'] = 1;
		$_SESSION['text_msgbox_info'] = 'Asignatura actualizada.';
	} else {
		$_SESSION['msgbox_info'] = 0;
		$_SESSION['msgbox_error'] = 1;
		$_SESSION['text_msgbox_error'] = 'Error al actualizar.';
	}
    
}

header('Location:../subjects');