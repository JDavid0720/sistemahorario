<?php
require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

$sql = "SELECT COUNT(Id_actividad) AS total FROM actividad";

if ($result = $conexion->query($sql)) {
	if ($row = mysqli_fetch_array($result)) {
		$tpages = ceil($row['total'] / $max);
	}
}

if (!empty($_POST['search'])) {
	$_POST['search'] = trim($_POST['search']);
	$_POST['search'] = mysqli_real_escape_string($conexion, $_POST['search']);
	$_SESSION['Id_actividad'] = array();
	$_SESSION['CI'] = array();
	$_SESSION['Facultad'] = array();
	$_SESSION['Carrera'] = array();
	$_SESSION['Ciclo'] = array();
	$_SESSION['Malla'] = array();
	$_SESSION['Id_asignatura'] = array();
	$_SESSION['Id_tipoActividad'] = array();
	$_SESSION['Id_actividadEspecifica'] = array();
	$_SESSION['Id_Jornada'] = array();
	$_SESSION['ACD'] = array();
	$_SESSION['APE'] = array();
	$_SESSION['HVIR'] = array();
	$_SESSION['Total Horas Clases']=array();
	$_SESSION['HVIR'] = array();
	$_SESSION['OAD'] = array();
	$_SESSION['HG'] = array();
	$_SESSION['HI'] = array();
	//$_SESSION['HVHPP'] = array();
	$_SESSION['Total H.'] =array();

	$i = 0;

	$sql = "SELECT * FROM actividad WHERE CI LIKE '%" . $_POST['search'] . "%' OR CI LIKE '%" . $_POST['search'] . "%' OR Id_actividad  LIKE '%" . $_POST['search'] . "%' ORDER BY CI";

	if ($result = $conexion->query($sql)) {
		while ($row = mysqli_fetch_array($result)) {
			$_SESSION['Id_actividad'][$i] = $row['Id_actividad'];
			$_SESSION['CI'][$i] = $row['CI'];
			$_SESSION['Facultad'][$i] = "La Maná";
			$_SESSION['Carrera'][$i] = $row['carrera_nombre'];
			$_SESSION['Ciclo'][$i] = $row['ciclo_nombre'];
			$_SESSION['Malla'][$i] = $row['malla_nombre'];
			$_SESSION['Id_asignatura'][$i] = $row['asignatura_nombre'];
			$_SESSION['Id_actividadEspecifica'][$i] = $row['actividadEspecifica_nombre'];
			$_SESSION['Id_Jornada'][$i] = $row['jornada_nombre'];
			$_SESSION['ACD'][$i] = $row['ACD'];
			$_SESSION['APE'][$i] = $row['APE'];
			$_SESSION['HVIR'][$i] = $row['HVIR'];
			$_SESSION['Total Horas Clases'][$i]=0;
			$_SESSION['HVIR'][$i] = $row['HVIR'];
			$_SESSION['OAD'][$i] = $row['OAD'];
			$_SESSION['HG'][$i] = $row['HG'];
			$_SESSION['HI'][$i] = $row['HI'];
			//$_SESSION['HVHPP'][$i] = $row['HVHPP'];
			$_SESSION['Total H.'] [$i]=$row['ACD']+$row['APE']+ $row['HVIR']+$row['OAD']+$row['HG']+$row['HI']+$row['HVHPP'];

			$i += 1;
		}
	}
	$_SESSION['total_docente'] = count($_SESSION['Id_actividad']);
} else {
	$_SESSION['Id_actividad'] = array();
	$_SESSION['CI'] = array();
	$_SESSION['Facultad'] = array();
	$_SESSION['Carrera'] = array();
	$_SESSION['Ciclo'] = array();
	$_SESSION['Malla'] = array();
	$_SESSION['Id_asignatura'] = array();
	$_SESSION['Id_tipoActividad'] = array();
	$_SESSION['Id_actividadEspecifica'] = array();
	$_SESSION['Id_Jornada'] = array();
	$_SESSION['ACD'] = array();
	$_SESSION['APE'] = array();
	$_SESSION['HVIR'] = array();
	$_SESSION['Total Horas Clases']=array();
	
	$_SESSION['OAD'] = array();
	$_SESSION['HG'] = array();
	$_SESSION['HI'] = array();
	$_SESSION['Total H.'] =array();
	$i = 0;
	$sql="SELECT actividad.Id_actividad,actividad.CI,actividad.ACD,actividad.APE,actividad.HVIR,actividad.OAD,actividad.HG,
	actividad.HI,actividad.HVHPP, 
	asignaturaa.Nom_asignatura As asignatura_nombre, 
	carrera.Nom_carrera As carrera_nombre, 
	cilco.Ciclo AS ciclo_nombre,
	malla.Nom_malla AS malla_nombre, 
	tipoactividad.Nom_tipoActividad AS tipoActividadNom, 
	actividadespecifica.Nom_actividadEspecifica AS actividadEspecifica_nombre,  
	jornada.Nom_jornada AS jornada_nombre
	FROM actividad 
	LEFT JOIN asignaturaa ON actividad.Id_asignatura = asignaturaa.Id_asignatura 
	LEFT JOIN docente ON actividad.CI = docente.CI
    LEFT JOIN carrera ON asignaturaa.Id_carrera = carrera.Id_carrera
    LEFT JOIN cilco ON asignaturaa.Id_cilco = cilco.Id_cilco 
    LEFT JOIN malla ON asignaturaa.Id_malla = malla.Id_malla 
	LEFT JOIN tipoactividad  ON actividad.Id_tipoActividad =tipoactividad.Id_tipoActividad
	LEFT JOIN actividadespecifica   ON actividad.Id_actividadEspecifica= actividadespecifica.Id_actividadEspecifica
	LEFT JOIN jornada  ON actividad.Id_Jornada =jornada.Id_Jornada
	ORDER BY docente.ApellidoNombre, actividad.Id_actividad";
	//$sql="SELECT * From actividad  ORDER BY CI LIMIT $inicio, $max";
	//$sql = "SELECT * FROM asignaturaa ORDER BY Id_cilco, Id_carrera,Id_malla,Nom_asignatura LIMIT $inicio, $max";
	
	if ($result = $conexion->query($sql)) {
		while ($row = mysqli_fetch_array($result)) {
			$_SESSION['Id_actividad'][$i] = $row['Id_actividad'];
			$_SESSION['CI'][$i] = $row['CI'];
			$_SESSION['Facultad'][$i] = "La Maná";
			$_SESSION['Carrera'][$i] = $row['carrera_nombre'];
			$_SESSION['Ciclo'][$i] = $row['ciclo_nombre'] ;
			$_SESSION['Malla'][$i] = $row['malla_nombre'];
			$_SESSION['Id_asignatura'][$i] = $row['asignatura_nombre'];
			$_SESSION['Id_actividadEspecifica'][$i] = $row['actividadEspecifica_nombre'];
			$_SESSION['Id_Jornada'][$i] = $row['jornada_nombre'];
			$_SESSION['ACD'][$i] = $row['ACD'];
			$_SESSION['APE'][$i] = $row['APE'];
			$_SESSION['HVIR'][$i] = $row['HVIR'];
			$_SESSION['Total Horas Clases'][$i]=$row['ACD']+$row['APE'];
			
			$_SESSION['OAD'][$i] = $row['OAD'];
			$_SESSION['HG'][$i] = $row['HG'];
			$_SESSION['HI'][$i] = $row['HI'];
			$_SESSION['HVHPP'][$i] = $row['HVHPP'];
			$_SESSION['Total H.'] [$i]=$row['ACD']+$row['APE']+ $row['HVIR']+$row['OAD']+$row['HG']+$row['HI']+$row['HVHPP'];
			$i += 1;
		}
	}
	$_SESSION['total_docente'] = count($_SESSION['Id_actividad']);
}