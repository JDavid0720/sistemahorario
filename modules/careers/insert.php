<?php
include_once '../security.php';
include_once '../conexion.php';


require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

if (empty($_POST['txtcareer'])) {
	header('Location: /');
	exit();
}

$_POST['txtcareer'] = trim($_POST['txtcareer']);

if ($_POST['txtcareer'] == '') {
	$_SESSION['msgbox_info'] = 0;
	$_SESSION['msgbox_error'] = 1;
	$_SESSION['text_msgbox_error'] = 'Ingrese un ID correcto.';
	header('Location: /modules/careers');
	exit();
}

$sql = "SELECT * FROM carrera WHERE Id_carrera = '" . $_POST['txtcareer'] . "'";

if ($result = $conexion->query($sql)) {
	if ($row = mysqli_fetch_array($result)) {
		$_SESSION['msgbox_info'] = 0;
		$_SESSION['msgbox_error'] = 1;
		$_SESSION['text_msgbox_error'] = 'La carrera que intenta crear ya éxiste.';

		header('Location: /modules/careers');
	} else {
		$_POST['txtcareerdescription'] = mysqli_real_escape_string($conexion, $_POST['txtcareerdescription']);
		$sql_insert = "INSERT INTO carrera(Id_carrera,Nom_carrera) VALUES('" . $_POST['txtcareer'] . "', '" . $_POST['txtcareername'] . "')";

		if (mysqli_query($conexion, $sql_insert)) {
			$_SESSION['msgbox_error'] = 0;
			$_SESSION['msgbox_info'] = 1;
			$_SESSION['text_msgbox_info'] = 'Carrera agregada.';
		} else {
			$_SESSION['msgbox_info'] = 0;
			$_SESSION['msgbox_error'] = 1;
			$_SESSION['text_msgbox_error'] = 'Error al guardar.';
		}

		header('Location: /sistemaHorario/modules/careers');
	}
}