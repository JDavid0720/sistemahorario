<?php
include_once '../security.php';
include_once '../conexion.php';
include_once '../notif_info_msgbox.php';

require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

$_POST['txtuserid'] = trim($_POST['txtuserid']);

if (empty($_POST['txtuserid'])) {
	header('Location: /');
	exit();
}
if ($_POST['txtuserid'] == '') {
	Error('Ingrese un ID correcto.');
	header('Location: /modules/teachers');
	exit();
}

$sql = "SELECT * FROM docente WHERE CI = '" . $_POST['txtuserid'] . "'";

if ($result = $conexion->query($sql)) {
	if ($row = mysqli_fetch_array($result)) {
		$date = date('Y-m-d H:i:s');
		$careers = '';

		for ($i = 0; $i < count($_POST["selectCareers"]); $i++) {
			$careers .= $_POST["selectCareers"][$i] . ',';
		}

		$careers = trim($careers, ',');

		$sql_update = "UPDATE docente SET ApellidoNombre= '" . trim($_POST['txtname']) . "', Id_carrera ='" . $careers . "', Titulo_tercer = '" . trim($_POST['txtT3']) . "', Titulo_cuarto = '" . trim($_POST['txtT4']) . "', Contrato= '" . trim($_POST['selecContrato']) . "', dedicacion = '" . trim($_POST['selecDedicacion']) . "', campus = '" . trim($_POST['selecCampus']) . "', actividad_complementaria= '" . trim($_POST['txtacti']) . "' WHERE CI = '" . trim($_POST['txtuserid']) . "'";

		if (mysqli_query($conexion, $sql_update)) {
			Info('Docente actualizado.');
		} else {
			Error('Error al actualizar.');
		}
		
		header('Location:../teachers');
		exit();
	} else {
		Error('Este ID de docente no existe.');
		header('Location:../teachers');
		exit();
	}
}