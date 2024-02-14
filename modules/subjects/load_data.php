<?php
require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

$sql = "SELECT COUNT(Id_asignatura) AS total FROM asignaturaa";

if ($result = $conexion->query($sql)) {
	if ($row = mysqli_fetch_array($result)) {
		$tpages = ceil($row['total'] / $max);
	}
}

if (!empty($_POST['search'])) {
	$_POST['search'] = trim($_POST['search']);
	$_POST['search'] = mysqli_real_escape_string($conexion, $_POST['search']);
	
	$_SESSION['subject'] = array();
$_SESSION['subject_name'] = array();
$_SESSION['subject_semester'] = array();
$_SESSION['subject_career'] = array();
$_SESSION['subject_malla'] = array();



	
$var=  $_POST['search']  ;

$i = 0;
$sql="SELECT asignaturaa.Id_asignatura,asignaturaa.Nom_asignatura,carrera.Nom_carrera As carrera_nombre, cilco.Ciclo AS cilco_nombre, malla.Nom_malla AS malla_nombre
,cilco.paralelo As paralelo
FROM asignaturaa 
INNER JOIN carrera ON asignaturaa.Id_carrera = carrera.Id_carrera 
INNER JOIN cilco  ON asignaturaa.Id_cilco = cilco.Id_cilco
INNER JOIN malla   ON asignaturaa.Id_malla= malla.Id_malla
WHERE  asignaturaa.Id_asignatura='$var'
OR carrera.Nom_carrera ='$var'
OR cilco.Ciclo='$var'
OR malla.Nom_malla='$var'
OR asignaturaa.Nom_asignatura='$var'
ORDER BY cilco.Ciclo , carrera.Nom_carrera , asignaturaa.Nom_asignatura, malla.Nom_malla ";

if ($result = $conexion->query($sql)) {
	while ($row = mysqli_fetch_array($result)) {
		$_SESSION['subject'][$i] = $row['Id_asignatura'];
		$_SESSION['subject_name'][$i] = $row['Nom_asignatura'];
		$_SESSION['subject_semester'][$i] = $row['cilco_nombre'];
		$_SESSION['subject_career'][$i] = $row['carrera_nombre'];
		$_SESSION['subject_malla'][$i] = $row['malla_nombre'];

		$i += 1;
	}
}
	
	$_SESSION['total_subjects'] = count($_SESSION['subject']);
} else {
	$_SESSION['subject'] = array();
$_SESSION['subject_name'] = array();
$_SESSION['subject_semester'] = array();
$_SESSION['subject_career'] = array();
$_SESSION['subject_malla'] = array();

	$i = 0;
	$sql="SELECT asignaturaa.Id_asignatura, asignaturaa.Nom_asignatura, carrera.Nom_carrera AS carrera_nombre, cilco.Ciclo AS cilco_nombre, malla.Nom_malla AS malla_nombre
	FROM asignaturaa 
	LEFT JOIN carrera ON asignaturaa.Id_carrera = carrera.Id_carrera 
	LEFT JOIN cilco ON asignaturaa.Id_cilco = cilco.Id_cilco
	LEFT JOIN malla ON asignaturaa.Id_malla = malla.Id_malla
	LIMIT $inicio, $max";
	//$sql = "SELECT * FROM asignaturaa ORDER BY Id_cilco, Id_carrera,Id_malla,Nom_asignatura LIMIT $inicio, $max";

	if ($result = $conexion->query($sql)) {
		while ($row = mysqli_fetch_array($result)) {
			$_SESSION['subject'][$i] = $row['Id_asignatura'];
			$_SESSION['subject_name'][$i] = $row['Nom_asignatura'];
			$_SESSION['subject_semester'][$i] = $row['cilco_nombre'];
			$_SESSION['subject_career'][$i] = $row['carrera_nombre'];
			$_SESSION['subject_malla'][$i] = $row['malla_nombre'];

			$i += 1;
		}
	}
	$_SESSION['total_subjects'] = count($_SESSION['subject']);
}