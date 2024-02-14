<?php
require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

$sql = "SELECT COUNT(Id_carrera) AS total FROM carrera";

if ($result = $conexion->query($sql)) {
	if ($row = mysqli_fetch_array($result)) {
		$tpages = ceil($row['total'] / $max);
	}
}

if (!empty($_POST['search'])) {
	$_POST['search'] = trim($_POST['search']);
	$_POST['search'] = mysqli_real_escape_string($conexion, $_POST['search']);

	$_SESSION['Id_carrera'] = array();
	$_SESSION['Nom_carrera'] = array();

	$i = 0;

	$sql = "SELECT * FROM carrera WHERE Id_carrera LIKE '%" . $_POST['search'] . "%' OR Nom_carrera LIKE '%" . $_POST['search'] . "%' ORDER BY Nom_carrera";

	if ($result = $conexion->query($sql)) {
		while ($row = mysqli_fetch_array($result)) {
			$_SESSION['Id_carrera'][$i] = $row['Id_carrera'];
			$_SESSION['Nom_carrera'][$i] = $row['Nom_carrera'];

			$i += 1;
		}
	}
	$_SESSION['total_careers'] = count($_SESSION['Id_carrera']);
} else {
	$_SESSION['Id_carrera'] = array();
	$_SESSION['Nom_carrera'] = array();

	$i = 0;

	$sql = "SELECT * FROM carrera ORDER BY Id_carrera LIMIT $inicio, $max";

	if ($result = $conexion->query($sql)) {
		while ($row = mysqli_fetch_array($result)) {
			$_SESSION['Id_carrera'][$i] = $row['Id_carrera'];
			$_SESSION['Nom_carrera'][$i] = $row['Nom_carrera'];

			$i += 1;
		}
	}
	$_SESSION['total_careers'] = count($_SESSION['Id_carrera']);
}