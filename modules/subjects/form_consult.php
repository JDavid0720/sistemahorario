<?php
require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

$_SESSION['subject'] = array();
$_SESSION['subject_name'] = array();
$_SESSION['subject_semester'] = array();
$_SESSION['subject_career'] = array();
$_SESSION['subject_malla'] = array();
$_SESSION['subject_paralelo'] = array();

include '../conexion.php';

$var= $_POST['txtsubject'] ;

	$i = 0;
	$sql = "SELECT asignaturaa.Id_asignatura, asignaturaa.Nom_asignatura, carrera.Nom_carrera AS carrera_nombre, cilco.Ciclo AS cilco_nombre, malla.Nom_malla AS malla_nombre, cilco.paralelo AS paralelo
	FROM asignaturaa 
	INNER JOIN carrera ON asignaturaa.Id_carrera = carrera.Id_carrera 
	INNER JOIN cilco ON asignaturaa.Id_cilco = cilco.Id_cilco
	INNER JOIN malla ON asignaturaa.Id_malla = malla.Id_malla
	WHERE asignaturaa.Id_asignatura = '$var'
	OR cilco.Ciclo = '$var'";
//$sql = "SELECT * FROM asignaturaa ORDER BY Id_cilco, Id_carrera,Id_malla,Nom_asignatura LIMIT $inicio, $max";

	if ($result = $conexion->query($sql)) {
		$num_rows = mysqli_num_rows($result); 
		echo $num_rows;
		if ($num_rows > 0) {
		while ($row = mysqli_fetch_array($result)) {
			$_SESSION['subject'][$i] = $row['Id_asignatura'];
			$_SESSION['subject_name'][$i] = $row['Nom_asignatura'];
			$_SESSION['subject_semester'][$i] = $row['cilco_nombre'];
			$_SESSION['subject_career'][$i] = $row['carrera_nombre'];
			$_SESSION['subject_malla'][$i] = $row['malla_nombre'];
			$_SESSION['subject_paralelo'][$i] = $row['paralelo'];

			$i += 1;
		}
	}
	else
	{
		
	}
}
echo '
<div class="form-data">
	<div class="head">
		<h1 class="titulo">Consultar</h1>
    </div>
	<div class="body">
		<form name="form-consult-subjects" action="" method="POST">
			<div class="wrap">
				<div class="first">
					<label class="label">Asignatura</label>
					<input style="display: none;" type="text" name="txtsubject" value="' . $_SESSION['subject'][0] . '"/>
					<input class="text" type="text" name="txtsubject" value="' . $_SESSION['subject'][0] . '" disabled/>
					<label class="label">Nombre</label>
					<input class="text" type="text" name="txtsubjectname" value="' . $_SESSION['subject_name'][0] . '" maxlength="100" required disabled/>
					<label class="label">Malla</label>
					<textarea disabled class="textarea" name="txtsubjectdescription" data-expandable>' . $_SESSION['subject_malla'][0] . '</textarea>
				</div>
				<div class="last">
					
					
					<label class="label">Semestre</label>
					<input class="text" type="text" name="txtsubjectname" value="' . $_SESSION['subject_semester'][0] . '" maxlength="100" required disabled/>
					<label class="label">Parelelo</label>
					<input class="text" type="text" name="txtsubjectname" value="' . $_SESSION['subject_paralelo'][0] . '" maxlength="100" required disabled/>

				
';


echo
'
                    </select>
                </div>
			</div>
			<button id="btnSave" class="btn icon" type="submit" autofocus>done</button>
        </form>
    </div>
</div>
';
echo '<div class="content-aside">';
include_once "../sections/options-disabled.php";
echo '
</div>
<script src="/js/controls/dataexpandable.js"></script>
<script src="/js/modules/consultcareer.js"></script>
<script>
	$(document).ready(function() {
		$(".select").select2({
			minimumResultsForSearch: Infinity
		});
	});
</script>
';
