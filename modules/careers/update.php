<?php
include_once '../security.php';
include_once '../conexion.php';


require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

if (empty($_POST['txtcareer'])) {
	header('Location: /sistemaHorario');
	exit();
}

$sql_update = "UPDATE carrera SET Nom_carrera= '" . $_POST['txtcareername'] . "' WHERE Id_carrera = '" . $_POST['txtcareer'] . "'";

if (mysqli_query($conexion, $sql_update)) {
	$_SESSION['msgbox_error'] = 0;
	$_SESSION['msgbox_info'] = 1;
	$_SESSION['text_msgbox_info'] = 'Carrera actualizada.';
} else {
	$_SESSION['msgbox_info'] = 0;
	$_SESSION['msgbox_error'] = 1;
	$_SESSION['text_msgbox_error'] = 'Error al actualizar.';
}

header('Location: /sistemaHorario/modules/careers');